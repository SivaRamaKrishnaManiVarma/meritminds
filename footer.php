
<style>
    /* Contact Form Specific Styles */
.contact-form-wrapper {
    background-color: transparent !important;
    border-radius: 0.25rem !important;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
    padding: 1.5rem !important;
}

.contact-form-title {
    color:#ff6e42 !important; /* Matching your primary color from links */
    font-weight: 700 !important;
    margin-bottom: 1.5rem !important;
}

.merit-contact-form .contact-form-input,
.merit-contact-form .contact-form-textarea {
    display: block !important;
    width: 100% !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background-color: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
}

.merit-contact-form .contact-form-button {
    color: #fff !important;
    background-color:#ff6e42 !important;
    border-color:#ff6e42 !important;
    padding: 0.5rem 1.5rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    border-radius: 0.25rem !important;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
}

.merit-contact-form .contact-form-button:hover {
    background-color: #ff6e42 !important;
    border-color: #ff6e42 !important;
}

.contact-form-success {
    background-color: #d4edda !important;
    color: #155724 !important;
    border-color: #c3e6cb !important;
    padding: 0.75rem 1.25rem !important;
    border-radius: 0.25rem !important;
}

.contact-form-error {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    border-color: #f5c6cb !important;
    padding: 0.75rem 1.25rem !important;
    border-radius: 0.25rem !important;
}
    </style>
<section id="contact" class="section has-img-bg">
    <div class="container-fluid">
        <div class="row">
            <!-- Company Info Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 text-md-center">
                <div class="p-4 bg-transparent shadow-sm rounded h-100 ">
                    <img src="assets/imgs/new_logo.png" alt="MeritMinds Logo" class="img-fluid mb-4" style="max-width: 100px;">
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-primary">Phone</h5>
                        <p class="mb-1">+91 9505889191 (ANDHRA PRADESH)</p>
                        <p>+91 9505929191 (TELANGANA)</p>
                    </div>

                    <div>
                        <h5 class="font-weight-bold text-primary">Email</h5>
                        <p class="mb-1">info@meritminds.co.in</p>
                        <p>meritminds.apply@gmail.com</p>
                        <!-- <a href="mailto:meritminds.apply@gmail.com">meritminds.apply@gmail.com</a> -->

                    </div>
                </div>
            </div>
            
            <!-- Study Destinations Column -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="p-4 bg-transparent shadow-sm rounded h-100 text-start">
                    <h5 class="text-primary font-weight-bold mb-4">Study Destinations</h5>
                    <ul class="list-unstyled text-primary ">
                        <li class="mb-3"><a href="australia-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In Australia
                        </a></li>
                        <li class="mb-3"><a href="usa-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In USA
                        </a></li>
                        <li class="mb-3"><a href="uk-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In UK
                        </a></li>
                        <li class="mb-3"><a href="ireland-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In Ireland
                        </a></li>
                        <li class="mb-3"><a href="canada-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In Canada
                        </a></li>
                        <li><a href="germany-details.php" style="color:#8585e4" class="text-decoration-none">
                            <i class="fas fa-graduation-cap mr-2"></i>Study In Germany
                        </a></li>
                    </ul>
                </div>
            </div>
            
    <!-- Contact Form Column -->
