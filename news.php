<?php include 'header.php'?>
<style>
    /* Updated color theme to match the real source */
    :root {
        --primary-color: #2c3e50; /* Changed from red to a more professional blue-gray */
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #34495e;
    }
    
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
    /* News Article Card Styles */
    .news-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
        margin: 30px auto;
        max-width: 1200px;
    }
    
    .news-card {
        flex: 1 1 320px;
        max-width: 360px;
        border-radius: 20px;
        background: var(--primary-color); /* Changed from red to primary color */
        padding: 15px;
        overflow: hidden;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 10px 25px;
        transition: transform 0.4s ease;
        display: flex;
        flex-direction: column;
    }
    
    .news-card:hover {
        transform: scale(1.03);
    }
    
    .news-card .article-header {
        border-radius: 15px;
        overflow: hidden;
        padding: 15px;
        background: linear-gradient(45deg, var(--secondary-color) 0%, var(--accent-color) 70%, #c0392b 100%); /* Updated gradient */
        text-align: center;
        margin-bottom: 15px;
    }
    
    .news-card .article-header h3 {
        color: #fff;
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }
    
    .news-card .article-meta {
        display: flex;
        justify-content: space-between;
        color: rgba(255, 230, 230, 0.85);
        font-size: 12px;
        margin-bottom: 15px;
    }
    
    .news-card .article-content {
        color: rgba(255, 230, 230, 0.9);
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .news-card .read-more {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 15px;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .news-card .read-more:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .news-card .share-buttons {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 15px;
    }
    
    .news-card .share-buttons h4 {
        color: #fff;
        font-size: 14px;
        margin: 0 0 10px;
        font-weight: 600;
        text-align: center;
    }
    
    .news-card .social-icons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    .news-card .social-icons a,
    .news-card .social-icons button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
        text-decoration: none;
    }
    
    .news-card .social-icons .whatsapp-share {
        background-color: #25D366;
    }
    
    .news-card .social-icons a:hover,
    .news-card .social-icons button:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        opacity: 0.95;
    }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 20px;
    }
    
    .modal-content {
        background-color: white;
        border-radius: 15px;
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-title {
        font-size: 24px;
        color: var(--primary-color); /* Changed from red to primary color */
        margin: 0;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        color: #666;
        font-size: 14px;
    }
    
    .modal-body h2 {
        color: var(--primary-color); /* Changed from red to primary color */
        margin-top: 25px;
        margin-bottom: 15px;
        font-size: 22px;
    }
    
    .modal-body h3 {
        color: var(--dark-color); /* Changed to dark color */
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 18px;
    }
    
    .modal-body p {
        margin-bottom: 15px;
        line-height: 1.6;
        color: #333;
    }
    
    .modal-body ul {
        margin-left: 20px;
        margin-bottom: 15px;
    }
    
    .modal-body li {
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    .contact-section {
        background: #f8f8f8;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
    }
    
    .contact-section h3 {
        color: var(--primary-color); /* Changed from red to primary color */
        margin-bottom: 15px;
    }
    
    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .contact-item i {
        color: var(--primary-color); /* Changed from red to primary color */
    }
    
    /* Responsive modal */
    @media (max-width: 768px) {
        .modal-content {
            max-height: 95vh;
        }
        .modal-title {
            font-size: 20px;
        }
    }
    .copy-link {
        background: #fff;
        border: 2px solid #e0e0e0;
        padding: 8px 25px 8px 8px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        position: relative;
    }

    .copy-link i.fa-copy {
        position: absolute;
        left: 12px;
        font-size: 16px;
        color: var(--primary-color); /* Changed from red to primary color */
        opacity: 0.8;
    }
    
    .copy-link:hover,
    .copy-link:focus {
        background: var(--primary-color); /* Changed from red to primary color */
        color: white;
        border: 2px solid var(--primary-color); /* Changed from red to primary color */
    }
    
    .copy-link:hover i.fa-copy,
    .copy-link:focus i.fa-copy {
        color: #fff;
    }
    
    /* Page update timestamp styles */
    .page-update-stamp {
        text-align: center;
        margin: 20px 0;
        padding: 10px;
        font-size: 14px;
        color: #666;
        border-top: 1px solid #eee;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .page-update-stamp .update-time {
        font-weight: 600;
        color: var(--primary-color);
    }
</style>
<!-- Main Header Strip -->
<div class="main-header-strip">
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    <div class="light-rays">
        <div class="ray"></div>
        <div class="ray"></div>
        <div class="ray"></div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center header-content">
                <h1 class="header-title">NEWS & UPDATES</h1>
                <p class="header-subtitle">Stay informed with the latest news on global education, migration policies, and work opportunities.</p>
            </div>
        </div>
    </div>
</div>
<!-- News Section -->
<div style="min-height:400px; text-align:center;margin-top:30px;">
    <div class="news-container">
        <!-- NEWS ARTICLE 1: Trump's Proposed Rule -->
        <div class="news-card">
            <div class="article-header">
                <h3>Trump's Proposed Rule: Impact on Indian Students in the US</h3>
            </div>
            <div class="article-meta">
                <span>September 04, 2025</span>
                <span>5 min read</span>
            </div>
            <div class="article-content">
                <p>New proposed rules could significantly affect Indian students in the US, including fixed stay durations, shorter grace periods, and restrictions on program changes...</p>
            </div>
            <div class="read-more" data-article="trump-rule">Read Full Article</div>
            <div class="share-buttons">
                <h4>Contact for doubt:</h4>
                <div class="social-icons">
                     <a href="#" class="whatsapp-share" data-title="Trump's Proposed Rule: Impact on Indian Students in the US" data-id="trump-rule">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <button class="copy-link" data-url="https://meritminds.co.in/news.php#trump-rule">
                        <i class="fa fa-copy"></i> 
                    </button>
                </div>
            </div>
        </div>
        
        <!-- NEWS ARTICLE 2: US Visa Policy Change -->
        <div class="news-card">
            <div class="article-header">
                <h3>US Visa Policy Change: Applicants Must Apply in Country of Residence</h3>
            </div>
            <div class="article-meta">
                <span>September 6, 2025</span>
                <span>4 min read</span>
            </div>
            <div class="article-content">
                <p>The U.S. Department of State announces a significant policy change requiring nonimmigrant visa applicants to apply in their country of residence, ending the practice of 'third country filing'...</p>
            </div>
            <div class="read-more" data-article="visa-residence-policy">Read Full Article</div>
            <div class="share-buttons">
                <h4>Contact for doubt:</h4>
                <div class="social-icons">
                    <a href="#" class="whatsapp-share" data-title="US Visa Policy Change: Applicants Must Apply in Country of Residence" data-id="visa-residence-policy">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                       <button class="copy-link" data-url="https://meritminds.co.in/news.php#visa-residence-policy">
                        <i class="fa fa-copy"></i> 
                    </button>
                    
                </div>
            </div>
        </div>
        
        <!-- NEWS ARTICLE 3: Example Article -->
        <div class="news-card">
            <div class="article-header">
                <h3>New Visa Regulations for International Students</h3>
            </div>
            <div class="article-meta">
                <span>September 20, 2025</span>
                <span>4 min read</span>
            </div>
            <div class="article-content">
                <p>Recent changes to visa regulations are making it easier for international students to work while studying, with new pathways to permanent residency...</p>
            </div>
            <div class="read-more" data-article="visa-regulations">Read Full Article</div>
            <div class="share-buttons">
                <h4>Contact for doubt:</h4>
                <div class="social-icons">
                    <a href="#" class="whatsapp-share" data-title="New Visa Regulations for International Students" data-id="visa-regulations">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                       <button class="copy-link" data-url="https://meritminds.co.in/news.php#visa-regulations">
                        <i class="fa fa-copy"></i> 
                    </button>
                    
                </div>
            </div>
        </div>
        
        <!-- NEWS ARTICLE 4: Example Article -->
        <div class="news-card">
            <div class="article-header">
                <h3>Top Scholarships for Indian Students Abroad</h3>
            </div>
            <div class="article-meta">
                <span>September 18, 2025</span>
                <span>6 min read</span>
            </div>
            <div class="article-content">
                <p>A comprehensive guide to the best scholarships available for Indian students planning to study abroad, including application deadlines and eligibility criteria...</p>
            </div>
            <div class="read-more" data-article="scholarships">Read Full Article</div>
            <div class="share-buttons">
                <h4>Contact for doubt:</h4>
                <div class="social-icons">
                    <a href="#" class="whatsapp-share" data-title="Top Scholarships for Indian Students Abroad" data-id="scholarships">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                       <button class="copy-link" data-url="https://meritminds.co.in/news.php#scholarships">
                        <i class="fa fa-copy"></i> 
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Update Timestamp -->
<div class="page-update-stamp">
    Last updated on: <span class="update-time"><?php echo date('F d, Y \a\t g:i A'); ?></span>
</div>

<!-- Article Modal -->
<div class="modal-overlay" id="articleModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Article Title</h2>
            <button class="modal-close" id="closeModal">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Article content will be inserted here -->
        </div>
        <div class="modal-footer">
            <button class="modal-close-bottom" id="closeModalBottom">Close</button>
        </div>
    </div>
</div>
<script>
    // Article data
    const articles = {
        'trump-rule': {
            title: "All about Trump's proposed rule that affects Indian students in US",
            date: "September 04, 2025",
            readTime: "5 min read",
            content: `
                <h2>What's changing</h2>
                <h3>Fixed stay</h3>
                <p>Admission will be tied to program length, capped at four years, with extensions filed directly to DHS (Department of Homeland Security) rather than just through the university.</p>
                
                <h3>Shorter grace</h3>
                <p>Post-completion stay drops from 60 to 30 days, affecting travel plans, status changes, and OPT (Optional Practical Training) timing.</p>
                
                <h3>Fewer early changes</h3>
                <p>No transfers or major switches in the first academic year; graduate students face stricter limits on program changes.</p>
                
                <h2>What it means for Indian students</h2>
                <h3>Plan ahead</h3>
                <p>Map the program timeline, research work, and OPT schedule before starting; build in time for extensions if needed.</p>
                
                <h3>Keep proof ready</h3>
                <p>Maintain transcripts, advisor letters, and progress records to support any extension request.</p>
                
                <h3>Opportunities remain strong</h3>
                <p>Indians are now the largest international student group in the US (3.31 lakh in 2023-24), so admissions and career paths remain robust.</p>
                
                <h2>How Merit Minds Overseas helps</h2>
                <h3>First-year strategy</h3>
                <p>Choose the right program and lock the plan for year one to avoid restricted transfers or switches.</p>
                
                <h3>Visa & extensions</h3>
                <p>End-to-end support for filings, documentation, and OPT/STEM OPT timelines under the proposed four-year framework.</p>
                
                <h3>Transparent timelines</h3>
                <p>Simple checklists and reminders so nothing is missed during degree, OPT, or extension stages.</p>
                
                <div class="contact-section">
                    <h3>Visit our offices</h3>
                    <p>Merit Minds Overseas—Hyderabad, Guntur, Chennai, Bangalore. Walk in for personalized guidance and a clear action plan suited to these proposed changes.</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp: +91 95059 29191</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-instagram"></i>
                            <span>@meritmindsovereseas</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook"></i>
                            <span>facebook.com/MERITMINDS23/</span>
                        </div>
                    </div>
                </div>
            `
        },
        'visa-residence-policy': {
            title: "US Visa Policy Change: Applicants Must Apply in Country of Residence",
            date: "September 6, 2025",
            readTime: "4 min read",
            content: `
                <h2>Major Policy Change in US Visa Application Process</h2>
                <p>The U.S. Department of State has announced a significant policy change affecting nonimmigrant visa applicants worldwide. Starting from the effective date, all nonimmigrant visa applicants must apply for visas in their country of residence or nationality, effectively ending the practice of "third country filing."</p>
                
                <h2>Key Policy Changes</h2>
                <h3>End of Third Country Visa Processing</h3>
                <p>Under the new policy, applicants can no longer schedule visa interviews or submit applications in countries where they are not residents or nationals. This marks a significant shift from previous practices that allowed flexibility in application location.</p>
                
                <h3>Country of Residence Requirement</h3>
                <p>Applicants must demonstrate strong ties to their country of residence, which will be the primary location for visa application processing. This change aims to streamline the visa process and improve security screening.</p>
                
                <h2>Implementation Timeline</h2>
                <p>The policy will be implemented in phases, with full enforcement expected by the end of 2025. The Department of State has stated that this change will help reduce visa processing backlogs and improve efficiency in consular operations.</p>
                
                <h2>Who Is Affected</h2>
                <h3>Tourists and Business Travelers</h3>
                <p>Individuals applying for B1/B2 visas must now return to their home country or country of residence for application processing, which may affect travel plans and increase overall processing time.</p>
                
                <h3>Students and Exchange Visitors</h3>
                <p>F, M, and J visa applicants will need to apply in their country of residence, potentially creating challenges for those currently traveling or studying in third countries.</p>
                
                <h3>Temporary Workers</h3>
                <p>H-1B, L-1, and other temporary work visa applicants must apply in their country of residence, which may require additional planning for those working abroad.</p>
                
                <h2>Exceptions and Special Circumstances</h2>
                <p>Limited exceptions may apply for emergency situations, diplomatic personnel, and certain special visa categories. However, these exceptions will be narrowly interpreted and require prior authorization from the Department of State.</p>
                
                <h2>Impact on Indian Applicants</h2>
                <h3>Planning Considerations</h3>
                <p>Indian citizens residing in India will see minimal impact, as they were already applying primarily within the country. However, those living or traveling abroad will need to return to India for visa processing.</p>
                
                <h3>Processing Times</h3>
                <p>With more applicants directed to their home countries, processing times in India may increase initially. Applicants are advised to plan well in advance and schedule appointments as early as possible.</p>
                
                <h2>How Merit Minds Overseas Can Help</h2>
                <h3>Application Strategy</h3>
                <p>Our experts can help you navigate the new requirements and develop a strategic approach to your visa application timeline.</p>
                
                <h3>Documentation Support</h3>
                <p>We provide comprehensive guidance on preparing the required documentation to demonstrate residence ties and meet the new policy requirements.</p>
                
                <h3>Interview Preparation</h3>
                <p>Our specialized interview preparation sessions will help you address questions related to your residence status and travel plans under the new policy framework.</p>
                
                <div class="contact-section">
                    <h3>Contact Us for Guidance</h3>
                    <p>Merit Minds Overseas is ready to help you understand and adapt to these policy changes. Visit our offices for personalized assistance with your visa application.</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp: +91 95059 29191</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-instagram"></i>
                            <span>@meritmindsovereseas</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook"></i>
                            <span>facebook.com/MERITMINDS23/</span>
                        </div>
                    </div>
                </div>
            `
        },
        'visa-regulations': {
            title: "New Visa Regulations for International Students",
            date: "September 18, 2025",
            readTime: "4 min read",
            content: `
                <h2>Overview of New Regulations</h2>
                <p>Recent changes to visa regulations are making it easier for international students to work while studying, with new pathways to permanent residency. These changes aim to attract more talent and address skill shortages in key industries.</p>
                
                <h2>Key Changes</h2>
                <h3>Extended Work Hours</h3>
                <p>International students can now work up to 24 hours per week during academic sessions, up from the previous limit of 20 hours.</p>
                
                <h3>Post-Graduation Work Permit</h3>
                <p>The post-graduation work permit has been extended to 3 years for all eligible graduates, regardless of their field of study.</p>
                
                <h3>Pathway to Permanent Residency</h3>
                <p>A new points-based system for international graduates makes it easier to transition to permanent residency after completing studies.</p>
                
                <h2>Impact on Students</h2>
                <p>These changes provide more flexibility for students to support themselves financially during studies and offer clearer pathways to build a career in the country after graduation.</p>
                
                <div class="contact-section">
                    <h3>How Merit Minds Can Help</h3>
                    <p>Our experts can guide you through the new regulations and help you make the most of these opportunities. Contact us for personalized advice.</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp: +91 95059 29191</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-instagram"></i>
                            <span>@meritmindsovereseas</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook"></i>
                            <span>facebook.com/MERITMINDS23/</span>
                        </div>
                    </div>
                </div>
            `
        },
        'scholarships': {
            title: "Top Scholarships for Indian Students Abroad",
            date: "September 18, 2025",
            readTime: "6 min read",
            content: `
                <h2>Introduction</h2>
                <p>Studying abroad can be expensive, but numerous scholarships are available for Indian students. This guide covers the best scholarships, their eligibility criteria, and application deadlines.</p>
                
                <h2>Top Scholarships</h2>
                <h3>Fulbright-Nehru Fellowships</h3>
                <p>These fellowships are for Indian students pursuing master's or doctoral degrees in the United States. They cover tuition, airfare, living expenses, and health insurance.</p>
                
                <h3>Commonwealth Scholarships</h3>
                <p>Available for Indian students who want to pursue master's or doctoral studies in the United Kingdom. The scholarship covers tuition fees, living expenses, and travel costs.</p>
                
                <h3>Australia Awards Scholarships</h3>
                <p>These scholarships are for Indian students to study in Australia at the undergraduate or postgraduate level. They cover tuition fees, living expenses, and health insurance.</p>
                
                <h2>Application Tips</h2>
                <h3>Start Early</h3>
                <p>Most scholarship applications open 12-18 months before the start of the academic year. Start preparing well in advance.</p>
                
                <h3>Focus on Extracurriculars</h3>
                <p>Scholarship committees look for well-rounded candidates. Highlight your leadership experience, community service, and special talents.</p>
                
                <h3>Write a Strong Personal Statement</h3>
                <p>Your personal statement should clearly articulate your goals, why you deserve the scholarship, and how you plan to contribute to your field and community.</p>
                
                <div class="contact-section">
                    <h3>Get Expert Guidance</h3>
                    <p>Merit Minds Overseas can help you identify the best scholarships for your profile and guide you through the application process.</p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp: +91 95059 29191</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-instagram"></i>
                            <span>@meritmindsovereseas</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-facebook"></i>
                            <span>facebook.com/MERITMINDS23/</span>
                        </div>
                    </div>
                </div>
            `
        }
    };
    // Modal functionality
    const modal = document.getElementById('articleModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    const closeModalBtn = document.getElementById('closeModal');
    const closeModalBottomBtn = document.getElementById('closeModalBottom');
    
    // Open modal when "Read Full Article" is clicked
    document.querySelectorAll('.read-more').forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.getAttribute('data-article');
            const article = articles[articleId];
            
            if (article) {
                modalTitle.textContent = article.title;
                modalBody.innerHTML = `
                    <div class="modal-meta">
                        <span><i class="far fa-calendar"></i> ${article.date}</span>
                        <span><i class="far fa-clock"></i> ${article.readTime}</span>
                    </div>
                    ${article.content}
                `;
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            }
        });
    });
    
    // Function to close modal
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scrolling
    }
    
    // Close modal when close button is clicked
    closeModalBtn.addEventListener('click', closeModal);
    
    // Close modal when bottom close button is clicked
    closeModalBottomBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside the modal content
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // WhatsApp share functionality with article ID
    document.querySelectorAll('.whatsapp-share').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const title = button.getAttribute('data-title');
            const articleId = button.getAttribute('data-id');
            const phoneNumber = '917036283571'; // +91 70362 83571 without spaces or +
            const currentUrl = window.location.href.split('#')[0]; // Get current page URL without fragment
            const articleUrl = `${currentUrl}#${articleId}`; // Add article ID as fragment
            const message = `Hi, I have a doubt about this article: ${title}. Please check: ${articleUrl}`;
            window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
        });
    });
    
    // Check for article ID in URL fragment on page load
    window.addEventListener('load', function() {
        const hash = window.location.hash.substring(1); // Remove the # character
        if (hash && articles[hash]) {
            const article = articles[hash];
            modalTitle.textContent = article.title;
            modalBody.innerHTML = `
                <div class="modal-meta">
                    <span><i class="far fa-calendar"></i> ${article.date}</span>
                    <span><i class="far fa-clock"></i> ${article.readTime}</span>
                </div>
                ${article.content}
            `;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    });
    // Copy Link functionality
    document.querySelectorAll('.copy-link').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const articleUrl = button.getAttribute('data-url');
            navigator.clipboard.writeText(articleUrl).then(function() {
                // Simple feedback: show "Copied!" text temporarily
                button.innerHTML = '<i class="fa fa-copy"></i> Copied!';
                setTimeout(() => {
                    button.innerHTML = '<i class="fa fa-copy"></i> Copy';
                }, 1200);
            });
        });
    });

</script>

<style>
    /* Modal footer styles */
    .modal-footer {
        padding: 15px;
        text-align: center;
        border-top: 1px solid #eee;
    }
    
    .modal-close-bottom {
        background-color: var(--primary-color); /* Changed from red to primary color */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    
    .modal-close-bottom:hover {
        background-color: var(--dark-color); /* Changed to dark color */
    }
</style>
<?php include 'footer.php'?>
</body>
</html>