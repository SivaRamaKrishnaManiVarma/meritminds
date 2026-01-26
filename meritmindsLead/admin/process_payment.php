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
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
$fee_status = isset($_POST['fee_status']) ? $conn->real_escape_string($_POST['fee_status']) : 'unpaid';
$payment_date = null;
if($fee_status == 'paid' && !empty($_POST['payment_date'])) {
    $payment_date = $conn->real_escape_string($_POST['payment_date']);
}
$fee_notes = isset($_POST['fee_notes']) ? $conn->real_escape_string($_POST['fee_notes']) : '';

// Validate inputs
if($student_id <= 0) {
    $_SESSION['error'] = "Invalid student selected.";
    header("location: financials.php");
    exit;
}

// Check if this student already has a financial record
$check_query = "SELECT id FROM student_financials WHERE student_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("i", $student_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if($check_result->num_rows > 0) {
    $_SESSION['error'] = "This student already has a financial record. Please edit the existing record instead.";
    header("location: financials.php");
    exit;
}

// Prepare the SQL statement
$sql = "INSERT INTO student_financials (student_id, fee_status, payment_date, fee_notes, created_at, updated_at) 
        VALUES (?, ?, ?, ?, NOW(), NOW())";

$stmt = $conn->prepare($sql);

// Bind parameters
if($payment_date) {
    $stmt->bind_param("isss", $student_id, $fee_status, $payment_date, $fee_notes);
} else {
    $payment_date = NULL;
    $stmt->bind_param("isss", $student_id, $fee_status, $payment_date, $fee_notes);
}

// Execute the query
if($stmt->execute()) {
    $_SESSION['success'] = "Payment record added successfully.";
} else {
    $_SESSION['error'] = "Error adding payment record: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to financials page
header("location: financials.php");
exit;
?>