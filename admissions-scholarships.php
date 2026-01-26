<?php include 'header.php'; ?>
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
            <h1 class="title masked-text">Admissions & Scholarships</h1>
            <h1 class="subtitle">Secure Your Future with Merit Minds</h1>  
        </div> 
    </div>   
   
    <!-- Main Content Section -->
    <section class="section pt-0">
        <div class="container">
            <h6 class="section-heading text-center masked-text">Admissions & Scholarships</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Get ready for success with our comprehensive admissions and scholarship guidance services.</h6>

            <div class="row">
                <div class="col-md-6">
                    <img src="assets\imgs\adm_scholor.webp" alt="Admissions Scholarships" class="w-100 shadow-sm mb-4">
                </div>
                <div class="col-md-6">
                    <p>At Merit Minds Overseas, we provide students with personalized support to navigate the admissions process and secure scholarships for international education. We understand the importance of gaining admission to top universities worldwide and are committed to helping you achieve that dream.</p>
                    <ul>
                        <li>End-to-end guidance on selecting universities and programs.</li>
                        <li>Assistance with crafting compelling applications and personal statements.</li>
                        <li>Access to a database of scholarships and financial aid programs.</li>
                        <li>Interview preparation and support for scholarship and university admissions.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Section: Benefits -->
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
            <h6 class="section-heading text-center masked-text">Why Choose Merit Minds for Admissions & Scholarships?</h6>
            <p class="section-subheading text-center mb-5">We make the admission process easier by providing you with unmatched expertise and support.</p>
    
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4 me-2">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-bookmark-alt text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Personalized Support</h6>
                            <p>Our team provides one-on-one consultation to tailor your application and scholarship process to your strengths and needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 me-2">
                    <div class="card p-4 shadow-xl h-100">
                        <div class="icon-box text-center">
                            <i class="ti-medall text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Exclusive Scholarships</h6>
                            <p>We offer access to exclusive scholarships that aren’t widely known, giving you an edge in funding your education.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 me-2">
                    <div class="card p-4 shadow-x h-100">
                        <div class="icon-box text-center">
                            <i class="ti-world text-primary mb-3" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">Global Opportunities</h6>
                            <p>We provide guidance for universities in the USA, UK, Canada, Australia, Germany, and more to expand your opportunities globally.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Call to Action Section -->
    <section class="section bg-primary text-white text-center mt-3">
        <div class="container">
            <h6 class="section-heading masked-text">Ready to Take the Next Step?</h6>
            <p class="section-subheading mb-4">Contact us today to start your admissions and scholarship journey with Merit Minds Overseas.</p>
            <a href="contact-us.php" class="btn btn-light">Contact Us</a>
        </div>
    </section>

    <!-- Testimonials Section -->
        
    <section class="section">
        <div class="container">
            <h6 class="section-heading text-center masked-text mt-3">What Our Students Say</h6>
            <h6 class="section-subheading text-center mb-5 pb-3">Hear from students who have successfully navigated their admissions and scholarships journey with us.</h6>

               <div class="row ">
                <!-- Testimonial: Lakshma Reddy Pothireddy -->
                <div class="col-md-4 my-3"  data-aos="flip-right" data-aos-delay="100">
                    <div class="card-3d"  >
                        <div class="card-body" style="background-color:#38d90b;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0">Lakshma Reddy Pothireddy</h6>
                                    <small class="text-muted">Cleveland State University</small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning">★★★★★</div>
                            <p class="mb-0">"This was our first experience with MERIT MINDS OVERSEAS, particularly with Shekar sir, and it was truly impressive and pleasant. He was resourceful and highly customer-focused."</p>
                        </div>
                    </div>
                </div>
    
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
    
                <!-- Testimonial: Venkata Saikumar Marri -->
                <div class="col-md-4 my-3" data-aos="flip-left" data-aos-delay="500">
                    <div class="card-3d">
                        <div class="card-body"  style="background-color:#c65858;">
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