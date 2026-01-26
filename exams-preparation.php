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
            
                <h1 class="title masked-text">Exams Preparation</h1>
                <h1 class="subtitle">Helping You Ace International Exams</h1>  
        
            </div>
        </div>
 
    </div>  
     

    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Exams Preparation</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Get ready for success with our comprehensive exam preparation services.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="assets\imgs\examprep.jpg" alt="Exams Preparation" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>At Merit Minds Overseas, we offer specialized training and resources to help you excel in the exams required for international education. Whether you're preparing for IELTS, TOEFL, SAT, GMAT, or other proficiency tests, our exam preparation services provide you with:</p>
                    <ul>
                        <li>Tailored study plans to fit your academic needs.</li>
                        <li>Access to past exam papers and mock tests.</li>
                        <li>Experienced trainers who guide you through key exam strategies.</li>
                        <li>Comprehensive feedback and performance tracking.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
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
    <section class="section bg-light">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Why Choose Merit Minds for Exam Preparation?</h6>
            <p class="section-subheading text-center mb-5">Our proven approach helps students ace their exams and secure top university placements.</p>

            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-ruler-pencil text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Customized Study Plans</h6>
                            <p>We design study plans specific to each student’s strengths and areas for improvement, ensuring the best possible results.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-notepad text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Mock Tests & Practice</h6>
                            <p>Gain access to mock tests and practice materials that simulate real exam environments, boosting your confidence and readiness.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-stats-up text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Performance Tracking</h6>
                            <p>Regular assessments and progress tracking help ensure that you stay on the right track to success.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    
       <!-- Call to Action Section -->
       <section class="section bg-primary text-white text-center">
        <div class="container">
            <h6 class="section-heading masked-text">Ready to Ace Your Exams?</h6>
            <p class="section-subheading mb-4">Contact us today to start your exam preparation journey with Merit Minds Overseas.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    
    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Student Success Stories</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Here's what our students have to say about their exam preparation journey with us.</h6>

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