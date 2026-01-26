<?php
// This script creates or updates admin credentials
// WARNING: Only run this once and then remove or secure this file

// Include database configuration
include 'dbconfig.php';

// Check if we already have admin accounts
$checkSql = "SELECT COUNT(*) as count FROM partner_login";
$result = $conn->query($checkSql);
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo "<h2>Admin accounts already exist!</h2>";
    echo "<p>If you need to reset or create a new admin account, please use the admin panel or manually update the database.</p>";
    exit;
}

// Create admin and manager accounts
$adminUsername = "admin";
$adminPassword = "admin123"; // Change this to a secure password
$hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

$managerUsername = "manager";
$managerPassword = "manager123"; // Change this to a secure password
$hashedManagerPassword = password_hash($managerPassword, PASSWORD_DEFAULT);

// Prepare and execute SQL to create admin
$adminSql = "INSERT INTO partner_login (username, password, role) VALUES (?, ?, 'Admin')";
$adminStmt = $conn->prepare($adminSql);
$adminStmt->bind_param("ss", $adminUsername, $hashedAdminPassword);
$adminSuccess = $adminStmt->execute();
$adminStmt->close();

// Prepare and execute SQL to create manager
$managerSql = "INSERT INTO partner_login (username, password, role) VALUES (?, ?, 'Manager')";
$managerStmt = $conn->prepare($managerSql);
$managerStmt->bind_param("ss", $managerUsername, $hashedManagerPassword);
$managerSuccess = $managerStmt->execute();
$managerStmt->close();

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 50px;
            background-color: #f8f9fa;
        }
        .setup-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .setup-header {
            text-align: center;
            margin-bottom: 30px;
            color: #4CAF50;
        }
        .setup-content {
            margin-bottom: 30px;
        }
        .credential-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .warning {
            color: #dc3545;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h2>Admin Setup</h2>
        </div>
        
        <div class="setup-content">
            <?php if ($adminSuccess): ?>
                <div class="alert alert-success">Admin account created successfully!</div>
                
                <div class="credential-box">
                    <h4>Admin Credentials</h4>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($adminUsername); ?></p>
                    <p><strong>Password:</strong> <?php echo htmlspecialchars($adminPassword); ?></p>
                    <p><strong>Role:</strong> Admin</p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Failed to create admin account.</div>
            <?php endif; ?>
            
            <?php if ($managerSuccess): ?>
                <div class="alert alert-success">Manager account created successfully!</div>
                
                <div class="credential-box">
                    <h4>Manager Credentials</h4>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($managerUsername); ?></p>
                    <p><strong>Password:</strong> <?php echo htmlspecialchars($managerPassword); ?></p>
                    <p><strong>Role:</strong> Manager</p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Failed to create manager account.</div>
            <?php endif; ?>
            
            <p class="warning">IMPORTANT: For security reasons, please change these default passwords immediately after logging in for the first time, and DELETE THIS SETUP FILE.</p>
            
            <div class="text-center mt-4">
                <a href="admin_login.php" class="btn btn-primary">Go to Admin Login</a>
            </div>
        </div>
    </div>
</body>
</html>