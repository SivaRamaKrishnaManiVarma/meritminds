<?php
include 'dbconfig.php';

// Enhanced error logging function
function logUploadError($message) {
    error_log("University Shortlist Upload Error: " . $message);
}

// Check if student_id is set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id'])) {
    logUploadError("Invalid student ID");
    header("Location: upload_university_shortlist.php?error=Invalid student ID");
    exit();
}

$student_id = intval($_POST['student_id']);
$file_type = $_POST['file_type'];

// More comprehensive file upload handling
if (isset($_FILES['document']) && $_FILES['document']['error'] != UPLOAD_ERR_OK) {
    $upload_errors = [
        UPLOAD_ERR_INI_SIZE => "File exceeds upload_max_filesize in php.ini",
        UPLOAD_ERR_FORM_SIZE => "File exceeds MAX_FILE_SIZE in HTML form",
        UPLOAD_ERR_PARTIAL => "File was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "PHP extension stopped file upload"
    ];
    
    $error_message = $upload_errors[$_FILES['document']['error']] ?? "Unknown upload error";
    logUploadError($error_message);
    
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=" . urlencode($error_message));
    exit();
}

// Additional file validation
if (!isset($_FILES['document']) || $_FILES['document']['size'] == 0) {
    logUploadError("No file uploaded or empty file");
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=No file uploaded");
    exit();
}

$target_dir = "uploads/university_shortlists/";

// Ensure target directory exists and is writable
if (!is_dir($target_dir) || !is_writable($target_dir)) {
    logUploadError("Upload directory does not exist or is not writable");
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=Server configuration error");
    exit();
}

// Create unique filename
$file_extension = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));
$allowed_types = ['xls', 'xlsx', 'pdf'];

// Strict file type validation
if (!in_array($file_extension, $allowed_types)) {
    logUploadError("Invalid file type: " . $file_extension);
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=Invalid file type. Only Excel and PDF allowed.");
    exit();
}

// Additional file type check using mime type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $_FILES['document']['tmp_name']);
$allowed_mime_types = [
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/pdf'
];

if (!in_array($mime_type, $allowed_mime_types)) {
    logUploadError("Mime type validation failed: " . $mime_type);
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=File type verification failed");
    exit();
}

$unique_filename = $student_id . '_' . $file_type . '_' . uniqid() . '.' . $file_extension;
$target_file = $target_dir . $unique_filename;

// Move uploaded file with additional error checking
if (!move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
    logUploadError("Failed to move uploaded file");
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=File upload failed");
    exit();
}

// Prepare SQL to insert file info
try {
    $stmt = $conn->prepare("INSERT INTO student_university_shortlists (student_id, file_type, file_name, file_path, upload_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isss", $student_id, $file_type, $_FILES['document']['name'], $target_file);
    
    if (!$stmt->execute()) {
        // If database insert fails, remove the uploaded file
        unlink($target_file);
        logUploadError("Database insertion failed: " . $stmt->error);
        header("Location: upload_university_shortlist.php?student_id=$student_id&error=Database error");
        exit();
    }
    
    $stmt->close();
} catch (Exception $e) {
    // Log any unexpected errors
    logUploadError("Unexpected error: " . $e->getMessage());
    header("Location: upload_university_shortlist.php?student_id=$student_id&error=Unexpected server error");
    exit();
}

// Successful upload
header("Location: upload_university_shortlist.php?student_id=$student_id&success=1");
$conn->close();
exit();
?>