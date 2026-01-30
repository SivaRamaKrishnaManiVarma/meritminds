<?php
// GDPR & Cookies Policy Page
$pageTitle = "GDPR & Cookies Policy - MeritMinds Overseas";
$metaDescription = "Read our GDPR and Cookies Policy to understand how MeritMinds Overseas collects, uses, and protects your personal data.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <title><?php echo $pageTitle; ?></title>

    <!-- Include your main CSS file if needed -->
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->

    <style>
        /* GDPR Policy Page Specific Styles */
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

        .address-box {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #22b7cb;
            margin: 20px 0;
        }

        .address-box p {
            margin-bottom: 10px;
        }

        .address-box p:last-child {
            margin-bottom: 0;
        }

        .highlight-box {
            background: #fff9e6;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #d21c31;
            margin: 20px 0;
        }

        .highlight-box ul {
            margin-top: 10px;
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
            <h1>GDPR & Cookies Policy</h1>
            <p class="last-updated">Last updated: January 27, 2026</p>
        </div>

        <div class="policy-content">
            <p>At MeritMinds Overseas, we deeply believe in the protection of your data and privacy and we care how it applies to you, as a user of our website(s). In this Cookies Policy ('Policy'), you can find information about how, whether, and why we collect and use your personal information. This Policy applies to any personal information that is gathered when you use our services, visit our Website, or otherwise interact with us. We have divided this Policy into different sections. Please go to the relevant section below for further information. The processing of your personal data complies with the General Data Protection Regulation ('GDPR'), the Dutch GDPR Execution Act and the Dutch Telecommunications Act.</p>

            <h2>About Us</h2>
            <p>We are MeritMinds Overseas, in the rest of this document referred to as MeritMinds Overseas or "we".</p>

            <div class="address-box">
                <p><strong>Headquarters:</strong><br>
                Guntur, Andhra Pradesh, India</p>
                <p>For more information, please contact us at: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>
            </div>

            <p>Please note that some of the processing described in this Policy we undertake as controller, but for some of the processing we may merely act as processor and the educational institutions and other organisations for which we collected your information or to whom we disclosed your personal information, which will act as controller. Please check the privacy policy of the educational institutions concerned to find out how they process your personal data.</p>

            <h2>Types of Personal Data We Process</h2>

            <h3>General</h3>
            <p>We may collect and process, whether or not on our own behalf or on behalf of one or more educational institutions, the following categories of personal information:</p>

            <h3>Name, email address and other identifying information</h3>
            <p>For example, we may record your name, email address, gender, date of birth, nationality, country of residence, education history, achievements, or language test scores. If you opt to use our Best Fit tool, we may also record your work experience and funding situation.</p>

            <h3>Your contact details and personal account/registration details</h3>
            <p>Your contact details may include: your address, telephone number, and email address. When you create a personal account or register for a service, we may also record your sign-in details and other information you provide when you create your personal account or fill in a registration form.</p>

            <h3>Our communication with you</h3>
            <p>When you send us an email, or chat with us online or via social media, we save your correspondence with us.</p>

            <h3>Information we collect when you use our Website</h3>
            <p>When you visit our Website or use our services, we may register your IP address, browser type, operating system, referring website, web-browsing behaviour.</p>
            <p>We may receive an automatic notification when you open (or open a link from) a newsletter.</p>

            <h3>Information in relation to social media</h3>
            <p>Depending on your social network settings, we may receive information from your social network provider. For example, when you sign in for our services using a social network account, we may gather publicly available information you give us access to from your social network profile, including your contact details, interests, and social network. For more information on the personal data that we receive from your social network provider, and how to change your privacy settings, please refer to the website and the privacy policy given by your social network provider.</p>

            <h3>Information you choose to share with us</h3>
            <p>You may also choose to share information with us. For example, when you leave a comment for us on Facebook, fill out a survey, submit a contact or application form, leave a review or submit an entry for a contest or scholarship, you have opted to share personal information with us.</p>

            <h3>Cookies and similar technologies</h3>
            <p>When you use our Website for the first time, a cookie notice is shown. MeritMinds Overseas uses the information collected through cookies strictly for the purposes stated in the Cookie Statement, found below.</p>

            <h2>How We Collect Your Data</h2>
            <p>MeritMinds Overseas collects personal information in a number of ways. Information is obtained, for example, when you visit our Website, register on our Website, communicate with us via social media, or subscribe to our newsletter.</p>
            <p>We may also receive personal information from associated educational institutions, subsidiaries, partners, or other service providers.</p>
            <p>We collect some information by accessing your publicly available data, such as your Facebook or LinkedIn public profile.</p>

            <h2>Purposes of Processing Your Data</h2>

            <h3>Providing services to you</h3>
            <p>MeritMinds Overseas processes personal data to provide our services. For example, personal data is processed so:</p>
            <ul>
                <li>Based on the country or field of study that you choose, we can send you programme recommendations that we believe best match your profile.</li>
                <li>To make your user experience easier and more effective, we may assess how you use our services, and combine this data with information collected via your personal account, registration details, cookies, and similar technologies.</li>
                <li>You can contact education institutes through our Website, by means of an electronic form. By sending an enquiry, you also create your own user account, enabling you to view the inquiries you sent.</li>
            </ul>
            <p>For these purposes, MeritMinds Overseas processes the following personal data: name, digital contact details, demographic information, shortlisted programmes, disciplines and countries of interest, funding situation, preferred start period, previous education information, work experience.</p>

            <h3>To communicate with you</h3>
            <p>MeritMinds Overseas processes contact details to communicate with you, answer your questions, or handle your complaints. This applies to both students and (potential) clients/customers/partners.</p>
            <p>For this purpose, MeritMinds Overseas processes the following personal data: communication history, name, digital contact details, message. For (potential) clients, the following data is also processed: phone number, employer, country.</p>

            <h3>For processing student applications for specific universities</h3>
            <p>MeritMinds Overseas processes personal information to enable students to apply for specific universities through MeritMinds Overseas rather than through the university website. For this processing of your personal data information, MeritMinds Overseas will act as a mere processor processing your information on behalf of the educational institution concerned.</p>
            <p>For this purpose, MeritMinds Overseas processes the following personal data on behalf of the educational institution: name, digital contact details, analog contact details, passport, educational transcripts, CV, various credentials (e.g. English language proficiency), demographic information, shortlisted programmes, disciplines and countries of interest, funding situation, preferred start period, previous education information, work experience.</p>

            <h3>Allowing you to provide reviews</h3>
            <p>MeritMinds Overseas processes personal information when you have left behind a review about a specific educational institution or a specific program.</p>
            <p>For those purposes, MeritMinds Overseas processes the following personal data: programme, educational institution, personal life and overall experience with respect to the educational institute and its location.</p>

            <div class="highlight-box">
                <p><strong>We only remove reviews in the following situations:</strong></p>
                <ul>
                    <li>If MeritMinds Overseas or another organisation can prove a respondent did not study at the reviewed institution.</li>
                    <li>When the review includes abusive language, swearing, discriminatory remarks, or threatening content.</li>
                    <li>When the review promotes illegal or commercial activities.</li>
                    <li>If the review is written 5+ years after studying at the institution.</li>
                    <li>If reviews contain contact details or links to other websites.</li>
                    <li>If a review violates intellectual property or privacy rights.</li>
                </ul>
                <p>If you come across a review that includes any of the above, let us know: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>
            </div>

            <h3>For statistical research</h3>
            <p>MeritMinds Overseas processes personal information for the development and optimisation of its services. We use automatic tools to perform statistical research into general trends. We broadly examine how our users behave towards our services, as well as the preferences our users set. Statistical research helps us develop better services and offerings, allowing us to improve the design and content of our Website.</p>

            <h3>For direct marketing purposes</h3>
            <p>MeritMinds Overseas processes personal information for (direct) marketing purposes. This means we may use your personal information to send you newsletters, promotions, or other marketing communications. We use the results of our analysis to tailor our marketing communications to your specific interests and preferences.</p>
            <p>You may object or revoke your consent for receiving marketing communications at any time, by following the instructions in the relevant marketing communication or by sending an email to: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>

            <h3>To initiate and evaluate business relationships</h3>
            <p>Your personal data will be processed for the entering into agreements and the performance thereof to the point of commercial services and the managing of the business relations which emerge from them, including the performance of activities aimed at the expansion of our client database.</p>

            <h2>Disclosing or Sharing Data with Third Parties</h2>

            <h3>General</h3>
            <p>We reserve the right to release personal information without your consent or without consulting you, when we deem it necessary to comply with our legal obligations, to enforce our terms and conditions, to protect the security of this Website, or to prevent fraud.</p>

            <h3>Other institutions or businesses</h3>
            <p>You can contact education institutes through our Website, by means of an electronic form. The details in your inquiry will then be shared with the institute you are trying to contact.</p>
            <p>We may share personally identifiable information (such as name, nationality, and email address) with carefully selected education institutions, to verify the status of your application or enrolment, evaluate and manage the performance of our business agreements or initiate new agreements. Some of these institutions may also have access to your information so that they may consider further marketing campaigns or recruitment measures.</p>

            <h3>Third party websites</h3>
            <p>Our Website contains links to third-party websites. If you follow these links, you will exit our Website. This Policy does not apply to third-party websites. MeritMinds Overseas cannot accept liability for the ways in which these third-party websites use of your personal data. You use these websites at your own risk. For more information on how these third parties treat your personal information, please check their respective privacy policies (if available).</p>

            <h3>Other countries</h3>
            <p>MeritMinds Overseas may transfer your personal data to countries outside of your country of residence. This might occur in the course of sharing information with education institutions or our subsidiaries, with whom we have explicit agreements with how they can or cannot use the data. In most cases, these agreements will be in the form of a written and signed Data Processing Agreement.</p>
            <p>If you contact, apply to, or enrol at, an education institution through MeritMinds Overseas which is located outside your country, your data will necessarily be transferred to that country.</p>

            <h2>Security and Retention</h2>
            <p>MeritMinds Overseas takes the safeguarding of your information very seriously. MeritMinds Overseas will take appropriate technical and organizational measures to protect your personal data against loss or unlawful use. These measures include but are not limited to: facilities protected by appropriate security measures, encryption of devices, version tracking and access to our databases is limited to key personnel and IP addresses and use of it is logged. Personally identifiable information and account activity are also protected through the use of user names and passwords. In order to help maintain the security of your information, you should protect the confidentiality of your user name and password.</p>
            <p>Your personal data will be retained for as long as required for the purposes described in this Policy, or insofar as is necessary to comply with our contractual or statuary obligations, and to solve any disputes. In most cases, your personal data will be retained for forty-eight (48) months after your last activity, or until you request deletion. MeritMinds Overseas retains your data for that period to optimize their services to you throughout your educational period.</p>

            <h2>Your Rights</h2>
            <p>You can request access to or a copy of your personal data collected by us. You may also request the rectification and removal of personal data or the restriction of the processing of your personal data, if there is a reason for doing so. You also have the right to data portability. You also have the right to object to a processing on grounds relating to your particular situation or against the processing of your personal data for direct marketing purposes.</p>

            <div class="address-box">
                <p><strong>To exercise your right(s), please send your written request to:</strong></p>
                <p>Email: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>
                <p><strong>or</strong></p>
                <p>MeritMinds Overseas<br>
                Guntur, Andhra Pradesh, India</p>
            </div>

            <p>In order to ensure that the request you are submitting on your behalf is legitimate, in some cases it may be necessary for us to obtain further proof of identity either in person or via webcam. This is only necessary in those cases where we have doubts about the identity of the person submitting the request.</p>

            <h2>Modifications to this Policy</h2>
            <p>This Policy is effective as of January 27, 2026 and replaces our previous privacy policy. We reserve the right to alter or otherwise make changes to this Policy. We will notify you of any changes by posting the revised policy on our Website and notifying you through a banner or in case of very material changes to the Policy, via email. Changes take effect as soon as the Policy is posted.</p>

            <h2>Questions or Complaints</h2>
            <p>If you have any question or complaints about the processing of your personal data, please send an email to us at <a href="mailto:info@meritminds.com">info@meritminds.com</a>. We will be happy to assist you.</p>

            <h2>Cookie Statement MeritMinds Overseas</h2>
            <p><em>Last updated January 27, 2026.</em></p>

            <h3>About Cookies</h3>
            <p>Websites use techniques that increase user-friendliness and make the websites as interesting as possible for each visitor. The best-known examples of such techniques are cookies and scripts (hereafter 'cookies'). Cookies may be used by website owners or by third parties – advertisers, for example – who communicate via the website you visit.</p>
            <p>The use of cookies is safe. No personal information, such as a telephone number or an e-mail address, can be traced back to cookies. As a result, cookies cannot be used for e-mail and telemarketing actions.</p>
            <p>We think it is important that you know which cookies our Website uses and for which purposes they are used. We want to guarantee your privacy and user-friendliness as much as possible. Below you can read more about the cookies that are used by and through our Website and for which purposes.</p>

            <h3>For which purposes do we use cookies?</h3>
            <p>We use cookies for the following reasons:</p>
            <ul>
                <li>To make sure the Website functions properly</li>
                <li>To measure usage of the Website</li>
                <li>To display advertisements on our Website and on others' Websites</li>
                <li>To measure the relevance of our information and your interest in the educational offer</li>
            </ul>

            <h3>Cookies to measure usage of the Website</h3>
            <p>In order to determine which parts of the Website are most interesting for our visitors, we continuously try to measure, with the help of third-party software, the number of visitors to our Website and the most frequently viewed parts. We use cookies for this purpose.</p>
            <p>The information we collect in this way is used to compile statistics. These statistics give us insight into how often our web page is visited, where exactly visitors spend most of their time, and so on. This enables us to make the structure, navigation and content of the Website as user-friendly as possible for you. The statistics and other reports are not traced back to persons unless they register on the Website.</p>
            <p>For the cookies that our third parties place and the possible data that they collect, we refer to the statements that these parties provide on their own websites about this; see the links below. Please note that these statements are subject to change on a regular basis. We have no influence over that.</p>
            <ul>
                <li>Google Analytics: <a href="https://www.google.com/policies/privacy/" target="_blank" rel="noopener">https://www.google.com/policies/privacy/</a></li>
            </ul>

            <h3>Cookies for the display of advertisements</h3>
            <p>These cookies are used by advertising networks who act as intermediaries between MeritMinds Overseas and advertisers. They are used to show relevant, personalised advertisements or offers through every type of medium (e.g. e-mail, social media, banner ads) based on your behaviour on our Website. They are also used for remarketing advertisements.</p>
            <p>These cookies are used to:</p>
            <ul>
                <li>Show relevant, personalised advertisements or offers through every type of medium based on your behaviour on our Website and other websites.</li>
                <li>Limit the number of times each advertisement is displayed.</li>
                <li>Measure the effectiveness of an advertising campaign.</li>
                <li>Make a link to social media, so that you can be recognised when you wish to use social media through MeritMinds Overseas' Website.</li>
            </ul>
            <p>If such cookies are not used, you will still see advertisements. This is because advertisements are also shown which do not use cookies. These advertisements may, for example, be adapted to the content of the Website.</p>

            <h3>Other / Unforeseen Cookies</h3>
            <p>Due to the way the internet and websites work, we may not always have insight into the cookies that are placed by third parties via our Website. This is particularly the case if our web pages contain so-called embedded elements; these are texts, documents, images or films that are stored with another party, but which are shown on, in or via our Website.</p>
            <p>If you encounter cookies on this Website that fall into this category and which we have not mentioned above, please let us know at <a href="mailto:info@meritminds.com">info@meritminds.com</a>. Or contact the third party directly and ask which cookies they have placed, what the reason is, what the life span of the cookie is and how they have safeguarded your privacy.</p>

            <h3>Browser Settings</h3>
            <p>If you do not want websites to place cookies on your computer at all, you can change your browser settings so that you receive a warning before cookies are placed. You can also change the settings in such a way that your browser rejects all cookies or only the cookies of third parties. You can also delete cookies that have already been placed. Please note that you will need to change the settings separately for each browser and computer you use.</p>
            <p>Please be aware that if you do not want cookies, we will no longer be able to guarantee that our Website is working properly. It is possible that some functions of the Website are lost or even that you can't see certain websites at all. In addition, the refusal of cookies does not mean that you will no longer see any advertisements. The ads will no longer be tailored to your interests and will be repeated more often.</p>
            <p>How to adjust your settings varies from browser to browser. If necessary, consult the help function of your browser. If you want to disable cookies from specific parties, you can do so via <a href="https://www.youronlinechoices.com" target="_blank" rel="noopener">www.youronlinechoices.com</a></p>

            <h3>Final Remarks</h3>
            <p>We will have to amend these statements from time to time, for example because our Website or the rules surrounding cookies change. We may change the content of the statements and the cookies included in the lists at any time and without prior warning. You can consult this web page for the latest version.</p>
            <p>If you have any questions or remarks, please contact: <a href="mailto:info@meritminds.com">info@meritminds.com</a></p>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>