<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Student Registration</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  
  <!-- Additional Bootstrap CSS for table -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
   
</head>
<?php include 'header.php';?>
<body>
  <!-- Header remains the same -->

  <main id="main" style="margin-top:80px;">
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Student Enquiries</h2>
        </div>
      </div>
    </section>

    <section id="enquiries" class="contact" style="min-height:600px; padding-top:20px;">
      <div class="container">
        <div class="table-container">
          <div class="d-flex justify-content-between mb-2">
            <!-- <a href="index.php" class="btn btn-primary">Home</a> -->
            <a href="New_Student_Enquiry.php" class="btn btn-success">New Enquiry</a>
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
                  <th>Branch Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Database connection
                include 'dbconfig.php';
                // Query to fetch all enquiries in specific branch
                $manager_branch = $_SESSION["manager_branch"];
                $sql = "SELECT * FROM enquiries WHERE branchName = ? ORDER BY created_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $manager_branch);
                $stmt->execute();
                $result = $stmt->get_result();

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

                    echo "<td>" . htmlspecialchars($row["branchName"]) . "</td>";
                    echo "<td class='action-buttons'>
                            <a href='application_status.php?student_id=" . $row["id"] . "' class='btn btn-sm btn-primary m-1'>Application Status</a>
                            <a href='upload_materials.php?student_id=" . $row["id"] . "' class='btn btn-sm btn-success m-1'>Upload Materials</a>
                          </td>";
                    echo "</tr>";
                    $i++;
                  }
                } else {
                  echo "<tr><td colspan='9' class='text-center'>No enquiries found</td></tr>";
                }
                  
                $conn->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include 'footer.php';?>
</body>
</html>