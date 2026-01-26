<?php
include 'dbconfig.php';

// Check if statement ID and student ID are set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['student_id']) || !is_numeric($_GET['student_id'])) {
    header("Location: bank_statement.php?error=Invalid parameters");
    exit();
}

$statement_id = intval($_GET['id']);
$student_id = intval($_GET['student_id']);

// Get file path before deleting record
$stmt = $conn->prepare("SELECT file_path FROM bank_statements WHERE id = ? AND student_id = ?");
$stmt->bind_param("ii", $statement_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $file_path = $row['file_path'];
    
    // Delete record from database
    $delete_stmt = $conn->prepare("DELETE FROM bank_statements WHERE id = ? AND student_id = ?");
    $delete_stmt->bind_param("ii", $statement_id, $student_id);
    
    if ($delete_stmt->execute()) {
        // Delete file from server
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        header("Location: bank_statement.php?student_id=$student_id&success=Statement deleted successfully");
    } else {
        header("Location: bank_statement.php?student_id=$student_id&error=Failed to delete record");
    }
    $delete_stmt->close();
} else {
    header("Location: bank_statement.php?student_id=$student_id&error=Statement not found");
}

$stmt->close();
$conn->close();
exit();
?>