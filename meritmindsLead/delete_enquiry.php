<?php
// Database connection
include 'dbconfig.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: view_enquiries.php?message=Enquiry deleted successfully!&status=success");
    } else {
        header("Location: view_enquiries.php?message=Error deleting enquiry: " . $conn->error . "&status=error");
    }
    
    $stmt->close();
} else {
    header("Location: view_enquiries.php?message=Invalid enquiry ID&status=error");
}

$conn->close();
?>