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
$application_status = $_POST['application_status'];
$status_update_date = $_POST['status_update_date'];
$notes = isset($_POST['status_notes']) ? $_POST['status_notes'] : '';

// Verify the university application exists and belongs to the student
$app_check = $conn->prepare("SELECT id FROM university_applications WHERE id = ? AND student_id = ?");
$app_check->bind_param("ii", $university_application_id, $student_id);
$app_check->execute();
$app_result = $app_check->get_result();

if ($app_result->num_rows == 0) {
    header("Location: upload_university_finalist.php?student_id=$student_id&error=Invalid university application");
    exit();
}

// Validate status
$allowed_statuses = ['Not Started', 'In Progress', 'Complete', 'On Hold', 'Rejected', 'Withdrawn', 'Accepted'];
if (!in_array($application_status, $allowed_statuses)) {
    header("Location: university_application_status.php?student_id=$student_id&university_application_id=$university_application_id&error=Invalid status");
    exit();
}

// Validate date
if (!empty($status_update_date)) {
    $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
    if (!preg_match($date_regex, $status_update_date)) {
        header("Location: university_application_status.php?student_id=$student_id&university_application_id=$university_application_id&error=Invalid date format");
        exit();
    }
}

try {
    // Insert new status record (we always add a new record to maintain history)
    $stmt = $conn->prepare("INSERT INTO university_application_status 
        (university_application_id, status, status_date, notes, updated_at) 
        VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isss", $university_application_id, $application_status, $status_update_date, $notes);
    
    if (!$stmt->execute()) {
        header("Location: university_application_status.php?student_id=$student_id&university_application_id=$university_application_id&error=Database error: " . $stmt->error);
        exit();
    }
    
    $stmt->close();
    
    // Also update the main university application status (brief status in the applications table)
    $update_app = $conn->prepare("UPDATE university_applications SET status = ? WHERE id = ?");
    $update_app->bind_param("si", $application_status, $university_application_id);
    $update_app->execute();
    $update_app->close();
    
    // Log this status update in the activity log
    $log_stmt = $conn->prepare("INSERT INTO activity_log 
        (student_id, activity_type, description, created_at) 
        VALUES (?, 'University Status Update', ?, NOW())");
    $log_description = "Application status for university_application_id: {$university_application_id} updated to '{$application_status}'";
    if (!empty($notes)) {
        $log_description .= " - Notes: {$notes}";
    }
    $log_stmt->bind_param("is", $student_id, $log_description);
    $log_stmt->execute();
    $log_stmt->close();
    
    header("Location: university_application_status.php?student_id=$student_id&university_application_id=$university_application_id&success=Status updated successfully");
    
} catch (Exception $e) {
    header("Location: university_application_status.php?student_id=$student_id&university_application_id=$university_application_id&error=Unexpected server error");
    exit();
}

$conn->close();
exit();