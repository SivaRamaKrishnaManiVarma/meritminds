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

// Check if ID is provided
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Get and sanitize the ID
    $payment_id = intval($_GET['id']);
    
    // Prepare a delete statement
    $delete_sql = "DELETE FROM student_financials WHERE id = ?";
    
    if($stmt = $conn->prepare($delete_sql)) {
        // Bind variables to the prepared statement
        $stmt->bind_param("i", $payment_id);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Set success message
            $_SESSION['status_message'] = "Payment record deleted successfully!";
            $_SESSION['status_type'] = "success";
        } else {
            // Set error message
            $_SESSION['status_message'] = "Error deleting payment record: " . $conn->error;
            $_SESSION['status_type'] = "danger";
        }
        
        // Close statement
        $stmt->close();
    } else {
        // Set error message
        $_SESSION['status_message'] = "Error preparing statement: " . $conn->error;
        $_SESSION['status_type'] = "danger";
    }
} else {
    // No valid ID provided
    $_SESSION['status_message'] = "No payment ID provided for deletion.";
    $_SESSION['status_type'] = "danger";
}

// Close connection
$conn->close();

// Redirect back to financials page
header("Location: financials.php");
exit;
?>