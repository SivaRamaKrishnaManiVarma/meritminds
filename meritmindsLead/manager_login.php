<?php
// Start session
session_start();

// Check if user is already logged in
if(isset($_SESSION["manager_logged_in"]) && $_SESSION["manager_logged_in"] === true) {
    header("location: index.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM partner_login WHERE username = ? AND role = 'Manager'";
        
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()) {
                        // Check if password is correct - added md5 fallback like in admin login
                        if(password_verify($password, $hashed_password) || md5($password) === $hashed_password) {
                            // Password is correct
                            
                            // Store data in session variables
                            $_SESSION["manager_logged_in"] = true;
                            $_SESSION["login_id"] = $id; // Changed from login_id to manager_id
                            $_SESSION["manager_username"] = $username;
                            $_SESSION["manager_role"] = "Manager";
                            $branch_query = "SELECT branch_name FROM partner_login WHERE id = ?";
                            if($branch_stmt = $conn->prepare($branch_query)) {
                                $branch_stmt->bind_param("i", $id);
                                $branch_stmt->execute();
                                $branch_result = $branch_stmt->get_result();
                                if($branch_row = $branch_result->fetch_assoc()) {
                                    $_SESSION["manager_branch"] = $branch_row['branch_name'];
                                }
                                $branch_stmt->close();
                            }

                            
                            // Log login action
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                            $log_sql = "INSERT INTO admin_logs (login_id, admin_username, action, ip_address, created_at) 
                                      VALUES (?, ?, 'Manager Login', ?, NOW())";
                            
                            if($log_stmt = $conn->prepare($log_sql)) {
                                $log_stmt->bind_param("iss", $id, $username, $ip_address);
                                $log_stmt->execute();
                                $log_stmt->close();
                            }
                            
                            // Redirect user to manager dashboard
                            header("location: index.php");
                            exit; // Added exit after redirect
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist or not a manager, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeritMinds Manager Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #FF9800, #2196F3, #FF9800);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            z-index: -1;
            opacity: 0.3;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 90%;
            max-width: 450px;
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 20px;
        }
        
        .logo img {
            height: 80px;
            margin-bottom: 15px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 28px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .login-form .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .login-form label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #FF9800;
        }
        
        .login-form input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .login-form input:focus {
            border-color: #FF9800;
            box-shadow: 0 0 8px rgba(255, 152, 0, 0.3);
            outline: none;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .login-btn {
            background-color: #FF9800;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 25px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        .login-btn:hover {
            background-color: #F57C00;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .back-to-welcome {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-to-welcome:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>
    
    <a href="welcome.php" class="back-to-welcome">
        <i class="fas fa-arrow-left"></i>
    </a>
    
    <div class="login-container">
        <div class="logo">
            <!-- Replace with your actual logo -->
            <i class="fas fa-user-tie fa-4x" style="color: #FF9800;"></i>
            <h1>MeritMinds</h1>
        </div>
        <p class="subtitle">Manager Portal</p>
        
        <?php if(!empty($login_err)): ?>
            <div style="color: #dc3545; margin-bottom: 20px; padding: 10px; background-color: rgba(220, 53, 69, 0.1); border-radius: 8px;">
                <?php echo $login_err; ?>
            </div>
        <?php endif; ?>
        
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </div>
                <?php if(!empty($username_err)): ?>
                    <div class="invalid-feedback"><?php echo $username_err; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <?php if(!empty($password_err)): ?>
                    <div class="invalid-feedback"><?php echo $password_err; ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>