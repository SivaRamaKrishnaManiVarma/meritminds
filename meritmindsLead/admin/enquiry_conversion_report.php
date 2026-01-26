<?php
include 'dbconfig.php';

// Define date range for reports
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-30 days'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'overall_conversion';

// Function to get overall conversion rate report
function getOverallConversionReport($conn, $date_from, $date_to) {
    // Get total enquiries (new_enquiries + enquiries with status 'Prospective')
    $total_query = "
        SELECT 
            DATE_FORMAT(created_date, '%Y-%m') as month,
            COUNT(*) as total_enquiries
        FROM (
            SELECT created_at as created_date FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT created_at as created_date FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            DATE_FORMAT(created_date, '%Y-%m')
        ORDER BY 
            month
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $monthly_data = [];
    $total_enquiries = 0;
    
    while ($row = $total_result->fetch_assoc()) {
        $month = $row['month'];
        $monthly_data[$month]['total_enquiries'] = $row['total_enquiries'];
        $monthly_data[$month]['converted'] = 0; // Initialize
        $total_enquiries += $row['total_enquiries'];
    }
    
    // Get converted enquiries (those in the enquiries table)
    $converted_query = "
        SELECT 
            COUNT(*) as converted,
            DATE_FORMAT(created_at, '%Y-%m') as month
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY 
            month
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    $total_converted = 0;
    
    while ($row = $converted_result->fetch_assoc()) {
        $month = $row['month'];
        if (isset($monthly_data[$month])) {
            $monthly_data[$month]['converted'] = $row['converted'];
        } else {
            $monthly_data[$month]['total_enquiries'] = $row['converted']; // In case there are months with only converted records
            $monthly_data[$month]['converted'] = $row['converted'];
        }
        $total_converted += $row['converted'];
    }
    
    // Calculate conversion rates
    $conversion_data = [];
    foreach ($monthly_data as $month => $data) {
        $month_name = date('M Y', strtotime($month . '-01'));
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $conversion_data[] = [
            'month' => $month_name,
            'total_enquiries' => $data['total_enquiries'],
            'converted' => $data['converted'],
            'conversion_rate' => $conversion_rate
        ];
    }
    
    // Calculate overall conversion rate
    $overall_conversion_rate = $total_enquiries > 0 ? round(($total_converted / $total_enquiries) * 100, 1) : 0;
    
    return [
        'data' => $conversion_data,
        'total_enquiries' => $total_enquiries,
        'total_converted' => $total_converted,
        'overall_conversion_rate' => $overall_conversion_rate
    ];
}

// Function to get conversion by country report
function getConversionByCountryReport($conn, $date_from, $date_to) {
    // Get total enquiries by country (new_enquiries + enquiries)
    $total_query = "
        SELECT 
            country,
            COUNT(*) as total_enquiries
        FROM (
            SELECT country, created_at FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT country, created_at FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            country
        ORDER BY 
            total_enquiries DESC
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $country_data = [];
    $total_enquiries = 0;
    
    while ($row = $total_result->fetch_assoc()) {
        $country = $row['country'] ? $row['country'] : 'Not Specified';
        $country_data[$country]['total_enquiries'] = $row['total_enquiries'];
        $country_data[$country]['converted'] = 0; // Initialize
        $total_enquiries += $row['total_enquiries'];
    }
    
    // Get converted enquiries by country (those in enquiries table)
    $converted_query = "
        SELECT 
            country,
            COUNT(*) as converted
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            country
        ORDER BY 
            converted DESC
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    $total_converted = 0;
    
    while ($row = $converted_result->fetch_assoc()) {
        $country = $row['country'] ? $row['country'] : 'Not Specified';
        if (isset($country_data[$country])) {
            $country_data[$country]['converted'] = $row['converted'];
        } else {
            $country_data[$country]['total_enquiries'] = $row['converted'];
            $country_data[$country]['converted'] = $row['converted'];
        }
        $total_converted += $row['converted'];
    }
    
    // Calculate conversion rates and prepare final data
    $conversion_data = [];
    foreach ($country_data as $country => $data) {
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $conversion_data[] = [
            'country' => $country,
            'total_enquiries' => $data['total_enquiries'],
            'converted' => $data['converted'],
            'conversion_rate' => $conversion_rate
        ];
    }
    
    // Sort by total enquiries
    usort($conversion_data, function($a, $b) {
        return $b['total_enquiries'] - $a['total_enquiries'];
    });
    
    // Limit to top 10 countries for visualization
    $top_countries = array_slice($conversion_data, 0, 10);
    
    return [
        'data' => $conversion_data,
        'top_countries' => $top_countries,
        'total_enquiries' => $total_enquiries,
        'total_converted' => $total_converted,
        'overall_conversion_rate' => $total_enquiries > 0 ? round(($total_converted / $total_enquiries) * 100, 1) : 0
    ];
}

// Function to get conversion by program report
function getConversionByProgramReport($conn, $date_from, $date_to) {
    // Get total enquiries by program (new_enquiries + enquiries)
    $total_query = "
        SELECT 
            program,
            COUNT(*) as total_enquiries
        FROM (
            SELECT program, created_at FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT program, created_at FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            program
        ORDER BY 
            total_enquiries DESC
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $program_data = [];
    $total_enquiries = 0;
    
    while ($row = $total_result->fetch_assoc()) {
        $program = $row['program'] ? $row['program'] : 'Not Specified';
        $program_data[$program]['total_enquiries'] = $row['total_enquiries'];
        $program_data[$program]['converted'] = 0; // Initialize
        $total_enquiries += $row['total_enquiries'];
    }
    
    // Get converted enquiries by program (those in the enquiries table)
    $converted_query = "
        SELECT 
            program,
            COUNT(*) as converted
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            program
        ORDER BY 
            converted DESC
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    $total_converted = 0;
    
    while ($row = $converted_result->fetch_assoc()) {
        $program = $row['program'] ? $row['program'] : 'Not Specified';
        if (isset($program_data[$program])) {
            $program_data[$program]['converted'] = $row['converted'];
        } else {
            $program_data[$program]['total_enquiries'] = $row['converted'];
            $program_data[$program]['converted'] = $row['converted'];
        }
        $total_converted += $row['converted'];
    }
    
    // Calculate conversion rates and prepare final data
    $conversion_data = [];
    foreach ($program_data as $program => $data) {
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $conversion_data[] = [
            'program' => $program,
            'total_enquiries' => $data['total_enquiries'],
            'converted' => $data['converted'],
            'conversion_rate' => $conversion_rate
        ];
    }
    
    // Sort by total enquiries
    usort($conversion_data, function($a, $b) {
        return $b['total_enquiries'] - $a['total_enquiries'];
    });
    
    // Limit to top 10 programs for visualization
    $top_programs = array_slice($conversion_data, 0, 10);
    
    return [
        'data' => $conversion_data,
        'top_programs' => $top_programs,
        'total_enquiries' => $total_enquiries,
        'total_converted' => $total_converted,
        'overall_conversion_rate' => $total_enquiries > 0 ? round(($total_converted / $total_enquiries) * 100, 1) : 0
    ];
}

// Function to get the staff performance report
function getStaffPerformanceReport($conn, $date_from, $date_to) {
    // Query for staff who moved enquiries to prospective students
    $staff_query = "
        SELECT 
            a.admin_username as staff_name,
            COUNT(*) as conversions,
            MIN(e.created_at) as first_conversion,
            MAX(e.created_at) as last_conversion
        FROM 
            enquiries e
        JOIN 
            admin_logs a ON a.details LIKE CONCAT('%', e.studentName, '%') AND a.action = 'Move Enquiry'
        WHERE 
            e.created_at BETWEEN ? AND ?
        GROUP BY 
            a.admin_username
        ORDER BY 
            conversions DESC
    ";
    
    $stmt = $conn->prepare($staff_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $staff_result = $stmt->get_result();
    
    $staff_data = [];
    $total_conversions = 0;
    
    while ($row = $staff_result->fetch_assoc()) {
        $staff_data[] = $row;
        $total_conversions += $row['conversions'];
    }
    
    return [
        'data' => $staff_data,
        'total_conversions' => $total_conversions
    ];
}

// Get report data based on report type
$report_data = [];
switch ($report_type) {
    case 'overall_conversion':
        $report_data = getOverallConversionReport($conn, $date_from, $date_to);
        $report_title = 'Enquiry to Prospective Student Conversion Report';
        break;
    case 'conversion_by_country':
        $report_data = getConversionByCountryReport($conn, $date_from, $date_to);
        $report_title = 'Conversion Rate by Country Report';
        break;
    case 'conversion_by_program':
        $report_data = getConversionByProgramReport($conn, $date_from, $date_to);
        $report_title = 'Conversion Rate by Program Report';
        break;
    case 'staff_performance':
        $report_data = getStaffPerformanceReport($conn, $date_from, $date_to);
        $report_title = 'Staff Performance Report';
        break;
    default:
        $report_data = getOverallConversionReport($conn, $date_from, $date_to);
        $report_title = 'Enquiry to Prospective Student Conversion Report';
}
?>

   

     <!-- Add this to the <head> of your HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', 'Segoe UI', sans-serif;
            color: #444;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 15px;
        }

        /* Report Header */
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }

        /* Report Filters */
        .report-filters {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .report-filters .row {
            align-items: flex-end;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        .form-select, .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            width: 100%;
            box-shadow: none;
        }

        .form-select:focus, .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        /* Generate Report Button */
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            border-radius: 6px;
            padding: 10px 15px;
            font-weight: 500;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        /* Stats Summary Cards */
        .row.mb-4 {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            flex: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .text-muted {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 600;
            color: #333;
        }

        /* Conversion Rate Circle */
        .conversion-rate-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(#4CAF50 0% var(--percentage), #f1f1f1 var(--percentage) 100%);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .conversion-rate-circle::before {
            content: '';
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            position: absolute;
        }

        .conversion-rate-text {
            position: relative;
            z-index: 1;
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        /* Chart Container */
        .chart-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 25px;
            height: 400px;
            margin: 30px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Table Styles */
        /* Data Table Styles */
        .table-responsive {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: none;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            padding: 16px 20px;
            text-align: left;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #dee2e6;
            color: #333;
            font-weight: 400;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            margin-top: 20px;
            gap: 10px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 6px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
            color: white;
            border-radius: 6px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            border-radius: 6px;
            padding: 10px 20px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }

        .btn-secondary:hover, .btn-success:hover, .btn-primary:hover {
            opacity: 0.9;
        }

        /* Print Report button - full width blue button */
        .print-report-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px 20px;
            width: 100%;
            margin-top: 20px;
            font-weight: 500;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .print-report-btn:hover {
            background-color: #0b5ed7;
        }
        .back-to-welcome {
                    position: absolute;
                    top: 20px;
                    left: 20px;
                    color: #fff;
                    background-color: rgba(0, 0, 0, 0.3);
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-decoration: none;
                    transition: all 0.3s;
                }
                
                .back-to-welcome:hover {
                    background-color: rgba(0, 0, 0, 0.5);
                }
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .row.mb-4 {
                flex-direction: column;
            }
            
            .stat-card {
                margin-bottom: 15px;
            }
        }
            
    </style>
</head>

<body>
  
    <div class="container mt-5">
    
        <div class="row justify-content-center">
        <a href="admin_dashboard.php" class="back-to-welcome">
        <i class="fas fa-arrow-left"></i>
        </a>
            <div class="col-lg-10">
                <div class="report-container">
                    <h2 class="header text-center mb-4"><?php echo $report_title; ?></h2>

                    <!-- Report Filters -->
                    <div class="report-filters no-print">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select id="report_type" name="report_type" class="form-select">
                                    <option value="overall_conversion" <?php echo $report_type == 'overall_conversion' ? 'selected' : ''; ?>>Overall Conversion</option>
                                    <option value="conversion_by_country" <?php echo $report_type == 'conversion_by_country' ? 'selected' : ''; ?>>By Country</option>
                                    <option value="conversion_by_program" <?php echo $report_type == 'conversion_by_program' ? 'selected' : ''; ?>>By Program</option>
                                    <option value="staff_performance" <?php echo $report_type == 'staff_performance' ? 'selected' : ''; ?>>Staff Performance</option>
                                </select>
                            </div>
                            <div class="col-md-3">
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

                    <?php if ($report_type != 'staff_performance'): ?>
                    <!-- Report Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="text-muted">Total Enquiries</div>
                                <div class="stat-value"><?php echo number_format($report_data['total_enquiries']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="text-muted">Converted to Prospective</div>
                                <div class="stat-value"><?php echo number_format($report_data['total_converted']); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="text-muted">Conversion Rate</div>
                                <div class="conversion-rate-circle" style="--percentage: <?php echo $report_data['overall_conversion_rate']; ?>%">
                                    <div class="conversion-rate-text"><?php echo $report_data['overall_conversion_rate']; ?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Staff Performance Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="stat-card">
                                <div class="text-muted">Total Conversions</div>
                                <div class="stat-value"><?php echo number_format($report_data['total_conversions']); ?></div>
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
                    <?php endif; ?>

                    <!-- Chart -->
                    <div class="chart-container">
                        <canvas id="reportChart"></canvas>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <?php if ($report_type == 'overall_conversion'): ?>
                                        <th>Month</th>
                                        <th>Total Enquiries</th>
                                        <th>Converted</th>
                                        <th>Conversion Rate</th>
                                    <?php elseif ($report_type == 'conversion_by_country'): ?>
                                        <th>Country</th>
                                        <th>Total Enquiries</th>
                                        <th>Converted</th>
                                        <th>Conversion Rate</th>
                                    <?php elseif ($report_type == 'conversion_by_program'): ?>
                                        <th>Program</th>
                                        <th>Total Enquiries</th>
                                        <th>Converted</th>
                                        <th>Conversion Rate</th>
                                    <?php elseif ($report_type == 'staff_performance'): ?>
                                        <th>Staff Member</th>
                                        <th>Conversions</th>
                                        <th>First Conversion</th>
                                        <th>Last Conversion</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($report_type == 'overall_conversion'): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['month']; ?></td>
                                            <td><?php echo number_format($row['total_enquiries']); ?></td>
                                            <td><?php echo number_format($row['converted']); ?></td>
                                            <td><?php echo $row['conversion_rate']; ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'conversion_by_country'): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['country']; ?></td>
                                            <td><?php echo number_format($row['total_enquiries']); ?></td>
                                            <td><?php echo number_format($row['converted']); ?></td>
                                            <td><?php echo $row['conversion_rate']; ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'conversion_by_program'): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['program']; ?></td>
                                            <td><?php echo number_format($row['total_enquiries']); ?></td>
                                            <td><?php echo number_format($row['converted']); ?></td>
                                            <td><?php echo $row['conversion_rate']; ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif ($report_type == 'staff_performance'): ?>
                                    <?php foreach ($report_data['data'] as $row): ?>
                                        <tr>
                                            <td><?php echo $row['staff_name']; ?></td>
                                            <td><?php echo number_format($row['conversions']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row['first_conversion'])); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row['last_conversion'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="admin_dashboard.php" class="btn-secondary">Back to Dashboard</a>
                            <!-- <a href="export_conversion_data.php?report_type=<?php echo $report_type; ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>" class="btn-success">Export to Excel</a> -->
                            <button onclick="window.print()" class="print-report-btn">Print Report</button>
                        </div>

                        <!-- Print Report Button (Full Width) -->
                       
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

            <?php if ($report_type == 'overall_conversion'): ?>
                const months = <?php echo json_encode(array_column($report_data['data'], 'month')); ?>;
                const totalEnquiries = <?php echo json_encode(array_column($report_data['data'], 'total_enquiries')); ?>;
                const converted = <?php echo json_encode(array_column($report_data['data'], 'converted')); ?>;
                const conversionRates = <?php echo json_encode(array_column($report_data['data'], 'conversion_rate')); ?>;

                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Total Enquiries',
                            data: totalEnquiries,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            order: 1
                        }, {
                            label: 'Converted to Prospective',
                            data: converted,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            order: 2
                        }, {
                            label: 'Conversion Rate (%)',
                            data: conversionRates,
                            type: 'line',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: 4,
                            tension: 0.1,
                            yAxisID: 'percentage',
                            order: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Enquiries'
                                }
                            },
                            percentage: {
                                beginAtZero: true,
                                position: 'right',
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Conversion Rate (%)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Monthly Enquiry Conversion Rates'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'conversion_by_country'): ?>
                const countries = <?php echo json_encode(array_column($report_data['top_countries'], 'country')); ?>;
                const totalEnquiries = <?php echo json_encode(array_column($report_data['top_countries'], 'total_enquiries')); ?>;
                const converted = <?php echo json_encode(array_column($report_data['top_countries'], 'converted')); ?>;
                const conversionRates = <?php echo json_encode(array_column($report_data['top_countries'], 'conversion_rate')); ?>;

                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: countries,
                        datasets: [{
                            label: 'Total Enquiries',
                            data: totalEnquiries,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            order: 1
                        }, {
                            label: 'Converted to Prospective',
                            data: converted,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            order: 2
                        }, {
                            label: 'Conversion Rate (%)',
                            data: conversionRates,
                            type: 'line',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: 4,
                            tension: 0.1,
                            yAxisID: 'percentage',
                            order: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Enquiries'
                                }
                            },
                            percentage: {
                                beginAtZero: true,
                                position: 'right',
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Conversion Rate (%)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Conversion Rates by Country'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'conversion_by_program'): ?>
                const programs = <?php echo json_encode(array_column($report_data['top_programs'], 'program')); ?>;
                const totalEnquiries = <?php echo json_encode(array_column($report_data['top_programs'], 'total_enquiries')); ?>;
                const converted = <?php echo json_encode(array_column($report_data['top_programs'], 'converted')); ?>;
                const conversionRates = <?php echo json_encode(array_column($report_data['top_programs'], 'conversion_rate')); ?>;

                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: programs,
                        datasets: [{
                            label: 'Total Enquiries',
                            data: totalEnquiries,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            order: 1
                        }, {
                            label: 'Converted to Prospective',
                            data: converted,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            order: 2
                        }, {
                            label: 'Conversion Rate (%)',
                            data: conversionRates,
                            type: 'line',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: 4,
                            tension: 0.1,
                            yAxisID: 'percentage',
                            order: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Enquiries'
                                }
                            },
                            percentage: {
                                beginAtZero: true,
                                position: 'right',
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Conversion Rate (%)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Conversion Rates by Program'
                            }
                        }
                    }
                });
            <?php elseif ($report_type == 'staff_performance'): ?>
                const staffNames = <?php echo json_encode(array_column($report_data['data'], 'staff_name')); ?>;
                const conversions = <?php echo json_encode(array_column($report_data['data'], 'conversions')); ?>;

                reportChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: staffNames,
                        datasets: [{
                            label: 'Number of Conversions',
                            data: conversions,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Conversions'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Staff Performance in Converting Enquiries'
                            }
                        }
                    }
                });
            <?php endif; ?>
        });
    </script>
    
</body>
</html>