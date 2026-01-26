<?php include 'header.php'?>

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
                <h1 class="header-title">Join Us</h1>
                <p class="header-subtitle">Empowering your future with global education, migration, and work opportunities.</p>
            </div>
        </div>
    </div>
</div>

      




<style>
    /* Custom styling */
    .success-message {
        display: none;
        text-align: center;
        color: green;
        margin-top: 20px;
    }

    .submit-button:hover {
        background-color: #e65c00;
    }
</style>
<body>
<!-- Registration Form Container -->
<div class="glass-form-container mt-5">
    <header class="glass-form-header">
        <h1>MERIT MINDS OVERSEAS - Registration</h1>
        <p>Complete the form below to be considered for our Study Abroad Processing Program.</p>
    </header>

    <form id="glass-registration-form">
        <div class="glass-form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="glass-form-group">
            <label for="full-name">Full Name *</label>
            <input type="text" id="full-name" name="full-name" required>
        </div>

        <div class="glass-form-group">
            <label for="contact-number">Contact Number *</label>
            <input type="tel" id="contact-number" name="contact-number" required>
        </div>

        <div class="glass-form-group">
            <label for="email2">Email 2 *</label>
            <input type="email" id="email2" name="email2" required>
        </div>

        <div class="glass-form-group">
            <label for="referred-by">Referred By *</label>
            <input type="text" id="referred-by" name="referred-by" required>
        </div>

        <div class="glass-form-group">
            <label for="marks-percentage">Marks Percentage (SSC, Inter, Graduation) *</label>
            <input type="text" id="marks-percentage" name="marks-percentage" required>
        </div>

        <div class="glass-form-group">
            <label for="toefl-ielts-marks">TOEFL / IELTS / PTE Marks *</label>
            <input type="text" id="toefl-ielts-marks" name="toefl-ielts-marks" required>
        </div>

        <div class="glass-form-group">
            <label for="country-interested">Country Interested *</label>
            <select id="country-interested" name="country-interested" required>
                <option value="USA">USA</option>
                <option value="UK">UK</option>
                <option value="Ireland">Ireland</option>
                <option value="Canada">Canada</option>
                <option value="Australia">Australia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="glass-form-group">
            <label for="budget-range">Tuition Fee Budget (Per Year) *</label>
            <select id="budget-range" name="budget-range" required>
                <option value="10-15">10 LAKHS - 15 LAKHS</option>
                <option value="15-20">15 LAKHS - 20 LAKHS</option>
                <option value="20-25">20 LAKHS - 25 LAKHS</option>
                <option value="30-40">30 LAKHS - 40 LAKHS</option>
                <option value="50-above">50 LAKHS & ABOVE</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="glass-form-group">
            <label for="requirements">Your Requirements *</label>
            <textarea id="requirements" name="requirements" rows="4" required></textarea>
        </div>

        <div class="glass-form-group">
            <button type="submit" class="glass-submit-button">Submit</button>
        </div>
    </form>

    <div id="glass-success-message" class="glass-success-message">
        <p>Registration form submitted successfully!</p>
    </div>
</div>

<!-- Glassmorphism Form CSS -->
<style>
    /* Glass Form Background */
    .glass-form-container {
        max-width: 800px;
        width: 100%;
        padding: 30px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
        animation: glassFadeIn 0.8s ease-in-out;
        margin: auto;
    }

    /* Header Styling */
    .glass-form-header h1 {
        font-size: 2.2em;
        color:  #dc3545;
        background: -webkit-linear-gradient(45deg, #151513, #ff6600);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        /* text-shadow: 0px 2px 8px  #dc3545; */
    }

    .glass-form-header p {
        font-size: 1.1em;
        color: #39300d;
    }

    /* Form Group */
    .glass-form-group {
        text-align: left;
        margin-bottom: 20px;
    }

    label {
        font-size: 1.1em;
        font-weight: bold;
        color: #000000;
        display: block;
        margin-bottom: 5px;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ffcc00;
        background: rgba(255, 255, 255, 0.2);
        color:#39300d;
        font-size: 1em;
        outline: none;
        transition: 0.3s ease-in-out;
        box-shadow: inset 0 0 8px #7b96ce;
    }

    /* Focus Effect */
    input:focus, select:focus, textarea:focus {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.03);
        border-color:  #dc3545;
        box-shadow: 0px 0px 10px  #dc3545;
    }

    /* Submit Button */
    .glass-submit-button {
        background: linear-gradient(135deg, #FF512F, #DD2476);
        color: white;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 1.3em;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0px 5px 15px rgba(255, 102, 0, 0.4);
    }

    .glass-submit-button:hover {
        background: linear-gradient(135deg, #ffcc00, #ff6600);
        transform: scale(1.07);
        box-shadow: 0px 7px 20px  #dc3545;
    }

    /* Success Message */
    .glass-success-message {
        display: none;
        color: #0f0;
        font-size: 1.2em;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }

    /* Fade-in Animation */
    @keyframes glassFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .glass-form-container {
            padding: 20px;
        }
        .glass-submit-button {
            font-size: 1.1em;
        }
    }
</style>


<!-- JavaScript -->
<script>
    document.getElementById("glass-registration-form").addEventListener("submit", function(event) {
        event.preventDefault();
        document.getElementById("glass-success-message").style.display = "block";
    });
</script>







    

    <!-- Core Scripts -->


    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>
    <script src="assets/vendors/isotope/isotope.pkgd.js"></script>
    <script src="assets/js/leadmark.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <!-- Firebase Firestore -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="./firebaseConfig.js"></script>

    <?php include 'footer.php'?>
    </body>
</html>
