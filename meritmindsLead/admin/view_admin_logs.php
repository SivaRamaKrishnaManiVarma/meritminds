<?php
// Start session
session_start();

// Check if user is logged in and has admin role
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true || $_SESSION["admin_role"] !== "Admin") {
    header("location: admin_login.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Initialize pagination variables
$records_per_page = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

// Initialize filter variables
$username_filter = isset($_GET['username']) ? $_GET['username'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build WHERE clause for filtering
$where_clauses = [];
$params = [];
$param_types = '';

if(!empty($username_filter)) {
    $where_clauses[] = "admin_username LIKE ?";
    $params[] = "%$username_filter%";
    $param_types .= 's';
}

if(!empty($date_from)) {
    $where_clauses[] = "created_at >= ?";
    $params[] = $date_from . ' 00:00:00';
    $param_types .= 's';
}

if(!empty($date_to)) {
    $where_clauses[] = "created_at <= ?";
    $params[] = $date_to . ' 23:59:59';
    $param_types .= 's';
}

$where_clause = !empty($where_clauses) ? "WHERE " . implode(' AND ', $where_clauses) : '';

// Query for pagination
$total_records_query = "SELECT COUNT(*) as total FROM admin_logs $where_clause";
$total_records_stmt = $conn->prepare($total_records_query);

if(!empty($params)) {
    $total_records_stmt->bind_param($param_types, ...$params);
}

$total_records_stmt->execute();
$total_records_result = $total_records_stmt->get_result();
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to get admin logs
$logs_query = "
    SELECT * FROM admin_logs 
    $where_clause
    ORDER BY created_at DESC 
    LIMIT ?, ?
";

$logs_stmt = $conn->prepare($logs_query);

// Add pagination parameters
$params[] = $offset;
$params[] = $records_per_page;
$param_types .= 'ii';

if(!empty($params)) {
    $logs_stmt->bind_param($param_types, ...$params);
}

$logs_stmt->execute();
$logs_result = $logs_stmt->get_result();

// Get unique usernames for dropdown filter
$usernames_query = "SELECT DISTINCT admin_username FROM admin_logs ORDER BY admin_username";
$usernames_result = $conn->query($usernames_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs - Lead Tracking Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        .table thead th {
            background-color: #4CAF50;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        .filter-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>


    <!-- Main Content -->
    <div class="main-content">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Activity Logs</h1>
            <!-- <a href="export_logs.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Logs
            </a> -->
        </div>
        
        <!-- Filter Box -->
        <div class="card filter-box">
            <div class="card-body">
                <form method="GET" action="view_admin_logs.php" class="row g-3">
                    <div class="col-md-3">
                        <label for="username" class="form-label">Admin Username:</label>
                        <select class="form-select" id="username" name="username">
                            <option value="">All Admins</option>
                            <?php while($username = $usernames_result->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($username['admin_username']); ?>" <?php if($username_filter == $username['admin_username']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($username['admin_username']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Date From:</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Date To:</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to; ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="view_admin_logs.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Logs Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history me-1"></i> Activity Logs (<?php echo $total_records; ?> records found)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Admin</th>
                                <th>Action</th>
                                <th>IP Address</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($logs_result && $logs_result->num_rows > 0):
                                $i=1;
                                while($row = $logs_result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $i; $i++ ?></td>
                                <td><?php echo htmlspecialchars($row['admin_username']); ?></td>
                                <td><?php echo htmlspecialchars($row['action']); ?></td>
                                <td><?php echo htmlspecialchars($row['ip_address'] ?? 'N/A'); ?></td>
                                <td><?php echo date('M d, Y H:i:s', strtotime($row['created_at'])); ?></td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">No logs found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1)
                                .((!empty($username_filter)) ? '&username='.urlencode($username_filter) : '')
                                .((!empty($date_from)) ? '&date_from='.urlencode($date_from) : '')
                                .((!empty($date_to)) ? '&date_to='.urlencode($date_to) : ''); ?>">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; 
                                    echo (!empty($username_filter)) ? '&username='.urlencode($username_filter) : '';
                                    echo (!empty($date_from)) ? '&date_from='.urlencode($date_from) : '';
                                    echo (!empty($date_to)) ? '&date_to='.urlencode($date_to) : '';
                                ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1)
                                .((!empty($username_filter)) ? '&username='.urlencode($username_filter) : '')
                                .((!empty($date_from)) ? '&date_from='.urlencode($date_from) : '')
                                .((!empty($date_to)) ? '&date_to='.urlencode($date_to) : ''); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>