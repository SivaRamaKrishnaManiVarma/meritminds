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
?>

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
        margin-top:100px;
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
                        echo '<div class="alert alert-success">Shortlist uploaded successfully!</div>';
                    }
                    ?>

                    <h2 class=" header text-center mb-4">University Shortlist Upload for <?php echo htmlspecialchars($student['studentName']); ?></h2>
                    
                    <!-- Upload Form -->
                    <form action="upload_shortlist.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="file_type" class="form-select" required>
                                    <option value="">Select Shortlist Type</option>
                                    <option value="initial_shortlist">Initial Shortlist</option>
                                    <option value="final_shortlist">Final Shortlist</option>
                                   
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="file" name="document" class="form-control" accept=".xls,.xlsx,.pdf" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>

                    <!-- Uploaded Shortlists Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Shortlist Type</th>
                                    <th>Received Date</th>
                                    <th>File Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch only documents for this specific student
                                $sql = $conn->prepare("SELECT * FROM student_university_shortlists WHERE student_id = ? ORDER BY upload_date DESC");
                                $sql->bind_param("i", $student_id);
                                $sql->execute();
                                $result = $sql->get_result();
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['file_type']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['upload_date']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                                        echo "<td>
                                        <a href='serve_file.php?path=" . urlencode($row['file_path']) . "' target='_blank' class='btn btn-sm btn-info'>View</a>
                                    </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No shortlists uploaded yet</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-2">
    <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">Upload Materials</a> 

    <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">Upload University Finalist</a>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>