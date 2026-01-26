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

// Initialize pagination variables
$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

// Initialize filter variables
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$where_clause = '';

if (!empty($status_filter)) {
    $status_filter = $conn->real_escape_string($status_filter);
    $where_clause = " WHERE a.status = '$status_filter'";
}

// Query for pagination
$total_records_query = "SELECT COUNT(*) as total FROM application_status a" . $where_clause;
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to get applications with student info
$applications_query = "
    SELECT a.*, e.studentName, e.mobile, e.email, e.program, e.country 
    FROM application_status a
    JOIN enquiries e ON a.student_id = e.id
    $where_clause
    ORDER BY a.updated_at DESC 
    LIMIT $offset, $records_per_page
";
$applications_result = $conn->query($applications_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - Lead Tracking Admin</title>
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
        .badge-not-started {
            background-color: #6c757d;
        }
        .badge-in-progress {
            background-color: #007bff;
        }
        .badge-complete {
            background-color: #28a745;
        }
        .badge-on-hold {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-rejected {
            background-color: #dc3545;
        }
        .badge-withdrawn {
            background-color: #6c757d;
        }
        .filter-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <    <?php include 'topbar.php'; ?>


    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Application Status</h1>
            <!-- <a href="create_application.php" class="btn btn-success">
                <i class="fas fa-plus"></i> New Application
            </a> -->
        </div>
        
        <!-- Filter Box -->
        <div class="card filter-box">
            <div class="card-body">
                <form method="GET" action="application_status.php" class="row g-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label">Filter by Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="Not Started" <?php if($status_filter == 'Not Started') echo 'selected'; ?>>Not Started</option>
                            <option value="In Progress" <?php if($status_filter == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Complete" <?php if($status_filter == 'Complete') echo 'selected'; ?>>Complete</option>
                            <option value="On Hold" <?php if($status_filter == 'On Hold') echo 'selected'; ?>>On Hold</option>
                            <option value="Rejected" <?php if($status_filter == 'Rejected') echo 'selected'; ?>>Rejected</option>
                            <option value="Withdrawn" <?php if($status_filter == 'Withdrawn') echo 'selected'; ?>>Withdrawn</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                        <a href="application_status.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Applications Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clipboard-list me-1"></i> Applications List (<?php echo $total_records; ?> records found)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Program</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($applications_result && $applications_result->num_rows > 0):
                                while($row = $applications_result->fetch_assoc()): 
                                    // Determine badge class based on status
                                    $badge_class = '';
                                    switch($row['status']) {
                                        case 'Not Started':
                                            $badge_class = 'badge-not-started';
                                            break;
                                        case 'In Progress':
                                            $badge_class = 'badge-in-progress';
                                            break;
                                        case 'Complete':
                                            $badge_class = 'badge-complete';
                                            break;
                                        case 'On Hold':
                                            $badge_class = 'badge-on-hold';
                                            break;
                                        case 'Rejected':
                                            $badge_class = 'badge-rejected';
                                            break;
                                        case 'Withdrawn':
                                            $badge_class = 'badge-withdrawn';
                                            break;
                                        default:
                                            $badge_class = 'bg-secondary';
                                    }
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                <td><?php echo htmlspecialchars($row['program']); ?></td>
                                <td><?php echo htmlspecialchars($row['country']); ?></td>
                                <td><span class="badge <?php echo $badge_class; ?>"><?php echo $row['status']; ?></span></td>
                                <td><?php echo date('M d, Y H:i', strtotime($row['updated_at'])); ?></td>
                                <!-- <td>
                                    <a href="view_application.php?id=<?php// echo $row['id']; ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="update_application_status.php?id=<?php// echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="application_documents.php?student_id=<?php// echo $row['student_id']; ?>" class="btn btn-sm btn-secondary" title="Documents">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    <a href="application_history.php?student_id=<?php// echo $row['student_id']; ?>" class="btn btn-sm btn-warning" title="History">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </td> -->
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">No applications found</td>
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
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1).((!empty($status_filter)) ? '&status='.$status_filter : ''); ?>">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo (!empty($status_filter)) ? '&status='.$status_filter : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1).((!empty($status_filter)) ? '&status='.$status_filter : ''); ?>">Next</a>
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