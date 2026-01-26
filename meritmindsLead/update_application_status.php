<?php
/**
 * Update Application Status Handler
 * 
 * This file processes the form submission from the status tracker page
 * to update a student's application status.
 */

include 'dbconfig.php';

// Function to log status updates
function logStatusUpdate($message) {
    error_log("Application Status Update: " . $message);
}

// Check if student_id is set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id'])) {
    logStatusUpdate("Invalid student ID");
    header("Location: application_status.php?error=Invalid student ID");
    exit();
}

$student_id = intval($_POST['student_id']);
$application_status = $_POST['application_status'];
$status_update_date = $_POST['status_update_date'];
$notes = isset($_POST['status_notes']) ? $_POST['status_notes'] : '';

// Validate status
$allowed_statuses = ['In Progress', 'Complete', 'On Hold', 'Rejected', 'Withdrawn'];
if (!in_array($application_status, $allowed_statuses)) {
    logStatusUpdate("Invalid status: $application_status");
    header("Location: application_status.php?student_id=$student_id&error=Invalid status");
    exit();
}

// Validate date
if (!empty($status_update_date)) {
    $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
    if (!preg_match($date_regex, $status_update_date)) {
        logStatusUpdate("Invalid date format: $status_update_date");
        header("Location: application_status.php?student_id=$student_id&error=Invalid date format");
        exit();
    }
}

try {
    // Check if student has an existing status record
    $check_query = $conn->prepare("SELECT * FROM application_status WHERE student_id = ?");
    $check_query->bind_param("i", $student_id);
    $check_query->execute();
    $result = $check_query->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE application_status SET 
            status = ?, 
            status_date = ?, 
            notes = ?,
            updated_at = NOW()
            WHERE student_id = ?");
        $stmt->bind_param("sssi", $application_status, $status_update_date, $notes, $student_id);
    } else {
        // Create new record
        $stmt = $conn->prepare("INSERT INTO application_status 
            (student_id, status, status_date, notes, created_at, updated_at) 
            VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("isss", $student_id, $application_status, $status_update_date, $notes);
    }
    
    if (!$stmt->execute()) {
        logStatusUpdate("Database error: " . $stmt->error);
        header("Location: application_status.php?student_id=$student_id&error=Database error: " . $stmt->error);
        exit();
    }
    
    $stmt->close();
    
    // Also log this status update in the activity log
    $log_stmt = $conn->prepare("INSERT INTO activity_log 
        (student_id, activity_type, description, created_at) 
        VALUES (?, 'Status Update', ?, NOW())");
    $log_description = "Application status updated to '{$application_status}'";
    if (!empty($notes)) {
        $log_description .= " - Notes: {$notes}";
    }
    $log_stmt->bind_param("is", $student_id, $log_description);
    $log_stmt->execute();
    $log_stmt->close();
    
} catch (Exception $e) {
    // Log any unexpected errors
    logStatusUpdate("Unexpected error: " . $e->getMessage());
    header("Location: application_status.php?student_id=$student_id&error=Unexpected server error");
    exit();
}

// Successful update
header("Location: application_status.php?student_id=$student_id&success=Status updated successfully");
$conn->close();
exit();