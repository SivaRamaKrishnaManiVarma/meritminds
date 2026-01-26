<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d1ecf1;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
            text-align: center;
        }
        .success-icon {
            color: #28a745;
            font-size: 80px;
            margin-bottom: 20px;
        }
        .error-icon {
            color: #dc3545;
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : "Thank you for your enquiry!";
        $status = isset($_GET['status']) ? $_GET['status'] : "success";
        
        if($status == "success") {
            echo '<div class="success-icon">✓</div>';
            echo '<h2>Success!</h2>';
        } else {
            echo '<div class="error-icon">✗</div>';
            echo '<h2>Oops!</h2>';
        }
        ?>
        
        <p class="lead"><?php echo $message; ?></p>
        
        <div class="mt-4">
            <a href="view_enquiries.php" class="btn btn-primary">View Enquiries</a>
            <a href="New_Student_Enquiry.php" class="btn btn-secondary">New Enquiry</a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>