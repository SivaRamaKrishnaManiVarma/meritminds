<?php
include 'dbconfig.php';

// Enhanced error handling
function showError($message) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($message) . "</div>";
    error_log("Edit Program Error: " . $message);
}

// Validate student ID and program ID
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id']) || 
    !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid parameters");
}

$student_id = intval($_GET['student_id']);
$program_id = intval($_GET['id']);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify student exists
try {
    $student_check = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
    if ($student_check === false) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $student_check->bind_param("i", $student_id);
    $student_check->execute();
    $student_result = $student_check->get_result();
    
    if ($student_result->num_rows == 0) {
        die("Student not found");
    }
    $student = $student_result->fetch_assoc();
    
    // Fetch program details - FIXED: Changed table name from university_applications to university_applications
    $program_sql = $conn->prepare("SELECT * FROM university_applications WHERE id = ? AND student_id = ?");
    if ($program_sql === false) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $program_sql->bind_param("ii", $program_id, $student_id);
    $program_sql->execute();
    $program_result = $program_sql->get_result();
    
    if ($program_result->num_rows == 0) {
        die("Program not found or does not belong to this student");
    }
    $program = $program_result->fetch_assoc();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit University Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; padding-top: 50px; }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-container">
                    <!-- Error and Success Messages -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    ?>

                    <h2 class="text-center mb-4">Edit University Program for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    
                    <!-- Edit University Program Form -->
                    <form action="update_university_program.php" method="POST">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="university_name" class="form-label">University Name</label>
                                <input type="text" name="university_name" id="university_name" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['university_name']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="program_name" class="form-label">Program Name</label>
                                <input type="text" name="program_name" id="program_name" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['program_name']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="application_fee" class="form-label">Application Fee (Rs.)</label>
                                <input type="number" name="application_fee" id="application_fee" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['application_fee']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['location']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="duration" class="form-label">Duration (Months)</label>
                                <input type="number" name="duration" id="duration" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['duration']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tuition_fee" class="form-label">Tuition Fee</label>
                                <input type="number" name="tuition_fee" id="tuition_fee" class="form-control" 
                                       value="<?php echo htmlspecialchars($program['tuition_fee']); ?>" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="currency" class="form-label">Currency</label>
                                <select name="currency" id="currency" class="form-select" required>
                                    <option value="dollar" <?php echo ($program['currency'] == 'dollar') ? 'selected' : ''; ?>>Dollar ($)</option>
                                    <option value="pound" <?php echo ($program['currency'] == 'pound') ? 'selected' : ''; ?>>Pound (£)</option>
                                    <option value="euro" <?php echo ($program['currency'] == 'euro') ? 'selected' : ''; ?>>Euro (€)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Program</button>
                            <a href="upload_university_program.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>