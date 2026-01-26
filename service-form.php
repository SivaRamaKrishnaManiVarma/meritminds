<?php include 'header.php'?>

    <!-- End Of Second Navigation -->

    <!-- Page Header -->
    <header class="header">
        <div class="overlay">
            <h1 class="title">Our Services</h1>
            <h1 class="subtitle"></h1>  
        </div>  
        <div class="shape">
            <svg viewBox="0 0 1500 200">
                <path d="m 0,240 h 1500.4828 v -71.92164 c 0,0 -286.2763,-81.79324 -743.19024,-81.79324 C 300.37862,86.28512 0,168.07836 0,168.07836 Z"/>
            </svg>
        </div>  
        
    </header>

    <!-- Service Form Section -->
    <section class="section pt-5">
        <div class="container">
            <h2 class="text-center mb-5">Choose Your Service</h2>
            <form id="service-form" class="form-row" novalidate >
                <div class="form-group col-md-6">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="service-name" name="name" placeholder="Enter your full name" required>
                    <div class="invalid-feedback">Please enter your full name.</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="service-email" name="email" placeholder="Enter your email" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">WhatsApp Number</label>
                    <input type="tel" class="form-control" id="service-phone" name="phone" placeholder="Enter your WhatsApp number" required>
                    <div class="invalid-feedback">Please enter your WhatsApp number.</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="service">Select Service</label>
                    <select class="form-control" id="service-type" name="service" required>
                        <option value="" disabled selected>Choose your service</option>
                        <option value="study_abroad">Study Abroad</option>
                        <option value="migrate_abroad">Migrate Abroad</option>
                        <option value="work_abroad">Work Abroad</option>
                        <option value="visit_abroad">Visit Abroad</option>
                    </select>
                    <div class="invalid-feedback">Please select a service.</div>
                </div>
                <div class="form-group col-md-12">
                    <label for="message">Additional Information</label>
                    <textarea class="form-control" id="service-message" name="message" rows="4" placeholder="Any additional details or queries..."></textarea>
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            
            <!-- Success and Error Messages -->
            <div id="success-message" style="display:none;" class="text-center text-success">Form submitted successfully!</div>
            <div id="error-message" style="display:none;" class="text-center text-danger">Error submitting form. Please try again.</div>
            
        </div>
    </section>

    <!-- Scripts -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <!-- Firebase Firestore -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="./firebaseConfig.js"></script>
</body>
</html>
