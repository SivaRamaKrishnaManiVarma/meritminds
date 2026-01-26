<?php
session_start(); // Make sure session is started
include 'dbconfig.php';

// Check if manager is logged in and has branch stored in session
if (!isset($_SESSION["manager_logged_in"]) || !isset($_SESSION["manager_branch"])) {
    header("location: manager_login.php");
    exit;
}

// Get manager's branch
$manager_branch = $_SESSION["manager_branch"];
$manager_name = isset($_SESSION["manager_name"]) ? $_SESSION["manager_name"] : "Manager";

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'updated_at';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC';

// Prepare base query with branch filter
$base_query = "
    SELECT  e.id, e.studentName, e.mobile as contact, e.email, e.branchName, 
           e.created_at as enquiry_date,
           s.status, s.status_date, s.updated_at,
           f.fee_status, f.payment_date,
           (SELECT COUNT(*) FROM application_materials WHERE student_id = e.id) as document_count,
           (SELECT COUNT(*) FROM university_applications WHERE student_id = e.id) as application_count
    FROM enquiries e
    LEFT JOIN application_status s ON e.id = s.student_id
    LEFT JOIN student_financials f ON e.id = f.student_id
    WHERE e.branchName = ?
";

// Add filters if provided
$params = [$manager_branch]; // Start with the branch parameter
$types = 's'; // String type for branch

if (!empty($status_filter)) {
    $base_query .= " AND (s.status = ? OR (s.status IS NULL AND ? = 'Not Started'))";
    $params[] = $status_filter;
    $params[] = $status_filter;
    $types .= 'ss';
}

