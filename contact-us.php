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
        text-align: center;
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
    
    /* Glass Contact Form Styles */
    .section {
        padding: 60px 0;
    }

    .glass-contact-container {
        max-width: 850px;
        width: 100%;
        padding: 40px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
        animation: glassFadeIn 0.8s ease-in-out;
        margin: auto;
    }

    .glass-contact-header h1 {
        font-size: 2.5em;
        color:  #dc3545;
        background: -webkit-linear-gradient(45deg, #151513, #ff6600);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0px 2px 8px  #dc3545;
    }

    .glass-contact-header p {
        font-size: 1.2em;
        color: #39300d;
        margin-bottom: 30px;
    }

    .glass-contact-row {
        display: flex;
        gap: 40px;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .glass-contact-group {
        flex: 1;
        text-align: left;
    }

    .glass-contact-group label {
        font-size: 1.1em;
        font-weight: bold;
        color: #000000;
        display: block;
        margin-bottom: 10px;
    }

    .glass-contact-group input, .glass-contact-group select {
        width: 100%;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ffcc00;
        background: rgba(255, 255, 255, 0.2);
        color: #39300d;
        font-size: 1.1em;
        outline: none;
        transition: 0.3s ease-in-out;
        box-shadow: inset 0 0 8px #7b96ce;
    }

    .glass-contact-group input:focus, .glass-contact-group select:focus {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.03);
        border-color:  #dc3545;
        box-shadow: 0px 0px 10px rgba(255, 204, 0, 0.8);
    }

    .glass-radio-container {
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: start;
    }

    .glass-radio-container input[type="radio"] {
        display: none;
    }

    .glass-radio-container label {
        background: rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        color: #000;
        font-weight: bold;
        margin-bottom: 0;
    }

    .glass-radio-container input[type="radio"]:checked + label {
        background: #dc3545;
        color: #fff;
        box-shadow: 0px 0px 10px #dc3545;
    }

    .glass-contact-button {
        background: linear-gradient(135deg, #FF512F, #DD2476);
        color: white;
        padding: 18px 40px;
        border: none;
        border-radius: 12px;
        font-size: 1.4em;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0px 5px 15px rgba(255, 102, 0, 0.4);
        width: 100%;
    }

    .glass-contact-button:hover:not(:disabled) {
        background: linear-gradient(135deg, #dc3545, #ff6600);
        transform: scale(1.05);
        box-shadow: 0px 7px 20px  #dc3545;
    }

    .glass-contact-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Success Message Styling */
    .form-message {
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        font-size: 1.1em;
        font-weight: 600;
        display: none;
    }

    .form-message.success {
        background: rgba(76, 175, 80, 0.2);
        color: #2e7d32;
        border: 2px solid #4CAF50;
        display: block;
    }

    .form-message.error {
        background: rgba(244, 67, 54, 0.2);
        color: #c62828;
        border: 2px solid #f44336;
        display: block;
    }

    @keyframes glassFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .glass-contact-container { padding: 20px; margin: 10px; width: calc(100% - 20px); max-width: none; }
        .glass-contact-row { flex-direction: column; gap: 20px; margin-bottom: 15px; }
        .glass-contact-group { width: 100%; }
        .glass-contact-header h1 { font-size: 2em; }
        .glass-contact-header p { font-size: 1em; }
        .glass-contact-group label { font-size: 1em; }
        .glass-contact-group input, .glass-contact-group select { padding: 12px; font-size: 1em; }
        .glass-radio-container { flex-direction: row; flex-wrap: wrap; }
        .glass-contact-button { font-size: 1.2em; padding: 15px; }
    }

    @media screen and (max-width: 480px) {
        .glass-contact-container { padding: 15px; }
        .glass-contact-header h1 { font-size: 1.8em; }
        .glass-contact-header p { font-size: 0.9em; }
        .glass-contact-group input, .glass-contact-group select { padding: 10px; font-size: 0.9em; }
    }
</style>

<!-- Main Header Strip -->
<div class="main-header-strip">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center header-content">
                <h1 class="header-title">Contact Us</h1>
                <p class="header-subtitle">We're Here to Help You Achieve Your Goals.</p>
            </div>
        </div>
    </div>
</div>

<!-- Get in Touch Section -->
<!-- AJAX FormSubmit Form -->
<form
  action="https://formsubmit.co/ajax/meritminds.info@gmail.com"
  method="POST"
  class="php-email-form"
  id="contact-form"
>
  <!-- Honeypot spam protection -->
  <input type="text" name="_honey" style="display:none">
  
  <!-- FormSubmit Configuration - NO _next for AJAX -->
  <input type="hidden" name="_subject" value="New Contact Form Submission - MAT 2026">
  <input type="hidden" name="_template" value="box">
  <input type="hidden" name="_captcha" value="false">

  <div class="row">
    <div class="col-md-6 form-group">
      <input
        type="text"
        name="Full Name"
        class="form-control"
        placeholder="Your Name"
        required
      />
    </div>
    <div class="col-md-6 form-group mt-3 mt-md-0">
      <input
        type="email"
        class="form-control"
        name="Email Address"
        placeholder="Your Email"
        required
      />
    </div>
  </div>
  <div class="form-group mt-3">
    <input
      type="text"
      class="form-control"
      name="Subject"
      placeholder="Subject"
      required
    />
  </div>
  <div class="form-group mt-3">
    <textarea
      class="form-control"
      name="Message"
      rows="5"
      placeholder="Message"
      required
    ></textarea>
  </div>

  <div class="my-3">
    <div class="loading" style="display: none; padding: 10px; background: #e3f2fd; color: #1976d2; border-radius: 5px;">Sending...</div>
    <div class="error-message" style="display: none; padding: 10px; background: #f8d7da; color: #721c24; border-radius: 5px;"></div>
    <div class="sent-message" style="display: none; padding: 10px; background: #d4edda; color: #155724; border-radius: 5px;"></div>
  </div>

  <div class="form-submit">
    <button type="submit" id="submitBtn">Send Message</button>
    <div class="social-links">
      <a href="https://www.facebook.com/MeritmindsOverseas" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-facebook"></i>
      </a>
      <a href="https://www.instagram.com/meritmindsoverseas" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://www.linkedin.com/company/mmosuccess" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-linkedin"></i>
      </a>
    </div>
  </div>
</form>


<!-- AOS Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init();
</script>

<script>
// AJAX Contact Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submitBtn');
            const loading = form.querySelector('.loading');
            const errorMessage = form.querySelector('.error-message');
            const sentMessage = form.querySelector('.sent-message');
            
            // Show loading
            loading.style.display = 'block';
            errorMessage.style.display = 'none';
            sentMessage.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            // Submit form using fetch
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                
                if (data.success) {
                    sentMessage.style.display = 'block';
                    sentMessage.innerHTML = '<strong>Success!</strong> Your message has been sent. We\'ll contact you within 24 hours!';
                    form.reset();
                    
                    setTimeout(() => {
                        sentMessage.style.display = 'none';
                    }, 8000);
                } else {
                    throw new Error('Submission failed');
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                errorMessage.style.display = 'block';
                errorMessage.innerHTML = '<strong>Error!</strong> Could not send message. Please email us at info@meritminds.co.in';
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Message';
            });
        });
    }
});
</script>


<?php include 'footer.php'; ?>
