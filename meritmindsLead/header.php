<?php
// Start the session at the beginning of file
session_start();

// Function to check if user is logged in

if(!isset($_SESSION["manager_logged_in"]) || $_SESSION["manager_logged_in"] !== true) {
  header("location: manager_login.php");
  exit;
}

// Function to check if user has admin role
// function check_admin() {
//     if (!isset($_SESSION['id']) || $_SESSION['role'] != 'Admin') {
//         header("Location: partner_login.php");
//         exit();
//     }
// }
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Merit Minds - Student Registraion</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo_cirlce.png" rel="icon">
  <link href="assets/img/logo_cirlce.png" rel="apple-touch-icon">

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

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top mb-5" style="margin-bottom:90px">
    <div class="container d-flex align-items-center">
    <a href="index.php" class="logo me-auto me-lg-0 mx-2"><img src="assets/img/logo_cirlce.png" alt="" class="img-fluid"></a>

      <h1 class="logo me-auto"><a href="index.php"><span>Student </span>Registraion</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
    
      <nav id="navbar" class="navbar order-last order-lg-0">
         <ul>
      
          <li><a class="getstarted scrollto" href="New_Student_Enquiry.php">NEW STUDENT ENQUIRY</a></li>
		   <li><a class="getstarted scrollto" href="Prospective_student_details.php">PROSPECTIVE STUDENT DETAILS</a></li>
		   <li><a class="getstarted scrollto" href="view_enquiries.php">View Enquiries</a></li>
		    <li><a class="getstarted scrollto" href="dashboard.php">REPORTS</a></li>
        <li><a class="getstarted scrollto" href="logout.php">LOG OUT</a></li>

			
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <div class="header-social-links d-flex">
        <a href="#" class="twitter"><i class="bu bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bu bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bu bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bu bi-linkedin"></i></i></a>
      </div>

    </div>
  </header><!-- End Header -->

 

  <!-- ======= Footer ======= -->


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

