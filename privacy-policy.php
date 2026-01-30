<?php
// Privacy Policy Page
$pageTitle = "Privacy Policy - MeritMinds Overseas";
$metaDescription = "Read our Privacy Policy to understand how MeritMinds Overseas collects, uses, and protects your personal information.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <title><?php echo $pageTitle; ?></title>

    <style>
        /* Privacy Policy Page Specific Styles */
        .policy-page {
            background: #f8f9fa;
            padding: 40px 0;
        }

        .policy-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .policy-header {
            background: linear-gradient(135deg, #004aad 0%, #0062e0 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
            margin-bottom: 40px;
            border-radius: 12px;
        }

        .policy-header h1 {
            font-size: 42px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .policy-header .last-updated {
            font-size: 16px;
            opacity: 0.9;
        }

        .policy-content {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .policy-content h2 {
            font-size: 28px;
            color: #004aad;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #22b7cb;
        }

        .policy-content h2:first-child {
            margin-top: 0;
        }

        .policy-content h3 {
            font-size: 22px;
            color: #004aad;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .policy-content h4 {
            font-size: 18px;
            color: #004aad;
            margin-top: 20px;
            margin-bottom: 12px;
        }

        .policy-content p {
            margin-bottom: 15px;
            color: #555;
            line-height: 1.7;
            font-size: 15px;
        }

        .policy-content ul {
            margin: 15px 0;
            padding-left: 40px;
        }

        .policy-content li {
            margin-bottom: 10px;
            color: #555;
            line-height: 1.6;
        }

        .policy-content a {
            color: #004aad;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: border-color 0.3s;
            font-weight: 500;
        }

        .policy-content a:hover {
            border-bottom-color: #004aad;
        }

        .info-box {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #22b7cb;
            margin: 20px 0;
        }

        .info-box p {
            margin-bottom: 10px;
        }

        .info-box p:last-child {
            margin-bottom: 0;
        }

        .highlight-box {
            background: #fff9e6;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #d21c31;
            margin: 20px 0;
        }

        .intro-text {
            font-size: 16px;
            color: #333;
            line-height: 1.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .policy-header {
                padding: 40px 20px;
            }

            .policy-header h1 {
                font-size: 32px;
            }

            .policy-content {
                padding: 30px 20px;
            }

            .policy-content h2 {
                font-size: 24px;
            }

            .policy-content h3 {
                font-size: 20px;
            }

            .policy-content h4 {
                font-size: 17px;
            }

            .policy-content p,
            .policy-content li {
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .policy-header h1 {
                font-size: 28px;
            }

            .policy-content {
                padding: 20px 15px;
            }

            .policy-content h2 {
                font-size: 22px;
            }

            .policy-content h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="policy-page">
    <div class="policy-container">
        <div class="policy-header">
            <h1>Privacy Policy</h1>
            <p class="last-updated">Last updated: January 27, 2026</p>
        </div>

        <div class="policy-content">
            <div class="info-box">
                <p><strong>MeritMinds Overseas</strong> is committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your personal information when you use our website and services.</p>
            </div>

            <p class="intro-text">MeritMinds Overseas is committed to ensure that your Privacy is protected. Should we ask you to provide certain information by which you can be identified when using this website then you can be assured that it will only be used in accordance with this Privacy Statement.</p>

            <p class="intro-text">MeritMinds Overseas may change this policy from time to time by updating this page. You should check this page from time to time to ensure that you are happy with any changes.</p>

            <h2>What We Collect</h2>
            <p>We may collect the following information:</p>
            <ul>
                <li>Name and Job Title</li>
                <li>Contact Information including Email Address, Mobile Number</li>
                <li>Demographic Information such as Postcode, Preferences and Interests</li>
                <li>Other Information relevant to Customer Surveys and/or Offers</li>
                <li>Data entered by the user on the website in their secured account (subject to terms and conditions issued under the user license)</li>
            </ul>

            <p>Information we gather can be categorized in two types:</p>

            <h3>1. Information Submitted Directly by Users</h3>
            <p>There are two types of user-submitted information we collect: <strong>Public</strong> and <strong>Private</strong>.</p>

            <h4>Public Information</h4>
            <p>We define Public information as Personal Information that may be displayed on the site at the behest of the member, such as:</p>
            <ul>
                <li>Organization Name</li>
                <li>Services offered by the Organization</li>
                <li>Facts and Figures provided on Historical Performance</li>
                <li>Logos and Business References</li>
                <li>Customer-Specified Username</li>
                <li>Telephone Number</li>
                <li>Directors name</li>
                <li>Business Website</li>
            </ul>

            <h4>Private Information</h4>
            <p>This information is gathered from members who apply for the various services our site offers. This information includes, but is not limited to:</p>
            <ul>
                <li>Email Address</li>
                <li>First Name, Last Name</li>
                <li>Credit Card Number or Checking Account Information for Payment</li>
                <li>User-Specified Password</li>
                <li>Mailing Address, Zip Code</li>
                <li>Telephone Number</li>
                <li>Student profile details</li>
            </ul>

            <p>MeritMinds Overseas also allows members to submit Public and Private Information on behalf of others. If they do not wish this information to be displayed, they have the option to request removal of such information after providing the necessary evidence that the information pertains to them.</p>

            <h4>Surveys & Contests</h4>
            <p>From time-to-time our site requests information from users via surveys or contests. Participation in these surveys or contests is completely voluntary and the user therefore has a choice whether or not to disclose this information.</p>

            <h4>Testimonials</h4>
            <p>Satisfied users of MeritMinds Overseas have chosen to post testimonials on our website. All permissions have been obtained to post these testimonials.</p>

            <h3>2. Information Not Submitted Directly by Users</h3>

            <h4>Aggregate Information</h4>
            <p>This information that we collect is not Personally Identifiable, such as:</p>
            <ul>
                <li>Browser Type and IP Address</li>
                <li>This information is gathered for all users to the site</li>
                <li>At times information is gathered from the user's Organizations Website</li>
            </ul>

            <h2>What We Do With The Information We Gather</h2>
            <p>We require this information to understand your needs and provide you with a better service, and in particular for the following reasons:</p>
            <ul>
                <li><strong>Internal Record Keeping:</strong> Maintaining accurate records of your interactions with us</li>
                <li><strong>Improve our Products and Services:</strong> Using feedback to enhance our offerings</li>
                <li><strong>Send Relevant Content:</strong> Sending you relevant interests and enquiries as per the preferences added under your account</li>
                <li><strong>Promotional Communications:</strong> Periodic promotional emails about new products, special offers or other information which we think you may find interesting using the email address which you have provided</li>
                <li><strong>Market Research:</strong> We may contact you by email, phone, fax or mail for market research purposes</li>
                <li><strong>Website Customization:</strong> Customize the website according to your interests</li>
                <li><strong>Profile Improvement:</strong> Student profile details excluding the student name and contact details, for improving the short-listing algorithm and product features</li>
                <li><strong>Personal Consultation:</strong> We will connect with you over a phone call to better understand your academic profile & connect you with a suitable counsellor as per your profile</li>
            </ul>

            <h2>Security</h2>
            <div class="highlight-box">
                <p><strong>We are committed to ensuring that your information is secure.</strong></p>
                <p>In order to prevent Unauthorized Access or Disclosure, we have put in place suitable Physical, Electronic and Managerial procedures to safeguard and secure the information we collect online.</p>
            </div>

            <h2>How We Use Cookies</h2>
            <p>A Cookie is a small file, which asks permission to be placed on your computer's hard drive. Once you agree, the file is added and the Cookie helps analyze Web Traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.</p>

            <p>We use Traffic Log Cookies to identify which pages are being used. This helps us analyze data about web page traffic and improve our website in order to tailor it to customer needs. We only use this information for Statistical Analysis purposes and then the data is removed from the system.</p>

            <p>Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.</p>

            <p>You can choose to <strong>Accept or Decline Cookies</strong>. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.</p>

            <h2>Links to Other Websites</h2>
            <p>Our website may contain links to other websites of interest. However, once you have used these links to leave our site, you should note that we do not have any control over that other website. Therefore, we cannot be responsible for the Protection and Privacy of any information, which you provide whilst visiting such sites and this Privacy Statement does not govern such sites. You should exercise caution and look at the privacy statement applicable to the website in question.</p>

            <h2>Controlling Your Personal Information</h2>
            <p>You may choose to restrict the collection or use of your personal information in the following ways:</p>

            <ul>
                <li><strong>Opt-out of Marketing:</strong> Whenever you are asked to fill in a form on the website, look for the box that you can click to indicate that you do not want the information to be used by anybody for direct marketing purposes.</li>
                <li><strong>Change Your Preferences:</strong> If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to or emailing us on <a href="mailto:info@meritminds.com">info@meritminds.com</a> or by clicking on unsubscribe link in the emails sent to you.</li>
                <li><strong>Third Party Sharing:</strong> We will not Sell, Distribute or Lease your Personal Information to Third Parties unless we have your permission or are required by law to do so. We may use your Personal Information to send you Promotional Information about Third Parties, which we think you may find interesting if you tell us that you wish this to happen.</li>
            </ul>

            <h2>Access to Your Information</h2>
            <p>You may request details of personal information, which we hold about you governed under the Data Protection and our Privacy Policy. A small fee may be payable. If you would like a copy of the information held on you please write to us.</p>

            <div class="info-box">
                <p><strong>Contact Us:</strong></p>
                <p>Email: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>
                <p>Address: MeritMinds Overseas, Guntur, Andhra Pradesh, India</p>
            </div>

            <p>If you believe that any information we are holding on you is incorrect or incomplete, please write or email us as soon as possible, at the above address. We will promptly correct any information found to be incorrect.</p>

            <h2>Data Protection Rights</h2>
            <p>You have the following rights regarding your personal data:</p>
            <ul>
                <li><strong>Right to Access:</strong> You have the right to request copies of your personal data</li>
                <li><strong>Right to Rectification:</strong> You have the right to request that we correct any information you believe is inaccurate or incomplete</li>
                <li><strong>Right to Erasure:</strong> You have the right to request that we erase your personal data, under certain conditions</li>
                <li><strong>Right to Restrict Processing:</strong> You have the right to request that we restrict the processing of your personal data, under certain conditions</li>
                <li><strong>Right to Object:</strong> You have the right to object to our processing of your personal data, under certain conditions</li>
                <li><strong>Right to Data Portability:</strong> You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions</li>
            </ul>

            <h2>Children's Privacy</h2>
            <p>Our services are not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us so that we can delete such information.</p>

            <h2>Changes to This Privacy Policy</h2>
            <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date at the top of this Privacy Policy.</p>

            <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>

            <h2>Contact Information</h2>
            <p>If you have any questions about this Privacy Policy, please contact us:</p>

            <div class="info-box">
                <p><strong>MeritMinds Overseas</strong></p>
                <p>Email: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>
                <p>Address: Guntur, Andhra Pradesh, India</p>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>