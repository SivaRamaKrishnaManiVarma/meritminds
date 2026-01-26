
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MeritMinds Navbar</title>
    
    <!-- AoS -->
   <!-- AoS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>     <!-- Bootstrap + LeadMark main styles -->
     <link rel="stylesheet" href="assets/css/leadmark.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/imgs/new_logo.png">
    <link href="assets/imgs/new_logo.png" rel="apple-touch-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    
    <style>
         /* Masked Gradient Text Animation */
         @keyframes animate-background {
            0% { background-position: 0 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Fade-in Animation for Headings */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-in-out, transform 1s ease-in-out;
        }

        /* When the section enters the viewport */
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Section Title Animation */
        .section-title {
            font-size: 2rem;
            color: #E3B23C;
            text-align: center;
            animation: fade-slide-in 1s ease-in-out;
        }

        /* Section Subtitle Animation */
        .section-subtitle {
            font-size: 1.3rem;
            color: #888;
            text-align: center;
            animation: fade-slide-in 1.5s ease-in-out;
        }

        /* Slide-in Effect for Headings */
        @keyframes fade-slide-in {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* For Large Screens (Desktop, Laptop) */
        @media (min-width: 768px) {
            #study-portfolio {
                display: block; /* Show portfolio section */
            }

            #destination-gallery {
                display: none; /* Hide destination section */
            }
        }

        /* For Small Screens (Mobile, Tablet) */
        @media (max-width: 767px) {
            #study-portfolio {
                display: none; /* Hide portfolio section */
            }

            #destination-gallery {
                display: block; /* Show destination section */
            }
        }

        /* General Styles for Both Sections */
        .portfolio-grid, .destination-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
            margin-top: 30px;
        }

        .portfolio-item, .destination-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .portfolio-content img, .destination-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        /* Hover Effects */
        .portfolio-item:hover img, .destination-item:hover img {
            transform: scale(1.1);
        }

        /* Overlay Effect */
        .portfolio-overlay, .destination-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .portfolio-item:hover .portfolio-overlay, .destination-item:hover .destination-overlay {
            opacity: 1;
        }

        /* Hover Content */
        .hover-content, .hover-info {
            color: #fff;
            text-align: center;
        }

        .hover-content h6, .hover-info h6 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .hover-content p, .hover-info p {
            font-size: 0.9rem;
        }

        /* Unique styles for our new navbar */
        .mm-navbar-wrapper {
            background-color: #dc3545;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            padding: 0.5rem 1rem;
        }
        
        .mm-navbar-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .mm-navbar-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .mm-navbar-logo {
            height: 50px;
            width: auto;
        }
        
        .mm-navbar-slogan {
            display: flex;
            flex-direction: column;
        }
        
        .mm-slogan-main {
            font-size: 10px;
            font-weight: bold;
            color: white;
            line-height: 1;
        }
        
        .mm-slogan-sub {
            font-size: 7px;
            color: white;
            line-height: 1;
            margin-top: 2px;
        }
        
        .mm-navbar-toggler {
            padding: 0.25rem 0.75rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: white;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            cursor: pointer;
            display: none;
        }
        
        .mm-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            content: "";
            background: no-repeat center center;
            background-size: 100% 100%;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.5)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .mm-navbar-links {
            display: flex;
            flex-direction: row;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .mm-nav-item {
            margin: 0;
            padding: 0;
        }
        
        .mm-nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            display: block;
            transition: color 0.15s ease-in-out;
        }
        
        .mm-nav-link:hover {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        /* Contact icons */
        .mm-contact-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 1000;
        }
        
        .mm-contact-icon {
            background-color: #dc3545;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }
        
        .mm-contact-icon:hover {
            background-color: #a71d2a;
            color: white;
            text-decoration: none;
        }
        
        /* Media queries for mobile responsiveness */
        @media (max-width: 767.98px) {
            .mm-navbar-toggler {
                display: block;
            }
            
            .mm-navbar-links-container {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #dc3545;
                padding: 0.5rem 1rem;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.35s ease;
            }
            
            .mm-navbar-links {
                flex-direction: column;
                width: 100%;
            }
            
            .mm-nav-link {
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .mm-nav-item:last-child .mm-nav-link {
                border-bottom: none;
            }
            
            .mm-navbar-links-container.show {
                max-height: 350px; /* Adjust as needed */
            }
        }
        
        /* Add some spacing below navbar */
        body {
            padding-top: 80px; /* Adjust based on your navbar height */
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

<!-- Unique Navbar Structure -->
<header class="mm-navbar-wrapper">
    <div class="mm-navbar-container">
        <!-- Brand and Logo -->
        <div class="mm-navbar-brand">
            <a href="index.php">
                <img src="assets/imgs/rectangle_logo.png" alt="MeritMinds Logo" class="mm-navbar-logo">
            </a>
            <div class="mm-navbar-slogan">
                <div class="mm-slogan-main">STUDY | WORK | SETTLE</div>
                <div class="mm-slogan-sub">STUDENT VISA - BUSINESS VISA - VISITING VISA</div>
            </div>
        </div>
        
        <!-- Mobile Toggle Button -->
        <button class="mm-navbar-toggler" id="mmNavbarToggler" type="button">
            <span class="mm-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links Container -->
        <div class="mm-navbar-links-container" id="mmNavbarLinks">
            <ul class="mm-navbar-links">
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./index.php">Home</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./About.php">About Us</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="#">Services</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./JoinUS.php">Join Us</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="#">Blogs</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./contact-us.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- Floating Contact Icons with unique classes -->
<div class="mm-contact-container">
    <a href="tel:+1234567890" class="mm-contact-icon">
        <i class="fas fa-phone-alt"></i>
    </a>
    <a href="https://wa.me/1234567890" class="mm-contact-icon">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<!-- Just for demo purposes - page content placeholder -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Page Content Goes Here</h1>
            <p>This is where your actual page content would appear.</p>
        </div>
    </div>
</div>

<!-- JavaScript for Navbar Toggle - Using Vanilla JS to avoid conflicts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to our unique elements
        const toggleButton = document.getElementById('mmNavbarToggler');
        const navLinksContainer = document.getElementById('mmNavbarLinks');
        const navLinks = document.querySelectorAll('.mm-nav-link');
        
        // Toggle menu when button is clicked
        toggleButton.addEventListener('click', function() {
            navLinksContainer.classList.toggle('show');
        });
        
        // Close menu when a link is clicked
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    navLinksContainer.classList.remove('show');
                }
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = toggleButton.contains(event.target) || 
                                 navLinksContainer.contains(event.target);
            
            if (!isClickInside && navLinksContainer.classList.contains('show')) {
                navLinksContainer.classList.remove('show');
            }
        });
    });
</script>

</body>
</html>