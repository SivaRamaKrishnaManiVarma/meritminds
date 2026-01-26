<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeritMinds Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #4CAF50, #2196F3, #FF9800, #9C27B0);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            z-index: -1;
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
        
        .welcome-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            width: 700px;
            position: relative;
            z-index: 1;
        }
        
        .logo {
            margin-bottom: 25px;
        }
        
        .logo i {
            font-size: 5rem;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        
        h1 {
            color: #333;
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        p {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .role-btn {
            background-color: #fff;
            border: 2px solid;
            border-radius: 15px;
            padding: 20px 30px;
            width: 200px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .role-btn i {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        #admin-btn {
            border-color: #4CAF50;
            color: #4CAF50;
        }
        
        #admin-btn:hover {
            background-color: #4CAF50;
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
        }
        
        #manager-btn {
            border-color: #FF9800;
            color: #FF9800;
        }
        
        #manager-btn:hover {
            background-color: #FF9800;
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 152, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>
    
    <div class="welcome-container">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <h1>MeritMinds</h1>
        <p>Lead Tracking Admin Portal</p>
        
        <div class="buttons">
            <a href="admin/admin_login.php" class="role-btn" id="admin-btn">
                <i class="fas fa-user-shield"></i>
                Admin Login
            </a>
            
            <a href="manager_login.php" class="role-btn" id="manager-btn">
                <i class="fas fa-user-tie"></i>
                Manager Login
            </a>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // You can add animations or other functionality here
        });
    </script>
</body>
</html>