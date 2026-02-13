<?php include 'header.php'?>

<!-- Hero Section with Orbit Animation - FIXED ORBITS -->
<!-- Updated HTML with Rotating Flags (except India) -->
<section class="orbit-animation-section mt-0">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left content -->
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <h2 class="orbit-main-title">
                    study abroad<br>
                    with expert<br>
                    guidance from<br>
                    <span class="highlight-text">international students</span>
                </h2>

                <!-- CTA Button - Refined Design -->
                <button type="button" class="orbit-cta-btn modal-trigger-btn">
                    Find my dream university
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="btn-arrow">
                        <circle cx="12" cy="12" r="11" fill="white" opacity="0.2"/>
                        <path d="M9 6L15 12L9 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

             <!-- Stats Container with Animated Counter -->
                <div class="stats-container">
                    <div class="stats-box">
                        <div class="stats-value" data-target="1000" data-suffix="K">0</div>
                        <div class="stats-label">universities</div>
                    </div>
                    <div class="stats-box">
                        <div class="stats-value" data-target="300">0</div>
                        <div class="stats-label">mentors</div>
                    </div>
                    <div class="stats-box">
                        <div class="stats-value" data-target="51">0</div>
                        <div class="stats-label">countries</div>
                    </div>
                    <div class="stats-box">
                        <div class="stats-value" data-target="100" data-suffix="+">0</div>
                        <div class="stats-label">success stories</div>
                    </div>
                </div>

                <script>
                // Animated Counter Function
                function animateCounter(element, target, duration = 2000) {
                    const suffix = element.getAttribute('data-suffix') || '';
                    const start = 0;
                    const increment = target / (duration / 16); // 60fps
                    let current = start;

                    const timer = setInterval(() => {
                        current += increment;

                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }

                        // Format the number
                        let displayValue = Math.floor(current);

                        // For "K" suffix, show as "1K" when reached 1000
                        if (suffix === 'K' && current >= 1000) {
                            displayValue = '1K';
                        } else if (suffix === 'K') {
                            displayValue = Math.floor(current);
                        } else {
                            displayValue = Math.floor(current) + suffix;
                        }

                        element.textContent = displayValue;
                    }, 16);
                }

                // Intersection Observer to trigger animation when stats come into view
                const observerOptions = {
                    threshold: 0.5,
                    rootMargin: '0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const statsValues = entry.target.querySelectorAll('.stats-value');

                            statsValues.forEach(stat => {
                                const target = parseInt(stat.getAttribute('data-target'));
                                animateCounter(stat, target);
                            });

                            // Unobserve after animation starts (run only once)
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                // Start observing when DOM is loaded
                document.addEventListener('DOMContentLoaded', () => {
                    const statsContainer = document.querySelector('.stats-container');
                    if (statsContainer) {
                        observer.observe(statsContainer);
                    }
                });
                </script>

                <style>
                /* Optional: Add transition effect */
                .stats-value {
                    transition: all 0.3s ease;
                }
                </style>
            </div>

            <!-- Right graphic with rotating flags -->
            <div class="col-lg-6 col-md-12">
                <div class="orbit-wrapper">
                    <!-- Animated Grid Background -->
                    <div class="grid-background"></div>

                    <!-- STATIC Orbit circles -->
                    <div class="orbit-circle outer-circle"></div>
                    <div class="orbit-circle middle-circle"></div>
                    <div class="orbit-circle inner-circle"></div>

                    <!-- Center person (Full image - Fixed) -->
                    <div class="center-person">
                        <img src="assets/imgs/picture3.jpg" alt="Student">
                    </div>

                    <!-- Top-left card (Fixed) -->
                    <div class="alumni-card">
                        <img src="assets/imgs/picture6.jpg" alt="Alumni" class="card-avatar">
                        <p class="card-text">Clarke is an alumni from Oxford University</p>
                    </div>

                    <!-- Bottom card (Fixed) -->
                    <div class="bottom-card">
                        <p class="card-text-bottom">Arnav looking forward to join Oxford University</p>
                    </div>

                    <!-- India flag - FIXED (NO ROTATION) -->
                    <div class="flag-item india-flag">
                        <img src="assets/imgs/flags/india.png" alt="India">
                    </div>

                    <!-- ROTATING FLAGS -->

                    <!-- Outer orbit - germany & USA (ROTATING clockwise) -->
                    <div class="orbit-path outer-orbit">
                        <div class="orbit-flag germany-pos">
                            <div class="flag-item counter-rotate">
                                <img src="assets/imgs/flags/germany.png" alt="germany">
                            </div>
                        </div>
                        <div class="orbit-flag usa-pos">
                            <div class="flag-item counter-rotate">
                                <img src="assets/imgs/flags/usa.png" alt="USA">
                            </div>
                        </div>
                    </div>

                    <!-- Middle orbit - UK & ireland (ROTATING counter-clockwise) -->
                    <div class="orbit-path middle-orbit">
                        <div class="orbit-flag uk-pos">
                            <div class="flag-item counter-rotate-reverse">
                                <img src="assets/imgs/flags/uk.png" alt="UK">
                            </div>
                        </div>
                        <div class="orbit-flag ireland-pos">
                            <div class="flag-item counter-rotate-reverse">
                                <img src="assets/imgs/flags/ireland.png" alt="ireland">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="masterx-section">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-4">
            <!-- <h2>Merit<span> Minds</span></h2>
            <p>one stop solution for all your study abroad needs</p> -->
             <h2 class="services-main-title" style="font-size:36px; font-weight:700; color:#004aad;">
                Merit<span style="color:#d21c31;">Minds</span>
            </h2>
        </div>
        

        <!-- Hero Image -->
        <div class="masterx-hero-wrapper">
            <img src="assets/imgs/mentorx.webp" 
                 alt="Merit Minds Study Abroad Services" 
                 class="masterx-hero-image"
                 loading="eager">
        </div>

        <!-- Slider Container -->
        <div class="slider-container">
            <div class="slider-track">
                
                <!-- ========== ORIGINAL 5 CARDS ========== -->
                
                <!-- 1. International Money Transfer - Blue -->
                <div class="service-slide-card blue-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <!-- Money Transfer Icon - Darker Blue -->
                            <circle cx="50" cy="50" r="35" fill="#0D47A1" opacity="0.15"/>
                            <path d="M35 45 L50 35 L65 45 M50 35 L50 60" stroke="#0D47A1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="30" y="60" width="40" height="8" rx="2" fill="#0D47A1"/>
                            <circle cx="35" cy="50" r="3" fill="#0D47A1"/>
                            <circle cx="50" cy="40" r="3" fill="#0D47A1"/>
                            <circle cx="65" cy="50" r="3" fill="#0D47A1"/>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>money transfer</h5>
                </div>

                <!-- 2. Credit Card - Red -->
                <div class="service-slide-card red-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <!-- Credit Card Icon - Darker Red -->
                            <rect x="20" y="35" width="60" height="40" rx="4" fill="#B71C1C" opacity="0.15"/>
                            <rect x="20" y="35" width="60" height="40" rx="4" stroke="#B71C1C" stroke-width="3" fill="none"/>
                            <rect x="20" y="42" width="60" height="8" fill="#B71C1C"/>
                            <rect x="26" y="56" width="18" height="12" rx="2" fill="#B71C1C" opacity="0.5"/>
                            <line x1="50" y1="60" x2="70" y2="60" stroke="#B71C1C" stroke-width="2" stroke-linecap="round"/>
                            <line x1="50" y1="66" x2="65" y2="66" stroke="#B71C1C" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h5>credit card</h5>
                </div>
                <!-- 5. International Bank Account - Teal -->
                <div class="service-slide-card teal-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <!-- Bank Icon - Darker Teal -->
                            <circle cx="50" cy="50" r="35" fill="#00838F" opacity="0.12"/>
                            <polygon points="50,25 75,35 75,40 25,40 25,35" fill="#00838F"/>
                            <rect x="30" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="42" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="54" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="66" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="25" y="68" width="50" height="5" fill="#00838F"/>
                            <circle cx="50" cy="31" r="3" fill="#00838F"/>
                            <text x="50" y="33" font-size="5" fill="#FFF" text-anchor="middle" font-weight="bold">$</text>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>bank account</h5>
                </div>
                <!-- 3. International SIM Card - Blue -->
                <div class="service-slide-card blue-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <!-- SIM Card Icon - Darker Blue -->
                            <rect x="30" y="20" width="40" height="60" rx="5" fill="#0D47A1" opacity="0.15"/>
                            <rect x="30" y="20" width="40" height="60" rx="5" stroke="#0D47A1" stroke-width="3" fill="none"/>
                            <circle cx="50" cy="72" r="3" fill="#0D47A1"/>
                            <rect x="35" y="28" width="30" height="35" rx="2" fill="#0D47A1" opacity="0.3"/>
                            <path d="M40 45 L45 45 L45 55 L40 55 M55 45 L60 45 L60 55 L55 55 M45 45 L55 45 M45 50 L55 50 M45 55 L55 55" stroke="#0D47A1" stroke-width="2"/>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>sim card</h5>
                </div>

                <!-- 4. Housing - Teal -->
                <div class="service-slide-card teal-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <!-- House Icon - Darker Teal -->
                            <path d="M25 50 L50 25 L75 50 L75 75 L25 75 Z" fill="#00838F" opacity="0.15"/>
                            <path d="M20 50 L50 20 L80 50" stroke="#00838F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            <rect x="25" y="50" width="50" height="30" fill="#00838F" opacity="0.2"/>
                            <rect x="43" y="60" width="14" height="20" fill="#00838F"/>
                            <rect x="30" y="55" width="10" height="10" fill="#00838F" opacity="0.5"/>
                            <rect x="60" y="55" width="10" height="10" fill="#00838F" opacity="0.5"/>
                            <circle cx="52" cy="70" r="1.5" fill="#FFF"/>
                        </svg>
                    </div>
                    <h5>housing</h5>
                </div>

                

                <!-- ========== DUPLICATE SET FOR SEAMLESS LOOP ========== -->

                <!-- 1. International Money Transfer - Blue (Duplicate) -->
                <div class="service-slide-card blue-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="35" fill="#0D47A1" opacity="0.15"/>
                            <path d="M35 45 L50 35 L65 45 M50 35 L50 60" stroke="#0D47A1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="30" y="60" width="40" height="8" rx="2" fill="#0D47A1"/>
                            <circle cx="35" cy="50" r="3" fill="#0D47A1"/>
                            <circle cx="50" cy="40" r="3" fill="#0D47A1"/>
                            <circle cx="65" cy="50" r="3" fill="#0D47A1"/>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>money transfer</h5>
                </div>

                <!-- 2. Credit Card - Red (Duplicate) -->
                <div class="service-slide-card red-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <rect x="20" y="35" width="60" height="40" rx="4" fill="#B71C1C" opacity="0.15"/>
                            <rect x="20" y="35" width="60" height="40" rx="4" stroke="#B71C1C" stroke-width="3" fill="none"/>
                            <rect x="20" y="42" width="60" height="8" fill="#B71C1C"/>
                            <rect x="26" y="56" width="18" height="12" rx="2" fill="#B71C1C" opacity="0.5"/>
                            <line x1="50" y1="60" x2="70" y2="60" stroke="#B71C1C" stroke-width="2" stroke-linecap="round"/>
                            <line x1="50" y1="66" x2="65" y2="66" stroke="#B71C1C" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h5>credit card</h5>
                </div>

                <!-- 3. International SIM Card - Blue (Duplicate) -->
                <div class="service-slide-card blue-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <rect x="30" y="20" width="40" height="60" rx="5" fill="#0D47A1" opacity="0.15"/>
                            <rect x="30" y="20" width="40" height="60" rx="5" stroke="#0D47A1" stroke-width="3" fill="none"/>
                            <circle cx="50" cy="72" r="3" fill="#0D47A1"/>
                            <rect x="35" y="28" width="30" height="35" rx="2" fill="#0D47A1" opacity="0.3"/>
                            <path d="M40 45 L45 45 L45 55 L40 55 M55 45 L60 45 L60 55 L55 55 M45 45 L55 45 M45 50 L55 50 M45 55 L55 55" stroke="#0D47A1" stroke-width="2"/>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>sim card</h5>
                </div>

                <!-- 4. Housing - Teal (Duplicate) -->
                <div class="service-slide-card teal-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <path d="M25 50 L50 25 L75 50 L75 75 L25 75 Z" fill="#00838F" opacity="0.15"/>
                            <path d="M20 50 L50 20 L80 50" stroke="#00838F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            <rect x="25" y="50" width="50" height="30" fill="#00838F" opacity="0.2"/>
                            <rect x="43" y="60" width="14" height="20" fill="#00838F"/>
                            <rect x="30" y="55" width="10" height="10" fill="#00838F" opacity="0.5"/>
                            <rect x="60" y="55" width="10" height="10" fill="#00838F" opacity="0.5"/>
                            <circle cx="52" cy="70" r="1.5" fill="#FFF"/>
                        </svg>
                    </div>
                    <h5>housing</h5>
                </div>

                <!-- 5. International Bank Account - Teal (Duplicate) -->
                <div class="service-slide-card teal-card">
                    <div class="service-icon-wrapper">
                        <svg class="service-svg-icon" viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="35" fill="#00838F" opacity="0.12"/>
                            <polygon points="50,25 75,35 75,40 25,40 25,35" fill="#00838F"/>
                            <rect x="30" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="42" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="54" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="66" y="40" width="8" height="28" fill="#00838F" opacity="0.7"/>
                            <rect x="25" y="68" width="50" height="5" fill="#00838F"/>
                            <circle cx="50" cy="31" r="3" fill="#00838F"/>
                            <text x="50" y="33" font-size="5" fill="#FFF" text-anchor="middle" font-weight="bold">$</text>
                        </svg>
                    </div>
                    <h5>international</h5>
                    <h5>bank account</h5>
                </div>

            </div>
        </div>
    </div>
</section>



<!-- Hear From Our Students Section -->
<section class="video-testimonials-section py-5">
    <div class="container">
        <!-- <h2 class="section-title text-center mb-2" style="font-size:32px; font-weight:700; color:#2d3748;">
            Hear from our students
        </h2> -->
        <h2 class="services-main-title" style="font-size:36px; font-weight:700; color:#004aad;">
                Hear from our <span style="color:#d21c31;">students</span>
            </h2>
        
        
        <div class="testimonial-carousel-wrapper position-relative">
            <!-- Left Navigation Arrow -->
            <button class="carousel-nav-btn carousel-nav-left" id="prevBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <!-- Testimonial Cards Container -->
            <div class="testimonial-carousel" id="testimonialCarousel">
                <!-- Card 1: Tanishq Kondru -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture3.jpg" alt="Tanishq Kondru" class="student-photo">
                        
                        <!-- Floating Content Box -->
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#5f5a07; font-weight:700; font-size:13px; margin-bottom:4px;">INCREDIBLY GRATEFUL</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"Incredibly grateful to MERIT MINDS OVERSEAS. Highly recommend for studying abroad."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Tanishq Kondru</h6>
                                    <p class="author-university" style="color:#5f5a07;">University of Minnesota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Salma Sultana -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture6.jpg" alt="Salma Sultana" class="student-photo">
                        
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#004694; font-weight:700; font-size:13px; margin-bottom:4px;">EXCEPTIONAL SUPPORT</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"MERIT MINDS OVERSEAS played a key role in my USA university admission, despite my educational gap."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Salma Sultana</h6>
                                    <p class="author-university" style="color:#004694;">Webster University</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Gopalakrishna Reddy -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture3.jpg" alt="Gopalakrishna Reddy Manukonda" class="student-photo">
                        
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#239bca; font-weight:700; font-size:13px; margin-bottom:4px;">FANTASTIC EXPERIENCE</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"Exceptional support throughout my study journey, from exam preparation to visa process approval."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Gopalakrishna Reddy Manukonda</h6>
                                    <p class="author-university" style="color:#239bca;">University of Florida</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Lakshma Reddy -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture3.jpg" alt="Lakshma Reddy Pothireddy" class="student-photo">
                        
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#dc3545; font-weight:700; font-size:13px; margin-bottom:4px;">RESOURCEFUL, RESPONSIVE</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"This was our first experience with MERIT MINDS OVERSEAS, particularly with Shekar sir, and it was truly impressive."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Lakshma Reddy Pothireddy</h6>
                                    <p class="author-university" style="color:#dc3545;">Cleveland State University</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Ishitha Bussa -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture3.jpg" alt="Ishitha Bussa" class="student-photo">
                        
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#7d6ef3; font-weight:700; font-size:13px; margin-bottom:4px;">EXCELLENT EXPERIENCE</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"I had an excellent experience, Rahul Sir on my side, everything including my VISA process went smoothly."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Ishitha Bussa</h6>
                                    <p class="author-university" style="color:#7d6ef3;">UMass Boston University</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Venkata Saikumar -->
                <div class="video-testimonial-card">
                    <div class="student-photo-wrapper">
                        <img src="assets/imgs/picture3.jpg" alt="Venkata Saikumar Marri" class="student-photo">
                        
                        <div class="testimonial-floating-box">
                            <div class="testimonial-header mb-2">
                                <h6 class="testimonial-title" style="color:#e67e00; font-weight:700; font-size:13px; margin-bottom:4px;">CONSISTENT & INSIGHTFUL</h6>
                                <div class="testimonial-rating" style="color:#ffc107; font-size:14px;">★★★★★</div>
                            </div>
                            <p class="testimonial-quote">"I am delighted to share that I have received my visa approval. All credit goes to the team at MERIT MINDS OVERSEAS."</p>
                            <div class="testimonial-author-info">
                                <div>
                                    <h6 class="author-name">Venkata Saikumar Marri</h6>
                                    <p class="author-university" style="color:#e67e00;">Wright State University</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Navigation Arrow -->
            <button class="carousel-nav-btn carousel-nav-right" id="nextBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Ensuring You Get The Best In Section -->
<section class="services-grid-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <p class="services-pretitle" style="font-size:18px; color:#4a5568; margin-bottom:8px;">Ensuring you get the</p>
            <h2 class="services-main-title" style="font-size:36px; font-weight:700; color:#004aad;">
                best in <span style="color:#d21c31;">education</span>
            </h2>
        </div>

        <div class="row g-4">
            <!-- Card 1: Shortlist Universities -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card blue-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Shortlist Universities</h5>
                        <p class="service-pastel-description">Find your dream university with our advanced Course Finder</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Find my dream university
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="20" y="30" width="80" height="60" rx="8" fill="#004aad" opacity="0.15"/>
                            <rect x="30" y="40" width="60" height="50" rx="6" fill="#004aad" opacity="0.25"/>
                            <rect x="40" y="50" width="40" height="40" rx="4" fill="#004aad" opacity="0.4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 2: Prepare for IELTS -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card teal-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Prepare for IELTS</h5>
                        <p class="service-pastel-description">Take the personalized assistance of our in-house IELTS experts</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Know more
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="60" cy="35" r="20" fill="#22b7cb" opacity="0.3"/>
                            <rect x="40" y="60" width="40" height="50" rx="8" fill="#22b7cb" opacity="0.5"/>
                            <text x="60" y="82" font-size="22" font-weight="bold" fill="#22b7cb" text-anchor="middle">ABC</text>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Get Education Loan -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card red-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Get Education Loan</h5>
                        <p class="service-pastel-description">Finance your study abroad dreams with AK Finance</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Talk to loan expert
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="30" y="40" width="60" height="40" rx="6" fill="#d21c31" opacity="0.25"/>
                            <circle cx="50" cy="60" r="8" fill="#d21c31" opacity="0.5"/>
                            <circle cx="70" cy="60" r="8" fill="#d21c31" opacity="0.5"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 4: Apply for Scholarship -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card blue-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Apply for Scholarship</h5>
                        <p class="service-pastel-description">Find the best scholarships available for your profile</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Find scholarship
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="35" y="50" width="50" height="10" rx="5" fill="#004aad" opacity="0.2"/>
                            <rect x="30" y="65" width="60" height="8" rx="4" fill="#004aad" opacity="0.3"/>
                            <rect x="25" y="78" width="70" height="6" rx="3" fill="#004aad" opacity="0.4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 5: Apply for Visa -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card teal-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Apply for Visa</h5>
                        <p class="service-pastel-description">Get world class visa assistance from our experts</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Apply for visa
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="30" y="35" width="60" height="50" rx="8" fill="#22b7cb" opacity="0.25"/>
                            <circle cx="60" cy="60" r="15" fill="#22b7cb" opacity="0.5"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 6: Student Accommodation -->
            <div class="col-lg-6 col-md-6">
                <div class="service-pastel-card red-card">
                    <div class="service-content-wrapper">
                        <h5 class="service-pastel-title">Student Accommodation</h5>
                        <p class="service-pastel-description">Book your accommodation near top universities across the globe</p>
                        <a href="#" class="service-pastel-btn service-trigger-modal">
                            Find accommodation
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="service-illustration">
                        <svg width="180" height="180" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="40" y="50" width="25" height="40" rx="4" fill="#d21c31" opacity="0.3"/>
                            <rect x="55" y="40" width="25" height="50" rx="4" fill="#d21c31" opacity="0.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- University Finder Section -->
<!-- <section class="university-finder-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="finder-image-wrapper">
                    <img src="assets/imgs/rooma.jpg" alt="University Finder" class="img-fluid rounded-3 shadow">
                </div>
            </div>
            <div class="col-lg-6">
                <h6 class="section-title mb-3">University Finder</h6>
                <h3 class="mb-4" style="font-size:28px;font-weight:700;color:#1a1a1a;">Know the Chance of Admit at Your Dream University</h3>
                <p class="mb-4" style="color:#666;line-height:1.8;">Use our advanced University Finder tool to discover universities that match your profile. Get instant admission chances based on your academic performance, test scores, and preferences.</p>

                <div class="finder-features mb-4">
                    <div class="finder-feature-item">
                        <i class="ti-check" style="color:#fc0511;margin-right:10px;"></i>
                        <span>1000+ universities across 51 countries</span>
                    </div>
                    <div class="finder-feature-item">
                        <i class="ti-check" style="color:#fc0511;margin-right:10px;"></i>
                        <span>Personalized university recommendations</span>
                    </div>
                    <div class="finder-feature-item">
                        <i class="ti-check" style="color:#fc0511;margin-right:10px;"></i>
                        <span>Real-time admission probability calculator</span>
                    </div>
                </div>

                <button type="button" class="btn modal-trigger-btn" style="background:linear-gradient(135deg,#fc0511,#a30008);color:#fff;font-weight:600;padding:14px 32px;border-radius:10px;border:none;">
                    Find Your University →
                </button>
            </div>
        </div>
    </div>
</section> -->

<!-- Mentor Connect Section -->
<!-- <section class="mentor-connect-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="mentor-image-wrapper">
                    <img src="assets/imgs/room1.jpg" alt="Mentor Connect" class="img-fluid rounded-3 shadow">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <h6 class="section-title mb-3">Mentor Connect</h6>
                <h3 class="mb-4" style="font-size:28px;font-weight:700;color:#1a1a1a;">Get Real Guidance from Real Students</h3>
                <p class="mb-4" style="color:#666;line-height:1.8;">Connect with students and alumni who are already studying at your dream university. Get insider insights about campus life, courses, and the admission process directly from those who've been there.</p>

                <div class="mentor-stats mb-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="mentor-stat-box">
                                <h4 style="color:#fc0511;font-weight:700;margin-bottom:5px;">500+</h4>
                                <p style="color:#666;margin:0;font-size:14px;">Student Mentors</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mentor-stat-box">
                                <h4 style="color:#fc0511;font-weight:700;margin-bottom:5px;">1000+</h4>
                                <p style="color:#666;margin:0;font-size:14px;">Universities Covered</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn modal-trigger-btn" style="background:linear-gradient(135deg,#fc0511,#a30008);color:#fff;font-weight:600;padding:14px 32px;border-radius:10px;border:none;">
                    Connect with Mentors →
                </button>
            </div>
        </div>
    </div>
</section> -->
<!-- Blogs Section - MeritMinds Theme -->
<section class="blogs-section" style="padding: 80px 0; background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);">
    <div class="container">
        <!-- Section Header -->
        <div class="blogs-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px;">
            <h2 style="font-size: 48px; font-weight: 700; color: #004aad; margin: 0;">Blogs</h2>
            <a href="blogs.php" class="view-all-btn" style="color: #004aad; font-size: 16px; text-decoration: none; font-weight: 600; padding: 10px 25px; border: 2px solid #004aad; border-radius: 25px; transition: all 0.3s;">
                view all
            </a>
        </div>

        <!-- Blog Cards Grid -->
        <div class="row">
            <!-- Blog Card 1 - Light Blue Background -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="blog-card" style="background: linear-gradient(135deg, #e3f2fd 0%, #f0f9ff 100%); border-radius: 24px; padding: 40px; height: 100%; position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                    <!-- Read Time Badge -->
                    <span class="read-time" style="display: inline-block; background: white; color: #004aad; font-size: 14px; font-weight: 600; padding: 8px 20px; border-radius: 20px; margin-bottom: 25px;">22 min read</span>

                    <!-- Blog Title & Subtitle -->
                    <h3 style="font-size: 28px; font-weight: 700; color: #004aad; margin-bottom: 8px; line-height: 1.3;">Best SOP for Master (MS)</h3>
                    <p style="font-size: 16px; color: #22b7cb; font-weight: 500; margin-bottom: 20px;">in Data Science</p>

                    <!-- Illustration -->
                    <div class="blog-illustration" style="text-align: right; margin-top: 30px;">
                        <img src="assets/imgs/blog-data-science.png" alt="Data Science" style="max-width: 250px; height: auto;">
                    </div>

                    <!-- Arrow Icon -->
                    <div class="blog-arrow" style="position: absolute; bottom: 30px; right: 30px; width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);">
                        <i class="fas fa-arrow-right" style="color: #004aad;"></i>
                    </div>
                </div>
            </div>

            <!-- Blog Card 2 - Light Peach Background -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="blog-card" style="background: linear-gradient(135deg, #fff3e0 0%, #ffebcc 100%); border-radius: 24px; padding: 40px; height: 100%; position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                    <!-- Read Time Badge -->
                    <span class="read-time" style="display: inline-block; background: white; color: #004aad; font-size: 14px; font-weight: 600; padding: 8px 20px; border-radius: 20px; margin-bottom: 25px;">9 min read</span>

                    <!-- Blog Title -->
                    <h3 style="font-size: 28px; font-weight: 700; color: #004aad; margin-bottom: 8px; line-height: 1.3;">PTE score required for</h3>
                    <p style="font-size: 16px; color: #22b7cb; font-weight: 500; margin-bottom: 20px;">Australia</p>

                    <!-- Illustration -->
                    <div class="blog-illustration" style="text-align: right; margin-top: 30px;">
                        <img src="assets/imgs/blog-english.png" alt="PTE Australia" style="max-width: 250px; height: auto;">
                    </div>

                    <!-- Arrow Icon -->
                    <div class="blog-arrow" style="position: absolute; bottom: 30px; right: 30px; width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);">
                        <i class="fas fa-arrow-right" style="color: #004aad;"></i>
                    </div>
                </div>
            </div>

            <!-- Blog Card 3 - Light Mint Background -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="blog-card" style="background: linear-gradient(135deg, #e0f7f4 0%, #b2ebf2 100%); border-radius: 24px; padding: 40px; height: 100%; position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                    <!-- Read Time Badge -->
                    <span class="read-time" style="display: inline-block; background: white; color: #004aad; font-size: 14px; font-weight: 600; padding: 8px 20px; border-radius: 20px; margin-bottom: 25px;">10 min read</span>

                    <!-- Blog Title -->
                    <h3 style="font-size: 28px; font-weight: 700; color: #004aad; margin-bottom: 8px; line-height: 1.3;">Career objective for MBA</h3>
                    <p style="font-size: 16px; color: #22b7cb; font-weight: 500; margin-bottom: 20px;">template</p>

                    <!-- Illustration -->
                    <div class="blog-illustration" style="text-align: right; margin-top: 30px;">
                        <img src="assets/imgs/blog-mba.png" alt="MBA Career" style="max-width: 200px; height: auto;">
                    </div>

                    <!-- Arrow Icon -->
                    <div class="blog-arrow" style="position: absolute; bottom: 30px; right: 30px; width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);">
                        <i class="fas fa-arrow-right" style="color: #004aad;"></i>
                    </div>
                </div>
            </div>

            <!-- Blog Card 4 - Light Lavender Background -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="blog-card" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); border-radius: 24px; padding: 40px; height: 100%; position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                    <!-- Read Time Badge -->
                    <span class="read-time" style="display: inline-block; background: white; color: #004aad; font-size: 14px; font-weight: 600; padding: 8px 20px; border-radius: 20px; margin-bottom: 25px;">16 min read</span>

                    <!-- Blog Title -->
                    <h3 style="font-size: 28px; font-weight: 700; color: #004aad; margin-bottom: 8px; line-height: 1.3;">Best 42 courses in Canada</h3>
                    <p style="font-size: 16px; color: #22b7cb; font-weight: 500; margin-bottom: 20px;">after 12th</p>

                    <!-- Illustration -->
                    <div class="blog-illustration" style="text-align: right; margin-top: 30px;">
                        <img src="assets/imgs/blog-canada.png" alt="Canada Courses" style="max-width: 250px; height: auto;">
                    </div>

                    <!-- Arrow Icon -->
                    <div class="blog-arrow" style="position: absolute; bottom: 30px; right: 30px; width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);">
                        <i class="fas fa-arrow-right" style="color: #004aad;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ Section -->
<div class="faq-section">

    <div class="accordion" id="faqAccordion">
            <h6 class="section-title text-center mb-0 masked-text mb-5">Frequently Asked Questions</h6>

        <div class="accordion-item">
            <h3 class="accordion-header" id="headingOne">
                <button class="accordion-button active" type="button">
                    What visa consulting services do you offer?
                </button>
            </h3>
            <div id="collapseOne" class="accordion-collapse show">
                <div class="accordion-body">
                    We provide end-to-end visa consulting services, including assistance with student visas, work visas, and tourist visas. Our experts guide you through the application process, document preparation, and interview preparation to ensure a smooth experience.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h3 class="accordion-header" id="headingTwo">
                <button class="accordion-button" type="button">
                    Do you offer IELTS preparation assistance?
                </button>
            </h3>
            <div id="collapseTwo" class="accordion-collapse">
                <div class="accordion-body">
                    Yes, we offer comprehensive IELTS preparation services, including study materials, mock tests, and personalized coaching to help you achieve your desired band score.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h3 class="accordion-header" id="headingThree">
                <button class="accordion-button" type="button">
                    How do you help with university selection?
                </button>
            </h3>
            <div id="collapseThree" class="accordion-collapse">
                <div class="accordion-body">
                    We assist you in selecting the best universities based on your academic profile, career goals, and preferences. Our team provides insights into top universities, their programs, and admission requirements.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h3 class="accordion-header" id="headingFour">
                <button class="accordion-button" type="button">
                    Are MeritMinds services free or paid?
                </button>
            </h3>
            <div id="collapseFour" class="accordion-collapse">
                <div class="accordion-body">
                    We offer both free consultations and premium services. Initial profile assessment and basic guidance are complimentary, while specialized services like application assistance and visa support are part of our paid packages.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h3 class="accordion-header" id="headingFive">
                <button class="accordion-button" type="button">
                    Do you provide scholarship assistance?
                </button>
            </h3>
            <div id="collapseFive" class="accordion-collapse">
                <div class="accordion-body">
                    Yes, we help you identify and apply for scholarships that match your profile. Our team guides you through the application process and ensures you submit a strong application.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="sk-ww-google-reviews" data-embed-id="25646060"></div><script src="https://widgets.sociablekit.com/google-reviews/widget.js" defer></script> -->

<!-- REVIEWS & CTA SECTION -->
<section class="reviews-cta-section" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 0;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <!-- Google Review Card -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="review-card">
                    <div class="review-rating">4.9</div>
                    <div class="review-platform">Google<br>Review</div>
                    <div class="review-stars">
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                    </div>
                </div>
            </div>

            <!-- Facebook Review Card -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="review-card">
                    <div class="review-rating">4.7</div>
                    <div class="review-platform">Facebook<br>Review</div>
                    <div class="review-stars">
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-filled">★</i>
                        <i class="star-half">★</i>
                    </div>
                </div>
            </div>

            <!-- CTA Card -->
            <div class="col-lg-4 col-md-12">
                <div class="cta-card">
                    <p class="cta-text">Trusted by over 10<br>lakh students<br>globally</p>
                    <button class="cta-button" onclick="openModal()">
                        Get started
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="margin-left: 8px;">
                            <circle cx="10" cy="10" r="9" fill="white" opacity="0.3"/>
                            <path d="M8 6L12 10L8 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="studyModal" class="modal-overlay" style="display:none">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">&times;</button>
        
        <!-- LEFT SIDE: Animated Loader -->
        <div class="modal-animation-side">
            <div class="side-loader">
                <div class="side-loader-orbit-ring"></div>
                <div class="side-loader-center"></div>
                <div class="side-loader-orbit">
                    <div class="side-loader-dot side-loader-dot-1"></div>
                    <div class="side-loader-dot side-loader-dot-2"></div>
                    <div class="side-loader-dot side-loader-dot-3"></div>
                </div>
            </div>
            
            <div class="side-text">
                <h3>Start Your Journey</h3>
                <p>Fill out the form to get personalized guidance from our expert counselors</p>
            </div>
            
            <div class="side-features">
                <div class="side-feature-item">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#004aad" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>1000+ Universities</span>
                </div>
                <div class="side-feature-item">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#22b7cb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Expert Visa Assistance</span>
                </div>
                <div class="side-feature-item">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#d21c31" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>100% Success Stories</span>
                </div>
            </div>
        </div>
        
        <!-- RIGHT SIDE: Form -->
        <div class="modal-form-side">
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>

            <form id="studyAbroadForm" method="POST">
                <!-- Step 1 -->
                <div class="form-step" data-step="1">
                    <h3 class="form-step-title">Personal Information</h3>
                    <p class="form-step-subtitle">Let's start with your basic details</p>
                    
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="fullname" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" required placeholder="your.email@example.com">
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone" required placeholder="+91 9876543210">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Current City <span class="required">*</span></label>
                        <input type="text" name="city" required placeholder="Enter your city">
                    </div>
                    
                    <button type="button" class="btn-next" onclick="nextStep()">Next Step</button>
                </div>

                <!-- Step 2 -->
                <div class="form-step" data-step="2" style="display:none">
                    <h3 class="form-step-title">Academic Background</h3>
                    <p class="form-step-subtitle">Tell us about your education</p>
                    
                    <div class="form-group">
                        <label>Highest Qualification <span class="required">*</span></label>
                        <select name="qualification" required>
                            <option value="">Select qualification</option>
                            <option value="High School">High School (12th Grade)</option>
                            <option value="Bachelors">Bachelor's Degree</option>
                            <option value="Masters">Master's Degree</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Field of Study <span class="required">*</span></label>
                            <input type="text" name="fieldofstudy" required placeholder="e.g., Computer Science">
                        </div>
                        <div class="form-group">
                            <label>CGPA/Percentage <span class="required">*</span></label>
                            <input type="text" name="cgpa" required placeholder="e.g., 8.5 CGPA or 85%">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>English Test Score (if any)</label>
                        <input type="text" name="englishscore" placeholder="e.g., IELTS 7.5, TOEFL 100">
                    </div>
                    
                    <div class="form-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn-next" onclick="nextStep()">Next Step</button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" data-step="3" style="display:none">
                    <h3 class="form-step-title">Study Preferences</h3>
                    <p class="form-step-subtitle">What are you looking for?</p>
                    
                    <div class="form-group">
                        <label>Preferred Country <span class="required">*</span></label>
                        <select name="preferredcountry" required>
                            <option value="">Select country</option>
                            <option value="USA">USA</option>
                            <option value="UK">UK</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ireland">Ireland</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Preferred Course/Program <span class="required">*</span></label>
                        <input type="text" name="preferredcourse" required placeholder="e.g., MS in Data Science">
                    </div>
                    
                    <div class="form-group">
                        <label>Intake Year <span class="required">*</span></label>
                        <select name="intakeyear" required>
                            <option value="">Select intake year</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Any specific requirements or questions?</label>
                        <textarea name="message" rows="4" placeholder="Share any specific questions or requirements..."></textarea>
                    </div>
                    
                    <input type="hidden" name="_captcha" value="false">
                    <input type="hidden" name="_subject" value="New Study Abroad Application">
                    <input type="hidden" name="_template" value="table">
                    
                    <div class="form-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn-submit">Submit Application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Initialize AOS -->
<script>
    AOS.init({
        duration: 1000,
        once: false,
        offset: 100
    });
</script>

<!-- FAQ Accordion Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionButtons = document.querySelectorAll('.accordion-button');

        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                const collapse = this.parentElement.nextElementSibling;
                collapse.classList.toggle('show');

                if (collapse.classList.contains('show')) {
                    accordionButtons.forEach(otherButton => {
                        if (otherButton !== button) {
                            otherButton.classList.remove('active');
                            otherButton.parentElement.nextElementSibling.classList.remove('show');
                        }
                    });
                }
            });
        });
    });
