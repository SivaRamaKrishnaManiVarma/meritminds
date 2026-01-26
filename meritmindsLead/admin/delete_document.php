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

// Initialize status message
$status_message = '';
$status_type = '';

// Check if ID parameter exists
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // First, get the document details to retrieve the file path
    $document_query = "SELECT file_path, student_id, material, file_name FROM application_materials WHERE id = ?";
    $stmt = $conn->prepare($document_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 0) {
        $status_message = "Document not found.";
        $status_type = "danger";
    } else {
        $document = $result->fetch_assoc();
        $file_path = $document['file_path'];
        $student_id = $document['student_id'];
        $material_type = $document['material'];
        $file_name = $document['file_name'];
        
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Delete the database record
            $delete_sql = "DELETE FROM application_materials WHERE id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            if($stmt->affected_rows > 0) {
                // Also delete the physical file if it exists
                if(file_exists($file_path)) {
                    if(unlink($file_path)) {
                        // Log the activity
                        $description = "Document '$material_type' ($file_name) was deleted";
                        $activity_sql = "INSERT INTO activity_log (student_id, activity_type, description, created_at) VALUES (?, 'Document Deleted', ?, NOW())";
                        $stmt = $conn->prepare($activity_sql);
                        $stmt->bind_param("is", $student_id, $description);
                        $stmt->execute();
                        
                        // Commit the transaction
                        $conn->commit();
                        
                        $status_message = "Document deleted successfully.";
                        $status_type = "success";
                    } else {
                        throw new Exception("Database record deleted but failed to remove the physical file. Please check file permissions.");
                    }
                } else {
                    // If file doesn't exist, just log the activity
                    $description = "Document '$material_type' ($file_name) was deleted (file not found)";
                    $activity_sql = "INSERT INTO activity_log (student_id, activity_type, description, created_at) VALUES (?, 'Document Deleted', ?, NOW())";
                    $stmt = $conn->prepare($activity_sql);
                    $stmt->bind_param("is", $student_id, $description);
                    $stmt->execute();
                    
                    // Commit the transaction
                    $conn->commit();
                    
                    $status_message = "Document record deleted, but the physical file was not found.";
                    $status_type = "warning";
                }
            } else {
                throw new Exception("Failed to delete document record.");
            }
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            
            $status_message = "Error: " . $e->getMessage();
            $status_type = "danger";
        }
    }
} else {
    $status_message = "Invalid document ID.";
    $status_type = "danger";
}

// Store message in session for display after redirect
$_SESSION['status_message'] = $status_message;
$_SESSION['status_type'] = $status_type;

// Redirect back to documents page
header("Location: documents.php");
exit;
?>