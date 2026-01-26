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

// Check if form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate student_id
    if(empty($_POST['student_id'])) {
        $status_message = "Error: Student must be selected.";
        $status_type = "danger";
    }
    // Validate document_type
    else if(empty($_POST['document_type'])) {
        $status_message = "Error: Document type must be selected.";
        $status_type = "danger";
    }
    // Validate file upload
    else if(!isset($_FILES['document_file']) || $_FILES['document_file']['error'] != UPLOAD_ERR_OK) {
        $error_message = '';
        switch($_FILES['document_file']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = "The uploaded file exceeds the maximum file size limit.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message = "The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = "No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error_message = "Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error_message = "Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $error_message = "A PHP extension stopped the file upload.";
                break;
            default:
                $error_message = "Unknown upload error.";
        }
        $status_message = "Error: " . $error_message;
        $status_type = "danger";
    } else {
        // Get form data
        $student_id = intval($_POST['student_id']);
        $document_type = $_POST['document_type'];
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        
        // If document type is "Other", get the specified type
        if($document_type === "Other" && !empty($_POST['other_document_type'])) {
            $document_type = $_POST['other_document_type'];
        }
        
        // Get file information
        $file = $_FILES['document_file'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        
        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define allowed extensions
        $allowed_extensions = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'txt');
        
        // Validate file extension
        if(!in_array($file_ext, $allowed_extensions)) {
            $status_message = "Error: Invalid file type. Allowed types: " . implode(', ', $allowed_extensions);
            $status_type = "danger";
        }
        // Validate file size (5MB max)
        else if($file_size > 5242880) {
            $status_message = "Error: File size exceeds the maximum limit of 5MB.";
            $status_type = "danger";
        } else {
            // Verify student exists
            $student_query = "SELECT studentName FROM enquiries WHERE id = ?";
            $stmt = $conn->prepare($student_query);
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $student_result = $stmt->get_result();
            
            if($student_result->num_rows === 0) {
                $status_message = "Error: Student not found.";
                $status_type = "danger";
            } else {
                $student = $student_result->fetch_assoc();
                $student_name = $student['studentName'];
                
                // Create uploads directory if it doesn't exist
                $upload_dir = 'uploads/';
                if(!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Generate a unique file name
                $new_file_name = $student_id . '_' . str_replace(' ', '_', $document_type) . '_' . uniqid() . '.' . $file_ext;
                $file_path = $upload_dir . $new_file_name;
                
                // Begin transaction
                $conn->begin_transaction();
                
                try {
                    // Upload the file
                    if(move_uploaded_file($file_tmp, $file_path)) {
                        // Insert record into database
                        $insert_sql = "INSERT INTO application_materials (student_id, material, status, received_date, file_path, file_name, file_size, file_type, uploaded_at) 
                                      VALUES (?, ?, 'Received', NOW(), ?, ?, ?, ?, NOW())";
                        $stmt = $conn->prepare($insert_sql);
                        $stmt->bind_param("isssss", $student_id, $document_type, $file_path, $file_name, $file_size, $file_ext);
                        
                        if($stmt->execute()) {
                            $document_id = $stmt->insert_id;
                            
                            // Log the activity
                            $description = "Document '$document_type' uploaded for $student_name";
                            $activity_sql = "INSERT INTO activity_log (student_id, activity_type, description, created_at) 
                                           VALUES (?, 'Document Upload', ?, NOW())";
                            $stmt = $conn->prepare($activity_sql);
                            $stmt->bind_param("is", $student_id, $description);
                            $stmt->execute();
                            
                            // Commit the transaction
                            $conn->commit();
                            
                            $status_message = "Document uploaded successfully.";
                            $status_type = "success";
                        } else {
                            throw new Exception("Failed to save document record to database.");
                        }
                    } else {
                        throw new Exception("Failed to upload file. Please check directory permissions.");
                    }
                } catch (Exception $e) {
                    // Rollback on error
                    $conn->rollback();
                    
                    // If file was uploaded, try to delete it
                    if(file_exists($file_path)) {
                        unlink($file_path);
                    }
                    
                    $status_message = "Error: " . $e->getMessage();
                    $status_type = "danger";
                }
            }
        }
    }
} else {
    $status_message = "Error: Invalid request method.";
    $status_type = "danger";
}

// Store message in session for display after redirect
$_SESSION['status_message'] = $status_message;
$_SESSION['status_type'] = $status_type;

// Redirect back to documents page
header("Location: documents.php");
exit;
?>