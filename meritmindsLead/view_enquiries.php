<?php include 'header.php'; ?>
<body>


<style>
    .header1 {
        background-color: #4CAF50; /* Green background color, you can change this */
        color: white; /* Text color */
        padding: 10px 0 10px; /* Vertical padding to create space */
        text-align: center; /* Center align the text */
        border-radius: 5px; /* Optional: Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for depth */
        margin-top:100px;
        margin-bottom:20px;
    }

    </style>
</head>
 <!-- Database connection -->
<?php include 'dbconfig.php'?>
<body>
    <div class="container">
        <div class="header header1">
            <h2>Student Enquiries</h2>
            <div class="mt-3">
                <a href="New_Student_Enquiry.php" class="btn btn-success">New Enquiry</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Gender</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Intake</th>
                        <th>Countries</th>
                        <th>Program</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
             
                 
                    // Query to fetch all enquiries
$manager_branch = $_SESSION["manager_branch"];
$sql = "SELECT * FROM new_enquiries WHERE branchName = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $manager_branch);
$stmt->execute();
$result = $stmt->get_result();
// Remove this line: $result = $conn->query($sql);

if ($result->num_rows > 0) {
    $i=1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . htmlspecialchars($row["studentName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["mobile"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["intake"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["country"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["program"]) . "</td>";
        echo "<td>
                <a href='edit_enquiry.php?id=" . $row["id"] . "' class='btn btn-sm btn-primary'>Edit</a>
                <a href='move_enquiry.php?id=" . $row["id"] . "' class='btn btn-sm btn-success' onclick='return confirm(\"Are you sure you want to move this enquiry?\")'>Move To Prospective Students</a>
              </td>";
        echo "</tr>";
        $i++;
    }
} else {
    echo "<tr><td colspan='9' class='text-center'>No enquiries found for branch: " . htmlspecialchars($manager_branch) . "</td></tr>";
}

$stmt->close();
$conn->close();                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>