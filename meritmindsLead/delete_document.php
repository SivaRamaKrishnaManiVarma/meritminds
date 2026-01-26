<?php
include 'dbconfig.php';

// Validate inputs
if (!isset($_GET['id']) || !isset($_GET['student_id'])) {
    die("Invalid request");
}

$document_id = intval($_GET['id']);
$student_id = intval($_GET['student_id']);

// Begin transaction for safe deletion
$conn->begin_transaction();

try {
    // First, fetch the file path to delete the physical file
    $stmt = $conn->prepare("SELECT file_path FROM application_materials WHERE id = ? AND student_id = ?");
    $stmt->bind_param("ii", $document_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        throw new Exception("Document not found");
    }

    $document = $result->fetch_assoc();
    $file_path = $document['file_path'];

    // Delete database record
    $delete_stmt = $conn->prepare("DELETE FROM application_materials WHERE id = ? AND student_id = ?");
    $delete_stmt->bind_param("ii", $document_id, $student_id);
    $delete_stmt->execute();

    // Delete physical file
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Commit transaction
    $conn->commit();

    // Redirect back to the upload page
    header("Location: upload_materials.php?student_id=$student_id&success=Document deleted successfully");
    exit();

} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();

    // Redirect with error message
    header("Location: upload_materials.php?student_id=$student_id&error=" . urlencode($e->getMessage()));
    exit();
}
?>