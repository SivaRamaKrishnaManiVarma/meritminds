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
            <h1 class="title masked-text">Travel & Forex</h1>
            <h1 class="subtitle">Simplifying Your Travel and Forex Needs</h1>  
        </div>  
   >
        </div>  

    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Travel & Forex</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Seamless solutions for your travel and foreign exchange needs.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="assets\imgs\travelforex.webp" alt="Travel Forex" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>At Merit Minds Overseas, we understand that international students need comprehensive support for their travel and forex needs. Whether it's securing competitive exchange rates or booking flights, our services include:</p>
                    <ul>
                        <li>Assistance with booking international and domestic flights at competitive prices.</li>
                        <li>Forex services to get the best exchange rates for foreign currency.</li>
                        <li>Guidance on prepaid forex cards, traveller's cheques, and cash handling abroad.</li>
                        <li>Travel insurance options for peace of mind during your journey.</li>
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
            <h6 class="section-heading text-center masked-text">Why Choose Merit Minds for Travel & Forex?</h6>
            <p class="section-subheading text-center mb-5">We make travel and currency exchange hassle-free for international students.</p>

            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-world text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Comprehensive Travel Assistance</h6>
                            <p>We handle all aspects of your travel arrangements, from flight bookings to insurance, ensuring a stress-free experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-money text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Best Forex Rates</h6>
                            <p>Get access to competitive exchange rates for foreign currency and advice on managing your finances abroad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-wallet text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Flexible Forex Solutions</h6>
                            <p>Choose from prepaid forex cards, traveller’s cheques, or cash to manage your money while studying abroad.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

           <!-- Call to Action Section -->
    <section class="section bg-primary text-white text-center">
        <div class="container">
            <h6 class="section-heading masked-text">Need Help with Travel or Forex?</h6>
            <p class="section-subheading mb-4">Get in touch with us today to get expert assistance with your travel and forex needs.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Success Stories</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">See how our students have benefited from our travel and forex services.</h6>

            <div class="row">
              <!-- Testimonial: Salma Sultana -->
              <div class="col-md-4 my-3"  data-aos="flip-up" data-aos-delay="300">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#cfa153;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Salma Sultana</h6>
                                    <small class="text-muted">Webster University</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"MERIT MINDS OVERSEAS played a key role in my USA university admission and student visa application process, guiding me through every challenge, despite my educational gap."</p>
                        </div>
                    </div>
                </div>
    
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
                            <p class="mb-0">"I extend my heartfelt gratitude to Vijayanand Sir for his unwavering moral support, exceptional dedication, and outstanding guidance throughout my application process and VISA preparation."</p>
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