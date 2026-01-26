<?php
// update_university_program.php - Updates an existing university program

include 'dbconfig.php';

// Check if required parameters are provided
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id']) || 
    !isset($_POST['program_id']) || !is_numeric($_POST['program_id'])) {
    header("Location: upload_university_finalist.php?error=Invalid parameters");
    exit();
}

$student_id = intval($_POST['student_id']);
$program_id = intval($_POST['program_id']);

// Validate required fields
$required_fields = [
    'university_name', 
    'program_name', 
    'application_fee', 
    'location', 
    'duration', 
    'tuition_fee', 
    'currency'
];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        header("Location: edit_university_program.php?id=$program_id&student_id=$student_id&error=All fields are required");
        exit();
    }
}

// Sanitize inputs
$university_name = trim($_POST['university_name']);
$program_name = trim($_POST['program_name']);
$application_fee = intval($_POST['application_fee']);
$location = trim($_POST['location']);
$duration = intval($_POST['duration']);
$tuition_fee = floatval($_POST['tuition_fee']);
$currency = $_POST['currency'];

// Validate numeric fields
if ($application_fee <= 0 || $duration <= 0 || $tuition_fee <= 0) {
    header("Location: edit_university_program.php?id=$program_id&student_id=$student_id&error=Invalid numeric values");
    exit();
}

// Validate currency
$allowed_currencies = ['dollar', 'pound', 'euro'];
if (!in_array($currency, $allowed_currencies)) {
    header("Location: edit_university_program.php?id=$program_id&student_id=$student_id&error=Invalid currency");
    exit();
}

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
    
    // Prepare SQL statement for update
    $stmt = $conn->prepare("UPDATE university_applications SET 
        university_name = ?, 
        program_name = ?, 
        application_fee = ?, 
        location = ?, 
        duration = ?, 
        tuition_fee = ?, 
        currency = ?,
        updated_at = NOW()
        WHERE id = ? AND student_id = ?");
    
    // Check if prepare statement failed
    if ($stmt === false) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    
    // Fixed parameter types - EXACTLY 9 parameters matching the 9 placeholders in the SQL query
    $stmt->bind_param(
        "ssisidsii", 
        $university_name,    // s - string
        $program_name,       // s - string
        $application_fee,    // i - integer
        $location,           // s - string
        $duration,           // i - integer
        $tuition_fee,        // d - double/float
        $currency,           // s - string
        $program_id,         // i - integer
        $student_id          // i - integer
    );
    
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
    error_log("University Program Update Error: " . $e->getMessage());
    if (isset($conn)) {
        $conn->close();
    }
    header("Location: edit_university_program.php?id=$program_id&student_id=$student_id&error=" . urlencode("Failed to update program: " . $e->getMessage()));
    exit();
}
?>