<?php include 'header.php'; ?>

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
    /* ============================================
       VALUE PROPOSITIONS - Three Cards
    ============================================ */
    .value-props-section {
        padding: 80px 0;
        background: white;
    }

    .value-prop-item {
        margin-bottom: 50px;
    }

    .prop-header {
        display: flex;
        align-items: flex-start;
        gap: 25px;
    }

    .prop-icon-label {
        min-width: 140px;
        text-align: right;
    }

    .prop-icon-text {
        font-size: 0.9rem;
        font-weight: 700;
        color: #fc0511;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.4;
    }

    .prop-content {
        flex: 1;
    }

    .prop-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }

    .prop-description {
        font-size: 1rem;
        color: #666;
        line-height: 1.7;
    }

    /* ============================================
       CORE VALUES - Pills
    ============================================ */
    .core-values-section {
        padding: 60px 0;
        background: #f8f9fa;
        text-align: center;
    }

    .values-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        max-width: 900px;
        margin: 0 auto;
    }

    .value-badge {
        background: white;
        border: 2px solid #fc0511;
        border-radius: 50px;
        padding: 12px 30px;
        font-size: 1rem;
        font-weight: 700;
        color: #fc0511;
        transition: all 0.3s ease;
    }

    .value-badge:hover {
        background: #fc0511;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(252, 5, 17, 0.3);
    }

    .values-description {
        text-align: center;
        color: #666;
        margin-top: 30px;
        font-size: 0.95rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    /* ============================================
       LEADERSHIP SECTION - Two Columns
    ============================================ */
    .leadership-section {
        padding: 80px 0;
        background: white;
    }

    .section-title-center {
        font-size: 2.5rem;
        font-weight: 800;
        color: #333;
        text-align: center;
        margin-bottom: 60px;
    }

    .leader-card {
        margin-bottom: 40px;
    }

    .leader-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fc0511, #a30008);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        font-weight: 700;
        margin: 0 auto 25px;
        box-shadow: 0 5px 20px rgba(252, 5, 17, 0.3);
    }

    .leader-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        text-align: center;
        margin-bottom: 8px;
    }

    .leader-title {
        font-size: 1rem;
        color: #fc0511;
        font-weight: 600;
        text-align: center;
        margin-bottom: 20px;
    }

    .leader-bio {
        font-size: 1rem;
        color: #666;
        line-height: 1.8;
        text-align: justify;
    }

    /* ============================================
       STATISTICS - Four Cards
    ============================================ */
    .stats-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .stat-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(252, 5, 17, 0.15);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        background: linear-gradient(135deg, #fc0511, #a30008);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ============================================
       TESTIMONIALS SECTION
    ============================================ */
    .testimonials-section {
        padding: 80px 0;
        background: white;
    }

    .testimonial-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        border-left: 4px solid #fc0511;
        transition: all 0.3s ease;
    }

    .testimonial-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(252, 5, 17, 0.1);
    }

    .testimonial-text {
        font-size: 1rem;
        color: #666;
        line-height: 1.8;
        margin-bottom: 20px;
        font-style: italic;
    }

    .testimonial-author {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
    }

    .testimonial-university {
        color: #fc0511;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* ============================================
       VIDEO SECTION
    ============================================ */
    .video-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .video-container {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        background: #000;
        margin-bottom: 20px;
    }

    .video-container:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 35px rgba(252, 5, 17, 0.2);
    }

    .video-container video {
        width: 100%;
        display: block;
    }

    .video-info {
        text-align: center;
        margin-top: 15px;
    }

    .video-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .video-course {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .hero-headline {
            font-size: 2rem;
        }

        .prop-header {
            flex-direction: column;
        }

        .prop-icon-label {
            text-align: left;
            min-width: auto;
        }

        .leader-bio {
            text-align: left;
        }

        .section-title-center {
            font-size: 2rem;
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
                <h1 class="header-title">ABOUT US</h1>
                <p class="header-subtitle"> Quality International Education is Your Right – We Make It Accessible</p>
            </div>
        </div>
    </div>
</div>


<!-- Value Propositions Section -->
<section class="value-props-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Prop 1: Expert Counselling -->
                <div class="value-prop-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="prop-header">
                        <div class="prop-icon-label">
                            <div class="prop-icon-text">Expert<br>Counselling</div>
                        </div>
                        <div class="prop-content">
                            <h3 class="prop-title">Personalized Guidance & Support</h3>
                            <p class="prop-description">Our certified counsellors provide personalized guidance based on your academic profile, career goals, and budget to help you make informed decisions. With comprehensive coaching for IELTS, TOEFL, GRE, GMAT, and PTE, we ensure you're fully prepared for your journey.</p>
                        </div>
                    </div>
                </div>

                <!-- Prop 2: Streamlined Process -->
                <div class="value-prop-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="prop-header">
                        <div class="prop-icon-label">
                            <div class="prop-icon-text">Streamlined<br>Application<br>Process</div>
                        </div>
                        <div class="prop-content">
                            <h3 class="prop-title">End-to-End Application Support</h3>
                            <p class="prop-description">Our user-friendly platform simplifies the application process, allowing you to manage applications, deadlines, and documents efficiently from anywhere. Complete assistance with university applications, SOP writing, LOR preparation, and document verification ensures your application stands out.</p>
                        </div>
                    </div>
                </div>

                <!-- Prop 3: Convenience & Flexibility -->
                <div class="value-prop-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="prop-header">
                        <div class="prop-icon-label">
                            <div class="prop-icon-text">Convenience<br>and<br>Flexibility</div>
                        </div>
                        <div class="prop-content">
                            <h3 class="prop-title">Complete Support From Home to Abroad</h3>
                            <p class="prop-description">Apply to your dream colleges from the comfort of your home, hostel, or anywhere with an internet connection. We provide complete visa documentation support, mock interviews, embassy guidance, travel arrangements, accommodation assistance, airport pickup, and ongoing support after you reach your destination.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Core Values Pills -->
<section class="core-values-section">
    <div class="container">
        <div class="values-container" data-aos="zoom-in">
            <span class="value-badge">🎯 Integrity</span>
            <span class="value-badge">⭐ Excellence</span>
            <span class="value-badge">💡 Innovation</span>
            <span class="value-badge">❤️ Empathy</span>
            <span class="value-badge">🌍 Diversity</span>
            <span class="value-badge">🤝 Transparency</span>
            <span class="value-badge">📈 Success-Driven</span>
        </div>
        <p class="values-description">
            <strong>Student First:</strong> All decisions to be made while keeping the student at the center. <strong>Transparent:</strong> Build trust with all stakeholders using data, communication and mentorship. <strong>Ambitious:</strong> We always aim to do better for our students, partners and team members.
        </p>
    </div>
</section>

<!-- Leadership Section -->
<section class="leadership-section">
    <div class="container">
        <h2 class="section-title-center" data-aos="fade-up">Our Leadership</h2>
        
        <div class="row justify-content-center">
            <!-- Leader 1 -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="leader-card">
                    <div class="leader-avatar">V</div>
                    <h3 class="leader-name">Vijayanand</h3>
                    <p class="leader-title">Co-Founder & Chief Counsellor</p>
                    <p class="leader-bio">
                        Vijayanand is a highly skilled innovator in the education consulting industry, with extensive experience in guiding students toward their international education goals. With a strong foundation in understanding student aspirations and global university requirements, he has helped thousands of students secure admissions to top universities across USA, UK, Canada, Australia, Ireland, and Germany. At MeritMinds Overseas, Vijayanand uses his exceptional counselling skills and passion for education to simplify the study abroad application process for students around the world. His unwavering moral support, exceptional dedication, and outstanding guidance throughout application processes and VISA preparation have earned him recognition and heartfelt gratitude from students and partners alike. His leadership is pivotal in steering MeritMinds toward its mission of making quality international education accessible to every aspiring student by combining education with technology, creating a transformative impact.
                    </p>
                </div>
            </div>

            <!-- Leader 2 -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="leader-card">
                    <div class="leader-avatar">R</div>
                    <h3 class="leader-name">Rahul</h3>
                    <p class="leader-title">Co-Founder & Operations Head</p>
                    <p class="leader-bio">
                        Rahul stands as a beacon of innovation in the overseas education landscape with MeritMinds Overseas. Blending deep operational expertise with strategic vision, his experience in education consulting and student services has equipped him with the ability to tackle diverse challenges across the study abroad journey, enriching his entrepreneurial approach. At MeritMinds, Rahul harnesses his passion for education and extensive professional knowledge to streamline the application process, ensuring students worldwide have easier access to global learning opportunities through our network of 500+ partner universities. His constant support, highly customer-focused approach, and resourcefulness have made him a trusted and reliable partner for students pursuing their international education dreams. His vision and leadership are instrumental in driving MeritMinds' mission to democratize education, making him a key figure in transforming how students plan their educational journeys with a 98% visa success rate.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-box">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Students Placed</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-box">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Universities</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-box">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Countries</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-box">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Visa Success</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title-center" data-aos="fade-up">Our Students Speak For Us</h2>
        
        <div class="row">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-item">
                    <p class="testimonial-text">"I extend my heartfelt gratitude to Vijayanand Sir for his unwavering moral support, exceptional dedication, and outstanding guidance throughout my application process and VISA preparation."</p>
                    <div class="testimonial-author">Monisha Thota</div>
                    <div class="testimonial-university">New York Institute of Technology</div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-item">
                    <p class="testimonial-text">"Incredibly grateful to MERIT MINDS OVERSEAS for personalized advice and meticulous visa interview preparation. Highly recommend for studying abroad."</p>
                    <div class="testimonial-author">Ramya</div>
                    <div class="testimonial-university">University of Greenwich</div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-item">
                    <p class="testimonial-text">"This was our first experience with MERIT MINDS OVERSEAS, particularly with Shekar sir, and it was truly impressive and pleasant. He was resourceful and highly customer-focused."</p>
                    <div class="testimonial-author">Lakshma Reddy Pothireddy</div>
                    <div class="testimonial-university">Cleveland State University</div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="testimonial-item">
                    <p class="testimonial-text">"I'm grateful to Rahul Sir for his constant support in achieving my dream. MERIT MINDS is a reliable organization in overseas education and they are my trusted partners."</p>
                    <div class="testimonial-author">Naga Madhuri Penmatsa</div>
                    <div class="testimonial-university">University of Strathclyde</div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                <div class="testimonial-item">
                    <p class="testimonial-text">"MERIT MINDS OVERSEAS played a key role in my USA university admission and student visa application process, guiding me through every challenge, despite my educational gap."</p>
                    <div class="testimonial-author">Salma Sultana</div>
                    <div class="testimonial-university">Webster University</div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
                <div class="testimonial-item">
                    <p class="testimonial-text">"Exceptional support throughout my study journey, from exam preparation to visa process approval. Expert guidance made everything seamless."</p>
                    <div class="testimonial-author">Neeharika</div>
                    <div class="testimonial-university">CCT College, Dublin</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Testimonials Section -->
<section class="video-section">
    <div class="container">
        <h2 class="section-title-center" data-aos="fade-up">Hear From Our Students</h2>
        
        <div class="row">
            <div class="col-lg-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="video-container">
                    <video controls poster="assets/imgs/WhatsApp Image 2024-10-19 at 2.25.57 PM.jpeg">
                        <source src="./assets/Video/merit.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="video-info">
                    <div class="video-name">Saivenkat Marri</div>
                    <div class="video-course">MS in Pharmacology & Toxicology<br>Wright State University</div>
                </div>
            </div>

            <div class="col-lg-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="video-container">
                    <video controls poster="assets/imgs/WhatsApp Image 2024-10-19 at 2.25.32 PM.jpeg">
                        <source src="./assets/Video/WhatsApp Video 2024-10-18 at 7.14.43 PM.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="video-info">
                    <div class="video-name">MGK Reddy</div>
                    <div class="video-course">MS in Artificial Intelligence<br>University of Florida</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
<script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>

<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
<script src="./firebaseConfig.js"></script>

</body>
</html>