<div class="col-lg-5 col-md-12">
    <div class="contact-form-wrapper p-4 bg-transparent shadow-sm rounded">
        <h4 class="contact-form-title text-primary font-weight-bold mb-4">Drop Us A Line</h4>
        <form action="https://formsubmit.co/ajax/meritminds.info@gmail.com" 
              method="POST" 
              id="contact-form" 
              class="merit-contact-form" 
              novalidate>
            
            <!-- Honeypot spam protection -->
            <input type="text" name="_honey" style="display:none">
            
            <!-- FormSubmit Configuration -->
            <input type="hidden" name="_subject" value="New Contact Form - MeritMinds Website">
            <input type="hidden" name="_template" value="table">
            <input type="hidden" name="_captcha" value="false">
            
            <div class="contact-form-row row">
                <div class="contact-form-col col-md-4 mb-3">
                    <div class="contact-form-group form-group">
                        <input type="text" 
                               class="contact-form-input form-control" 
                               name="name" 
                               placeholder="Name" 
                               required
                               aria-label="Name">
                    </div>
                </div>
                <div class="contact-form-col col-md-4 mb-3">
                    <div class="contact-form-group form-group">
                        <input type="email" 
                               class="contact-form-input form-control" 
                               name="email" 
                               placeholder="Email" 
                               required
                               aria-label="Email">
                    </div>
                </div>
                <div class="contact-form-col col-md-4 mb-3">
                    <div class="contact-form-group form-group">
                        <input type="text" 
                               class="contact-form-input form-control" 
                               name="subject" 
                               placeholder="Subject"
                               aria-label="Subject">
                    </div>
                </div>
            </div>
            <div class="contact-form-group form-group mb-4">
                <textarea name="message" 
                          rows="4" 
                          class="contact-form-textarea form-control" 
                          placeholder="Message" 
                          required
                          aria-label="Message"></textarea>
            </div>
            
            <!-- Submit Button Container -->
            <div class="contact-form-submit text-center text-md-left" id="submitContainer">
                <button type="submit" class="contact-form-button btn btn-primary px-4 py-2">
                    <span class="button-text">Send Message</span>
                    <span class="button-loader" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Sending...
                    </span>
                </button>
            </div>
            
            <!-- Success Container -->
            <div class="contact-form-submit text-center text-md-left" id="successContainer" style="display:none;">
                <div class="contact-form-success alert alert-success">
                    <span class="green-tick">✓</span>
                    Thank you! We'll get back to you soon.
                </div>
            </div>
            
            <!-- Error messages -->
            <div class="contact-form-messages mt-3">
                <div id="error-message" class="contact-form-error alert alert-danger" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> <span class="error-text">Please check your network and try again.</span>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Contact Form Submission Handler with FormSubmit.co
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get form elements
            const submitButton = contactForm.querySelector('.contact-form-button');
            const buttonText = submitButton.querySelector('.button-text');
            const buttonLoader = submitButton.querySelector('.button-loader');
            const submitContainer = document.getElementById('submitContainer');
            const successContainer = document.getElementById('successContainer');
            const errorMessage = document.getElementById('error-message');
            
            // Show loader
            buttonText.style.display = 'none';
            buttonLoader.style.display = 'inline-block';
            submitButton.disabled = true;
            errorMessage.style.display = 'none';
            
            try {
                // Create FormData from the form
                const formData = new FormData(contactForm);
                
                // Submit to FormSubmit.co
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    // Hide submit button, show success message
                    submitContainer.style.display = 'none';
                    successContainer.style.display = 'block';
                    
                    // Reset form
                    contactForm.reset();
                    
                    // Optional: Reset after 5 seconds
                    setTimeout(() => {
                        submitContainer.style.display = 'block';
                        successContainer.style.display = 'none';
                    }, 5000);
                    
                } else {
                    throw new Error('Submission failed');
                }
                
            } catch (error) {
                console.error('Error submitting form:', error);
                
                // Show error message
                errorMessage.querySelector('.error-text').textContent = 'Failed to send message. Please try again.';
                errorMessage.style.display = 'block';
                
                // Reset button state
                buttonText.style.display = 'inline-block';
                buttonLoader.style.display = 'none';
                submitButton.disabled = false;
            }
        });
    }
});
</script>

<style>
/* Contact Form Styling */
.contact-form-wrapper {
    background: rgba(255, 255, 255, 0.95);
}

.contact-form-input,
.contact-form-textarea {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.contact-form-input:focus,
.contact-form-textarea:focus {
    border-color: #fc0511;
    box-shadow: 0 0 0 0.2rem rgba(252, 5, 17, 0.1);
    outline: none;
}

.contact-form-button {
    background: linear-gradient(135deg, #fc0511, #a30008);
    border: none;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 150px;
}

.contact-form-button:hover:not(:disabled) {
    background: linear-gradient(135deg, #a30008, #fc0511);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(252, 5, 17, 0.3);
}

.contact-form-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.contact-form-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    border-radius: 5px;
    padding: 12px 20px;
    text-align: center;
    font-weight: 600;
}

.green-tick {
    color: #28a745;
    font-size: 1.5rem;
    font-weight: bold;
    margin-right: 8px;
}

.contact-form-error {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    border-radius: 5px;
    padding: 12px 20px;
}

.button-loader i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

        </div>
    </div>
</section>
        <!-- Footer -->
        <footer class="py-2">
        <div class="container text-center">
            <p class="mb-0">&copy; <script>document.write(new Date().getFullYear());</script> Merit Minds Overseas Consultancy. All rights reserved.</p>
           <!-- <p style="margin-bottom:0px"><b>Designed By:  <a href="https://mindrevel.in/" target="_blank"> Mind Revel</a></b></p> -->

        </div>
    </footer>
    