</script>

<!-- Study Abroad Modal -->
<div id="studyModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">&times;</button>
        
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <form id="studyAbroadForm" method="POST">
            <!-- Step 1: Personal Information -->
            <div class="form-step" data-step="1">
                <h3 class="form-step-title">Personal Information</h3>
                <p class="form-step-subtitle">Let's start with your basic details</p>

                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" required placeholder="Enter your full name">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="your.email@example.com">
                    </div>
                    <div class="form-group">
                        <label>Phone Number <span class="required">*</span></label>
                        <input type="tel" name="phone" required placeholder="+91 9876543210">
                    </div>
                </div>

                <div class="form-group">
                    <label>Current City <span class="required">*</span></label>
                    <input type="text" name="city" required placeholder="Enter your city">
                </div>

                <button type="button" class="btn-next" onclick="nextStep()">Next Step →</button>
            </div>

            <!-- Step 2: Academic Background -->
            <div class="form-step" data-step="2" style="display:none;">
                <h3 class="form-step-title">Academic Background</h3>
                <p class="form-step-subtitle">Tell us about your education</p>

                <div class="form-group">
                    <label>Highest Qualification <span class="required">*</span></label>
                    <select name="qualification" required>
                        <option value="">Select qualification</option>
                        <option value="High School">High School (12th Grade)</option>
                        <option value="Bachelors">Bachelor's Degree</option>
                        <option value="Masters">Master's Degree</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Field of Study <span class="required">*</span></label>
                        <input type="text" name="field_of_study" required placeholder="e.g., Computer Science">
                    </div>
                    <div class="form-group">
                        <label>CGPA/Percentage <span class="required">*</span></label>
                        <input type="text" name="cgpa" required placeholder="e.g., 8.5 CGPA or 85%">
                    </div>
                </div>

                <div class="form-group">
                    <label>English Test Score (if any)</label>
                    <input type="text" name="english_score" placeholder="e.g., IELTS 7.5, TOEFL 100">
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn-prev" onclick="prevStep()">← Previous</button>
                    <button type="button" class="btn-next" onclick="nextStep()">Next Step →</button>
                </div>
            </div>

            <!-- Step 3: Study Preferences -->
            <div class="form-step" data-step="3" style="display:none;">
                <h3 class="form-step-title">Study Preferences</h3>
                <p class="form-step-subtitle">What are you looking for?</p>

                <div class="form-group">
                    <label>Preferred Country <span class="required">*</span></label>
                    <select name="preferred_country" required>
                        <option value="">Select country</option>
                        <option value="USA">USA</option>
                        <option value="UK">UK</option>
                        <option value="Canada">Canada</option>
                        <option value="Australia">Australia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ireland">Ireland</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Preferred Course/Program <span class="required">*</span></label>
                    <input type="text" name="preferred_course" required placeholder="e.g., MS in Data Science">
                </div>

                <div class="form-group">
                    <label>Intake Year <span class="required">*</span></label>
                    <select name="intake_year" required>
                        <option value="">Select intake year</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Any specific requirements or questions?</label>
                    <textarea name="message" rows="4" placeholder="Share any specific questions or requirements..."></textarea>
                </div>

                <!-- Hidden fields for FormSubmit.co -->
                <input type="hidden" name="_captcha" value="false">
                <input type="hidden" name="_subject" value="New Study Abroad Application">
                <input type="hidden" name="_template" value="table">

                <div class="form-buttons">
                    <button type="button" class="btn-prev" onclick="prevStep()">← Previous</button>
                    <button type="submit" class="btn-submit">Submit Application</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }

    .modal-content {
        background: #fff;
        border-radius: 20px;
        max-width: 1100px;
        width: 100%;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 0;
        margin: auto;
        max-height: 90vh;
        overflow: hidden;
        display: grid;
        grid-template-columns: 350px 1fr;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        font-size: 28px;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .modal-close:hover {
        color: #fc0511;
        background: #fff;
        transform: rotate(90deg);
    }

    /* LEFT SIDE: Animation */
    .modal-animation-side {
        background: linear-gradient(135deg, #e8f4ff 0%, #d4e9ff 100%);
        padding: 40px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 20px 0 0 20px;
    }

    /* RIGHT SIDE: Form */
    .modal-form-side {
        padding: 40px 35px;
        overflow-y: auto;
        max-height: 90vh;
    }

    /* Animated Loader */
    .side-loader {
        position: relative;
        width: 180px;
        height: 180px;
        margin-bottom: 35px;
    }

    .side-loader-center {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 45px;
        height: 45px;
        background: #004aad;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulse-center 1.5s ease-in-out infinite;
        box-shadow: 0 0 35px rgba(0, 74, 173, 0.5);
    }

    .side-loader-orbit-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 140px;
        height: 140px;
        border: 3px solid rgba(0, 74, 173, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    .side-loader-orbit {
        position: absolute;
        width: 100%;
        height: 100%;
        animation: rotate-orbit 2.5s linear infinite;
    }

    .side-loader-dot {
        position: absolute;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .side-loader-dot-1 {
        background: #004aad;
    }

    .side-loader-dot-2 {
        background: #22b7cb;
        transform: translateX(-50%) rotate(120deg) translate(0, -70px) rotate(-120deg);
    }

    .side-loader-dot-3 {
        background: #d21c31;
        transform: translateX(-50%) rotate(240deg) translate(0, -70px) rotate(-240deg);
    }

    @keyframes rotate-orbit {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulse-center {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1);
            box-shadow: 0 0 35px rgba(0, 74, 173, 0.5);
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.15);
            box-shadow: 0 0 45px rgba(0, 74, 173, 0.7);
        }
    }

    /* Side Content Text */
    .side-text {
        text-align: center;
        padding: 0 15px;
    }

    .side-text h3 {
        font-size: 22px;
        font-weight: 700;
        color: #004aad;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .side-text p {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }

    /* Side Features */
    .side-features {
        margin-top: 35px;
        width: 100%;
    }

    .side-feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .side-feature-item svg {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
    }

    /* Progress Bar */
    .progress-container {
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #fc0511, #a30008);
        width: 33.33%;
        transition: width 0.4s ease;
        border-radius: 10px;
    }

    /* Form Steps */
    .form-step {
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-step-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .form-step-subtitle {
        color: #666;
        font-size: 15px;
        margin-bottom: 30px;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .required {
        color: #fc0511;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s;
        font-family: inherit;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #fc0511;
        box-shadow: 0 0 0 3px rgba(252, 5, 17, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    /* Buttons */
    .btn-next,
    .btn-prev,
    .btn-submit {
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-next,
    .btn-submit {
        background: linear-gradient(135deg, #fc0511, #a30008);
        color: #fff;
    }

    .btn-next:hover,
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(252, 5, 17, 0.3);
    }

    .btn-prev {
        background: #f8f9fa;
        color: #333;
    }

    .btn-prev:hover {
        background: #e9ecef;
    }

    .form-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    /* Validation States */
    .form-group input.valid,
    .form-group select.valid,
    .form-group textarea.valid {
        border-color: #28a745 !important;
    }

    .form-group input.invalid,
    .form-group select.invalid,
    .form-group textarea.invalid {
        border-color: #ff4444 !important;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Custom Scrollbar */
    .modal-form-side::-webkit-scrollbar {
        width: 6px;
    }

    .modal-form-side::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-form-side::-webkit-scrollbar-thumb {
        background: #fc0511;
        border-radius: 10px;
    }

    .modal-form-side::-webkit-scrollbar-thumb:hover {
        background: #a30008;
    }

    /* ============================================
       RESPONSIVE DESIGN - MOBILE FIXES
    ============================================ */

    /* Tablet View */
    @media (max-width: 968px) {
        .modal-content {
            grid-template-columns: 1fr;
            max-width: 600px;
            max-height: 85vh;
        }

        .modal-animation-side {
            border-radius: 20px 20px 0 0;
            padding: 25px 20px;
        }

        .modal-form-side {
            padding: 30px 25px;
        }

        .side-loader {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
        }

        .side-loader-center {
            width: 35px;
            height: 35px;
        }

        .side-loader-orbit-ring {
            width: 100px;
            height: 100px;
        }

        .side-loader-dot {
            width: 16px;
            height: 16px;
            top: 10px;
        }

        .side-loader-dot-2 {
            transform: translateX(-50%) rotate(120deg) translate(0, -50px) rotate(-120deg);
        }

        .side-loader-dot-3 {
            transform: translateX(-50%) rotate(240deg) translate(0, -50px) rotate(-240deg);
        }

        .side-text h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .side-text p {
            font-size: 13px;
        }

        .side-features {
            margin-top: 20px;
        }

        .side-feature-item {
            font-size: 12px;
            margin-bottom: 12px;
        }

        .side-feature-item svg {
            width: 18px;
            height: 18px;
        }
    }

    /* Mobile View - Critical Fixes */
    @media (max-width: 768px) {
        .modal-overlay {
            padding: 10px;
            align-items: flex-start;
        }

        .modal-content {
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 15px;
            max-height: 95vh;
            width: 100%;
        }

        .modal-close {
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            font-size: 24px;
        }

        .modal-animation-side {
            padding: 20px 15px;
            border-radius: 15px 15px 0 0;
        }

        .modal-form-side {
            padding: 25px 20px;
            max-height: 60vh;
        }

        .form-step-title {
            font-size: 20px;
        }

        .form-step-subtitle {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 11px 14px;
            font-size: 14px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .form-buttons {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .btn-next,
        .btn-prev,
        .btn-submit {
            padding: 13px 25px;
            font-size: 14px;
        }

        .progress-container {
            margin-bottom: 20px;
        }
    }

    /* Extra Small Mobile Devices */
    @media (max-width: 480px) {
        .modal-overlay {
            padding: 5px;
        }

        .modal-content {
            border-radius: 12px;
            margin-top: 5px;
        }

        .modal-animation-side {
            padding: 18px 12px;
        }

        .side-loader {
            width: 100px;
            height: 100px;
            margin-bottom: 15px;
        }

        .side-loader-center {
            width: 30px;
            height: 30px;
        }

        .side-loader-orbit-ring {
            width: 85px;
            height: 85px;
            border-width: 2px;
        }

        .side-loader-dot {
            width: 14px;
            height: 14px;
            top: 8px;
        }

        .side-loader-dot-2 {
            transform: translateX(-50%) rotate(120deg) translate(0, -42px) rotate(-120deg);
        }

        .side-loader-dot-3 {
            transform: translateX(-50%) rotate(240deg) translate(0, -42px) rotate(-240deg);
        }

        .side-text h3 {
            font-size: 16px;
        }

        .side-text p {
            font-size: 12px;
        }

        .side-feature-item {
            font-size: 11px;
            gap: 8px;
        }

        .modal-form-side {
            padding: 20px 15px;
        }

        .form-step-title {
            font-size: 18px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 12px;
            font-size: 13px;
        }

        .btn-next,
        .btn-prev,
        .btn-submit {
            padding: 12px 20px;
            font-size: 13px;
        }
    }

    /* Landscape Mobile Fix */
    @media (max-width: 768px) and (orientation: landscape) {
        .modal-overlay {
            align-items: flex-start;
        }

        .modal-content {
            max-height: 98vh;
        }

        .modal-animation-side {
            padding: 15px;
        }

        .side-loader {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .side-text {
            display: none;
        }

        .side-features {
            margin-top: 10px;
        }

        .modal-form-side {
            max-height: 70vh;
        }
    }
</style>


<script>
    let currentStep = 1;
    const totalSteps = 3;

    function openModal() {
        document.getElementById('studyModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('studyModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function nextStep() {
        if (validateCurrentStep()) {
            document.querySelector(`[data-step="${currentStep}"]`).style.display = 'none';
            currentStep++;
            if (currentStep <= totalSteps) {
                document.querySelector(`[data-step="${currentStep}"]`).style.display = 'block';
            }
            updateProgressBar();
        }
    }

    function prevStep() {
        document.querySelector(`[data-step="${currentStep}"]`).style.display = 'none';
        currentStep--;
        document.querySelector(`[data-step="${currentStep}"]`).style.display = 'block';
        updateProgressBar();
    }

    function validateCurrentStep() {
        const currentStepElement = document.querySelector(`[data-step="${currentStep}"]`);
        const requiredInputs = currentStepElement.querySelectorAll('[required]');
        
        let isValid = true;
        let firstInvalidField = null;
        
        requiredInputs.forEach(input => {
            // Reset border color
            input.style.borderColor = '#e9ecef';
            
            // Check if field is empty or invalid
            const value = input.value.trim();
            
            if (!value) {
                isValid = false;
                input.style.borderColor = '#ff4444';
                if (!firstInvalidField) {
                    firstInvalidField = input;
                }
            } else if (input.type === 'email' && !isValidEmail(value)) {
                isValid = false;
                input.style.borderColor = '#ff4444';
                if (!firstInvalidField) {
                    firstInvalidField = input;
                }
            } else if (input.type === 'tel' && value.length < 10) {
                isValid = false;
                input.style.borderColor = '#ff4444';
                if (!firstInvalidField) {
                    firstInvalidField = input;
                }
            }
        });
        
        if (!isValid) {
            alert('Please fill all required fields correctly before continuing');
            if (firstInvalidField) {
                firstInvalidField.focus();
                // Reset border after 3 seconds
                setTimeout(() => {
                    requiredInputs.forEach(input => {
                        input.style.borderColor = '#e9ecef';
                    });
                }, 3000);
            }
            return false;
        }
        
        return true;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function updateProgressBar() {
        const progress = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Testimonial carousel navigation
        const carousel = document.getElementById('testimonialCarousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (carousel && prevBtn && nextBtn) {
            const scrollAmount = 320;
            
            prevBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });
            
            nextBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }

        // Modal triggers
        const allModalTriggers = document.querySelectorAll('.modal-trigger-btn, .service-trigger-modal, .service-pastel-btn');
        
        console.log('Found ' + allModalTriggers.length + ' modal triggers');
        
        allModalTriggers.forEach((button, index) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Opening modal from trigger ' + index);
                openModal();
            });
        });

        // Close modal when clicking outside
        const modalOverlay = document.getElementById('studyModal');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        }

        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Add real-time validation feedback
        const allInputs = document.querySelectorAll('#studyAbroadForm input, #studyAbroadForm select, #studyAbroadForm textarea');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.hasAttribute('required')) {
                    if (this.value.trim()) {
                        this.style.borderColor = '#28a745';
                    } else {
                        this.style.borderColor = '#e9ecef';
                    }
                }
            });
            
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.style.borderColor = '#ff4444';
                } else if (this.value.trim()) {
                    this.style.borderColor = '#28a745';
                }
            });
            
            input.addEventListener('focus', function() {
                if (this.style.borderColor === 'rgb(255, 68, 68)') {
                    this.style.borderColor = '#fc0511';
                }
            });
        });

        // Form submission
        const form = document.getElementById('studyAbroadForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                console.log('Form submit triggered');
                
                if (!validateCurrentStep()) {
                    console.log('Validation failed');
                    return;
                }

                console.log('Validation passed, submitting...');

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<span style="display:inline-flex;align-items:center;gap:8px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="animation: rotate-orbit 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="15" stroke-linecap="round"/></svg> Submitting...</span>';
                submitBtn.disabled = true;

                fetch('https://formsubmit.co/ajax/meritminds.info@gmail.com', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Form submitted successfully:', data);
                    
                    // Show success message
                    document.querySelector('.modal-content').innerHTML = `
                        <div style="text-align:center; padding:60px 40px; grid-column: 1 / -1;">
                            <div style="width:90px; height:90px; background:linear-gradient(135deg,#28a745,#20c997); border-radius:50%; margin:0 auto 25px; display:flex; align-items:center; justify-content:center; animation: scaleIn 0.5s ease;">
                                <svg width="45" height="45" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 6L9 17L4 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2 style="color:#28a745; margin-bottom:15px; font-size:32px; font-weight:700;">Thank You!</h2>
                            <p style="color:#666; font-size:17px; line-height:1.6; margin-bottom:10px; max-width:500px; margin-left:auto; margin-right:auto;">
                                Your application has been received successfully.
                            </p>
                            <p style="color:#999; font-size:15px; margin-bottom:35px;">
                                Our counselor will contact you within 24 hours via WhatsApp/Email.
                            </p>
                            <button onclick="location.reload()" style="background:linear-gradient(135deg,#fc0511,#a30008); color:#fff; border:none; padding:16px 40px; border-radius:10px; font-weight:700; font-size:16px; cursor:pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(252,5,17,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                Close & Return
                            </button>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Submission error:', error);
                    
                    // Show error message
                    alert('⚠️ Submission failed. Please try again or contact us directly.');
                    
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }
    });
</script>



<?php include 'footer.php'?>
