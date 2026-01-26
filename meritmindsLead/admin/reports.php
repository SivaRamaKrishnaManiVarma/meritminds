<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Get report type from URL parameter
$report_type = isset($_GET['type']) ? $_GET['type'] : 'enquiries';

// Get date range parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of current month
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Today

// Sanitize inputs
$start_date = $conn->real_escape_string($start_date);
$end_date = $conn->real_escape_string($end_date);

// Prepare data for the selected report type
switch($report_type) {
    case 'enquiries':
        // Enquiries by date
        $enquiries_query = "
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM enquiries 
            WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY DATE(created_at) 
            ORDER BY date
        ";
        $enquiries_result = $conn->query($enquiries_query);
        
        $enquiries_data = [];
        $total_enquiries = 0;
        while($row = $enquiries_result->fetch_assoc()) {
            $enquiries_data[] = $row;
            $total_enquiries += $row['count'];
        }
        
        // Try the new structure first for countries
        $countries_query = "
            SELECT c.name as country, COUNT(DISTINCT sc.enquiry_id) as count 
            FROM countries c
            JOIN student_countries sc ON c.id = sc.country_id
            JOIN enquiries e ON sc.enquiry_id = e.id
            WHERE e.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY c.name 
            ORDER BY count DESC
            LIMIT 5
        ";
        $countries_result = $conn->query($countries_query);
        
        // If no results from the new structure, fall back to the old structure
        if ($countries_result->num_rows == 0) {
            $countries_query = "
                SELECT country, COUNT(*) as count 
                FROM enquiries 
                WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
                AND country IS NOT NULL AND country != ''
                GROUP BY country 
                ORDER BY count DESC
                LIMIT 5
            ";
            $countries_result = $conn->query($countries_query);
        }
        
        // Try the new structure first for intakes
        $intakes_query = "
            SELECT i.name as intake, COUNT(DISTINCT si.enquiry_id) as count 
            FROM intakes i
            JOIN student_intakes si ON i.id = si.intake_id
            JOIN enquiries e ON si.enquiry_id = e.id
            WHERE e.created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY i.name 
            ORDER BY count DESC
            LIMIT 5
        ";
        $intakes_result = $conn->query($intakes_query);
        
        // If no results from the new structure, fall back to the old structure
        if ($intakes_result->num_rows == 0) {
            $intakes_query = "
                SELECT intake, COUNT(*) as count 
                FROM enquiries 
                WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
                AND intake IS NOT NULL AND intake != ''
                GROUP BY intake 
                ORDER BY count DESC
                LIMIT 5
            ";
            $intakes_result = $conn->query($intakes_query);
        }
        break;
      case 'applications':
        // Applications by status - FIXED: Using updated_at instead of created_at
        $applications_query = "
            SELECT status, COUNT(*) as count 
            FROM application_status 
            WHERE updated_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY status
        ";
        $applications_result = $conn->query($applications_query);
        
        $applications_data = [];
        $total_applications = 0;
        while($row = $applications_result->fetch_assoc()) {
            $applications_data[] = $row;
            $total_applications += $row['count'];
        }
        
        // Status changes over time
        $status_changes_query = "
            SELECT DATE(created_at) as date, activity_type, COUNT(*) as count 
            FROM activity_log 
            WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            AND activity_type = 'Status Update'
            GROUP BY DATE(created_at), activity_type
            ORDER BY date
        ";
        $status_changes_result = $conn->query($status_changes_query);
        break;
        
    case 'financials':
        // Payments by status
        // Payments by status - FIXED: Using updated_at instead of created_at
        $payments_query = "
            SELECT fee_status, COUNT(*) as count 
            FROM student_financials 
            WHERE updated_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'
            GROUP BY fee_status
        
        ";
        $payments_result = $conn->query($payments_query);
        
        // Payments over time
        $payments_time_query = "
            SELECT DATE(payment_date) as date, COUNT(*) as count 
            FROM student_financials 
            WHERE payment_date BETWEEN '$start_date' AND '$end_date'
            AND fee_status = 'paid'
            GROUP BY DATE(payment_date)
            ORDER BY date
        ";
        $payments_time_result = $conn->query($payments_time_query);
        break;
        
        
    default:
        // Default to enquiries report
        header("Location: reports.php?type=enquiries");
        exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Lead Tracking Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
            color: white;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
        }
        .nav-link:hover {
            color: #fff;
        }
        .nav-link.active {
            color: #fff;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 200px;
            padding: 30px;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .report-tabs .nav-link {
            color: #6c757d;
            font-weight: bold;
        }
        .report-tabs .nav-link.active {
            color: #4CAF50;
            background-color: transparent;
            border-bottom: 3px solid #4CAF50;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .table thead th {
            background-color: #4CAF50;
            color: white;
        }
        .filter-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'topbar.php'; ?>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>


    <!-- Main Content -->
    <div class="main-content">
        <h1 class="mb-4">Reports</h1>
        
        <!-- Report Tabs -->
        <ul class="nav nav-tabs report-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?php echo $report_type == 'enquiries' ? 'active' : ''; ?>" href="reports.php?type=enquiries">
                    <i class="fas fa-user-graduate"></i> Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $report_type == 'applications' ? 'active' : ''; ?>" href="reports.php?type=applications">
                    <i class="fas fa-clipboard-list"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $report_type == 'financials' ? 'active' : ''; ?>" href="reports.php?type=financials">
                    <i class="fas fa-money-bill"></i> Financials
                </a>
            </li>
           
        </ul>
        
        <!-- Date Range Filter -->
        <div class="card filter-box">
            <div class="card-body">
                <form method="GET" action="reports.php" class="row g-3">
                    <input type="hidden" name="type" value="<?php echo htmlspecialchars($report_type); ?>">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                        <a href="reports.php?type=<?php echo htmlspecialchars($report_type); ?>" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if($report_type == 'enquiries'): ?>
    <!-- Enquiries Report -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i> Enquiries Over Time
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="enquiriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i> Summary
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Total Enquiries</h5>
                        <h2 class="fw-bold"><?php echo $total_enquiries; ?></h2>
                        <small class="text-muted">From <?php echo date('M d, Y', strtotime($start_date)); ?> to <?php echo date('M d, Y', strtotime($end_date)); ?></small>
                    </div>
                    <div class="mb-4">
                        <h5>Daily Average</h5>
                        <?php 
                        $days = max(1, (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1);
                        $daily_avg = $total_enquiries / $days;
                        ?>
                        <h2 class="fw-bold"><?php echo number_format($daily_avg, 1); ?></h2>
                        <small class="text-muted">Enquiries per day</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-globe me-1"></i> Top Countries
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="countriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar me-1"></i> Top Intakes
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="intakesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Enquiries over time chart
        const enquiriesCtx = document.getElementById('enquiriesChart').getContext('2d');
        const enquiriesChart = new Chart(enquiriesCtx, {
            type: 'line',
            data: {
                labels: [
                    <?php 
                    foreach($enquiries_data as $data) {
                        echo "'" . date('M d', strtotime($data['date'])) . "', ";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'New Enquiries',
                    data: [
                        <?php 
                        foreach($enquiries_data as $data) {
                            echo $data['count'] . ", ";
                        }
                        ?>
                    ],
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    tension: 0.3,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Check if countries data is available
        <?php $has_countries_data = ($countries_result && $countries_result->num_rows > 0); ?>
        
        // Countries chart
        const countriesCtx = document.getElementById('countriesChart').getContext('2d');
        <?php if($has_countries_data): ?>
        const countriesChart = new Chart(countriesCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    <?php 
                    $countries_result->data_seek(0);
                    while($row = $countries_result->fetch_assoc()) {
                        echo "'" . htmlspecialchars($row['country']) . "', ";
                    }
                    ?>
                ],
                datasets: [{
                    data: [
                        <?php 
                        $countries_result->data_seek(0);
                        while($row = $countries_result->fetch_assoc()) {
                            echo $row['count'] . ", ";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
        <?php else: ?>
        // Display no data message
        countriesCtx.font = '14px Arial';
        countriesCtx.textAlign = 'center';
        countriesCtx.fillText('No country data available for the selected date range', 
                             countriesCtx.canvas.width / 2, 
                             countriesCtx.canvas.height / 2);
        <?php endif; ?>
        
        // Check if intakes data is available
        <?php $has_intakes_data = ($intakes_result && $intakes_result->num_rows > 0); ?>
        
        // Intakes chart
        const intakesCtx = document.getElementById('intakesChart').getContext('2d');
        <?php if($has_intakes_data): ?>
        const intakesChart = new Chart(intakesCtx, {
            type: 'bar',
            data: {
                labels: [
                    <?php 
                    $intakes_result->data_seek(0);
                    while($row = $intakes_result->fetch_assoc()) {
                        echo "'" . htmlspecialchars($row['intake']) . "', ";
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Enquiries',
                    data: [
                        <?php 
                        $intakes_result->data_seek(0);
                        while($row = $intakes_result->fetch_assoc()) {
                            echo $row['count'] . ", ";
                        }
                        ?>
                    ],
                    backgroundColor: 'rgba(76, 175, 80, 0.7)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        <?php else: ?>
        // Display no data message
        intakesCtx.font = '14px Arial';
        intakesCtx.textAlign = 'center';
        intakesCtx.fillText('No intake data available for the selected date range', 
                           intakesCtx.canvas.width / 2, 
                           intakesCtx.canvas.height / 2);
        <?php endif; ?>

            </script>
            
        <?php elseif($report_type == 'applications'): ?>
            <!-- Applications Report -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i> Application Status Changes Over Time
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="statusChangesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i> Summary
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5>Total Applications</h5>
                                <h2 class="fw-bold"><?php echo $total_applications; ?></h2>
                                <small class="text-muted">From <?php echo date('M d, Y', strtotime($start_date)); ?> to <?php echo date('M d, Y', strtotime($end_date)); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-clipboard-list me-1"></i> Applications by Status
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // Application status chart
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                const statusChart = new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php 
                            foreach($applications_data as $data) {
                                echo "'" . $data['status'] . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Applications',
                            data: [
                                <?php 
                                foreach($applications_data as $data) {
                                    echo $data['count'] . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(108, 117, 125, 0.7)', // Not Started
                                'rgba(0, 123, 255, 0.7)',   // In Progress
                                'rgba(40, 167, 69, 0.7)',   // Complete
                                'rgba(255, 193, 7, 0.7)',   // On Hold
                                'rgba(220, 53, 69, 0.7)',   // Rejected
                                'rgba(108, 117, 125, 0.7)'  // Withdrawn
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
                
                // Status changes over time chart
                const statusChangesCtx = document.getElementById('statusChangesChart').getContext('2d');
                const statusChangesChart = new Chart(statusChangesCtx, {
                    type: 'line',
                    data: {
                        labels: [
                            <?php 
                            $dates = [];
                            $counts = [];
                            while($row = $status_changes_result->fetch_assoc()) {
                                $dates[] = $row['date'];
                                $counts[] = $row['count'];
                                echo "'" . date('M d', strtotime($row['date'])) . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Status Changes',
                            data: [
                                <?php 
                                foreach($counts as $count) {
                                    echo $count . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: 'rgba(0, 123, 255, 0.2)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            tension: 0.3,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            </script>
            
        <?php elseif($report_type == 'financials'): ?>
            <!-- Financials Report -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i> Payments Over Time
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="paymentsTimeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i> Payment Status Summary
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="paymentStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // Payment status chart
                const paymentStatusCtx = document.getElementById('paymentStatusChart').getContext('2d');
                const paymentStatusChart = new Chart(paymentStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            <?php 
                            while($row = $payments_result->fetch_assoc()) {
                                echo "'" . ucfirst($row['fee_status']) . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            data: [
                                <?php 
                                $payments_result->data_seek(0);
                                while($row = $payments_result->fetch_assoc()) {
                                    echo $row['count'] . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.7)',  // Paid
                                'rgba(220, 53, 69, 0.7)'   // Unpaid
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
                
                // Payments over time chart
                const paymentsTimeCtx = document.getElementById('paymentsTimeChart').getContext('2d');
                const paymentsTimeChart = new Chart(paymentsTimeCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php 
                            while($row = $payments_time_result->fetch_assoc()) {
                                echo "'" . date('M d', strtotime($row['date'])) . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Payments Received',
                            data: [
                                <?php 
                                $payments_time_result->data_seek(0);
                                while($row = $payments_time_result->fetch_assoc()) {
                                    echo $row['count'] . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            </script>
            
        <?php elseif($report_type == 'documents'): ?>
            <!-- Documents Report -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i> Documents Uploaded Over Time
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="documentsTimeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i> Documents by Type
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="documentTypesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // Document types chart
                const documentTypesCtx = document.getElementById('documentTypesChart').getContext('2d');
                const documentTypesChart = new Chart(documentTypesCtx, {
                    type: 'pie',
                    data: {
                        labels: [
                            <?php 
                            while($row = $documents_result->fetch_assoc()) {
                                echo "'" . $row['material'] . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            data: [
                                <?php 
                                $documents_result->data_seek(0);
                                while($row = $documents_result->fetch_assoc()) {
                                    echo $row['count'] . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(199, 199, 199, 0.7)',
                                'rgba(83, 102, 255, 0.7)',
                                'rgba(40, 167, 69, 0.7)',
                                'rgba(220, 53, 69, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12
                                }
                            }
                        }
                    }
                });
                
                // Documents over time chart
                const documentsTimeCtx = document.getElementById('documentsTimeChart').getContext('2d');
                const documentsTimeChart = new Chart(documentsTimeCtx, {
                    type: 'line',
                    data: {
                        labels: [
                            <?php 
                            while($row = $documents_time_result->fetch_assoc()) {
                                echo "'" . date('M d', strtotime($row['date'])) . "', ";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Documents Uploaded',
                            data: [
                                <?php 
                                $documents_time_result->data_seek(0);
                                while($row = $documents_time_result->fetch_assoc()) {
                                    echo $row['count'] . ", ";
                                }
                                ?>
                            ],
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            tension: 0.3,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>
        
       
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>