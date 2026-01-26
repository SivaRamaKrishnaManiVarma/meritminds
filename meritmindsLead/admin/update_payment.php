<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: financials.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Get form data and sanitize inputs
$payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
$fee_status = isset($_POST['fee_status']) ? $conn->real_escape_string($_POST['fee_status']) : 'unpaid';
$payment_date = null;
if($fee_status == 'paid' && !empty($_POST['payment_date'])) {
    $payment_date = $conn->real_escape_string($_POST['payment_date']);
}
$fee_notes = isset($_POST['fee_notes']) ? $conn->real_escape_string($_POST['fee_notes']) : '';

// Validate inputs
if($payment_id <= 0) {
    $_SESSION['error'] = "Invalid payment record.";
    header("location: financials.php");
    exit;
}

// Prepare the SQL statement
if($fee_status == 'paid' && $payment_date) {
    $sql = "UPDATE student_financials 
            SET fee_status = ?, payment_date = ?, fee_notes = ?, updated_at = NOW() 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fee_status, $payment_date, $fee_notes, $payment_id);
} else {
    // If status is unpaid, we set payment_date to NULL
    $sql = "UPDATE student_financials 
            SET fee_status = ?, payment_date = NULL, fee_notes = ?, updated_at = NOW() 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fee_status, $fee_notes, $payment_id);
}

// Execute the query
if($stmt->execute()) {
    $_SESSION['success'] = "Payment record updated successfully.";
} else {
    $_SESSION['error'] = "Error updating payment record: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to financials page
header("location: financials.php");
exit;
?>