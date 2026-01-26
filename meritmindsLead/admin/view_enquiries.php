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

// Initialize search variables
$search = isset($_GET['search']) ? $_GET['search'] : '';
$where_clause = '';

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where_clause = " WHERE studentName LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' OR program LIKE '%$search%' OR country LIKE '%$search%'";
}

// Query for pagination
$total_records_query = "SELECT COUNT(*) as total FROM enquiries" . $where_clause;
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to get enquiries with pagination
$enquiries_query = "SELECT * FROM enquiries" . $where_clause . " ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$enquiries_result = $conn->query($enquiries_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enquiries - Lead Tracking Admin</title>
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
        .pagination .page-item.active .page-link {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .pagination .page-link {
            color: #4CAF50;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .action-buttons .btn {
            margin: 0 2px;
        }
    </style>
</head>
<body>
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>All Enquiries</h1>
            <a href="export_data.php" class="btn btn-success">
                <i class="fas fa-download"></i>  Export Data
            </a>
           
        </div>
        
        <!-- Search Box -->
        <div class="card search-box">
            <div class="card-body">
                <form method="GET" action="view_enquiries.php" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by name, email, phone, program, or country" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="view_enquiries.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Enquiries Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Enquiries List (<?php echo $total_records; ?> records found)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Branch Name</th>
                                <th>Student Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Program</th>
                                <th>Country</th>
                                <th>Intake</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            if($enquiries_result->num_rows > 0):
                                while($row = $enquiries_result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['branchName']); ?></td>

                                <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['program']); ?></td>
                                <td><?php echo htmlspecialchars($row['country']); ?></td>
                                <td><?php echo htmlspecialchars($row['intake']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td class="action-buttons">
                                    <!--<a href="view_enquiry.php?id=<?php //echo $row['id']; ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit_enquiry.php?id=<?php //echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="manage_application.php?student_id=<?php //echo $row['id']; ?>" class="btn btn-sm btn-success" title="Manage Application">
                                        <i class="fas fa-clipboard-check"></i>
                                    </a> -->
                                    <a href="delete_enquiry.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this enquiry?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="9" class="text-center">No enquiries found</td>
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
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1).((!empty($search)) ? '&search='.$search : ''); ?>">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo (!empty($search)) ? '&search='.$search : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1).((!empty($search)) ? '&search='.$search : ''); ?>">Next</a>
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