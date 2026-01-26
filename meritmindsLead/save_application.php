<?php
include 'dbconfig.php';

// Enhanced error logging function
function logApplicationError($message) {
    error_log("University Application Error: " . $message);
}

// Check if student_id is set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id'])) {
    logApplicationError("Invalid student ID");
    header("Location: upload_university_finalist.php?error=Invalid student ID");
    exit();
}

// Validate required fields
$required_fields = [
    'university_name', 'program_name', 'application_fee', 
    'location', 'duration', 'tuition_fee', 'currency'
];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        logApplicationError("Missing required field: $field");
        header("Location: upload_university_finalist.php?student_id=" . $_POST['student_id'] . "&error=All fields are required");
        exit();
    }
}

// Sanitize and validate input
$student_id = intval($_POST['student_id']);
$university_name = trim($_POST['university_name']);
$program_name = trim($_POST['program_name']);
$location = trim($_POST['location']);
$application_fee = floatval($_POST['application_fee']);
$duration = intval($_POST['duration']);
$tuition_fee = floatval($_POST['tuition_fee']);
$currency = $_POST['currency'];

// Additional validation
if (strlen($university_name) > 100) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=University name is too long");
    exit();
}

if (strlen($program_name) > 100) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Program name is too long");
    exit();
}

if ($application_fee < 0) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Application fee cannot be negative");
    exit();
}

if ($duration <= 0 || $duration > 120) { // Max 10 years
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Invalid duration");
    exit();
}

if ($tuition_fee < 0) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Tuition fee cannot be negative");
    exit();
}

// Validate currency
$allowed_currencies = ['USD', 'GBP', 'EUR'];
if (!in_array($currency, $allowed_currencies)) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Invalid currency");
    exit();
}

// Prepare SQL to insert application details
try {
    $stmt = $conn->prepare("INSERT INTO university_applications 
        (student_id, university_name, program_name, application_fee, location, duration, tuition_fee, currency, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $stmt->bind_param("issdsisd", 
        $student_id, 
        $university_name, 
        $program_name, 
        $application_fee,
        $location, 
        $duration, 
        $tuition_fee, 
        $currency
    );
    
    if (!$stmt->execute()) {
        logApplicationError("Database insertion failed: " . $stmt->error);
        header("Location: upload_university_finalist.php?student_id=$student_id&error=Database error: " . $stmt->error);
        exit();
    }
    
    $stmt->close();
} catch (Exception $e) {
    // Log any unexpected errors
    logApplicationError("Unexpected error: " . $e->getMessage());
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Unexpected server error");
    exit();
}

// Successful submission
header("Location: upload_university_finalist.php?student_id=$student_id&success=1");
$conn->close();
exit();
?>