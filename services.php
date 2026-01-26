<?php include 'header.php'?>
      <!-- Service Section -->
      <style>
        .page {
            width: 100vw;
            height: 100vh;
            min-height: 700px;
            overflow: hidden;
        }
    
        /* Tabs (Service Titles) */
        .tabs-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
            list-style-type: none;
            padding: 10px 0;
        }
    
        .tabs-controls__item {
            display: inline-block;
        }
    
        .tabs-controls__link {
            display: inline-block;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
            color: #423E37;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease-in-out;
        }
    
        /* Active Tab Highlight */
        .tabs-controls__link:hover,
        .tabs-controls__link--active {
            border-bottom: 2px solid #423E37;
            color:#fc0511;
        }
    
        /* Cards (Service Descriptions) */
        .cards-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 10px auto;
            height: 300px; /* Increased height for more content */
            perspective: 1000px;
        }
    
        /* Card Styling */
        .card {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #EDEBD7, #F5F3E4); /* Gradient background */
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(30px) rotateY(180deg);
            visibility: hidden;
            transition: opacity 0.5s ease, transform 0.5s ease;
            cursor: pointer;
        }
    
        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }
    
        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            padding: 20px;
            box-sizing: border-box;
        }
    
        .card-front h1,
        .card-back h2 {
            color: #423E37;
            margin-bottom: 15px;
            font-size: 24px;
        }
    
        .card-front p,
        .card-back p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }
    
        .card-front ul,
        .card-back ul {
            text-align: left;
            padding-left: 20px;
            list-style-type: disc;
            color: #555;
        }
    
        .card-front ul li,
        .card-back ul li {
            margin-bottom: 10px;
        }
    
        .card-back {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, #F5F3E4, #EDEBD7); /* Gradient for back side */
        }
    
        /* Active Card (Visible and Animated) */
        .card--current {
            opacity: 1;
            transform: translateY(0) rotateY(0deg);
            visibility: visible;
        }
    
        /* Stretched link inside cards */
        .card a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-decoration: none;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .cards-container {
                max-width: 90%;
                height: 400px; /* Set fixed height equal to a single card */
                margin: 0 auto;
                position: relative;
                overflow: hidden; /* Prevent other cards from taking extra space */
            }

            .card {
                position: absolute; /* Stack all cards on top of each other */
                width: 100%;
                height: 100%;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.5s ease, transform 0.5s ease;
                transform: translateY(20px);
            }

            /* Only show the current active card */
            .card--current {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .card-front, .card-back {
                padding: 15px;
                width: 100%;
                height: 100%;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            .card-front h1, .card-back h2 {
                font-size: 20px;
            }

            .card-front p, .card-back p {
                font-size: 14px;
                line-height: 1.4;
            }

            .card-front ul, .card-back ul {
                padding-left: 15px;
                font-size: 14px;
            }

            .tabs-controls {
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .tabs-controls__link {
                font-size: 14px;
                padding: 6px 12px;
            }
        }


    </style>
      
<style>
    .main-header-strip {
        background: linear-gradient(135deg, #ff3019 0%, #cf0404 70%, #b80404 100%);
        padding: 25px 0;
        margin-top: 76px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
        border-bottom: 4px solid rgba(0, 0, 0, 0.1);
        text-align: center; /* Ensure all content is centered */
    }
    
    /* Enhanced top light effect */
    .main-header-strip::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, rgba(255,255,255,0), rgba(255,255,255,0.9), rgba(255,255,255,0));
        animation: shimmer 8s infinite linear;
    }
    
    @keyframes shimmer {
        0% { background-position: -500px 0; }
        100% { background-position: 500px 0; }
    }
    
    /* Improved subtle pattern overlay */
    .main-header-strip::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20v20H0V0zm10 17a7 7 0 1 0 0-14 7 7 0 0 0 0 14zm20 0a7 7 0 1 0 0-14 7 7 0 0 0 0 14zM10 37a7 7 0 1 0 0-14 7 7 0 0 0 0 14zm10-17h20v20H20V20zm10 17a7 7 0 1 0 0-14 7 7 0 0 0 0 14z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.2;
        z-index: 1;
    }
    
    .header-content {
        position: relative;
        z-index: 5;
        margin: 0 auto;
        width: 100%;
        text-align: center;
    }
    
    /* Enhanced title styling with reduced size */
    .header-title {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        display: inline-block;
        letter-spacing: 0.5px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    
    .header-title::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, rgba(255,255,255,0.3), rgba(255,255,255,1), rgba(255,255,255,0.3));
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    
    /* Enhanced subtitle styling with reduced size */
    .header-subtitle {
        font-size: 1rem;
        margin: 10px auto 5px;
        color: rgba(255, 255, 255, 0.95);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        max-width: 700px;
        font-weight: 400;
        text-align: center;
    }
    
    /* Particle animation effect with higher contrast */
    .particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        z-index: 2;
    }
    
    .particle {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        pointer-events: none;
    }
    
    /* Multiple particles with different sizes and animations */
    .particle:nth-child(1) {
        width: 60px;
        height: 60px;
        top: -20px;
        left: 10%;
        animation: float-large 20s infinite linear;
    }
    
    .particle:nth-child(2) {
        width: 40px;
        height: 40px;
        bottom: -15px;
        right: 15%;
        animation: float-medium 18s infinite linear;
    }
    
    .particle:nth-child(3) {
        width: 30px;
        height: 30px;
        top: 40%;
        right: 5%;
        animation: float-small 15s infinite linear;
    }
    
    .particle:nth-child(4) {
        width: 25px;
        height: 25px;
        bottom: 30%;
        left: 5%;
        animation: float-tiny 12s infinite linear;
    }
    
    /* Different float animations with adjusted travel distance */
    @keyframes float-large {
        0% { transform: translate(0, 0) scale(1) rotate(0deg); opacity: 0.8; }
        25% { transform: translate(25px, 20px) scale(1.1) rotate(90deg); opacity: 0.5; }
        50% { transform: translate(50px, 0) scale(1) rotate(180deg); opacity: 0.8; }
        75% { transform: translate(25px, -20px) scale(1.1) rotate(270deg); opacity: 0.5; }
        100% { transform: translate(0, 0) scale(1) rotate(360deg); opacity: 0.8; }
    }
    
    @keyframes float-medium {
        0% { transform: translate(0, 0) scale(1) rotate(0deg); opacity: 0.8; }
        25% { transform: translate(-15px, 15px) scale(1.15) rotate(-90deg); opacity: 0.5; }
        50% { transform: translate(-30px, 0) scale(1) rotate(-180deg); opacity: 0.8; }
        75% { transform: translate(-15px, -15px) scale(1.15) rotate(-270deg); opacity: 0.5; }
        100% { transform: translate(0, 0) scale(1) rotate(-360deg); opacity: 0.8; }
    }
    
    @keyframes float-small {
        0% { transform: translate(0, 0) scale(1); opacity: 0.3; }
        33% { transform: translate(15px, -15px) scale(1.2); opacity: 0.5; }
        66% { transform: translate(-15px, -15px) scale(1.1); opacity: 0.8; }
        100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
    }
    
    @keyframes float-tiny {
        0% { transform: translate(0, 0) scale(1); opacity: 0.8; }
        33% { transform: translate(-10px, 10px) scale(1.2); opacity: 0.5; }
        66% { transform: translate(10px, 10px) scale(1.1); opacity: 0.85; }
        100% { transform: translate(0, 0) scale(1); opacity: 0.8; }
    }
    
    /* Light rays effect with increased visibility */
    .light-rays {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        overflow: hidden;
        opacity: 0.8;
    }
    
    .ray {
        position: absolute;
        width: 30px;
        height: 150%;
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%);
        transform: rotate(45deg);
    }
    
    .ray:nth-child(1) {
        left: 10%;
        animation: ray-move 8s infinite linear;
    }
    
    .ray:nth-child(2) {
        left: 30%;
        animation: ray-move 12s infinite linear 2s;
    }
    
    .ray:nth-child(3) {
        left: 50%;
        animation: ray-move 10s infinite linear 1s;
    }
    
    @keyframes ray-move {
        0% { transform: translateX(-100px) rotate(45deg); }
        100% { transform: translateX(100px) rotate(45deg); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-header-strip {
            padding: 20px 0;
        }
        
        .header-title {
            font-size: 1.7rem;
        }
        
        .header-subtitle {
            font-size: 0.9rem;
        }
    }
</style>

<!-- Main Header Strip - Add this right after your navbar in header.php -->
<div class="main-header-strip">
    <!-- Animated particles with higher contrast -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <!-- Light rays effect -->
    <div class="light-rays">
        <div class="ray"></div>
        <div class="ray"></div>
        <div class="ray"></div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center header-content">
                <h1 class="header-title">MERIT MINDS OVERSEAS - Services</h1>
                <p class="header-subtitle">Empowering your future with global education, migration, and work opportunities.</p>
            </div>
        </div>
    </div>
</div>
   
     
    <section id="education-service" class="section pt-0 mt-5">
        <div class="container">
            <!-- <h6 class="section-header text-center masked-text">Our Services</h6>
            <h6 class="section-subheading text-center mb-3">
                Empowering your future with global education, migration, and work opportunities.
            </h6> -->
    
            <!-- Tabs (Service Titles) -->
            <ul class="tabs-controls">
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link tabs-controls__link--active" data-id="1">Study Abroad</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="2">Qualifying Exams & University Shortlisting</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="3">Application & Visa Process</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="4">Financial Services</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="5">Accommodation & Airport Pickup</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="6">Indian Food Supply</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="7">Migrate Abroad</a></li>
                <li class="tabs-controls__item"><a href="#" class="tabs-controls__link" data-id="8">Work Abroad</a></li>
            </ul>
    
            <!-- Service Description Cards -->
            <section class="cards-container">
                <div class="card card--current" id="1">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1 class="masked-text">Study Abroad</h1>
                            <p>Experience the transformative power of international education. Our advisors will guide you through selecting the right courses, universities, and scholarships tailored to your career goals.</p>
                            <ul>
                                <li>Personalized university and course recommendations.</li>
                                <li>Scholarship and financial aid guidance.</li>
                                <li>Pre-departure orientation and support.</li>
                                <li>Post-arrival assistance for a smooth transition.</li>
                            </ul>
                        </div>
                        <div class="card-back">
                            <h2>About Study Abroad</h2>
                            <p>We provide end-to-end support for students aspiring to study abroad, ensuring a seamless transition to your dream university.</p>
                            <ul>
                                <li>Expert counseling for course selection.</li>
                                <li>Assistance with application documentation.</li>
                                <li>Visa and immigration support.</li>
                                <li>Career guidance and alumni network access.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="2">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Qualifying Exams & University Shortlisting</h1>
                            <p>Prepare for your qualifying exams with expert guidance. We also assist in shortlisting the best universities that match your profile and aspirations.</p>
                            <ul class="m-3">
                                <li>Comprehensive exam preparation resources.</li>
                                <li>Mock tests and performance analysis.</li>
                                <li>University shortlisting based on your profile.</li>
                                <li>Application strategy and timeline planning.</li>
                            </ul>
                        </div>
                        <div class="card-back">
                            <h2>About Qualifying Exams & University Shortlisting</h2>
                            <p>Our experts help you prepare for exams and choose the right universities to maximize your chances of success.</p>
                            <ul>
                                <li>Personalized study plans.</li>
                                <li>Access to top-rated study materials.</li>
                                <li>Guidance on university rankings and programs.</li>
                                <li>Interview preparation and tips.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="3">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Application & Visa Process</h1>
                            <p>From submitting your applications to securing your visa, we guide you every step of the way, ensuring you meet deadlines and comply with all requirements for a smooth process.</p>
                            <ul>
                                <li>Assistance with application forms and documents.</li>
                                <li>Visa application guidance and documentation.</li>
                                <li>Interview preparation for visa approvals.</li>
                                <li>Tracking application status and follow-ups.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="4">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Financial Services</h1>
                            <p>Need assistance with education loans, money transfers, or currency exchange? We connect you with trusted financial services, including debit cards and remittance solutions.</p>
                            <ul>
                                <li>Education loan consultation and processing.</li>
                                <li>International money transfer solutions.</li>
                                <li>Guidance on opening bank accounts abroad.</li>
                                <li>Assistance with currency exchange.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="5">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Accommodation & Airport Pickup</h1>
                            <p>Arrive stress-free with our airport pickup services and assistance in finding safe, comfortable accommodation near your university.</p>
                            <ul>
                                <li>Pre-arranged airport pickup services.</li>
                                <li>Guidance on finding affordable housing.</li>
                                <li>Hostel and shared accommodation options.</li>
                                <li>Assistance with rental agreements.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="6">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Indian Food Supply</h1>
                            <p>Missing the taste of home? We provide connections to reliable suppliers of Indian groceries and meals, ensuring you have access to your favorite foods while studying abroad.</p>
                            <ul>
                                <li>Grocery delivery services.</li>
                                <li>Indian restaurant and catering recommendations.</li>
                                <li>Subscription meal services.</li>
                                <li>Assistance in finding Indian supermarkets abroad.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="7">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Migrate Abroad</h1>
                            <p>Considering a permanent move? Our team specializes in immigration solutions that make your dream of settling abroad a reality.</p>
                            <ul>
                                <li>Permanent residency and citizenship consultation.</li>
                                <li>Eligibility assessment and legal guidance.</li>
                                <li>Application processing and documentation support.</li>
                                <li>Post-immigration settlement services.</li>
                            </ul>
                        </div>
                        <div class="card-back">
                            <h2>About Migrate Abroad</h2>
                            <p>We provide expert migration services to help individuals and families successfully relocate to their desired countries.</p>
                            <ul>
                                <li>Pathways for skilled workers and investors.</li>
                                <li>Guidance on immigration laws and policies.</li>
                                <li>Support with integration and employment abroad.</li>
                                <li>Comprehensive post-arrival assistance.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
                <div class="card hidden" id="8">
                    <div class="card-inner">
                        <div class="card-front">
                            <h1  class="masked-text">Work Abroad</h1>
                            <p>Expand your career opportunities by working abroad. We provide assistance with job placements, work visas, and international career development strategies.</p>
                            <ul>
                                <li>Job search and placement assistance.</li>
                                <li>Work visa application guidance.</li>
                                <li>Resume and interview preparation.</li>
                                <li>Networking with international recruiters.</li>
                            </ul>
                        </div>
                        <div class="card-back">
                            <h2>About Work Abroad</h2>
                            <p>Our work abroad services help professionals land jobs and build successful careers in foreign countries.</p>
                            <ul>
                                <li>Industry-specific job market insights.</li>
                                <li>Visa sponsorship and employer connections.</li>
                                <li>Legal compliance and employment regulations.</li>
                                <li>Work-life transition support.</li>
                            </ul>
                        </div>
                    </div>
                    <a href="JoinUS.php"></a>
                </div>
            </section>
        </div>
    </section>
    
    <!-- JS -->
    <script>
     
        document.addEventListener("DOMContentLoaded", function () {
            let tabs = document.querySelectorAll(".tabs-controls__link");
            let cards = document.querySelectorAll(".card");
            let lastIndex = 0;

            tabs.forEach((tab, index) => {
                tab.addEventListener("click", function (e) {
                    e.preventDefault();

                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove("tabs-controls__link--active"));

                    // Add active class to clicked tab
                    this.classList.add("tabs-controls__link--active");

                    // Hide previous card with flip animation
                    cards[lastIndex].classList.remove("card--current");
                    cards[lastIndex].classList.add("hidden");

                    // Show clicked tab’s corresponding card with flip animation
                    setTimeout(() => {
                        cards[index].classList.remove("hidden");
                        cards[index].classList.add("card--current");
                        lastIndex = index; // Update last index
                    }, 200);
                });
            });
        });
    </script> 

 
    <!-- End OF Service Section -->
     <?php include 'footer.php'?>
    </body>
     </html>