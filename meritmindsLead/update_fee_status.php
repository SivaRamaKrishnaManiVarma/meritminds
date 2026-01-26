<?php
include 'dbconfig.php';

// Check if student_id is set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id'])) {
    header("Location: bank_statement.php?error=Invalid student ID");
    exit();
}

$student_id = intval($_POST['student_id']);
$fee_status = $_POST['fee_status'];
$payment_date = !empty($_POST['payment_date']) ? $_POST['payment_date'] : NULL;
$fee_notes = isset($_POST['fee_notes']) ? $_POST['fee_notes'] : '';

// Check if record already exists
$check_sql = $conn->prepare("SELECT id FROM student_financials WHERE student_id = ?");
$check_sql->bind_param("i", $student_id);
$check_sql->execute();
$check_result = $check_sql->get_result();

if ($check_result->num_rows > 0) {
    // Update existing record
    $row = $check_result->fetch_assoc();
    $stmt = $conn->prepare("UPDATE student_financials SET fee_status = ?, payment_date = ?, fee_notes = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sssi", $fee_status, $payment_date, $fee_notes, $row['id']);
} else {
    // Insert new record
    $stmt = $conn->prepare("INSERT INTO student_financials (student_id, fee_status, payment_date, fee_notes, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("isss", $student_id, $fee_status, $payment_date, $fee_notes);
}

if ($stmt->execute()) {
    header("Location: bank_statement.php?student_id=$student_id&success=Application fee status updated successfully");
} else {
    header("Location: bank_statement.php?student_id=$student_id&error=Database error: " . $conn->error);
}

$stmt->close();
$conn->close();
exit();
?>