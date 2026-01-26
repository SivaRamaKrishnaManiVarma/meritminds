<?php
// country-template.php
$countryCode = isset($_GET['country']) ? $_GET['country'] : 'germany';

require_once 'country-data.php';
$data = getCountryData($countryCode);

if (!$data) {
    header("HTTP/1.0 404 Not Found");
    echo "Country page not found.";
    exit;
}

include 'header.php';
?>
<style>
/* === Base Styling & Variables === */
.aus-page-container {
    font-family: 'Poppins', sans-serif;
    color: #333;
    line-height: 1.6;
}
:root {
    --aus-primary: #fc0511;
    --aus-primary-light: #fd4a52;
    --aus-primary-dark: #d00410;
    --aus-secondary: #ffebec;
    --aus-dark: #222;
    --aus-light: #f9f9f9;
    --aus-gray: #f1f1f1;
}

/* === Hero Header === */
.aus-header {
    position: relative;
    height: 80vh;
    min-height: 480px;
    background: linear-gradient(to right, rgba(208,4,16,0.9), rgba(252,5,17,0.9)), url('<?php echo $data['hero_image']; ?>');
    background-size: cover;
    background-position: center;
    color: white;
    overflow: hidden;
}
.aus-overlay {
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    text-align: center;
}
.aus-title {
    font-size: 3.2rem;
    font-weight: 800;
    margin-bottom: 0.8rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    animation: aus-title-reveal 1.3s ease-out forwards;
}
.aus-subtitle {
    font-size: 1.5rem;
    font-weight: 300;
    opacity: 0;
    max-width: 700px;
    animation: aus-fade-in 1s ease-out 0.7s forwards;
}
.aus-shape svg {
    fill: #fff;
    width: 100%;
    height: auto;
}

/* === Sections === */
.aus-section {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}
.aus-section.aus-no-padding-top { padding-top: 0; }
.aus-section.aus-bg-light { background-color: var(--aus-gray); }

.aus-section-heading {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
}
.aus-section-heading::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 80px;
    height: 4px;
    background-color: var(--aus-primary);
}
.aus-text-center .aus-section-heading::after {
    left: 50%;
    transform: translateX(-50%);
}
.aus-section-subheading {
    font-size: 1.1rem;
    font-weight: 400;
    margin-bottom: 3rem;
    color: #666;
}

/* === Content Layout === */
.aus-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}
.aus-col-md-6,
.aus-col-md-4 {
    position: relative;
    width: 100%;
    padding: 15px;
}
@media (min-width: 768px) {
    .aus-col-md-6 { flex: 0 0 50%; max-width: 50%; }
    .aus-col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
}
.aus-content-image {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    width: 100%;
    height: auto;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    object-fit: cover;
}
.aus-content-image:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}
.aus-content-text {
    font-size: 1.05rem;
    line-height: 1.8;
}

/* List with custom bullets */
.aus-list {
    list-style: none;
    padding-left: 0;
    margin-top: 1.5rem;
}
.aus-list-item {
    position: relative;
    margin-bottom: 0.9rem;
    padding-left: 2.3rem;
}
.aus-list-item::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0.55rem;
    width: 11px;
    height: 11px;
    background-color: var(--aus-primary);
    border-radius: 50%;
}

/* === Benefit Boxes === */
.aus-benefit-box {
    background-color: #fff;
    border-radius: 15px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.aus-benefit-box::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(252,5,17,0.06), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.aus-benefit-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(252,5,17,0.12);
}
.aus-benefit-box:hover::before { opacity: 1; }
.aus-benefit-icon {
    font-size: 2.3rem;
    color: var(--aus-primary);
    margin-bottom: 1.2rem;
}
.aus-benefit-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.7rem;
}
.aus-benefit-text { color: #666; }

/* === Key Facts Cards === */
.aus-fact-card {
    background: #fff;
    padding: 28px 18px;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.06);
    height: 100%;
}
.aus-fact-icon {
    font-size: 2.3rem;
    margin-bottom: 10px;
}
.aus-fact-number {
    font-size: 1.7rem;
    font-weight: 700;
    color: var(--aus-primary);
}
.aus-fact-label {
    font-size: 0.95rem;
    color: #666;
}

