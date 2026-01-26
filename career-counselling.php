<?php include 'header.php'?>

    
    <style>
    
        /* Fade-in Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
        }

        .animated-section {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }

        .animated-section.visible, .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }


        /* Scale-Up Effect */
        .scale-up {
            transition: transform 0.5s ease-in-out;
        }

        .scale-up:hover {
            transform: scale(1.05);
        }
        /* From Uiverse.io by adamgiebl */ 
        .card {
        width: 280px;
        height: 204px;
        border-radius: 30px;
        background: #e0e0e0;
        box-shadow: 15px 15px 30px #bebebe,
                    -15px -15px 30px #ffffff;
        }
    </style>
    <!-- Page Header Section -->
    <div class="overlay">
        <!-- Translucent Layer -->
        <div class="translucent-layer"></div>
    
        <!-- Background Image -->
        <img src="assets/imgs/corousel.png" alt="carousel" class="img-fluid d-none d-lg-block">
        <img src="assets\imgs\corousel_550px.jpg" alt="carousel" class="img-fluid d-block d-lg-none">
    
    
        <!-- Text Content Positioned Over Image -->
        <div class="text-content">
            <h1 class="title masked-text">Career Counselling</h1>
            <h1 class="subtitle">Guiding You to Achieve Your International Education Dreams</h1>
    
        </div>
    </div>
 

    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Career Counselling</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Explore your career path with our professional counselling services.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="assets\imgs\careerounseling.webp" alt="Career Counselling" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>At Merit Minds Overseas, we offer comprehensive career counselling to help you navigate the best educational path suited to your skills and interests. Our expert counsellors have years of experience guiding students towards successful careers through personalized counselling sessions.</p>
                    <ul>
                        <li>Assess your strengths, interests, and academic achievements.</li>
                        <li>Get expert advice on career options and university programs.</li>
                        <li>Access industry insights to help you make an informed decision.</li>
                        <li>Receive ongoing support throughout your educational journey.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- CSS -->
     <style>
        @media (max-width: 992px) { /* Targets tablets and smaller screens */
    .row.justify-content-center {
        flex-direction: column;
        align-items: center;
    }

    .col-md-4 {
        width: 80%; /* Adjust width for better appearance */
    }

    .section-heading {
        font-size: 1.5rem; /* Reduce title font size */
    }
}

@media (max-width: 768px) { /* Targets mobile screens */
    .col-md-4 {
        width: 100%;
    }

    .section-heading {
        font-size: 1.2rem;
    }
}

     </style>
    <!-- Benefits Section -->
    <section class="section bg-light">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Why Choose Our Career Counselling?</h6>
            <p class="section-subheading text-center mb-5">Our expert counsellors provide personalized support tailored to your individual goals and ambitions.</p>

            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-user text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Personalized Guidance</h6>
                            <p>We work with you one-on-one to understand your strengths and interests and guide you toward the best academic and career path.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-bar-chart-alt text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Industry Insights</h6>
                            <p>Gain access to the latest industry trends and employment opportunities that align with your career ambitions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-briefcase text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Career Development</h6>
                            <p>We help you develop the skills and knowledge needed to succeed in the global workforce and meet the challenges of a rapidly changing job market.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    
        
    <!-- Call to Action Section -->
    <section class="section bg-primary text-white text-center">
        <div class="container">
            <h6 class="section-heading masked-text">Ready to Get Career Guidance?</h6>
            <p class="section-subheading mb-4">Contact us today to receive personalized career counselling and embark on your path to success.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Success Stories</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Hear from students who have achieved their career goals with our counselling services.</h6>

            <div class="row">
                <!-- Testimonial: Tanishq Kondru -->
                <div class="col-md-4 my-3"  data-aos="flip-right" data-aos-delay="600">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#7d6ef3">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Tanishq Kondru</h6>
                                    <small class="text-muted">University of Minnesota</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"Incredibly grateful to MERIT MINDS OVERSEAS for personalized advice and meticulous visa interview preparation. Highly recommend for studying abroad."</p>
                        </div>
                    </div>
                </div>
    
                <!-- Testimonial: Gopalakrishna Manukonda -->
                <div class="col-md-4 my-3" data-aos="flip-up" data-aos-delay="800">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#239bca;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Gopalakrishna Reddy Manukonda</h6>
                                    <small class="text-muted">University of Florida</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"Exceptional support throughout my study journey, from exam preparation to visa approval Expert guidance made everything seamless."</p>
                        </div>
                    </div>
                </div>
    
                <!-- Testimonial: Monisha Thota -->
                <div class="col-md-4 my-3" data-aos="flip-left" data-aos-delay="1000">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#ad37c2db;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Monisha Thota</h6>
                                    <small class="text-muted">New York Institute of Technology</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"I thank the Vijayanand Sir for his moral support, dedication and the outstanding service during my application process and VISA preparation."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="mt-5 py-4 border-top border-secondary">
        <div class="container">
            <p class="mb-0 small">&copy; <script>document.write(new Date().getFullYear())</script>, Merit Minds Overseas. All rights reserved.</p>     
        </div>
    </footer>

    <!-- Core Scripts -->
     <!-- AOS Library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script>
        AOS.init();
        </script>

    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>
    <script src="assets/vendors/isotope/isotope.pkgd.js"></script>
    <script src="assets/js/leadmark.js"></script>

</body>
</html>