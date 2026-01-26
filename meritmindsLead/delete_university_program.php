<?php
// delete_university_program.php - Deletes a university program

include 'dbconfig.php';

// Check if required parameters are provided
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id']) || 
    !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: upload_university_finalist.php?error=Invalid parameters");
    exit();
}

$student_id = intval($_GET['student_id']);
$program_id = intval($_GET['id']);

try {
    // Check DB connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    // First verify that this program belongs to this student
    $verify_sql = $conn->prepare("SELECT id FROM university_applications WHERE id = ? AND student_id = ?");
    if ($verify_sql === false) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    
    $verify_sql->bind_param("ii", $program_id, $student_id);
    $verify_sql->execute();
    $verify_result = $verify_sql->get_result();
    
    if ($verify_result->num_rows == 0) {
        throw new Exception("Program not found or does not belong to this student");
    }
    
    // Prepare SQL statement for delete
    $stmt = $conn->prepare("DELETE FROM university_applications WHERE id = ? AND student_id = ?");
    if ($stmt === false) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $program_id, $student_id);
    
    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
    // Redirect back with success message
    header("Location: upload_university_finalist.php?student_id=$student_id&success=1");
    exit();
    
} catch (Exception $e) {
    // Log error and redirect with error message
    error_log("University Program Delete Error: " . $e->getMessage());
    if (isset($conn)) {
        $conn->close();
    }
    header("Location: upload_university_finalist.php?student_id=$student_id&error=" . urlencode("Failed to delete program: " . $e->getMessage()));
    exit();
}
?>