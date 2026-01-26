<?php
include 'dbconfig.php';

// Check if parameters are set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id']) ||
    !isset($_POST['university_application_id']) || !is_numeric($_POST['university_application_id'])) {
    header("Location: upload_university_finalist.php?error=Invalid parameters");
    exit();
}

$student_id = intval($_POST['student_id']);
$university_application_id = intval($_POST['university_application_id']);
$statement_type = $_POST['statement_type'];
$notes = isset($_POST['statement_notes']) ? $_POST['statement_notes'] : '';

// Verify the university application exists and belongs to the student
$app_check = $conn->prepare("SELECT id FROM university_applications WHERE id = ? AND student_id = ?");
$app_check->bind_param("ii", $university_application_id, $student_id);
$app_check->execute();
$app_result = $app_check->get_result();

if ($app_result->num_rows == 0) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Invalid university application");
    exit();
}

// File upload handling
if (isset($_FILES['statement_document']) && $_FILES['statement_document']['error'] == 0) {
    $target_dir = "uploads/bank_statements/universities/"; // Ensure this directory exists and is writable
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Create unique filename
    $file_extension = pathinfo($_FILES['statement_document']['name'], PATHINFO_EXTENSION);
    $unique_filename = $student_id . '_uni' . $university_application_id . '_' . $statement_type . '_' . uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['statement_document']['tmp_name'], $target_file)) {
        // Prepare SQL to insert file info
        $stmt = $conn->prepare("INSERT INTO bank_statements 
            (student_id, university_application_id, statement_type, file_name, file_path, notes, uploaded_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iissss", $student_id, $university_application_id, $statement_type, $_FILES['statement_document']['name'], $target_file, $notes);
        
        if ($stmt->execute()) {
            header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&success=Statement uploaded successfully");
        } else {
            // If database insert fails, remove the uploaded file
            unlink($target_file);
            header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&error=Database error: " . $conn->error);
        }
        $stmt->close();
    } else {
        header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&error=File upload failed");
    }
} else {
    $error_message = "File upload error: ";
    switch ($_FILES['statement_document']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $error_message .= "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $error_message .= "The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form";
            break;
        case UPLOAD_ERR_PARTIAL:
            $error_message .= "The uploaded file was only partially uploaded";
            break;
        case UPLOAD_ERR_NO_FILE:
            $error_message .= "No file was uploaded";
            break;
        default:
            $error_message .= "Unknown error";
    }
    header("Location: university_bank_statement.php?student_id=$student_id&university_application_id=$university_application_id&error=" . urlencode($error_message));
}

$conn->close();
exit();
?>