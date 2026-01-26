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

// Get some basic stats
$totalEnquiriesQuery = "SELECT COUNT(*) as total FROM enquiries";
$totalEnquiriesResult = $conn->query($totalEnquiriesQuery);
$totalEnquiries = $totalEnquiriesResult->fetch_assoc()['total'];

$recentEnquiriesQuery = "SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5";
$recentEnquiriesResult = $conn->query($recentEnquiriesQuery);

// Countries stats
$countriesQuery = "SELECT country, COUNT(*) as count FROM enquiries GROUP BY country ORDER BY count DESC LIMIT 5";
$countriesResult = $conn->query($countriesQuery);

// Intakes stats
$intakesQuery = "SELECT intake, COUNT(*) as count FROM enquiries GROUP BY intake ORDER BY count DESC LIMIT 5";
$intakesResult = $conn->query($intakesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .stats-card {
            text-align: center;
            padding: 20px;
        }
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #4CAF50;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stats-text {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
            <!-- <a href="../New_student_enquiry.php" class="btn btn-success">
                <i class="fas fa-plus"></i> New Enquiry
            </a> -->
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card stats-card">
                    <i class="fas fa-users"></i>
                    <div class="stats-number"><?php echo $totalEnquiries; ?></div>
                    <div class="stats-text">Total Enquiries</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <i class="fas fa-clipboard-check"></i>
                    <div class="stats-number">
                        <?php 
                        $completedApplicationsQuery = "SELECT COUNT(*) as count FROM application_status WHERE status = 'Complete'";
                        $completedResult = $conn->query($completedApplicationsQuery);
                        echo $completedResult->fetch_assoc()['count']; 
                        ?>
                    </div>
                    <div class="stats-text">Completed Applications</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <i class="fas fa-spinner"></i>
                    <div class="stats-number">
                        <?php 
                        $inProgressQuery = "SELECT COUNT(*) as count FROM application_status WHERE status = 'In Progress'";
                        $inProgressResult = $conn->query($inProgressQuery);
                        echo $inProgressResult->fetch_assoc()['count']; 
                        ?>
                    </div>
                    <div class="stats-text">In Progress</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <i class="fas fa-globe-americas"></i>
                    <div class="stats-number">
                        <?php 
                        $countriesCountQuery = "SELECT COUNT(DISTINCT country) as count FROM enquiries";
                        $countriesCountResult = $conn->query($countriesCountQuery);
                        echo $countriesCountResult->fetch_assoc()['count']; 
                        ?>
                    </div>
                    <div class="stats-text">Countries</div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <!-- Recent Enquiries -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i> Recent Enquiries
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
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; while($row = $recentEnquiriesResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i; $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                        <td><?php echo htmlspecialchars($row['program']); ?></td>
                                        <td><?php echo htmlspecialchars($row['country']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="view_enquiries.php" class="btn btn-outline-primary btn-sm">View All Enquiries</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="col-md-4">
                <!-- Countries Stats -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-globe me-1"></i> Top Countries
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php while($row = $countriesResult->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($row['country']); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $row['count']; ?></span>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Intakes Stats -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-calendar me-1"></i> Top Intakes
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php while($row = $intakesResult->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($row['intake']); ?>
                                <span class="badge bg-success rounded-pill"><?php echo $row['count']; ?></span>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>