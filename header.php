<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="7 Creators">
    <meta name="author" content="Devcrud">
    <title>Meritminds.co</title>
   <!-- AoS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    

    <style>
                /* General Styling for Headings */
        h1, h2, h6 {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

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



    </style>

    <!-- font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="assets/css/leadmark.css">
	<link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">



   <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="assets\imgs\new_logo.png">
    <link href="assets\imgs\new_logo.png" rel="apple-touch-icon">


</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- page Navigation -->

    <style>
                /* General Styling for Headings */
        h1, h2, h6 {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

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



    </style>

    <!-- font icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="assets/css/leadmark.css">
	<link rel="stylesheet" href="assets/css/style.css">



   <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="assets\imgs\new_logo.png">
    <link href="assets\imgs\new_logo.png" rel="apple-touch-icon">


</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- page Navigation -->

<style>
 /* Active Navigation Link Styles */
    .mm-nav-link.active {
        position: relative;
        font-weight: bold;
    }

    .mm-nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1rem;
        right: 1rem;
        height: 3px;
        background-color: white;
        border-radius: 1.5px;
        transition: all 0.3s ease;
    }

    /* Hover effect for non-active links */
    .mm-nav-link:not(.active):hover::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1rem;
        right: 1rem;
        height: 2px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 1px;
    }

    /* Position relative needed for the underlines */
    .mm-nav-link {
        position: relative;
    }

    /* Unique styles for our new navbar */
    .mm-navbar-wrapper {
        background-color: #dc3545;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        padding: 0.1rem 0.8rem;
    }

    .mm-navbar-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin: 0 auto;
        padding: 0 15px;
    }

    .mm-navbar-brand {
        display: flex;
        flex-direction: column;
        align-items: flex-center;
    }

    .mm-navbar-logo {
        height: 70px;
        width: auto;
        margin-bottom:5px;
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

    .mm-navbar-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .mm-book-btn, .mm-phone-btn {
        text-decoration: none;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        text-align: center;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .mm-phone-btn:hover {
        background-color: white;
        color: #dc3545;
    }

    /* Social Icons Container */
    .nm-social-icons {
        display: flex;
        gap: 15px;  /* Spacing between icons */
    }

    /* Individual Icon Styling */
    .nm-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: white;  /* White background */
        border-radius: 50%;  /* Circular icons */
        text-decoration: none;
        transition: 0.3s ease-in-out;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Icon Styling */
    .nm-icon i {
        color: #fc0511;  /* Red icon color */
        font-size: 20px;
    }

    /* Hover Effect */
    .nm-icon:hover {
        transform: scale(1.1);
    }

    /* Add some spacing below navbar */
    body {
        padding-top: 80px; /* Adjust based on your navbar height */
    }

    /* Media queries for responsive design */
    /* Large screens */
    @media (min-width: 1301px) {
        .mm-navbar-links-container {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }
        
        .mm-navbar-actions {
            margin-left: 20px;
            margin-top: 0;
        }
        
        .mm-navbar-toggler {
            display: none;
        }
        
        .nm-social-icons {
            display: flex !important;
        }
    }

    /* Medium screens - hide social icons but keep navbar links */
    @media (min-width: 1098px) and (max-width: 1300px) {
        .mm-navbar-links-container {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }
        
        .mm-navbar-actions {
            margin-left: 20px;
            margin-top: 0;
        }
        
        .mm-navbar-toggler {
            display: none;
        }
        
        .nm-social-icons {
            display: none !important;
        }
    }

    /* Smaller screens - show hamburger icon, hide links by default */
    @media (max-width: 1097px) {
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
        display: none;
    }
    
    .mm-navbar-links-container.show {
        max-height: 500px;
        display: block;
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
    
    .mm-navbar-actions {
        width: 100%;
        flex-direction: row;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
        margin-bottom: 10px;
    }
    
    body {
        padding-top: 70px;
    }
}

    /* Show social icons for small screens below 510px */
    @media (max-width: 510px) {
        .nm-social-icons {
            display: none !important;
        }
        
        .mm-navbar-container {
            padding: 0 10px;
        }
        
        .mm-navbar-logo {
            height: 40px;
        }
        
        .mm-navbar-actions {
            flex-direction: column;
            gap: 8px;
        }
        
        .mm-book-btn, .mm-phone-btn {
            width: 100%;
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .mm-slogan-main {
            font-size: 8px;
        }
        
        .mm-slogan-sub {
            font-size: 6px;
        }
    }

    /* Specific case for social icons between 511px and 1097px */
    @media (min-width: 511px) and (max-width: 1097px) {
        .nm-social-icons {
            display: flex !important;
        }
    }
</style>
<header class="mm-navbar-wrapper">
    <div class="mm-navbar-container">
        <!-- Brand and Logo -->
        <div class="mm-navbar-brand mt-2">
            <a href="index.php">
                <img src="assets/imgs/rectangle_logo.jpg" alt="MeritMinds Logo" class="mm-navbar-logo">
            </a>
           
        </div>
        <div class="row px-3 nm-social-icons">
            <a href="#" class="nm-icon">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://wa.me/+91 9505889191" class="nm-icon">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://www.instagram.com/meritmindsoverseas" class="nm-icon">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.linkedin.com/in/merit-minds-overseas-0571a6351/" class="nm-icon">
                <i class="fab fa-linkedin"></i>
            </a>
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
                    <a class="mm-nav-link" href="./about.php">About Us</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="services.php">Services</a>
                </li>
                <!-- <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./JoinUS.php">Join Us</a>
                </li> -->
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="news.php">Blogs</a>
                </li>
                <li class="mm-nav-item">
                    <a class="mm-nav-link" href="./contact-us.php">Contact Us</a>
                </li>
            </ul>
            
            <!-- Booking and Phone buttons -->
            <div class="mm-navbar-actions">
                <a href="tel:+91 9505889191" class="mm-phone-btn mb-2" style="color:#dc3545; background-color:white;">+91 9505889191</a>
                <a href="meritmindsLead/welcome.php" class="mm-phone-btn mb-2" style="color:#dc3545; background-color:yellow;">Partner Login</a> 
                <!-- Student register -->
            </div>
        </div>
    </div>
</header>

<!-- Floating Contact Icons with unique classes -->
<div class="mm-contact-container">
    <a href="tel:+91 9505889191" class="mm-contact-icon">
        <i class="fas fa-phone-alt"></i>
    </a>
    <a href="https://wa.me/+91 9505889191" class="mm-contact-icon">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
      
  <!-- Required Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current page filename
        const currentPage = window.location.pathname.split('/').pop();
        
        // Get all navigation links
        const navLinks = document.querySelectorAll('.mm-nav-link');
        
        // Loop through links and add active class to the matching page
        navLinks.forEach(function(link) {
            const linkHref = link.getAttribute('href');
            
            // Check if the href matches the current page
            if (linkHref === `./${currentPage}` || 
                linkHref === currentPage || 
                (currentPage === '' && linkHref === './index.php') ||
                (currentPage === '' && linkHref.includes('index.php'))) {
                link.classList.add('active');
            }
        });
    });
</script>