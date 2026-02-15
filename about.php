<?php include 'header.php'; ?>
    <style>
        /* General Styles */
   
        h6.section-heading {
            font-size: 1.75rem;
            font-weight: bold;
            color: #0056b3;
        }
        h6.section-subheading {
            font-size: 1.1rem;
            color: #6c757d;
        }
    
        .about-img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        /* Testimonials Styles */
        .testimonials .card {
            background-color: #fff;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .testimonials img {
            max-width: 80px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .testimonials .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .testimonials .card-body {
            display: flex;
            align-items: center;
        }
        .testimonials .text-muted {
            font-size: 0.9rem;
            color: #868e96;
        }
        /* Video Section */
        .video-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .video-item {
            flex: 1 1 calc(50% - 20px);
            max-width: 48%;
            margin-bottom: 20px;
        }
        .video-description {
            font-size: 1rem;
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
        }
        /* Footer */
        footer {
            background-color: #f8f9fa;
            text-align: center;
        }
        /* Mobile Styles */
        @media (max-width: 768px) {
            .video-item {
                max-width: 100%;
            }
            .testimonials .card-body {
                flex-direction: column;
                align-items: flex-start;
            }
            .testimonials img {
                margin-bottom: 15px;
            }
        }
 
    </style>
    

        <!-- Page Header Section -->
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
                    <h1 class="header-title">Merit Minds Overseas</h1>
                    <p class="header-subtitle">Guiding Your International Education Journey.</p>
                </div>
            </div>
        </div>
    </div>     


<!-- CSS for the main header strip -->
<style>
    .main-header-strip {
        background: red;
        padding: 30px 0;
        margin-top: 76px; /* Adjust based on your navbar height */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    

    
    .header-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .main-header-strip .btn {
        padding: 8px 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .main-header-strip .btn-primary {
        background-color: #ffffff;
        color: #54a214;
        border: none;
    }
    
    .main-header-strip .btn-primary:hover {
        background-color: #f5f5f5;
        transform: translateY(-2px);
    }
    
    .main-header-strip .btn-outline-light {
        border: 2px solid white;
    }
    
    .main-header-strip .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .main-header-strip {
            padding: 25px 0;
            text-align: center;
        }
        
        .header-title {
            font-size: 2rem;
        }
        
        .header-subtitle {
            font-size: 1rem;
        }
        
        .col-md-4.text-md-end {
            text-align: center !important;
            margin-top: 15px;
        }
    }
</style> 
      
<!-- About Section -->
    
<style>
    /* Section Styling */
    .animated-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
    }

    .animated-section.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Title & Subtitle */
    .section-title {
        font-size: 28px;
        font-weight: bold;
        background: linear-gradient(90deg, #fc0511, #a30008);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
    }

    .section-subtitle {
        font-size: 20px;
        font-weight: 500;
        color: #fc0511;
        margin-bottom: 25px;
    }

    /* Fade-in Effect */
    .fade-in {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Scale-Up Effect */
    .scale-up {
        transition: transform 0.5s ease-in-out;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .scale-up:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Process Cards */
    .process-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid #fc0511;
    }

    .process-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .process-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        background: #fc0511;
        color: white;
        text-align: center;
        line-height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        font-weight: bold;
    }

    /* Value Pills */
    .value-pill {
        display: inline-block;
        background: #fff3f3;
        border-radius: 20px;
        padding: 8px 15px;
        margin: 5px;
        font-weight: 500;
        color: #fc0511;
        border: 1px solid #fc0511;
        transition: all 0.3s ease;
    }

    .value-pill:hover {
        background: #fc0511;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Image Container Styling */
    .equal-height {
        display: flex;
        align-items: stretch;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .equal-height img {
        object-fit: cover;
        height: 100%;
        border-radius: 10px;
        transition: all 0.5s ease;
    }

    .about-img-container {
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Theme Background */
    .theme-background {
        background-color: #fc0511;
        color: white;
        padding: 40px 20px;
        border-radius: 10px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 24px;
        }

        .section-subtitle {
            font-size: 16px;
        }

        .process-cards {
            margin-top: 30px;
        }
    }
</style>

<section class="animated-section mt-5" id="about">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            
            <!-- Left Section (Text & Values) -->
            <div class="col-md-6">
                <h6 class="section-title fade-in masked-text">MeritMinds</h6>
                <h6 class="section-subtitle fade-in">Your Trusted Partner in International Education</h6>
                
                <p class="fade-in">At <b>MeritMinds</b>, we are dedicated to transforming educational aspirations into reality. Since our establishment, we have successfully guided thousands of students toward achieving their dreams of international higher education.</p>
                
                <div class="fade-in mt-4">
                    <h5><b>Our Mission</b></h5>
                    <p>We believe that quality education knows no boundaries. Our mission is to empower students with the knowledge, resources, and support they need to access world-class educational opportunities abroad, allowing them to reach their full potential on the global stage.</p>
                </div>

                <div class="fade-in mt-4">
                    <h5><b>Our Values</b></h5>
                    <div class="d-flex flex-wrap">
                        <span class="value-pill">Integrity</span>
                        <span class="value-pill">Excellence</span>
                        <span class="value-pill">Innovation</span>
                        <span class="value-pill">Empathy</span>
                        <span class="value-pill">Diversity</span>
                    </div>
                </div>

                <div class="row equal-height">
                    <div class="col-6 fade-in">
                        <div class="about-img-container scale-up">
                            <img src="assets\imgs\room3.jpg" alt="Students Consulting" class="w-100" style="height:191px;">
                        </div>
                    </div>
                    <div class="col-6 fade-in">
                        <div class="about-img-container scale-up">
                            <img src="assets\imgs\room4.jpg" alt="International Education" class="w-100" style="height:191px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section (Process & Image) -->
            <div class="col-md-6">
                <div class="about-img-container fade-in scale-up mb-4">
                    <img src="assets\imgs\rooma.jpg" alt="Global Education" class="w-100" style="max-height:350px;">
                </div>
                
                <div class="process-cards fade-in">
                    <h5><b>Our Process</b></h5>
                    
                    <div class="process-card">
                        <span class="process-number">1</span>
                        <b>Initial Consultation</b>
                        <p class="mb-0">We begin with a thorough assessment of your academic profile, interests, and career objectives.</p>
                    </div>
                    
                    <div class="process-card">
                        <span class="process-number">2</span>
                        <b>University Selection</b>
                        <p class="mb-0">Based on your profile, we help you identify institutions that match your academic and personal requirements.</p>
                    </div>
                    
                    <div class="process-card">
                        <span class="process-number">3</span>
                        <b>Application Strategy</b>
                        <p class="mb-0">We develop a strategic plan for applications, emphasizing your strengths while addressing potential concerns.</p>
                    </div>
                    
                    <div class="process-card">
                        <span class="process-number">4</span>
                        <b>Document Preparation</b>
                        <p class="mb-0">Our experts assist with crafting compelling personal statements, resumes, and recommendation letters.</p>
                    </div>
                    
                    <div class="fade-in mt-3 text-center">
                        <p>Join <b>MeritMinds</b> and take the first step toward a world of opportunities!</p>
                    </div>
                </div>
            </div>

        </div>              
    </div>

    <script>
        // JavaScript to handle fade-in animations
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animated-section, .fade-in').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</section>
 

 <!-- About Us Section
<section class="section pt-0 animated-section mt-5">
    <div class="container">
        <h6 class="section-heading text-center masked-text">About Us</h6>
        <h6 class="section-subheading text-center mb-5 pb-3 fade-in">At Merit Minds Overseas, we are dedicated to helping students achieve their academic dreams across the globe. With personalized support and expert guidance, we make international education a reality.</h6>

        <div class="row">
            <div class="col-md-6 fade-in">
                <p>Our team of experienced professionals offers comprehensive services, from selecting the best universities to securing visas and financial aid. We specialize in making the complex process of studying abroad simple and stress-free. With a focus on student success, our tailored approach ensures that every student receives the attention and guidance they need to thrive in their new academic environment.</p>
                <ul>
                    <li>Personalized university selection and application support.</li>
                    <li>Visa application assistance and interview preparation.</li>
                    <li>Financial aid guidance and scholarship opportunities.</li>
                    <li>Continuous support throughout the study abroad journey.</li>
                </ul>
            </div>
            <div class="col-md-6 fade-in">
                <img src="./assets/imgs/Depositphotos_266217346_DS.jpg" alt="About Merit Minds" class="about-img scale-up">
            </div>
        </div>
    </div>
</section> -->

<!-- Testimonials Section -->
<section class="section bg-light" id="testimonial">
        <div class="container">
            <h6 class="section-title text-center mb-0 masked-text mb-5">Our Students Speak For Us</h6>
            <!-- <h6 class="section-subtitle mb-5 text-center">What Our Clients Say</h6> -->
        
            <!-- Testimonial Cards Row -->
            <div class="row">
                   <!-- Testimonial: Monisha Thota -->
                   <div class="col-md-4 my-3" data-aos="flip-left" data-aos-delay="1000">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold"  style="color:#ad37c2db;">EXCEPTIONAL SUPPORT</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Monisha Thota</small>
                                    <small style="color:#ad37c2db;" class="d-block text-end">New York Institute of Technology</small>
                                </div>
                            </div>
                            <p class="mb-0">"I extend my heartfelt gratitude to Vijayanand Sir for his unwavering moral support, exceptional dedication, and outstanding guidance throughout my application process and VISA preparation."</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2 Ramya -->
                <div class="col-md-4 my-3" data-aos="flip-right" data-aos-delay="600">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold" style="color:#5f5a07;" >INCREDIBLY GRATEFUL</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Ramya</small>
                                    <small style="color:#5f5a07;" class="d-block text-end">University of Greenwich</small>
                                </div>
                            </div>
                            <p class="mb-0">"Incredibly grateful to MERIT MINDS OVERSEAS for personalized advice and meticulous visa interview preparation. Highly recommend for studying abroad."</p>
                        </div>
                    </div>
                </div>
     
                  <!-- Card 3 Lakshma -->
                  <div class="col-md-4 my-3" data-aos="flip-right" data-aos-delay="100">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold" style="color:#dc3545;">RESOURCEFUL, RESPONSIVE</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Lakshma Reddy Pothireddy</small>
                                    <small style="color:#dc3545;" class="d-block text-end">Cleveland State University</small>
                                </div>
                            </div>
                            <p class="mb-0">"This was our first experience with MERIT MINDS OVERSEAS, particularly with Shekar sir, and it was truly impressive and pleasant. He was resourceful and highly customer-focused."</p>
                        </div>
                    </div>
                </div>

                
              
                <!-- Testimonial: Naga Madhuri Penmatsa -->
                <div class="col-md-4 my-3" data-aos="flip-right" data-aos-delay="600">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold" style="color:#7d6ef3">IMPECCABLE DIRECTION</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Naga Madhuri Penmatsa</small>
                                    <small style="color:#7d6ef3" class="d-block text-end">University of Strathclyde</small>
                                </div>
                            </div>
                            <p class="mb-0">"
                            I'm grateful to Rahul Sir for his constant support in achieving my dream. MERIT MINDS is a reliable organization 
                            in overseas education and they are my trusted partners."</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 Salma -->
                <div class="col-md-4 my-3" data-aos="flip-up" data-aos-delay="300">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold" style="color:#004694;">EXCEPTIONAL SUPPORT</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Salma Sultana</small>
                                    <small style="color:#004694;" class="d-block text-end">Webster University</small>
                                </div>
                            </div>
                            <p class="mb-0">"MERIT MINDS OVERSEAS played a key role in my USA university admission and student visa application process, guiding me through every challenge, despite my educational gap."</p>
                        </div>
                    </div>
                </div>
             
                
                <!--Card 3  Testimonial: Neeharika -->
                <div class="col-md-4 my-3" data-aos="flip-up" data-aos-delay="800">
                    <div class="card-3d">
                        <div class="card-body">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0 fw-bold" style="color:#239bca;">FANTASTIC EXPERIENCE</h6>
                                    <h6 class="mt-1 mb-0 text-end">★★★★★</h6>
                                    <small class="text-warning d-block text-end">Neeharika</small>
                                    <small style="color:#239bca;" class="d-block text-end">CCT College, Dublin</small>
                                </div>
                            </div>
                            <p class="mb-0">"Exceptional support throughout my study journey, from exam preparation to visa process approval Expert guidance made everything seamless."</p>
                        </div>
                    </div>
                </div>

             
            </div>
        </div>
    </section>


<!-- Video Testimonials Section -->
<section class="section video-section animated-section">
    <div class="container">
        <h6 class="section-heading text-center" style="color:#dc3545">What Our Students Say (Video)</h6>
        <h6 class="section-subheading text-center mb-5 fade-in">Watch the experiences shared by our students in their own words.</h6>

        <div class="video-wrapper fade-in">
            <div class="video-item">
                <video controls poster="assets/imgs/WhatsApp Image 2024-10-19 at 2.25.57 PM.jpeg" width="100%">
                    <source src="./assets/Video/merit.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p class="video-description">Saivenkat Marri</p>
                <p class="video-description">MS in Pharmacology.Toxicology, Wright State University</p>
            </div>

            <div class="video-item fade-in">
                <video controls poster="assets/imgs/WhatsApp Image 2024-10-19 at 2.25.32 PM.jpeg" width="100%">
                    <source src="./assets/Video/WhatsApp Video 2024-10-18 at 7.14.43 PM.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p class="video-description">MGK Reddy</p>
                <p class="video-description">MS in Artificial intelligence .University of Florida</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* CSS to ensure equal height for video cards */
    .video-wrapper {
        display: flex;
        gap: 20px; /* Adjust the gap between videos as needed */
    }

    .video-item {
        flex: 1; /* Distribute space equally between video items */
        display: flex;
        flex-direction: column;
        height: 100%; /* Ensure the container takes full height */
    }

    video {
        width: 100%;
        height: auto; /* Maintain aspect ratio */
        flex-grow: 1; /* Allow video to take remaining space */
    }

    .video-description {
        margin: 10px 0 0; /* Add spacing below the video */
        text-align: center; /* Center-align the text */
    }
</style>

<!-- JS for Animations -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fadeInElements = document.querySelectorAll(".fade-in");
        const animatedSections = document.querySelectorAll(".animated-section");

        function revealOnScroll() {
            const windowHeight = window.innerHeight;

            animatedSections.forEach(section => {
                if (section.getBoundingClientRect().top < windowHeight - 50) {
                    section.classList.add("visible");
                }
            });

            fadeInElements.forEach(el => {
                if (el.getBoundingClientRect().top < windowHeight - 50) {
                    el.classList.add("visible");
                }
            });
        }

        window.addEventListener("scroll", revealOnScroll);
        revealOnScroll();
    });
</script>

<!-- CSS for Animations -->
<style>
    .animated-section {
        opacity: 0;
        transition: opacity 0.6s ease-in-out;
    }
    .animated-section.visible, .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
    }
    .card-3d {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .card-3d:hover {
        transform: translateY(-10px) rotateX(10deg) rotateY(5deg);
    }
</style>
<?php include 'footer.php'?>
    <!-- Scripts -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    
<!-- Add AOS library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        
    });
</script>
<script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
<script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>
<script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>
<script src="assets/vendors/isotope/isotope.pkgd.js"></script>
<script src="assets/js/leadmark.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<!-- Firebase Firestore -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
<script src="./firebaseConfig.js"></script>
</body>

</html>
