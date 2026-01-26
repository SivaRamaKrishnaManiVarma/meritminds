<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION["manager_logged_in"]) && !isset($_SESSION["admin_logged_in"])) {
    header("location: welcome.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Check if ID parameter exists
if(!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid enquiry ID.";
    header("location: index.php");
    exit;
}

$enquiry_id = intval($_GET['id']);

// Fetch the complete enquiry data
$fetch_sql = "SELECT * FROM new_enquiries WHERE id = ?";
$stmt = $conn->prepare($fetch_sql);
$stmt->bind_param("i", $enquiry_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    $_SESSION['error_message'] = "Enquiry not found.";
    header("location: index.php");
    exit;
}

// Get the enquiry data
$enquiry = $result->fetch_assoc();

// Get current user details - Fix for undefined array key issue
$user_id = isset($_SESSION["admin_id"]) ? $_SESSION["admin_id"] : (isset($_SESSION["manager_id"]) ? $_SESSION["manager_id"] : 0);
$username = isset($_SESSION["admin_username"]) ? $_SESSION["admin_username"] : (isset($_SESSION["manager_username"]) ? $_SESSION["manager_username"] : "System");

// Insert the data into the enquiries table
// Fixed SQL query to match exact columns in your enquiries table
$insert_sql = "INSERT INTO enquiries (
    studentName, fatherName, motherName, gender, dob, 
    mobile, email, intake, country, program,
    created_at, surname, given_name, new_email, qualification,
    year_of_pass, percentage, backlogs, inter_english_marks, inter_percentage,
    preferred_universities, preferred_locations, tuition_fee_budget,
    financial_ability, travel_history, visa_refusals,branchName,
    status
) VALUES (
    ?, ?, ?, ?, ?, 
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?, ?,
    ?, ?, ?, ?,
    'Prospective'
)";

$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param(
    "sssssssssssssssssssssssssss",
    $enquiry['studentName'], 
    $enquiry['fatherName'], 
    $enquiry['motherName'], 
    $enquiry['gender'], 
    $enquiry['dob'],
    $enquiry['mobile'], 
    $enquiry['email'], 
    $enquiry['intake'], 
    $enquiry['country'], 
    $enquiry['program'],
    $enquiry['created_at'],
    $enquiry['surname'], 
    $enquiry['given_name'], 
    $enquiry['new_email'], 
    $enquiry['qualification'],
    $enquiry['year_of_pass'], 
    $enquiry['percentage'], 
    $enquiry['backlogs'], 
    $enquiry['inter_english_marks'], 
    $enquiry['inter_percentage'],
    $enquiry['preferred_universities'], 
    $enquiry['preferred_locations'], 
    $enquiry['tuition_fee_budget'],
    $enquiry['financial_ability'], 
    $enquiry['travel_history'], 
    $enquiry['visa_refusals'],
    $enquiry['branchName']
);

// Execute the insert query
if($insert_stmt->execute()) {
    // Optional: Delete the enquiry from new_enquiries table
    $delete_sql = "DELETE FROM new_enquiries WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $enquiry_id);
    $delete_stmt->execute();
    
    // Log the action
    $log_sql = "INSERT INTO admin_logs (login_id, admin_username, action, details, created_at) 
              VALUES (?, ?, 'Move Enquiry', ?, NOW())";
    
    $details = "Moved enquiry ID: " . $enquiry_id . " (" . $enquiry['studentName'] . ") to Prospective Students";
    
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bind_param("iss", $user_id, $username, $details);
    $log_stmt->execute();
    
    // Set success message
    $_SESSION['success_message'] = "Enquiry successfully moved to Prospective Students.";
} else {
    // Set error message
    $_SESSION['error_message'] = "Error moving enquiry: " . $conn->error;
}

// Close connections
$insert_stmt->close();
$stmt->close();
$conn->close();

// Redirect back to the enquiries list
header("location: view_enquiries.php");
exit;
?>