<?php
include 'dbconfig.php';

// Validate parameters
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id']) ||
    !isset($_GET['university_application_id']) || !is_numeric($_GET['university_application_id'])) {
    die("Invalid parameters");
}

$student_id = intval($_GET['student_id']);
$university_application_id = intval($_GET['university_application_id']);

// Verify student exists
$student_check = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
$student_check->bind_param("i", $student_id);
$student_check->execute();
$student_result = $student_check->get_result();

if ($student_result->num_rows == 0) {
    die("Student not found");
}
$student = $student_result->fetch_assoc();

// Verify university application exists and belongs to the student
$app_check = $conn->prepare("SELECT * FROM university_applications WHERE id = ? AND student_id = ?");
$app_check->bind_param("ii", $university_application_id, $student_id);
$app_check->execute();
$app_result = $app_check->get_result();

if ($app_result->num_rows == 0) {
    die("University application not found or does not belong to this student");
}
$application = $app_result->fetch_assoc();
?>

<?php include 'header.php'; ?>
<body>

<style>
    .header {
        background-color: #4CAF50;
        color: white;
        padding: 10px 0 10px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-top:10px;
        margin-bottom:20px;
    }
    body { background-color: #f4f6f9; padding-top: 50px; }
    .upload-container {
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
                <div class="upload-container">
                    <!-- Error and Success Messages -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    if (isset($_GET['success'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
                    }
                    ?>

                    <h2 class="header text-center mb-4">Bank Statements for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    <h4 class="text-center mb-4">University: <?php echo htmlspecialchars($application['university_name']); ?> - Program: <?php echo htmlspecialchars($application['program_name']); ?></h4>
                    
                    <!-- Bank Statement Upload Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Upload Bank Statement</h4>
                        </div>
                        <div class="card-body">
                            <form action="university_bank_statement_process.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                <input type="hidden" name="university_application_id" value="<?php echo $university_application_id; ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="statement_type" class="form-label">Statement Type</label>
                                        <select name="statement_type" id="statement_type" class="form-select" required>
                                            <option value="">Select Type</option>
                                            <option value="Personal">Personal Bank Statement</option>
                                            <option value="Parent/Guardian">Parent/Guardian Bank Statement</option>
                                            <option value="Sponsor">Sponsor Bank Statement</option>
                                            <option value="Education Loan">Education Loan Approval</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="statement_document" class="form-label">Document</label>
                                        <input type="file" name="statement_document" id="statement_document" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="statement_notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="statement_notes" name="statement_notes" rows="2"></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Upload Statement</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Uploaded Bank Statements Table -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4>Uploaded Bank Statements</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Statement Type</th>
                                            <th>Upload Date</th>
                                            <th>File Name</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch bank statements for this specific university application
                                        $sql = $conn->prepare("SELECT * FROM bank_statements WHERE student_id = ? AND university_application_id = ? ORDER BY uploaded_at DESC");
                                        $sql->bind_param("ii", $student_id, $university_application_id);
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['statement_type']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['uploaded_at']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['notes']) . "</td>";
                                                echo "<td>
                                                    <a href='serve_file.php?path=" . urlencode($row['file_path']) . "' target='_blank' class='btn btn-sm btn-info'>View</a>
                                                    <a href='delete_university_statement.php?id=" . $row['id'] . "&student_id=" . $student_id . "&university_application_id=" . $university_application_id . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this statement?\")'>Delete</a>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No bank statements uploaded yet</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3 mb-5">
        <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary">Back to Applications</a>
        <a href="university_application_status.php?student_id=<?php echo $student_id; ?>&university_application_id=<?php echo $university_application_id; ?>" class="btn btn-primary">Application Status</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>