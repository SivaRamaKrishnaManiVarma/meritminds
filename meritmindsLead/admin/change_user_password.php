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

// Initialize variables
$user_id = $username = $password = $confirm_password = "";
$password_err = $confirm_password_err = "";
$success_msg = $error_msg = "";

// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate user ID
    if(empty(trim($_POST["user_id"]))) {
        $error_msg = "Invalid user selected.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }
    
    // Get username for display purposes
    $sql = "SELECT username FROM partner_login WHERE id = ?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if($stmt->execute()) {
            $stmt->store_result();
            if($stmt->num_rows == 1) {
                $stmt->bind_result($username);
                $stmt->fetch();
            } else {
                $error_msg = "User not found.";
            }
        } else {
            $error_msg = "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    
    // Validate password - Changed from "password" to "new_password" to match form field name
    if(empty(trim($_POST["new_password"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password - Changed from "confirm_password" to match form field name
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before updating the database
    if(empty($error_msg) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an update statement
        $sql = "UPDATE partner_login SET password = ? WHERE id = ?";
        
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_id = $user_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                // Password updated successfully. Create success message
                $success_msg = "Password for user \"" . $username . "\" has been updated successfully.";
                
                // Add log entry
                $log_action = "Changed password for user: " . $username;
                $admin_username = $_SESSION["admin_username"];
                $log_sql = "INSERT INTO admin_logs (admin_username, action, created_at) VALUES (?, ?, NOW())";
                if($log_stmt = $conn->prepare($log_sql)) {
                    $log_stmt->bind_param("ss", $admin_username, $log_action);
                    $log_stmt->execute();
                    $log_stmt->close();
                }
                
                // Redirect to manage_partners.php with success message
                $_SESSION["status_message"] = $success_msg;
                $_SESSION["status_type"] = "success";
                header("location: manage_partners.php");
                exit;
            } else {
                $error_msg = "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change User Password - Lead Tracking Admin</title>
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lead Tracking Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION["admin_username"]); ?> (<?php echo htmlspecialchars($_SESSION["admin_role"]); ?>)
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="change_password.php"><i class="fas fa-key"></i> Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" style="width: 200px;">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_enquiries.php">
                        <i class="fas fa-user-graduate"></i> Enquiries
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="application_status.php">
                        <i class="fas fa-clipboard-list"></i> Applications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="documents.php">
                        <i class="fas fa-file-alt"></i> Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="financials.php">
                        <i class="fas fa-money-bill"></i> Financials
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_partners.php">
                        <i class="fas fa-users-cog"></i> Partners
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_admin_logs.php">
                        <i class="fas fa-history"></i> Admin Logs
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Change User Password</h1>
            <a href="manage_partners.php" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Partners
            </a>
        </div>
        
        <?php 
        // Display success message if any
        if(!empty($success_msg)) {
            echo '<div class="alert alert-success" role="alert">' . $success_msg . '</div>';
        }
        
        // Display error message if any
        if(!empty($error_msg)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_msg . '</div>';
        }
        ?>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-key me-1"></i> Change Password for <?php echo htmlspecialchars($username); ?>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <div class="invalid-feedback"><?php echo $password_err; ?></div>
                                <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <div class="invalid-feedback"><?php echo $confirm_password_err; ?></div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                                <a href="manage_partners.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>