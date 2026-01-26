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
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get enquiry details for logging before deletion
        $enquiry_query = "SELECT studentName, email FROM enquiries WHERE id = ?";
        $stmt = $conn->prepare($enquiry_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) {
            throw new Exception("Enquiry not found.");
        }
        
        $enquiry = $result->fetch_assoc();
        $student_name = $enquiry['studentName'];
        $email = $enquiry['email'];
        
        // Check if there are any related records in the dependent tables
        $tables_with_constraints = [
            'activity_log' => 'student_id',
            'application_materials' => 'student_id',
            'application_status' => 'student_id',
            'bank_statements' => 'student_id',
            'student_financials' => 'student_id',
            'student_university_shortlists' => 'student_id',
            'university_applications' => 'student_id'
        ];
        
        // Delete related records first (foreign key constraints)
        foreach($tables_with_constraints as $table => $fk_column) {
            $delete_related_sql = "DELETE FROM $table WHERE $fk_column = ?";
            $stmt = $conn->prepare($delete_related_sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        
        // Now delete the main enquiry record
        $delete_sql = "DELETE FROM enquiries WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if($stmt->affected_rows > 0) {
            // Commit the transaction
            $conn->commit();
            
            $status_message = "Enquiry for '$student_name' ($email) has been deleted successfully.";
            $status_type = "success";
        } else {
            throw new Exception("Unable to delete enquiry. Record may have already been deleted.");
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        
        $status_message = "Error: " . $e->getMessage();
        $status_type = "danger";
    }
} else {
    $status_message = "Error: Invalid enquiry ID.";
    $status_type = "danger";
}

// Store message in session for display on redirect
$_SESSION['status_message'] = $status_message;
$_SESSION['status_type'] = $status_type;

// Redirect back to enquiries list
header("Location: view_enquiries.php");
exit;
?>