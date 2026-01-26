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
  /* Blog card container */
  .blog-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    margin: 30px auto;
    max-width: 1200px;
  }

  /* Blog card style */
  .blog-card {
    flex: 1 1 320px;              
    max-width: 360px;             
    border-radius: 20px;
    background: #ff3019; /* dark background body */
    padding: 10px;
    overflow: hidden;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 10px 25px;
    transition: transform 0.4s ease;
    display: flex;
    flex-direction: column;
  }

  .blog-card:hover {
    transform: scale(1.03);
  }

  /* 🎨 Top section with red theme gradient */
  .blog-card .top-section {
    border-radius: 15px;
    overflow: hidden;
    padding: 10px;
    background: linear-gradient(45deg, #c68a8aff 0%, #ff6c6cff 70%, #ff6868ff 100%);
    text-align: center;
  }

  .blog-card .top-section h3 {
    color: #fff;
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: 700;
  }

  /* iframe video */
  .blog-card iframe {
    border-radius: 12px;
    border: none;
    width: 100%;
  }

  /* Bottom section */
  .blog-card .bottom-section {
    margin-top: 15px;
    padding: 10px;
    text-align: center;
    color: rgba(255, 200, 200, 0.9);
  }

  .blog-card .bottom-section p {
    font-size: 14px;
    margin-bottom: 10px;
    color: rgba(255, 230, 230, 0.85);
    line-height: 1.5;
  }

  .blog-card .bottom-section h4 {
    color: #fff;
    font-size: 14px;
    margin: 10px 0;
    font-weight: 600;
  }

  /* Social icons row */
  .share-buttons .social-icons {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .share-buttons .social-icons a,
  .share-buttons .social-icons button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
  }

  /* Hover effect: subtle glow in red */
  .share-buttons .social-icons a:hover,
  .share-buttons .social-icons button:hover {
    transform: translateY(-3px);
    box-shadow: 0 3px 10px rgba(25, 251, 255, 0.5);
    opacity: 0.95;
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
                <h1 class="header-title">OUR BLOGS</h1>
                <p class="header-subtitle">Empowering your future with global education, migration, and work opportunities.</p>
            </div>
        </div>
    </div>
</div>

<!-- Blog Section -->

 <div style="min-height:400px; text-align:center;margin-top:30px;">
        
<div class="blog-container">

  <!-- BLOG 1 -->
  <div id="blog-b5hlcHUJbY" class="blog-card">
    <div class="top-section">
      <h3>Short: Learning & Growth</h3>
      <iframe width="100%" height="220"
        src="https://www.youtube.com/embed/b5hl-cHUJbY"
        title="YouTube Short b5hl-cHUJbY"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
    </div>
    <div class="bottom-section">
      <p>Watch this inspirational YouTube Short about growth through learning and new opportunities.</p>
      <div class="share-buttons">
        <h4>Share this blog:</h4>
        <div class="social-icons">
          <a href="#" class="whatsapp-share btn btn-success"
             data-url="https://meritminds.co.in/blogs.php#blog-b5hlcHUJbY">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="#" class="facebook-share btn btn-primary"
             data-url="https://meritminds.co.in/blogs.php#blog-b5hlcHUJbY">
            <i class="fab fa-facebook"></i>
          </a>
          <button class="btn btn-dark copy-link"
             data-url="https://meritminds.co.in/blogs.php#blog-b5hlcHUJbY">
            <i class="fa fa-copy"></i> Copy Link
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- BLOG 2 -->
  <div id="blog-Y7OzTZmhUUU" class="blog-card">
    <div class="top-section">
      <h3>Short: Opportunity Abroad</h3>
      <iframe width="100%" height="220"
        src="https://www.youtube.com/embed/Y7OzTZmhUUU"
        title="YouTube Short Y7OzTZmhUUU"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
    </div>
    <div class="bottom-section">
      <p>Watch this Short for tips on building your future and finding opportunities abroad.</p>
      <div class="share-buttons">
        <h4>Share this blog:</h4>
        <div class="social-icons">
          <a href="#" class="whatsapp-share btn btn-success"
             data-url="https://meritminds.co.in/blogs.php#blog-Y7OzTZmhUUU">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="#" class="facebook-share btn btn-primary"
             data-url="https://meritminds.co.in/blogs.php#blog-Y7OzTZmhUUU">
            <i class="fab fa-facebook"></i>
          </a>
          <button class="btn btn-dark copy-link"
             data-url="https://meritminds.co.in/blogs.php#blog-Y7OzTZmhUUU">
            <i class="fa fa-copy"></i> Copy Link
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- BLOG 3 -->
  <div id="blog-ZIlE1YUEnyQ" class="blog-card">
    <div class="top-section">
      <h3>Short: Global Opportunities</h3>
      <iframe width="100%" height="220"
        src="https://www.youtube.com/embed/ZIlE1YUEnyQ"
        title="YouTube Short ZIlE1YUEnyQ"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
    </div>
    <div class="bottom-section">
      <p>Watch this Short for tips on building your future and finding opportunities abroad.</p>
      <div class="share-buttons">
        <h4>Share this blog:</h4>
        <div class="social-icons">
          <a href="#" class="whatsapp-share btn btn-success"
             data-url="https://meritminds.co.in/blogs.php#blog-ZIlE1YUEnyQ">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="#" class="facebook-share btn btn-primary"
             data-url="https://meritminds.co.in/blogs.php#blog-ZIlE1YUEnyQ">
            <i class="fab fa-facebook"></i>
          </a>
          <button class="btn btn-dark copy-link"
             data-url="https://meritminds.co.in/blogs.php#blog-ZIlE1YUEnyQ">
            <i class="fa fa-copy"></i> Copy Link
          </button>
        </div>
      </div>
    </div>
  </div>

</div>

    </div>

    <script>
        // Function to dynamically update the share links
        document.querySelectorAll('.whatsapp-share').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = button.getAttribute('data-url');
                window.open('https://wa.me/?text=' + encodeURIComponent(url), '_blank');
            });
        });

        document.querySelectorAll('.facebook-share').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = button.getAttribute('data-url');
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
            });
        });

        document.querySelectorAll('.copy-link').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = button.getAttribute('data-url');
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = url;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Link copied to clipboard!");
            });
        });
    </script>
</div>
<?php include 'footer.php'?>
</body>
</html>
