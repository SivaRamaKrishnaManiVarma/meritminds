<?php
include 'dbconfig.php';

// Validate student ID
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])) {
    die("Invalid student ID");
}
$student_id = intval($_GET['student_id']);

// Verify student exists
$student_check = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
$student_check->bind_param("i", $student_id);
$student_check->execute();
$student_result = $student_check->get_result();

if ($student_result->num_rows == 0) {
    die("Student not found");
}
$student = $student_result->fetch_assoc();

// Process form submission to add new university application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_application'])) {
    $university_name = $_POST['university_name'];
    $program_name = $_POST['program_name'];
    $location = $_POST['location'] ?? '';
    $duration = !empty($_POST['duration']) ? $_POST['duration'] : null;
    $application_fee = !empty($_POST['application_fee']) ? $_POST['application_fee'] : null;
    $tuition_fee = !empty($_POST['tuition_fee']) ? $_POST['tuition_fee'] : null;
    $application_date = $_POST['application_date'];
    $status = 'Submitted';
    
    $stmt = $conn->prepare("INSERT INTO university_applications 
        (student_id, university_name, program_name, location, duration, application_fee, tuition_fee, application_date, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $stmt->bind_param("isssiidss", $student_id, $university_name, $program_name, $location, $duration, $application_fee, $tuition_fee, $application_date, $status);
    
    if ($stmt->execute()) {
        $success_message = "Application added successfully!";
    } else {
        $error_message = "Error adding application: " . $conn->error;
    }
}
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        margin-top:10px;
        margin-bottom:20px;
    }
    body { background-color: #f4f6f9; padding-top: 50px; }
    .container-fluid { padding: 30px; }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-not-started { background-color: #e9ecef; color: #495057; }
    .status-in-progress { background-color: #fff3cd; color: #856404; }
    .status-complete { background-color: #d4edda; color: #155724; }
    .status-on-hold { background-color: #cce5ff; color: #004085; }
    .status-rejected { background-color: #f8d7da; color: #721c24; }
    .status-withdrawn { background-color: #d6d8db; color: #383d41; }
    .status-accepted { background-color: #c3e6cb; color: #155724; }
</style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header header text-center">
                        <h2>University Applications for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        
                        <!-- Add New Application Form -->
                        <form method="POST" class="mb-4">
                            <h4 class="mb-3">Add New University Application</h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>University Name</label>
                                    <input type="text" name="university_name" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Program Name</label>
                                    <input type="text" name="program_name" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Duration (months)</label>
                                    <input type="number" name="duration" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Application Fee</label>
                                    <input type="number" step="0.01" name="application_fee" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Tuition Fee</label>
                                    <input type="number" step="0.01" name="tuition_fee" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Application Date</label>
                                    <input type="date" name="application_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="add_application" class="btn btn-primary">Add Application</button>
                            </div>
                        </form>
                        
                        <!-- University Applications Table -->
                        <div class="table-responsive mt-4">
                            <h4 class="mb-3">Application List</h4>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>University</th>
                                        <th>Program</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch applications for this student
                                    $applications_query = $conn->prepare("
                                        SELECT 
                                            a.id, a.university_name, a.program_name, a.application_date, a.status,
                                            (SELECT COUNT(*) FROM bank_statements WHERE university_application_id = a.id) as bank_statements_count,
                                            (SELECT status FROM university_application_status 
                                             WHERE university_application_id = a.id ORDER BY updated_at DESC LIMIT 1) as detailed_status
                                        FROM 
                                            university_applications a
                                        WHERE 
                                            a.student_id = ?
                                        ORDER BY 
                                            a.application_date DESC
                                    ");
                                    $applications_query->bind_param("i", $student_id);
                                    $applications_query->execute();
                                    $applications_result = $applications_query->get_result();
                                    
                                    if ($applications_result->num_rows > 0) {
                                        while ($app = $applications_result->fetch_assoc()) {
                                            // Determine status display
                                            $status = !empty($app['detailed_status']) ? $app['detailed_status'] : $app['status'];
                                            $status_class = strtolower(str_replace(' ', '-', $status));
                                            
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($app['university_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($app['program_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($app['application_date']) . "</td>";
                                            echo "<td>
                                                <span class='status-badge status-{$status_class}'>
                                                    " . htmlspecialchars($status) . "
                                                </span>
                                            </td>";
                                            echo "<td>
                                                <div class='btn-group'>
                                                    <a href='university_bank_statement.php?student_id={$student_id}&university_application_id={$app['id']}' class='btn btn-sm btn-info'>
                                                        Bank Statements (" . $app['bank_statements_count'] . ")
                                                    </a>
                                                    <a href='university_application_status.php?student_id={$student_id}&university_application_id={$app['id']}' class='btn btn-sm btn-primary'>
                                                        Track Status
                                                    </a>
                                                </div>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No applications added yet</td></tr>";
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
    
    <div class="text-center mt-3 mb-5">
        <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary">Back to Documents</a>
        <a href="application_status.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">Overall Application Status</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>