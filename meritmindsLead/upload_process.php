<?php
include 'dbconfig.php';

// Check if student_id is set and valid
if (!isset($_POST['student_id']) || !is_numeric($_POST['student_id'])) {
    header("Location: upload_materials.php?error=Invalid student ID");
    exit();
}

$student_id = intval($_POST['student_id']);
$material_type = $_POST['material_type'];

// File upload handling
if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    
    // Create unique filename
    $file_extension = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $unique_filename = $student_id . '_' . $material_type . '_' . uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        // Prepare SQL to insert file info
        $stmt = $conn->prepare("INSERT INTO application_materials (student_id, material, file_name, file_path, received_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $student_id, $material_type, $_FILES['document']['name'], $target_file);
        
        if ($stmt->execute()) {
            header("Location: upload_materials.php?student_id=$student_id&success=1");
        } else {
            // If database insert fails, remove the uploaded file
            unlink($target_file);
            header("Location: upload_materials.php?student_id=$student_id&error=Database error");
        }
        $stmt->close();
    } else {
        header("Location: upload_materials.php?student_id=$student_id&error=File upload failed");
    }
} else {
    header("Location: upload_materials.php?student_id=$student_id&error=No file uploaded");
}

$conn->close();
exit();
?>