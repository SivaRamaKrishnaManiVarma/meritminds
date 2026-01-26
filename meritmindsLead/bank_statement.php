<?php include 'header.php'; ?>
<body>


<style>
    .header {
        background-color: #4CAF50; /* Green background color, you can change this */
        color: white; /* Text color */
        padding: 10px 0 10px; /* Vertical padding to create space */
        text-align: center; /* Center align the text */
        border-radius: 5px; /* Optional: Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for depth */
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
                    <?php
                    // Database connection
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

                    // Check if financial record exists for this student
                    $financial_check = $conn->prepare("SELECT * FROM student_financials WHERE student_id = ?");
                    $financial_check->bind_param("i", $student_id);
                    $financial_check->execute();
                    $financial_result = $financial_check->get_result();
                    $financial_data = $financial_result->fetch_assoc();
                    $has_financial_record = ($financial_result->num_rows > 0);
                    ?>

                    <!-- Error and Success Messages -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    if (isset($_GET['success'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
                    }
                    ?>

                    <h2 class="header text-center mb-4">Financial Information for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    
                    <!-- Application Fee Status Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Application Fee Status</h4>
                        </div>
                        <div class="card-body">
                            <form action="update_fee_status.php" method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fee_status" id="paid" value="paid"
                                                <?php echo ($has_financial_record && $financial_data['fee_status'] == 'paid') ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="paid">Paid</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="fee_status" id="unpaid" value="unpaid"
                                                <?php echo ($has_financial_record && $financial_data['fee_status'] == 'unpaid') || !$has_financial_record ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="unpaid">Unpaid</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Payment Date</span>
                                            <input type="date" class="form-control" name="payment_date" 
                                                value="<?php echo ($has_financial_record && $financial_data['payment_date']) ? $financial_data['payment_date'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="fee_notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="fee_notes" name="fee_notes" rows="2"><?php echo ($has_financial_record) ? htmlspecialchars($financial_data['fee_notes']) : ''; ?></textarea>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Fee Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Bank Statement Upload Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Bank Statement Upload</h4>
                        </div>
                        <div class="card-body">
                            <form action="bank_statement_process.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
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
                                        // Fetch bank statements for this specific student
                                        $sql = $conn->prepare("SELECT * FROM bank_statements WHERE student_id = ? ORDER BY uploaded_at DESC");
                                        $sql->bind_param("i", $student_id);
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
                                                    <a href='delete_statement.php?id=" . $row['id'] . "&student_id=" . $student_id . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this statement?\")'>Delete</a>
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
        <!-- <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-secondary me-2">Back to Documents</a> -->
        <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">Upload University Finalist</a>

        <a href="application_status.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">Application Status</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>