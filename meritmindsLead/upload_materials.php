<?php include 'header.php'; ?>
<body>


<style>
    .header1 {
        background-color: #4CAF50; /* Green background color, you can change this */
        color: white; /* Text color */
        padding: 10px 0 10px; /* Vertical padding to create space */
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
                    ?>

                    <!-- Error and Success Messages -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    if (isset($_GET['success'])) {
                        echo '<div class="alert alert-success">File uploaded successfully!</div>';
                    }
                    ?>

                    <h2 class="header1 text-center mb-4">Application Materials Upload for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    
                    <!-- Upload Form -->
                    <form action="upload_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="material_type" id="material_type" class="form-select" required>
                                    <option value="">Select Document Type</option>
                                    <?php
                                    // Full list of document types
                                    $all_document_types = [
                                        'SSC Certificate', 'Inter Certificate', 'Graduation Certificate', 
                                        'CMM Semester Transcript', 'Provisional Certificate', 'Original Degree', 
                                        'English Exam Score', 'GRE Score', 'GMAT Score', 'SAT Score', 
                                        'Passport', 'Resume', 'Letter of Recommendation', 
                                        'Experience Certificate', 'Medium of Instruction Certificate', 
                                        'Bonafide Certificate', 'Course Completion Certificate', 
                                        'Backlog Certificate', 'Signed Declaration'
                                    ];

                                    // Get uploaded document types for this specific student
                                    $uploaded_types_query = $conn->prepare("SELECT material FROM application_materials WHERE student_id = ?");
                                    $uploaded_types_query->bind_param("i", $student_id);
                                    $uploaded_types_query->execute();
                                    $uploaded_types_result = $uploaded_types_query->get_result();
                                    
                                    $uploaded_types = [];
                                    if ($uploaded_types_result->num_rows > 0) {
                                        while ($row = $uploaded_types_result->fetch_assoc()) {
                                            $uploaded_types[] = $row['material'];
                                        }
                                    }

                                    // Display only non-uploaded document types
                                    foreach ($all_document_types as $type) {
                                        if (!in_array($type, $uploaded_types)) {
                                            echo "<option value='" . htmlspecialchars($type) . "'>" . htmlspecialchars($type) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="file" name="document" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>

                    <!-- Uploaded Materials Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Received Date</th>
                                    <th>File Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch only documents for this specific student
                                $sql = $conn->prepare("SELECT * FROM application_materials WHERE student_id = ? ORDER BY uploaded_at DESC");
                                $sql->bind_param("i", $student_id);
                                $sql->execute();
                                $result = $sql->get_result();
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['material']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['received_date']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                                        echo "<td>
                                            <a href='serve_file.php?path=" . urlencode($row['file_path']) . "' target='_blank' class='btn btn-sm btn-info'>View</a>
                                             <a href='delete_document.php?id=" . $row['id'] . "&student_id=" . $student_id . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\")'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No documents uploaded yet</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
    <a href="Prospective_student_details.php" class="btn btn-primary">Prospective Student Details</a>

        <a href="upload_university_shortlist.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">University Shortlist Upload</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>