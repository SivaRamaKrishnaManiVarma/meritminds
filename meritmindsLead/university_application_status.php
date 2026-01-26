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

// Get the latest application status if it exists
$status_check = $conn->prepare("SELECT * FROM university_application_status WHERE university_application_id = ? ORDER BY updated_at DESC LIMIT 1");
$status_check->bind_param("i", $university_application_id);
$status_check->execute();
$status_result = $status_check->get_result();
$status_data = $status_result->fetch_assoc();
$current_status = $status_result->num_rows > 0 ? $status_data['status'] : 'Not Started';
$status_notes = $status_result->num_rows > 0 ? $status_data['notes'] : '';
$status_date = $status_result->num_rows > 0 ? $status_data['status_date'] : '';
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
    .tracker-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
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
                <div class="tracker-container">
                    <h2 class="header text-center mb-4">Application Status Tracker</h2>
                    
                    <!-- Student & University Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Application Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Student Name:</strong> <?php echo htmlspecialchars($student['studentName']); ?></p>
                                    <p><strong>University:</strong> <?php echo htmlspecialchars($application['university_name']); ?></p>
                                    <p><strong>Program:</strong> <?php echo htmlspecialchars($application['program_name']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Application Date:</strong> <?php echo htmlspecialchars($application['application_date']); ?></p>
                                    <p><strong>Current Status:</strong> 
                                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $current_status)); ?>">
                                            <?php echo $current_status; ?>
                                        </span>
                                    </p>
                                    <?php if (!empty($status_date)): ?>
                                        <p><strong>Status Date:</strong> <?php echo htmlspecialchars($status_date); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Application Status Change Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Update Application Status</h4>
                        </div>
                        <div class="card-body">
                            <form action="university_application_status_process.php" method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                <input type="hidden" name="university_application_id" value="<?php echo $university_application_id; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="application_status" class="form-label">Application Status </label>
                                        <select name="application_status" id="application_status" class="form-select">
                                            <option value="Not Started" <?php echo ($current_status == 'Not Started') ? 'selected' : ''; ?>>Not Started</option>
                                            <option value="In Progress" <?php echo ($current_status == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Complete" <?php echo ($current_status == 'Complete') ? 'selected' : ''; ?>>Complete</option>
                                            <option value="On Hold" <?php echo ($current_status == 'On Hold') ? 'selected' : ''; ?>>On Hold</option>
                                            <option value="Rejected" <?php echo ($current_status == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                            <option value="Withdrawn" <?php echo ($current_status == 'Withdrawn') ? 'selected' : ''; ?>>Withdrawn</option>
                                            <option value="Accepted" <?php echo ($current_status == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status_update_date" class="form-label">Status Date</label>
                                        <input type="date" class="form-control" name="status_update_date" id="status_update_date" value="<?php echo !empty($status_date) ? $status_date : date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="status_notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="status_notes" name="status_notes" rows="2"><?php echo htmlspecialchars($status_notes); ?></textarea>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Status History -->
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h4>Status History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get status history
                                        $history_query = $conn->prepare("SELECT * FROM university_application_status 
                                                                        WHERE university_application_id = ? 
                                                                        ORDER BY updated_at DESC");
                                        $history_query->bind_param("i", $university_application_id);
                                        $history_query->execute();
                                        $history_result = $history_query->get_result();
                                        
                                        if ($history_result->num_rows > 0) {
                                            while ($row = $history_result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['status_date']) . "</td>";
                                                echo "<td><span class='status-badge status-" . strtolower(str_replace(' ', '-', $row['status'])) . "'>" 
                                                    . htmlspecialchars($row['status']) . "</span></td>";
                                                echo "<td>" . htmlspecialchars($row['notes']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' class='text-center'>No status history available</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Documents -->
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h4>Related Documents</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Bank Statements</h5>
                                    <ul class="list-group">
                                        <?php
                                        // Get bank statements for this university application
                                        $statement_query = $conn->prepare("SELECT * FROM bank_statements 
                                                                          WHERE university_application_id = ? 
                                                                          ORDER BY uploaded_at DESC LIMIT 5");
                                        $statement_query->bind_param("i", $university_application_id);
                                        $statement_query->execute();
                                        $statement_result = $statement_query->get_result();
                                        
                                        if ($statement_result->num_rows > 0) {
                                            while ($row = $statement_result->fetch_assoc()) {
                                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                                                echo htmlspecialchars($row['statement_type']) . " - " . htmlspecialchars($row['file_name']);
                                                echo "<a href='serve_file.php?path=" . urlencode($row['file_path']) . 
                                                     "' target='_blank' class='btn btn-sm btn-info'>View</a>";
                                                echo "</li>";
                                            }
                                        } else {
                                            echo "<li class='list-group-item'>No bank statements uploaded yet</li>";
                                        }
                                        ?>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="university_bank_statement.php?student_id=<?php echo $student_id; ?>&university_application_id=<?php echo $university_application_id; ?>" class="btn btn-outline-primary btn-sm">
                                            Manage Bank Statements
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5>Application Materials</h5>
                                    <ul class="list-group">
                                        <?php
                                        // Get application materials for this student
                                        $materials_query = $conn->prepare("SELECT * FROM application_materials 
                                                                         WHERE student_id = ? 
                                                                         ORDER BY uploaded_at DESC LIMIT 5");
                                        $materials_query->bind_param("i", $student_id);
                                        $materials_query->execute();
                                        $materials_result = $materials_query->get_result();
                                        
                                        if ($materials_result->num_rows > 0) {
                                            while ($row = $materials_result->fetch_assoc()) {
                                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                                                echo htmlspecialchars($row['material']) . " - " . htmlspecialchars($row['file_name']);
                                                echo "<a href='serve_file.php?path=" . urlencode($row['file_path']) . 
                                                     "' target='_blank' class='btn btn-sm btn-info'>View</a>";
                                                echo "</li>";
                                            }
                                        } else {
                                            echo "<li class='list-group-item'>No application materials uploaded yet</li>";
                                        }
                                        ?>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-primary btn-sm">
                                            Manage Application Materials
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-3 mb-5">
        <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary">Back to Applications</a>
        <a href="university_bank_statement.php?student_id=<?php echo $student_id; ?>&university_application_id=<?php echo $university_application_id; ?>" class="btn btn-primary">Bank Statements</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>