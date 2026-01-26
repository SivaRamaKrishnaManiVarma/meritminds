<?php
// Include database configuration
include 'dbconfig.php';

// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = intval($_POST['user_id']);
    $username = $conn->real_escape_string($_POST['username']);
    $role = $conn->real_escape_string($_POST['role']);
    $branch_name = $conn->real_escape_string($_POST['branch_name']);
    
    // Update user information
    $update_sql = "UPDATE partner_login SET username = ?, role = ?, branch_name = ? WHERE id = ?";
    
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("sssi", $username, $role, $branch_name, $user_id);
        
        if ($stmt->execute()) {
            // Success
            $_SESSION['status_message'] = "User updated successfully!";
            $_SESSION['status_type'] = "success";
        } else {
            // Error
            $_SESSION['status_message'] = "Error updating user: " . $stmt->error;
            $_SESSION['status_type'] = "danger";
        }
        
        $stmt->close();
    } else {
        $_SESSION['status_message'] = "Error preparing statement: " . $conn->error;
        $_SESSION['status_type'] = "danger";
    }
    
    // Redirect back to manage_partners.php
    header("Location: manage_partners.php");
    exit;
}
?>