/* === Universities cards === */
.aus-uni-card {
    background: #fff;
    padding: 24px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.06);
    text-align: center;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.aus-uni-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

/* === CTA Section === */
.aus-cta-section {
    background: linear-gradient(135deg, var(--aus-primary-dark), var(--aus-primary));
    color: #fff;
    padding: 4rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.aus-cta-heading {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
}
.aus-cta-text {
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto 1.8rem;
    opacity: 0.95;
}
.aus-cta-btn {
    display: inline-block;
    background-color: #fff;
    color: var(--aus-primary);
    font-weight: 600;
    padding: 0.8rem 2.5rem;
    border-radius: 40px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.aus-cta-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.25);
}

/* === Timeline / Process === */
.aus-timeline {
    position: relative;
    padding-left: 40px;
}
.aus-timeline-line {
    position: absolute;
    left: 16px;
    top: 25px;
    bottom: 25px;
    width: 2px;
    background: linear-gradient(to bottom, var(--aus-primary), var(--aus-primary-dark));
}
.aus-timeline-step {
    position: relative;
    margin-bottom: 26px;
}
.aus-timeline-badge {
    position: absolute;
    left: -34px;
    top: 8px;
    width: 30px;
    height: 30px;
    background: var(--aus-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    box-shadow: 0 0 0 5px #ffebec;
}

/* === Testimonials === */
.card-3d, .aus-testimonial-card {
    border-radius: 15px;
    overflow: hidden;
    height: 100%;
    transition: transform 0.5s ease, box-shadow 0.5s ease;
    transform-style: preserve-3d;
}
.card-3d:hover, .aus-testimonial-card:hover {
    transform: rotateY(5deg) translateZ(10px);
    box-shadow: 0 18px 30px rgba(0,0,0,0.18);
}

/* === Animations === */
.aus-animated-section,
.aus-fade-in {
    opacity: 0;
    transform: translateY(25px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}
.aus-animated-section.visible,
.aus-fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}
@keyframes aus-title-reveal {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes aus-fade-in {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Masked text */
.aus-masked-text {
    background: linear-gradient(45deg, var(--aus-primary), var(--aus-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Responsive tweaks */
@media (max-width: 992px) {
    .aus-title { font-size: 2.6rem; }
    .aus-subtitle { font-size: 1.25rem; }
}
@media (max-width: 768px) {
    .aus-header { height: 65vh; }
    .aus-section { padding: 3rem 0; }
    .aus-title { font-size: 2.2rem; }
    .aus-subtitle { font-size: 1rem; }
    .aus-section-heading { font-size: 1.8rem; }
}
</style>

<div class="aus-page-container">

<!-- HERO -->
<header class="aus-header">
    <div class="aus-overlay">
        <h1 class="aus-title"><?php echo htmlspecialchars($data['hero_title']); ?></h1>
        <h1 class="aus-subtitle"><?php echo htmlspecialchars($data['hero_subtitle']); ?></h1>
    </div>
    <div class="aus-shape">
        <svg viewBox="0 0 1500 200">
            <path d="m 0,240 h 1500.4828 v -71.92164 c 0,0 -286.2763,-81.79324 -743.19024,-81.79324 C 300.37862,86.28512 0,168.07836 0,168.07836 Z"/>
        </svg>
    </div>
</header>

<!-- QUICK FORM -->
<section style="background:#fff;padding:40px 0;margin-top:-50px;position:relative;z-index:10;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="background:linear-gradient(135deg,#fc0511,#a30008);padding:32px 28px;border-radius:18px;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
                    <h4 class="text-white text-center mb-3">
                          Interested in Studying in <?php echo htmlspecialchars($data['name']); ?>?
                    </h4>
                    <form action="https://formsubmit.co/ajax/meritminds.info@gmail.com" method="POST" id="countryInterestForm">
                        <input type="hidden" name="_subject" value="<?php echo $data['name']; ?> Study Inquiry - MeritMinds">
                        <input type="hidden" name="_template" value="table">
                        <input type="hidden" name="_captcha" value="false">
                        <input type="hidden" name="Country of Interest" value="<?php echo htmlspecialchars($data['name']); ?>">
                        <input type="text" name="_honey" style="display:none">

                        <div class="row g-3">
                            <div class="col-md-3 mb-2">
                                <input type="text" class="form-control" name="Full Name" placeholder="Your Name" required class="text-light" style=" border-radius:10px;border:none;padding:12px;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="email" class="form-control" name="Email Address" placeholder="Email" required style="color:white  border-radius:10px;border:none;padding:12px;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="tel" class="form-control" name="Phone Number" placeholder="Phone / WhatsApp" required style="color:white border-radius:10px;border:none;padding:12px;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <button type="submit" id="submitFormBtn" class="btn w-100" style="background:#fff;color:#fc0511;font-weight:700;border-radius:10px;padding:12px;border:none;">
                                    Get Free Counselling →
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INTRO -->
<section class="aus-section aus-no-padding-top aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text"><?php echo htmlspecialchars($data['hero_title']); ?></h6>
        <h6 class="aus-section-subheading aus-text-center aus-mb-4">
            Unlock world‑class education in a globally recognised destination.
        </h6>

        <div class="aus-row">
            <div class="aus-col-md-6 aus-fade-in">
                <img src="<?php echo htmlspecialchars($data['intro_image']); ?>" alt="Study in <?php echo htmlspecialchars($data['name']); ?>" class="aus-content-image">
            </div>
            <div class="aus-col-md-6 aus-fade-in">
                <p class="aus-content-text"><?php echo htmlspecialchars($data['intro_text']); ?></p>
                <ul class="aus-list">
                    <?php foreach ($data['intro_points'] as $point): ?>
                        <li class="aus-list-item"><?php echo htmlspecialchars($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- KEY FACTS -->
<?php if (!empty($data['key_facts'])): ?>
<section class="aus-section aus-bg-light aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text"><?php echo htmlspecialchars($data['name']); ?> at a Glance</h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4">Important facts to plan your study abroad journey.</p>
        <div class="row text-center">
            <?php foreach ($data['key_facts'] as $i => $fact): ?>
                <div class="col-md-3 col-6 mb-4 aus-fade-in">
                    <div class="aus-fact-card">
                        <div class="aus-fact-icon"><?php echo $fact['icon']; ?></div>
                        <div class="aus-fact-number"><?php echo htmlspecialchars($fact['number']); ?></div>
                        <div class="aus-fact-label"><?php echo htmlspecialchars($fact['label']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- WHY CHOOSE -->
<section class="aus-section aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text"><?php echo htmlspecialchars($data['why_choose']['title']); ?></h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4"><?php echo htmlspecialchars($data['why_choose']['subtitle']); ?></p>

        <div class="aus-row">
            <?php foreach ($data['why_choose']['benefits'] as $index => $benefit): ?>
                <div class="aus-col-md-4 aus-fade-in">
                    <div class="aus-benefit-box aus-text-center aus-mb-4">
                        <i class="aus-benefit-icon <?php echo htmlspecialchars($benefit['icon']); ?>"></i>
                        <h6 class="aus-benefit-title"><?php echo htmlspecialchars($benefit['title']); ?></h6>
                        <p class="aus-benefit-text"><?php echo htmlspecialchars($benefit['text']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- UNIVERSITIES -->
<?php if (!empty($data['universities'])): ?>
<section class="aus-section aus-bg-light aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text">Top Universities in <?php echo htmlspecialchars($data['name']); ?></h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4">Some of the institutions our students aspire to.</p>
        <div class="row">
            <?php foreach ($data['universities'] as $index => $uni): ?>
                <div class="aus-col-md-4 aus-fade-in">
                    <div class="aus-uni-card">
                        <div style="width:80px;height:80px;margin:0 auto 15px;border-radius:50%;overflow:hidden;background:#f8f9fa;display:flex;align-items:center;justify-content:center;">
                            <?php if (!empty($uni['flag'])): ?>
                                <img src="<?php echo htmlspecialchars($uni['flag']); ?>" 
                                    alt="<?php echo htmlspecialchars($uni['name']); ?> flag"
                                    style="width:100%;height:100%;object-fit:contain;">
                            <?php else: ?>
                                <i class="ti-cup" style="font-size:35px;color:#fc0511;"></i>
                            <?php endif; ?>
                        </div>

                        <h5 style="font-weight:700;margin-bottom:6px;"><?php echo htmlspecialchars($uni['name']); ?></h5>
                        <p style="font-size:13px;color:#666;margin-bottom:6px;"><?php echo htmlspecialchars($uni['rank']); ?></p>
                        <p style="font-size:13px;color:#999;margin-bottom:0;"><?php echo htmlspecialchars($uni['specialization']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- COST OF STUDY -->
<section class="aus-section aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text">Cost of Studying in <?php echo htmlspecialchars($data['name']); ?></h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4">Understand tuition fees and approximate living expenses.</p>
        <div class="row justify-content-center">
            <div class="col-lg-8 aus-fade-in">
                <div style="background:#fff;padding:30px;border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,0.08);">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div style="border-left:4px solid #fc0511;padding-left:16px;">
                                <h6 style="font-size:12px;color:#999;text-transform:uppercase;margin-bottom:4px;">
                                    <?php echo strtoupper($data['cost_of_study']['tuition']['label']); ?>
                                </h6>
                                <h3 style="color:#fc0511;font-weight:700;margin:0;">
                                    <?php echo htmlspecialchars($data['cost_of_study']['tuition']['amount']); ?>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div style="border-left:4px solid #fc0511;padding-left:16px;">
                                <h6 style="font-size:12px;color:#999;text-transform:uppercase;margin-bottom:4px;">
                                    <?php echo strtoupper($data['cost_of_study']['living']['label']); ?>
                                </h6>
                                <h3 style="color:#fc0511;font-weight:700;margin:0;">
                                    <?php echo htmlspecialchars($data['cost_of_study']['living']['amount']); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 style="font-weight:700;margin-bottom:16px;">Typical Monthly Living Expenses:</h6>
                    <?php foreach ($data['cost_of_study']['breakdown'] as $expense): ?>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px;">
                            <span><?php echo htmlspecialchars($expense['item']); ?></span>
                            <strong style="color:#fc0511;"><?php echo htmlspecialchars($expense['cost']); ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- REQUIREMENTS -->
<section class="aus-section aus-bg-light aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text">Admission Requirements</h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4">Check what you typically need for applications.</p>
        <div class="row">
            <div class="aus-col-md-6 aus-fade-in">
                <div style="background:#fff;padding:28px;border-radius:15px;box-shadow:0 5px 15px rgba(0,0,0,0.06);height:100%;">
                    <h5 style="font-weight:700;margin-bottom:16px;color:#fc0511;">📚 Academic Requirements</h5>
                    <ul class="aus-list">
                        <?php foreach ($data['requirements']['academic'] as $req): ?>
                            <li class="aus-list-item"><?php echo htmlspecialchars($req); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="aus-col-md-6 aus-fade-in">
                <div style="background:#fff;padding:28px;border-radius:15px;box-shadow:0 5px 15px rgba(0,0,0,0.06);height:100%;">
                    <h5 style="font-weight:700;margin-bottom:16px;color:#fc0511;">📝 Language & Visa Requirements</h5>
                    <ul class="aus-list">
                        <?php foreach ($data['requirements']['language'] as $req): ?>
                            <li class="aus-list-item"><?php echo htmlspecialchars($req); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- APPLICATION PROCESS -->
<section class="aus-section aus-animated-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text">Application Process</h6>
        <p class="aus-section-subheading aus-text-center aus-mb-4">Step‑by‑step support from MeritMinds Overseas.</p>
        <div class="row justify-content-center">
            <div class="col-lg-10 aus-fade-in">
                <div class="aus-timeline">
                    <div class="aus-timeline-line"></div>
                    <?php foreach ($data['application_process'] as $step): ?>
                        <div class="aus-timeline-step">
                            <div class="aus-timeline-badge"><?php echo (int)$step['step']; ?></div>
                            <div style="background:#fff;padding:18px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.06);margin-left:16px;">
                                <h6 style="font-weight:700;margin-bottom:6px;"><?php echo htmlspecialchars($step['title']); ?></h6>
                                <p style="margin:0;font-size:14px;color:#666;"><?php echo htmlspecialchars($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="aus-cta-section aus-animated-section">
    <div class="container">
        <h6 class="aus-cta-heading"><?php echo htmlspecialchars($data['cta']['title']); ?></h6>
        <p class="aus-cta-text"><?php echo htmlspecialchars($data['cta']['subtitle']); ?></p>
        <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
            <a href="contact-us.php" class="aus-cta-btn">
                📞 <?php echo htmlspecialchars($data['cta']['button_text']); ?>
            </a>
            <a href="tel:<?php echo htmlspecialchars($data['cta']['phone']); ?>" class="aus-cta-btn" style="background:transparent;border:2px solid #fff;color:#fff;">
                📲 Call: <?php echo htmlspecialchars($data['cta']['phone']); ?>
            </a>
        </div>
    </div>
</section>

<!-- SUCCESS STORIES -->
<section class="aus-section">
    <div class="container">
        <h6 class="aus-section-heading aus-text-center aus-masked-text">Success Stories</h6>
        <h6 class="aus-section-subheading aus-text-center aus-mb-4">Students who trusted MeritMinds for their journey.</h6>
        <div class="row">
            <?php foreach ($data['testimonials'] as $index => $t): ?>
                <div class="col-md-4 my-3 aus-fade-in">
                    <div class="card-3d">
                        <div class="card-body" style="background-color:<?php echo htmlspecialchars($t['color']); ?>;">
                            <div class="media align-items-center mb-2">
                                <div class="media-body">
                                    <h6 class="mt-1 mb-0"><?php echo htmlspecialchars($t['name']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($t['university']); ?></small>
                                </div>
                            </div>
                            <div class="mb-2 text-warning"><?php echo str_repeat('★', (int)$t['rating']); ?></div>
                            <p class="mb-0" style="font-size:14px;"><?php echo htmlspecialchars($t['text']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</div> <!-- /.aus-page-container -->

<!-- AOS & scroll animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration: 900, once: false });

document.addEventListener("DOMContentLoaded", function () {
    const fadeInElements = document.querySelectorAll(".aus-fade-in");
    const animatedSections = document.querySelectorAll(".aus-animated-section");

    function revealOnScroll() {
        const windowHeight = window.innerHeight;
        animatedSections.forEach(section => {
            if (section.getBoundingClientRect().top < windowHeight - 60) {
                section.classList.add("visible");
            }
        });
        fadeInElements.forEach(el => {
            if (el.getBoundingClientRect().top < windowHeight - 60) {
                el.classList.add("visible");
            }
        });
    }
    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
});

// FormSubmit AJAX
document.getElementById('countryInterestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn  = document.getElementById('submitFormBtn');
    const formData = new FormData(form);
    btn.disabled = true;
    btn.textContent = 'Sending...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'Accept': 'application/json' }
    }).then(r => r.json())
      .then(data => {
          if (data.success) {
              btn.textContent = '✓ Sent Successfully';
              form.reset();
              setTimeout(() => {
                  btn.disabled = false;
                  btn.textContent = 'Get Free Counselling →';
              }, 3000);
          } else {
              throw new Error();
          }
      }).catch(() => {
          alert('Something went wrong. Please try again.');
          btn.disabled = false;
          btn.textContent = 'Get Free Counselling →';
      });
});
</script>

<?php include 'footer.php'; ?>
