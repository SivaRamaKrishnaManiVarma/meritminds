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
            <h1 class="title masked-text">Visa Processing</h1>
            <h1 class="subtitle">Your Gateway to International Study Success</h1>  
        </div>  
       
    </div>  
    

    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Visa Processing</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Navigating your visa process with ease and expertise.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="https://media.rnztools.nz/rnz/image/upload/s--ENOegft4--/c_scale,f_auto,q_auto,w_1050/v1643617877/4N5O6Q7_image_crop_87774" alt="Visa Processing" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>At Merit Minds Overseas, we offer a complete range of visa processing services to ensure your application is smooth and hassle-free. Our visa experts are familiar with the requirements of various countries, and we guide you through every step of the process, including:</p>
                    <ul>
                        <li>Filling out visa application forms and submitting them to the appropriate embassy.</li>
                        <li>Helping you gather and prepare all the necessary documentation.</li>
                        <li>Providing mock visa interviews and coaching to ensure you're well-prepared.</li>
                        <li>Offering guidance on health insurance and visa fee payments.</li>
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
            <h6 class="section-heading text-center masked-text">Why Choose Merit Minds for Visa Processing?</h6>
            <p class="section-subheading text-center mb-5">We simplify the complex visa process, ensuring a smooth experience for every student.</p>

            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-check-box text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Expert Guidance</h6>
                            <p>Our experienced visa counsellors guide you through every step of the process, from form submission to interview preparation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-clipboard text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Streamlined Documentation</h6>
                            <p>We help you gather and organize all the necessary documents to ensure a smooth visa submission.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-world text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Global Expertise</h6>
                            <p>We have experience with visa processing for multiple countries, ensuring you get the best advice for your destination.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

      <!-- Call to Action Section -->
      <section class="section bg-primary text-white text-center">
        <div class="container">
            <h6 class="section-heading masked-text">Need Help with Your Visa Application?</h6>
            <p class="section-subheading mb-4">Get in touch with us today and let our experts guide you through the visa process.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Success Stories</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Hear from our students who successfully obtained their visas with our support.</h6>
       <!-- Testimonial: Venkata Saikumar Marri -->
                 <div class="col-md-4 my-3" data-aos="flip-left" data-aos-delay="500">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#a79595;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Venkata Saikumar Marri</h6>
                                    <small class="text-muted">Wright State University</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"I am delighted to share that I have received my visa approval to attend Wright State University for Fall 2024. Their constant support was crucial in achieving this milestone."</p>
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