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
                <h1 class="title masked-text">Financial Eduloans</h1>
                <h1 class="subtitle">Get Financial Support to Achieve Your Educational Goals</h1>  
            </div>  
     
        </div>  
    

    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Financial Eduloans</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Get the financial support you need for your international education.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="https://overseaseduloans.com/images/slide04.jpg" alt="Financial Eduloans" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>Merit Minds Overseas offers a range of financial support options, including education loans, to help you fund your studies abroad. Our team works with financial institutions to secure loans at competitive rates. Our services include:</p>
                    <ul>
                        <li>Assistance with securing education loans tailored to your financial needs.</li>
                        <li>Guidance on loan repayment plans and interest rates.</li>
                        <li>Support with the documentation and application process.</li>
                        <li>Advice on financial planning for your international education journey.</li>
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
            <h6 class="section-heading text-center masked-text">Why Choose Merit Minds for Financial Eduloans?</h6>
            <p class="section-subheading text-center mb-5">We simplify the process of securing loans to make your education journey stress-free.</p>

            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-wallet text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Flexible Loan Options</h6>
                            <p>We offer a variety of loan options that suit your financial situation, with flexible repayment plans.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-files text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Simplified Application Process</h6>
                            <p>Our team helps you through the loan application process, ensuring you have all the required documentation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-lg h-100">
                        <div class="icon-box text-center">
                            <i class="ti-pie-chart text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Competitive Interest Rates</h6>
                            <p>We work with trusted financial institutions to offer loans at competitive interest rates, reducing the financial burden.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

          <!-- Call to Action Section -->
    <section class="section bg-primary text-white text-center">
        <div class="container">
            <h6 class="section-heading masked-text">Ready to Secure Your Education Loan?</h6>
            <p class="section-subheading mb-4">Contact us today to get started with your loan application process and plan your financial future.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Success Stories</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Here’s how our students secured financial support to pursue their education abroad.</h6>

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
                            <p class="mb-0">I thank the Vijayanand Sir for his moral support, dedication and the outstanding service during my application process and VISA preparation."</p>
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