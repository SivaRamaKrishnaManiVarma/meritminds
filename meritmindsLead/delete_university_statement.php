<?php
include 'dbconfig.php';

// Check if parameters are set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id']) ||
    !isset($_GET['student_id']) || !is_numeric($_GET['student_id']) ||
    !isset($_GET['university_application_id']) || !is_numeric($_GET['university_application_id'])) {
    header("Location: upload_university_finalist.php?error=Invalid parameters");
    exit();
}

$statement_id = intval($_GET['id']);
$student_id = intval($_GET['student_id']);
$university_application_id = intval($_GET['university_application_id']);

// Verify the statement exists and belongs to the correct student and university application
$stmt = $conn->prepare("SELECT file_path FROM bank_statements 
                      WHERE id = ? AND student_id = ? AND university_application_id = ?");
$stmt->bind_param("iii", $statement_id, $student_id, $university_application_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $file_path = $row['file_path'];
    
    // Delete the file if it exists
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Delete from database
    $delete_stmt = $conn->prepare("DELETE FROM bank_statements WHERE id = ?");
    $delete_stmt->bind_param("i", $statement_id);
    
    if ($delete_stmt->execute()) {
        header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&success=Statement deleted successfully");
    } else {
        header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&error=Failed to delete statement from database");
    }
    
    $delete_stmt->close();
} else {
    header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&error=Statement not found or access denied");
}

$stmt->close();
$conn->close();
exit();