if (!empty($search)) {
    $search_param = "%$search%";
    $base_query .= " AND (e.studentName LIKE ? OR e.mobile LIKE ? OR e.email LIKE ?)";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

// Add sorting
$allowed_sort_fields = ['studentName', 'enquiry_date', 'updated_at', 'status', 'fee_status', 'document_count', 'application_count'];
$allowed_sort_orders = ['ASC', 'DESC'];

if (!in_array($sort_by, $allowed_sort_fields)) {
    $sort_by = 'updated_at';
}

if (!in_array($sort_order, $allowed_sort_orders)) {
    $sort_order = 'DESC';
}

// Special handling for sorting by status (to handle NULL values properly)
if ($sort_by === 'status') {
    $base_query .= " ORDER BY COALESCE(s.status, 'Not Started') $sort_order";
} else if ($sort_by === 'updated_at') {
    $base_query .= " ORDER BY COALESCE(s.updated_at, e.created_at) $sort_order";
} else if ($sort_by === 'enquiry_date') {
    $base_query .= " ORDER BY e.created_at $sort_order";
} else {
    $base_query .= " ORDER BY $sort_by $sort_order";
}

// Prepare and execute the query
$stmt = $conn->prepare($base_query);

// Check if prepare was successful
if ($stmt === false) {
    die("Error in query preparation: " . $conn->error);
}

// Bind parameters
$stmt->bind_param($types, ...$params);

// Check execution success
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

// Get summary statistics
$stats_query = "
    SELECT 
        COUNT(*) as total_students,
        COUNT(CASE WHEN COALESCE(s.status, 'Not Started') = 'Complete' THEN 1 END) as completed,
        COUNT(CASE WHEN COALESCE(s.status, 'Not Started') = 'In Progress' THEN 1 END) as in_progress,
        COUNT(CASE WHEN f.fee_status = 'paid' THEN 1 END) as fees_paid,
        SUM(CASE WHEN ua.id IS NOT NULL THEN 1 ELSE 0 END) as total_applications,
        COUNT(DISTINCT e.id) as unique_students
    FROM 
        enquiries e
    LEFT JOIN 
        application_status s ON e.id = s.student_id
    LEFT JOIN 
        student_financials f ON e.id = f.student_id
    LEFT JOIN 
        university_applications ua ON e.id = ua.student_id
    WHERE
        e.branchName = ?
";

$stats_stmt = $conn->prepare($stats_query);
$stats_stmt->bind_param("s", $manager_branch);
$stats_stmt->execute();
$stats_result = $stats_stmt->get_result();
$stats = $stats_result->fetch_assoc();

// Also filter status counts by branch
$count_query = "
    SELECT 
        COALESCE(s.status, 'Not Started') as status, 
        COUNT(*) as count
    FROM 
        enquiries e
    LEFT JOIN 
        application_status s ON e.id = s.student_id
    WHERE
        e.branchName = ?
    GROUP BY 
        COALESCE(s.status, 'Not Started')
";

// Initialize status counts
$status_counts = [
    'Total' => 0,
    'Not Started' => 0,
    'In Progress' => 0,
    'Complete' => 0,
    'On Hold' => 0,
    'Rejected' => 0,
    'Withdrawn' => 0
];

// Execute the count query with branch parameter
$count_stmt = $conn->prepare($count_query);
if ($count_stmt) {
    $count_stmt->bind_param("s", $manager_branch);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    
    while ($row = $count_result->fetch_assoc()) {
        $status_counts[$row['status']] = $row['count'];
        $status_counts['Total'] += $row['count'];
    }
    
    $count_stmt->close();
} else {
    error_log("Error in status count query: " . $conn->error);
}

// Get recent activities
$activities_query = "
    SELECT 
        a.*, e.studentName
    FROM 
        activity_log a
    JOIN
        enquiries e ON a.student_id = e.id
    WHERE
        e.branchName = ?
    ORDER BY 
        a.created_at DESC
    LIMIT 5
";

$activities_stmt = $conn->prepare($activities_query);
$activities_stmt->bind_param("s", $manager_branch);
$activities_stmt->execute();
$activities_result = $activities_stmt->get_result();
$recent_activities = [];
while ($row = $activities_result->fetch_assoc()) {
    $recent_activities[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tracking Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #3a4f7a;
            --secondary-color: #6098d1;
            --accent-color: #557c93;
            --light-color: #f0f7ff;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .dashboard-container {
            padding: 1.5rem;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1.5rem;
            position: sticky;
            top: 1.5rem;
            height: calc(100vh - 3rem);
            overflow-y: auto;
        }
        
        .main-content {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1.5rem;
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .sidebar-header .avatar {
            width: 45px;
            height: 45px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 0.75rem;
        }
        
        .sidebar-header .info h5 {
            margin-bottom: 0;
            font-size: 1rem;
        }
        
        .sidebar-header .info small {
            color: #6c757d;
        }
        
        .nav-pills .nav-link {
            color: var(--dark-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 0.25rem 0.5rem rgba(58, 79, 122, 0.2);
        }
        
        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(58, 79, 122, 0.1);
        }
        
        .count-badge {
            background-color: #e9ecef;
            color: var(--dark-color);
            font-size: 0.75rem;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            font-weight: 600;
        }
        
        .nav-link.active .count-badge {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-not-started { background-color: #e9ecef; color: #495057; }
        .status-in-progress { background-color: #fff3cd; color: #856404; }
        .status-complete { background-color: #d4edda; color: #155724; }
        .status-on-hold { background-color: #cce5ff; color: #004085; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .status-withdrawn { background-color: #d6d8db; color: #383d41; }
        
        .list-group-item {
            border: none;
            padding: 0.75rem 1rem;
            background-color: transparent;
            position: relative;
        }
        
        .list-group-item:hover {
            background-color: rgba(58, 79, 122, 0.05);
        }
        
        .list-group-item i {
            color: var(--primary-color);
        }
        
        .list-group-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .list-group-item:last-child::after {
            display: none;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
        }
        
        .search-form {
            position: relative;
        }
        
        .search-form .form-control {
            padding-left: 2.5rem;
            border-radius: 0.5rem;
            background-color: #f5f7fb;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .search-form .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            border-top: none;
            padding: 0.75rem 1rem;
        }
        
        .table td {
            vertical-align: middle;
            padding: 0.75rem 1rem;
        }
        
        .table tr:hover {
            background-color: rgba(58, 79, 122, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2c3e5d;
            border-color: #2c3e5d;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .stat-card {
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background-color: white;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-primary { background-color: rgba(58, 79, 122, 0.1); color: var(--primary-color); }
        .stat-success { background-color: rgba(46, 204, 113, 0.1); color: var(--success-color); }
        .stat-warning { background-color: rgba(243, 156, 18, 0.1); color: var(--warning-color); }
        .stat-info { background-color: rgba(52, 152, 219, 0.1); color: var(--info-color); }
        
        .stat-title {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .sort-icon {
            font-size: 0.75rem;
            margin-left: 0.25rem;
        }
        
        .recent-activity {
            padding: 1.25rem;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-top: 1.5rem;
        }
        
        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-right: 0.75rem;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-content p {
            margin-bottom: 0;
            font-size: 0.875rem;
        }
        
        .activity-content .activity-time {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .activity-status {
            background-color: rgba(58, 79, 122, 0.1);
            color: var(--primary-color);
        }
        
        .activity-document {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--info-color);
        }
        
        .activity-application {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                height: auto;
                margin-bottom: 1.5rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .d-flex.justify-content-between {
                flex-direction: column;
            }
            
            .search-form {
                margin-top: 1rem;
                width: 100%;
            }
        }
        
        /* Sortable columns styling */
        .sortable {
            cursor: pointer;
            position: relative;
        }
        
        .sortable:hover {
            background-color: #e9ecef;
        }
        
        .sort-indicator {
            display: inline-block;
            vertical-align: middle;
            margin-left: 0.25rem;
        }
        /* Increase z-index for dropdown menus */
    .dropdown-menu {
        z-index: 1050 !important; /* Higher than other elements */
    }
    
    /* Ensure dropdown parent has correct positioning */
    .dropdown {
        position: relative !important;
    }
    
    /* Make sure table cells with dropdowns have proper overflow */
    table td {
        overflow: visible !important;
    }
    
    /* Fix for dropdowns in tables */
    .table-responsive {
        overflow: visible !important;
    }
    
    /* Optional: Add pointer cursor to dropdown buttons */
    .dropdown-toggle {
        cursor: pointer;
    }
    </style>
</head>
<?php include "header.php"?>
<body>
    <div class="dashboard-container mt-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <div class="avatar">
                            <?php echo strtoupper(substr($manager_name, 0, 1)); ?>
                        </div>
                        <div class="info">
                            <h5><?php echo htmlspecialchars($manager_name); ?></h5>
                            <small><?php echo htmlspecialchars($manager_branch); ?> Branch</small>
                        </div>
                    </div>
                    
                    <h6 class="text-uppercase text-muted mb-3 fw-semibold fs-7">Application Status</h6>
                    <div class="nav flex-column nav-pills mb-4">
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo empty($status_filter) ? 'active' : ''; ?>" href="dashboard.php">
                            <span><i class="bi bi-grid-1x2-fill me-2"></i> All Applications</span>
                            <span class="count-badge"><?php echo $status_counts['Total']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'Not Started' ? 'active' : ''; ?>" href="dashboard.php?status=Not Started">
                            <span><i class="bi bi-hourglass me-2"></i> Not Started</span>
                            <span class="count-badge"><?php echo $status_counts['Not Started']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'In Progress' ? 'active' : ''; ?>" href="dashboard.php?status=In Progress">
                            <span><i class="bi bi-clock-history me-2"></i> In Progress</span>
                            <span class="count-badge"><?php echo $status_counts['In Progress']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'Complete' ? 'active' : ''; ?>" href="dashboard.php?status=Complete">
                            <span><i class="bi bi-check-circle me-2"></i> Complete</span>
                            <span class="count-badge"><?php echo $status_counts['Complete']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'On Hold' ? 'active' : ''; ?>" href="dashboard.php?status=On Hold">
                            <span><i class="bi bi-pause-circle me-2"></i> On Hold</span>
                            <span class="count-badge"><?php echo $status_counts['On Hold']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'Rejected' ? 'active' : ''; ?>" href="dashboard.php?status=Rejected">
                            <span><i class="bi bi-x-circle me-2"></i> Rejected</span>
                            <span class="count-badge"><?php echo $status_counts['Rejected']; ?></span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center <?php echo $status_filter === 'Withdrawn' ? 'active' : ''; ?>" href="dashboard.php?status=Withdrawn">
                            <span><i class="bi bi-arrow-left-circle me-2"></i> Withdrawn</span>
                            <span class="count-badge"><?php echo $status_counts['Withdrawn']; ?></span>
                        </a>
                    </div>
                    
                    <h6 class="text-uppercase text-muted mb-3 fw-semibold fs-7">Quick Actions</h6>
                    <div class="list-group mb-4">
                        <a href="New_Student_Enquiry.php" class="list-group-item list-group-item-action">
                            <i class="bi bi-plus-circle me-2"></i> New Student
                        </a>
                        <a href="generate_report.php" class="list-group-item list-group-item-action">
                            <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                        </a>
                        <a href="export_data.php" class="list-group-item list-group-item-action">
                            <i class="bi bi-download me-2"></i> Export Data
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Statistics Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon stat-primary">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-title">Total Prospectived Students</div>
                            <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon stat-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-title">Completed</div>
                            <div class="stat-value"><?php echo $stats['completed']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon stat-warning">
                                <i class="bi bi-arrow-clockwise"></i>
                            </div>
                            <div class="stat-title">In Progress</div>
                            <div class="stat-value"><?php echo $stats['in_progress']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <!-- <div class="stat-card">
                            <div class="stat-icon stat-info">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div class="stat-title">Applications</div>
                            <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
                        </div> -->
                    </div>
                </div>

                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="page-title mb-0">
                            Student Applications
                            <?php if (!empty($status_filter)): ?>
                                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $status_filter)); ?>">
                                    <?php echo $status_filter; ?>
                                </span>
                            <?php endif; ?>
                        </h2>
                        
                        <!-- Search Form -->
                        <form class="d-flex search-form" method="GET" action="dashboard.php">
                            <?php if (!empty($status_filter)): ?>
                                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status_filter); ?>">
                            <?php endif; ?>
                            <span class="search-icon"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search students..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                        </form>
                    </div>
                    
                    <!-- Students Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="sortable" onclick="sortTable('studentName')">
                                        Student Name
                                        <?php if ($sort_by == 'studentName'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th>Contact</th>
                                    <th class="sortable" onclick="sortTable('status')">
                                        Status
                                        <?php if ($sort_by == 'status'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th class="sortable" onclick="sortTable('fee_status')">
                                        Fee
                                        <?php if ($sort_by == 'fee_status'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th class="sortable" onclick="sortTable('document_count')">
                                        Docs
                                        <?php if ($sort_by == 'document_count'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th class="sortable" onclick="sortTable('application_count')">
                                        Apps
                                        <?php if ($sort_by == 'application_count'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th class="sortable" onclick="sortTable('updated_at')">
                                        Updated
                                        <?php if ($sort_by == 'updated_at'): ?>
                                            <span class="sort-indicator">
                                                <?php echo $sort_order == 'ASC' ? '↑' : '↓'; ?>
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($students) > 0): ?>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2" style="width: 32px; height: 32px; background-color: #3a4f7a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                                        <?php echo strtoupper(substr($student['studentName'], 0, 1)); ?>
                                                    </div>
                                                    <div>
                                                        <?php echo htmlspecialchars($student['studentName']); ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo htmlspecialchars($student['contact']); ?>
                                                    <div class="small text-muted"><?php echo htmlspecialchars($student['email']); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = isset($student['status']) ? $student['status'] : 'Not Started';
                                                $status_class = strtolower(str_replace(' ', '-', $status));
                                                ?>
                                                <span class="status-badge status-<?php echo $status_class; ?>">
                                                    <?php echo $status; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $fee_status = isset($student['fee_status']) ? $student['fee_status'] : 'unpaid';
                                                $fee_badge_class = ($fee_status == 'paid') ? 'bg-success' : 'bg-danger';
                                                ?>
                                                <span class="badge <?php echo $fee_badge_class; ?>">
                                                    <?php echo ucfirst($fee_status); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <?php echo $student['document_count']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <?php echo $student['application_count']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $last_updated = isset($student['updated_at']) ? $student['updated_at'] : null;
                                                if (!empty($last_updated)) {
                                                    $date = new DateTime($last_updated);
                                                    $now = new DateTime();
                                                    $diff = $now->diff($date);
                                                    
                                                    if ($diff->days == 0) {
                                                        // Today
                                                        echo 'Today ' . $date->format('H:i');
                                                    } else if ($diff->days == 1) {
                                                        // Yesterday
                                                        echo 'Yesterday';
                                                    } else if ($diff->days < 7) {
                                                        // This week
                                                        echo $diff->days . ' days ago';
                                                    } else {
                                                        echo $date->format('M d, Y');
                                                    }
                                                } else {
                                                    echo '<span class="text-muted">Never</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu" style="z-index:1000">
                                                        <li><a class="dropdown-item" href="application_status.php?student_id=<?php echo $student['id']; ?>">
                                                            <i class="bi bi-clipboard-check me-2"></i> Track Application
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="upload_materials.php?student_id=<?php echo $student['id']; ?>">
                                                            <i class="bi bi-file-earmark-text me-2"></i> Upload Documents
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="upload_university_finalist.php?student_id=<?php echo $student['id']; ?>">
                                                            <i class="bi bi-building me-2"></i> University Applications
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="bank_statement.php?student_id=<?php echo $student['id']; ?>">
                                                            <i class="bi bi-cash-stack me-2"></i> Bank Statements
                                                        </a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="student_profile.php?student_id=<?php echo $student['id']; ?>">
                                                            <i class="bi bi-person-badge me-2"></i> View Profile
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-search mb-3" style="font-size: 2rem; color: #6c757d;"></i>
                                                <h5>No students found</h5>
                                                <p class="text-muted">Try adjusting your search or filter criteria</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h5 class="mb-3">Recent Activity</h5>
                    <?php if (count($recent_activities) > 0): ?>
                        <?php foreach ($recent_activities as $activity): ?>
                            <div class="activity-item d-flex align-items-start">
                                <?php 
                                $icon_class = 'activity-status';
                                $icon = 'bi-clock-history';
                                
                                if (strpos($activity['activity_type'], 'Document') !== false) {
                                    $icon_class = 'activity-document';
                                    $icon = 'bi-file-earmark-text';
                                } else if (strpos($activity['activity_type'], 'Application') !== false) {
                                    $icon_class = 'activity-application';
                                    $icon = 'bi-building';
                                } else if (strpos($activity['activity_type'], 'Status') !== false) {
                                    $icon_class = 'activity-status';
                                    $icon = 'bi-arrow-clockwise';
                                }
                                ?>
                                <div class="activity-icon <?php echo $icon_class; ?>">
                                    <i class="bi <?php echo $icon; ?>"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="mb-1">
                                        <strong><?php echo htmlspecialchars($activity['studentName']); ?></strong>: 
                                        <?php echo htmlspecialchars($activity['description']); ?>
                                    </p>
                                    <p class="activity-time">
                                        <?php 
                                        $date = new DateTime($activity['created_at']);
                                        $now = new DateTime();
                                        $diff = $now->diff($date);
                                        
                                        if ($diff->days == 0) {
                                            if ($diff->h == 0) {
                                                if ($diff->i == 0) {
                                                    echo 'Just now';
                                                } else {
                                                    echo $diff->i . ' minutes ago';
                                                }
                                            } else {
                                                echo $diff->h . ' hours ago';
                                            }
                                        } else if ($diff->days == 1) {
                                            echo 'Yesterday';
                                        } else {
                                            echo $date->format('M d, Y');
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-activity mb-3" style="font-size: 2rem; color: #6c757d;"></i>
                            <p class="mb-0 text-muted">No recent activities found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
        // Function to handle sorting
        function sortTable(column) {
            let currentSortBy = '<?php echo $sort_by; ?>';
            let currentSortOrder = '<?php echo $sort_order; ?>';
            let newSortOrder = 'ASC';
            
            if (currentSortBy === column) {
                // If already sorting by this column, toggle the order
                newSortOrder = currentSortOrder === 'ASC' ? 'DESC' : 'ASC';
            }
            
            // Redirect with new sorting parameters
            let url = new URL(window.location.href);
            url.searchParams.set('sort_by', column);
            url.searchParams.set('sort_order', newSortOrder);
            window.location.href = url.toString();
        }
    </script>

</body>
</html>