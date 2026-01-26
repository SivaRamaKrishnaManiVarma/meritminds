<?php
// Start the session at the beginning
session_start();

include 'dbconfig.php';

// Define date range for reports
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-30 days'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'application_status';

// Initialize branch filtering variables
$manager_branch = "";
$is_admin_viewing_all = false;

// Check if the user is logged in
if (isset($_SESSION["manager_logged_in"]) && $_SESSION["manager_logged_in"] === true) {
    // Check if admin with branch filter
    if (isset($_SESSION["manager_role"]) && $_SESSION["manager_role"] == "Admin") {
        $manager_branch = isset($_GET['branch_filter']) ? $_GET['branch_filter'] : "";
        $is_admin_viewing_all = empty($manager_branch);
    } 
    // Otherwise use the branch from manager's session
    else if (isset($_SESSION["manager_branch"])) {
        $manager_branch = $_SESSION["manager_branch"];
        $is_admin_viewing_all = false;
    }
}

// Function to get application status report (branch-specific)
function getApplicationStatusReport($conn, $date_from, $date_to, $branch_name = "", $is_admin_viewing_all = false) {
    $query = "
        SELECT 
            COALESCE(s.status, 'Not Started') as status,
            COUNT(*) as count
        FROM 
            enquiries e
        LEFT JOIN 
            application_status s ON e.id = s.student_id
        WHERE 
            (s.updated_at BETWEEN ? AND ? OR s.updated_at IS NULL)
            " . (!$is_admin_viewing_all ? "AND e.branchName = ?" : "") . "
        GROUP BY 
            COALESCE(s.status, 'Not Started')
        ORDER BY 
            FIELD(COALESCE(s.status, 'Not Started'), 'Complete', 'In Progress', 'Not Started', 'On Hold', 'Rejected', 'Withdrawn')
    ";
    
    $stmt = $conn->prepare($query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    
    if ($is_admin_viewing_all) {
        $stmt->bind_param("ss", $date_from_start, $date_to_end);
    } else {
        $stmt->bind_param("sss", $date_from_start, $date_to_end, $branch_name);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $status_data = [];
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        $status_data[] = $row;
        $total += $row['count'];
    }
    
    return [
        'data' => $status_data,
        'total' => $total
    ];
}

// Function to get document submission report (branch-specific)
function getDocumentReport($conn, $date_from, $date_to, $branch_name = "", $is_admin_viewing_all = false) {
    $query = "
        SELECT 
            m.material,
            COUNT(*) as count
        FROM 
            application_materials m
        JOIN
            enquiries e ON m.student_id = e.id
        WHERE 
            m.uploaded_at BETWEEN ? AND ?
            " . (!$is_admin_viewing_all ? "AND e.branchName = ?" : "") . "
        GROUP BY 
            m.material
        ORDER BY 
            count DESC
    ";
    
    $stmt = $conn->prepare($query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    
    if ($is_admin_viewing_all) {
        $stmt->bind_param("ss", $date_from_start, $date_to_end);
    } else {
        $stmt->bind_param("sss", $date_from_start, $date_to_end, $branch_name);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $document_data = [];
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        $document_data[] = $row;
        $total += $row['count'];
    }
    
    return [
        'data' => $document_data,
        'total' => $total
    ];
}

// Function to get university application report (branch-specific)
function getUniversityReport($conn, $date_from, $date_to, $branch_name = "", $is_admin_viewing_all = false) {
    $query = "
        SELECT 
            a.university_name,
            COUNT(*) as total_applications,
            AVG(a.tuition_fee) as avg_tuition_fee,
            a.currency
        FROM 
            university_applications a
        JOIN
            enquiries e ON a.student_id = e.id
        WHERE 
            a.created_at BETWEEN ? AND ?
            " . (!$is_admin_viewing_all ? "AND e.branchName = ?" : "") . "
        GROUP BY 
            a.university_name, a.currency
        ORDER BY 
            total_applications DESC
    ";
    
    $stmt = $conn->prepare($query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    
    if ($is_admin_viewing_all) {
        $stmt->bind_param("ss", $date_from_start, $date_to_end);
    } else {
        $stmt->bind_param("sss", $date_from_start, $date_to_end, $branch_name);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $university_data = [];
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        $university_data[] = $row;
        $total += $row['total_applications'];
    }
    
    return [
        'data' => $university_data,
        'total' => $total
    ];
}

// Function to get fee status report (branch-specific)
function getFeeReport($conn, $date_from, $date_to, $branch_name = "", $is_admin_viewing_all = false) {
    $query = "
        SELECT 
            f.fee_status,
            COUNT(*) as count,
            SUM(CASE WHEN f.fee_status = 'paid' THEN u.application_fee ELSE 0 END) as total_paid
        FROM 
            student_financials f
        LEFT JOIN
            university_applications u ON f.student_id = u.student_id AND u.id = (
                SELECT id FROM university_applications WHERE student_id = f.student_id LIMIT 1
            )
        JOIN
            enquiries e ON f.student_id = e.id
        WHERE 
            f.updated_at BETWEEN ? AND ?
            " . (!$is_admin_viewing_all ? "AND e.branchName = ?" : "") . "
        GROUP BY 
            f.fee_status
    ";
    
    $stmt = $conn->prepare($query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    
    if ($is_admin_viewing_all) {
        $stmt->bind_param("ss", $date_from_start, $date_to_end);
    } else {
        $stmt->bind_param("sss", $date_from_start, $date_to_end, $branch_name);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $fee_data = [];
    $total = 0;
    $total_paid = 0;
    
    while ($row = $result->fetch_assoc()) {
        $fee_data[] = $row;
        $total += $row['count'];
        if ($row['fee_status'] == 'paid') {
            $total_paid = $row['total_paid'];
        }
    }
    
    return [
        'data' => $fee_data,
        'total' => $total,
        'total_paid' => $total_paid
    ];
}

// Get report data based on report type
$report_data = [];
switch ($report_type) {
    case 'application_status':
        $report_data = getApplicationStatusReport($conn, $date_from, $date_to, $manager_branch, $is_admin_viewing_all);
        $report_title = 'Application Status Report';
        break;
    case 'document_submissions':
        $report_data = getDocumentReport($conn, $date_from, $date_to, $manager_branch, $is_admin_viewing_all);
        $report_title = 'Document Submissions Report';
        break;
    case 'university_applications':
        $report_data = getUniversityReport($conn, $date_from, $date_to, $manager_branch, $is_admin_viewing_all);
        $report_title = 'University Applications Report';
        break;
    case 'fee_status':
        $report_data = getFeeReport($conn, $date_from, $date_to, $manager_branch, $is_admin_viewing_all);
        $report_title = 'Application Fee Status Report';
        break;
    default:
        $report_data = getApplicationStatusReport($conn, $date_from, $date_to, $manager_branch, $is_admin_viewing_all);
        $report_title = 'Application Status Report';
}
?>
<?php include 'header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
<style>
    .header {
        background-color: #4CAF50; /* Green background color, you can change this */
        color: white; /* Text color */
        padding: 10px 0 10px; /* Vertical padding to create space */
        text-align: center; /* Center align the text */
        border-radius: 5px; /* Optional: Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for depth */
        margin-top:10px;
        margin-bottom:20px;
    }

        body { background-color: #f4f6f9; padding-top: 20px; }
        .report-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .report-filters {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .chart-container {
            position: relative;
            height: 400px;
            margin: 20px 0;
        }
        .stat-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: white;
            }
            .report-container {
                box-shadow: none;
                margin: 0;
                padding: 10px;
            }
            .table {
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="report-container">
                    <h2 class="header text-center mb-4"><?php echo $report_title; ?></h2>
                    
                    <!-- Branch Information -->
                    <?php if (!$is_admin_viewing_all && !empty($manager_branch)): ?>
                    <div class="alert alert-info mb-3">
                        <strong>Branch:</strong> <?php echo htmlspecialchars($manager_branch); ?>
                    </div>
                    <?php elseif ($is_admin_viewing_all): ?>
                    <div class="alert alert-info mb-3">
                        <strong>View:</strong> All Branches
                    </div>
                    <?php endif; ?>
                    
                    <!-- Report Filters -->
                    <div class="report-filters no-print">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select id="report_type" name="report_type" class="form-select">
                                    <option value="application_status" <?php echo $report_type == 'application_status' ? 'selected' : ''; ?>>Application Status</option>
                                    <option value="document_submissions" <?php echo $report_type == 'document_submissions' ? 'selected' : ''; ?>>Document Submissions</option>
                                    <option value="university_applications" <?php echo $report_type == 'university_applications' ? 'selected' : ''; ?>>University Applications</option>
                                    <option value="fee_status" <?php echo $report_type == 'fee_status' ? 'selected' : ''; ?>>Fee Status</option>
                                </select>
                            </div>
                            
                            <?php if (isset($_SESSION["manager_role"]) && $_SESSION["manager_role"] == "Admin"): ?>
                            <div class="col-md-2">
                                <label for="branch_filter" class="form-label">Branch</label>
                                <select id="branch_filter" name="branch_filter" class="form-select">
                                    <option value="">All Branches</option>
                                    <?php
                                    $branch_query = "SELECT DISTINCT branchName FROM enquiries ORDER BY branchName";
                                    $branch_result = $conn->query($branch_query);
                                    while ($branch_row = $branch_result->fetch_assoc()) {
                                        $selected = (isset($_GET['branch_filter']) && $_GET['branch_filter'] == $branch_row['branchName']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($branch_row['branchName']) . "' $selected>" . 
                                             htmlspecialchars($branch_row['branchName']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                            <?php else: ?>
                            <div class="col-md-3">
                            <?php endif; ?>
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to; ?>">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Report Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="stat-card">
                                <div class="text-muted">Total Records</div>
                                <div class="stat-value"><?php echo isset($report_data['total']) ? $report_data['total'] : 0; ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-card">
                                <div class="text-muted">Date Range</div>
                                <div class="stat-value" style="font-size: 18px;">
                                    <?php echo date('M d, Y', strtotime($date_from)); ?> - 
                                    <?php echo date('M d, Y', strtotime($date_to)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart -->
                    <div class="chart-container">
                        <canvas id="reportChart"></canvas>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <?php if ($report_type == 'application_status'): ?>
                                        <th>Status</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    <?php elseif ($report_type == 'document_submissions'): ?>
                                        <th>Document Type</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    <?php elseif ($report_type == 'university_applications'): ?>
                                        <th>University</th>
                                        <th>Applications</th>
                                        <th>Avg. Tuition Fee</th>
                                    <?php elseif ($report_type == 'fee_status'): ?>
                                        <th>Fee Status</th>
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($report_type == 'application_status' && isset($report_data['data'])): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['status']; ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                            <td><?php echo round(($row['count'] / ($report_data['total'] > 0 ? $report_data['total'] : 1)) * 100, 1); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'document_submissions' && isset($report_data['data'])): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['material']; ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                            <td><?php echo round(($row['count'] / ($report_data['total'] > 0 ? $report_data['total'] : 1)) * 100, 1); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'university_applications' && isset($report_data['data'])): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['university_name']; ?></td>
                                            <td><?php echo $row['total_applications']; ?></td>
                                            <td>
                                                <?php 
                                                $currency_symbol = '';
                                                switch($row['currency']) {
                                                    case 'USD': $currency_symbol = '$'; break;
                                                    case 'GBP': $currency_symbol = '£'; break;
                                                    case 'EUR': $currency_symbol = '€'; break;
                                                    default: $currency_symbol = '$';
                                                }
                                                echo $currency_symbol . number_format($row['avg_tuition_fee'], 2); 
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'fee_status' && isset($report_data['data'])): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo ucfirst($row['fee_status']); ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                            <td><?php echo round(($row['count'] / ($report_data['total'] > 0 ? $report_data['total'] : 1)) * 100, 1); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No data available for the selected criteria</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Export and Print Actions -->
                    <div class="d-flex justify-content-between mt-4 no-print">
                        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        <div>
                            <!-- <a href="export_data.php?report_type=<?php echo $report_type; ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?><?php echo isset($_GET['branch_filter']) ? '&branch_filter='.$_GET['branch_filter'] : ''; ?>" class="btn btn-success me-2">Export to Excel</a> -->
                            <button onclick="window.print()" class="btn btn-primary">Print Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Generate chart based on report type
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportChart').getContext('2d');
            let reportChart;
            
            <?php if ($report_type == 'application_status' && isset($report_data['data']) && !empty($report_data['data'])): ?>
                const statusLabels = <?php echo json_encode(array_column($report_data['data'], 'status')); ?>;
                const statusData = <?php echo json_encode(array_column($report_data['data'], 'count')); ?>;
                const statusColors = [
                    'rgba(40, 167, 69, 0.7)',  // Complete - green
                    'rgba(255, 193, 7, 0.7)',  // In Progress - yellow
                    'rgba(108, 117, 125, 0.7)',  // Not Started - gray
                    'rgba(0, 123, 255, 0.7)',  // On Hold - blue
                    'rgba(220, 53, 69, 0.7)',  // Rejected - red
                    'rgba(73, 80, 87, 0.7)'    // Withdrawn - dark gray
                ];
                
                reportChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: statusColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: 'Application Status Distribution'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'document_submissions' && isset($report_data['data']) && !empty($report_data['data'])): ?>
                // Limit to top 10 document types for the chart
                const documentLabels = <?php 
                    $top_docs = array_slice($report_data['data'], 0, 10);
                    echo json_encode(array_column($top_docs, 'material')); 
                ?>;
                const documentData = <?php 
                    echo json_encode(array_column($top_docs, 'count')); 
                ?>;
                
                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: documentLabels,
                        datasets: [{
                            label: 'Number of Submissions',
                            data: documentData,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top Document Submissions'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'university_applications' && isset($report_data['data']) && !empty($report_data['data'])): ?>
                // Limit to top 10 universities for the chart
                const universityLabels = <?php 
                    $top_unis = array_slice($report_data['data'], 0, 10);
                    echo json_encode(array_column($top_unis, 'university_name')); 
                ?>;
                const applicationData = <?php 
                    echo json_encode(array_column($top_unis, 'total_applications')); 
                ?>;
                
                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: universityLabels,
                        datasets: [{
                            label: 'Number of Applications',
                            data: applicationData,
                            backgroundColor: 'rgba(153, 102, 255, 0.7)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top University Applications'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'fee_status' && isset($report_data['data']) && !empty($report_data['data'])): ?>
                const feeLabels = <?php echo json_encode(array_map('ucfirst', array_column($report_data['data'], 'fee_status'))); ?>;
                const feeData = <?php echo json_encode(array_column($report_data['data'], 'count')); ?>;
                const feeColors = [
                    'rgba(40, 167, 69, 0.7)',  // Paid - green
                    'rgba(220, 53, 69, 0.7)'   // Unpaid - red
                ];
                
                reportChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: feeLabels,
                        datasets: [{
                            data: feeData,
                            backgroundColor: feeColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: 'Application Fee Payment Status'
                            }
                        }
                    }
                });
            <?php else: ?>
                // Display a message when no data is available
                ctx.font = "16px Arial";
                ctx.fillStyle = "#666";
                ctx.textAlign = "center";
                ctx.fillText("No data available for the selected criteria", ctx.canvas.width/2, ctx.canvas.height/2);
            <?php endif; ?>
        });
    </script>
</body>
</html>