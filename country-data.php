<?php
function getCountryData($countryCode) {
    $countries = [

        // ---------------- GERMANY ----------------
        'germany' => [
            'name' => 'Germany',
            'flag_emoji' => '🇩🇪',
            'hero_image' => 'assets/imgs/GERMANY.jpg',
            'hero_title' => 'Study in Germany',
            'hero_subtitle' => 'Your Gateway to a Global Future',

            'intro_text' => 'At Merit Minds Overseas, we provide expert guidance on studying in Germany. From selecting the best universities to handling the application and visa process, we are with you every step of the way.',
            'intro_image' => 'assets/imgs/GERMANY.jpg',
            'intro_points' => [
                'Discover leading universities and programs.',
                'Get advice on applications, scholarships, and financial planning.',
                'Learn about life as an international student in Germany.',
                'Receive support throughout your educational journey.',
            ],

            'why_choose' => [
                'title' => 'Why Choose Germany?',
                'subtitle' => 'With a rich academic heritage and a diverse cultural landscape, Germany offers an exceptional study experience.',
                'benefits' => [
                    [
                        'icon' => 'ti-user',
                        'title' => 'World-Class Education',
                        'text'  => 'Germany is home to top universities with highly regarded academic programs and cutting-edge research opportunities.'
                    ],
                    [
                        'icon' => 'ti-bar-chart-alt',
                        'title' => 'Affordable Education',
                        'text'  => 'Many public universities offer very low or no tuition fees for international students.'
                    ],
                    [
                        'icon' => 'ti-briefcase',
                        'title' => 'Cultural Immersion',
                        'text'  => 'Experience Germany’s rich culture and history while gaining global exposure.'
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '400+',      'label' => 'Universities'],
                ['icon' => '💰', 'number' => '€0–350',   'label' => 'Tuition / Semester'],
                ['icon' => '💼', 'number' => '18 Months', 'label' => 'Post‑Study Work Visa'],
                ['icon' => '⏰', 'number' => '20 hrs/wk', 'label' => 'Part‑Time Work'],
            ],

            'universities' => [
                [
                    'name' => 'Technical University of Munich',
                    'rank' => 'QS Rank: 37',
                    'specialization' => 'Engineering, Technology, Natural Sciences',
                    'flag' => 'assets/imgs/flags/germany.png',
                ],
                [
                    'name' => 'Ludwig Maximilian University of Munich',
                    'rank' => 'QS Rank: 54',
                    'specialization' => 'Arts, Humanities, Social Sciences',
                    'flag' => 'assets/imgs/flags/germany.png',
                ],
                [
                    'name' => 'Heidelberg University',
                    'rank' => 'QS Rank: 87',
                    'specialization' => 'Medicine, Law, Life Sciences',
                    'flag' => 'assets/imgs/flags/germany.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => [
                    'label'  => 'Tuition Fees (Public Universities)',
                    'amount' => '€0 – €350 / Semester',
                ],
                'living' => [
                    'label'  => 'Living Costs',
                    'amount' => '€850 – €1,200 / Month',
                ],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',      'cost' => '€300 – €500'],
                    ['item' => '🍽️ Food & Groceries',  'cost' => '€200 – €250'],
                    ['item' => '🚇 Transportation',     'cost' => '€80 – €100'],
                    ['item' => '📱 Internet & Phone',   'cost' => '€30 – €50'],
                    ['item' => '🎯 Other Expenses',     'cost' => '€100 – €200'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    'Valid 10+2 certificate for Bachelor’s programs.',
                    'Bachelor’s degree for Master’s programs.',
                    'Minimum 60–70% aggregate, depending on course/university.',
                    'Recognised school or university credentials.',
                ],
                'language' => [
                    'IELTS 6.0+ or TOEFL iBT 80+ for English‑taught programs.',
                    'TestDaF or DSH for German‑taught programs.',
                    'GRE / GMAT for selected programs.',
                    'Valid passport and proof of funds for visa.',
                ],
            ],

            'application_process' => [
                [
                    'step' => 1,
                    'title' => 'Profile Evaluation & Counselling',
                    'description' => 'Assess your academic background and career goals to shortlist suitable German universities and courses.',
                ],
                [
                    'step' => 2,
                    'title' => 'Test Preparation',
                    'description' => 'Prepare for IELTS/TOEFL and, if required, GRE/GMAT or German language tests with our coaching support.',
                ],
                [
                    'step' => 3,
                    'title' => 'Applications & Documents',
                    'description' => 'We help craft SOPs, arrange LORs and submit complete applications within university deadlines.',
                ],
                [
                    'step' => 4,
                    'title' => 'Visa File & Interview',
                    'description' => 'End‑to‑end support for blocked account, visa documentation and embassy interview preparation.',
                ],
                [
                    'step' => 5,
                    'title' => 'Pre‑Departure & Arrival',
                    'description' => 'Guidance on accommodation, travel and settling‑in once you land in Germany.',
                ],
            ],

            'testimonials' => [
                [
                    'name'       => 'Tanishq Kondru',
                    'university' => 'University of Minnesota',
                    'rating'     => 5,
                    'text'       => 'Incredibly grateful to MERIT MINDS OVERSEAS for personalized advice and meticulous visa interview preparation. Highly recommend for studying abroad.',
                    'color'      => '#7d6ef3',
                ],
                [
                    'name'       => 'Gopalakrishna Reddy Manukonda',
                    'university' => 'University of Florida',
                    'rating'     => 5,
                    'text'       => 'Exceptional support throughout my study journey, from exam preparation to visa approval. Expert guidance made everything seamless.',
                    'color'      => '#239bca',
                ],
                [
                    'name'       => 'Monisha Thota',
                    'university' => 'New York Institute of Technology',
                    'rating'     => 5,
                    'text'       => 'Heartfelt gratitude for moral support, dedication and outstanding guidance during my application and visa preparation.',
                    'color'      => '#ad37c2db',
                ],
            ],

            'cta' => [
                'title'       => 'Begin Your Journey to Germany',
                'subtitle'    => 'Book a free counselling session with our Germany experts and get a personalised roadmap for your profile.',
                'button_text' => 'Book Free Consultation',
                'phone'       => '+91 9505889191',
            ],
        ],

        // ---------------- USA ----------------
        'usa' => [
            'name' => 'USA',
            'flag_emoji' => '🇺🇸',
            'hero_image' => 'assets/imgs/USA.jpg',
            'hero_title' => 'Study in USA',
            'hero_subtitle' => 'Your Gateway to World‑Class Education',

            'intro_text' => 'At Merit Minds Overseas, we offer a comprehensive overview of education opportunities in the USA. Our experts guide you from university shortlisting to visa approval.',
            'intro_image' => 'https://st3.depositphotos.com/1005891/35853/i/450/depositphotos_358531720-stock-photo-american-flag-on-old-flagpole.jpg',
            'intro_points' => [
                'Explore top‑ranking universities and programs.',
                'Get expert advice on every step of the application process.',
                'Understand life, costs and part‑time options in the USA.',
                'Receive ongoing support right up to your admission.',
            ],

            'why_choose' => [
                'title' => 'Why Study in the USA?',
                'subtitle' => 'The USA is home to the world’s best universities and unmatched career opportunities.',
                'benefits' => [
                    [
                        'icon' => 'ti-world',
                        'title' => 'Global Recognition',
                        'text'  => 'US degrees are recognised worldwide and valued highly by employers.',
                    ],
                    [
                        'icon' => 'ti-layers',
                        'title' => 'Broad Course Options',
                        'text'  => 'Choose flexible programs and specialisations across every major discipline.',
                    ],
                    [
                        'icon' => 'ti-bookmark-alt',
                        'title' => 'World‑Class Facilities',
                        'text'  => 'Access modern campuses, research labs and strong industry connections.',
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '4,000+',   'label' => 'Universities'],
                ['icon' => '💰', 'number' => '$20K–55K', 'label' => 'Tuition / Year'],
                ['icon' => '💼', 'number' => 'Up to 3 Yrs', 'label' => 'OPT for STEM'],
                ['icon' => '⏰', 'number' => '20 hrs/wk', 'label' => 'On‑Campus Work'],
            ],

            'universities' => [
                [
                    'name' => 'MIT',
                    'rank' => 'QS Rank: 1',
                    'specialization' => 'Technology, Engineering, Sciences',
                    'flag' => 'assets/imgs/flags/usa.png',
                ],
                [
                    'name' => 'Stanford University',
                    'rank' => 'QS Rank: 3',
                    'specialization' => 'Engineering, Computer Science',
                    'flag' => 'assets/imgs/flags/usa.png',
                ],
                [
                    'name' => 'Harvard University',
                    'rank' => 'QS Rank: 5',
                    'specialization' => 'Business, Law, Medicine',
                    'flag' => 'assets/imgs/flags/usa.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => [
                    'label'  => 'Tuition Fees (Public Universities)',
                    'amount' => '$20,000 – $35,000 / Year',
                ],
                'living' => [
                    'label'  => 'Living Costs',
                    'amount' => '$1,000 – $1,800 / Month',
                ],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',      'cost' => '$500 – $900'],
                    ['item' => '🍽️ Food & Groceries',  'cost' => '$250 – $400'],
                    ['item' => '🚇 Transportation',     'cost' => '$100 – $200'],
                    ['item' => '📱 Internet & Phone',   'cost' => '$50 – $100'],
                    ['item' => '🎯 Other Expenses',     'cost' => '$100 – $200'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    'Valid 10+2 for undergraduate programs.',
                    'Bachelor’s degree for Master’s programs.',
                    'Competitive GPA as per university requirements.',
                    'Transcripts from all institutions attended.',
                ],
                'language' => [
                    'TOEFL iBT 80+ or IELTS 6.5+ for most programs.',
                    'GRE / GMAT for many graduate programs.',
                    'SAT / ACT scores for undergraduate admissions where required.',
                    'Proof of funds and documentation for F‑1 visa.',
                ],
            ],

            'application_process' => [
                ['step' => 1, 'title' => 'Profile Evaluation & Shortlisting', 'description' => 'Identify best‑fit US universities based on academics, budget and goals.'],
                ['step' => 2, 'title' => 'Test Preparation', 'description' => 'Coaching and strategy for GRE/GMAT/SAT and IELTS/TOEFL.'],
                ['step' => 3, 'title' => 'Applications & Essays', 'description' => 'Support with SOPs, essays, LORs and online forms.'],
                ['step' => 4, 'title' => 'Visa Guidance', 'description' => 'F‑1 visa documentation and mock interviews.'],
                ['step' => 5, 'title' => 'Pre‑Departure Support', 'description' => 'Travel, accommodation and orientation before you fly.'],
            ],

            'testimonials' => [
                [
                    'name'       => 'Lakshma Reddy Pothireddy',
                    'university' => 'Cleveland State University',
                    'rating'     => 5,
                    'text'       => 'Our first experience with MERIT MINDS OVERSEAS was truly impressive. Shekar sir was resourceful and highly student‑focused.',
                    'color'      => '#38d90b',
                ],
                [
                    'name'       => 'Salma Sultana',
                    'university' => 'Webster University',
                    'rating'     => 5,
                    'text'       => 'They played a key role in my US admission and visa process, supporting me despite my educational gap.',
                    'color'      => '#cfa153',
                ],
                [
                    'name'       => 'Venkata Saikumar Marri',
                    'university' => 'Wright State University',
                    'rating'     => 5,
                    'text'       => 'Their constant support helped me secure my visa for Fall 2024 at Wright State University.',
                    'color'      => '#c65858',
                ],
            ],

            'cta' => [
                'title'       => 'Ready to Study in the USA?',
                'subtitle'    => 'Get personalised guidance on universities, courses and visa planning from our USA experts.',
                'button_text' => 'Contact Us',
                'phone'       => '+91 9505889191',
            ],
        ],

        // ---------------- UK ----------------
        'uk' => [
            'name' => 'UK',
            'flag_emoji' => '🇬🇧',
            'hero_image' => 'assets/imgs/UK.jpg',
            'hero_title' => 'Study in the UK',
            'hero_subtitle' => 'Your Gateway to a Global Future',

            'intro_text' => 'At Merit Minds Overseas, we provide expert guidance on studying in the UK, from course selection to visa filing.',
            'intro_image' => 'https://cdn.pixabay.com/photo/2017/06/15/16/52/united-kingdom-2405963_640.jpg',
            'intro_points' => [
                'Discover leading universities and programs.',
                'Get advice on scholarships and financial planning.',
                'Learn about life as an international student in the UK.',
                'Receive support at every stage of your education journey.',
            ],

            'why_choose' => [
                'title' => 'Why Choose the UK?',
                'subtitle' => 'With a rich academic heritage and diverse culture, the UK offers an exceptional study experience.',
                'benefits' => [
                    [
                        'icon' => 'ti-world',
                        'title' => 'World‑Class Education',
                        'text'  => 'The UK hosts some of the world’s top universities with globally respected degrees.',
                    ],
                    [
                        'icon' => 'ti-layers',
                        'title' => 'Global Opportunities',
                        'text'  => 'A UK degree opens doors to international careers and strong alumni networks.',
                    ],
                    [
                        'icon' => 'ti-bookmark-alt',
                        'title' => 'Cultural Immersion',
                        'text'  => 'Experience a multicultural environment while living in historic and modern cities.',
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '160+',   'label' => 'Universities & Colleges'],
                ['icon' => '💰', 'number' => '£12K–£30K', 'label' => 'Tuition / Year'],
                ['icon' => '💼', 'number' => '2 Years', 'label' => 'Post‑Study Work (PG)'],
                ['icon' => '⏰', 'number' => '20 hrs/wk', 'label' => 'Part‑Time Work'],
            ],

            'universities' => [
                [
                    'name' => 'University of Manchester',
                    'rank' => 'QS Rank: 32',
                    'specialization' => 'Engineering, Business, Sciences',
                    'flag' => 'assets/imgs/flags/uk.png',
                ],
                [
                    'name' => 'University of Leeds',
                    'rank' => 'QS Rank: 75',
                    'specialization' => 'Business, Law, Arts',
                    'flag' => 'assets/imgs/flags/uk.png',
                ],
                [
                    'name' => 'University of Glasgow',
                    'rank' => 'QS Rank: 76',
                    'specialization' => 'Medicine, Engineering, Social Sciences',
                    'flag' => 'assets/imgs/flags/uk.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => [
                    'label'  => 'Tuition Fees',
                    'amount' => '£12,000 – £30,000 / Year',
                ],
                'living' => [
                    'label'  => 'Living Costs',
                    'amount' => '£800 – £1,200 / Month',
                ],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',     'cost' => '£400 – £700'],
                    ['item' => '🍽️ Food & Groceries', 'cost' => '£150 – £250'],
                    ['item' => '🚇 Transportation',    'cost' => '£60 – £120'],
                    ['item' => '📱 Internet & Phone',  'cost' => '£30 – £60'],
                    ['item' => '🎯 Other Expenses',    'cost' => '£100 – £200'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    '12th grade completion for Bachelor’s entry.',
                    'Bachelor’s degree for Master’s courses.',
                    'Required percentage as per university and course.',
                    'Academic gap explanation where applicable.',
                ],
                'language' => [
                    'IELTS 6.0–6.5 or equivalent for most programs.',
                    'Some universities accept MOI or waive tests for certain profiles.',
                    'Financial documentation to meet UKVI requirements.',
                ],
            ],

            'application_process' => [
                ['step' => 1, 'title' => 'Counselling & University Shortlist', 'description' => 'Match your profile with suitable UK universities and intakes.'],
                ['step' => 2, 'title' => 'Applications & SOP', 'description' => 'Prepare SOPs, gather LORs and submit online applications.'],
                ['step' => 3, 'title' => 'Offer & CAS Process', 'description' => 'Complete conditions, pay deposits and obtain CAS.'],
                ['step' => 4, 'title' => 'Visa Application', 'description' => 'File the UK student visa with accurate documentation and guidance.'],
                ['step' => 5, 'title' => 'Pre‑Departure Briefing', 'description' => 'Travel, accommodation and arrival checklist before you fly.'],
            ],

            'testimonials' => [
                [
                    'name'       => 'Salma Sultana',
                    'university' => 'Webster University',
                    'rating'     => 5,
                    'text'       => 'MERIT MINDS OVERSEAS played a key role in my university admission and visa process, supporting me through every challenge.',
                    'color'      => '#cfa153',
                ],
                [
                    'name'       => 'Tanishq Kondru',
                    'university' => 'University of Minnesota',
                    'rating'     => 5,
                    'text'       => 'Highly grateful for their personalised advice and thorough visa interview preparation.',
                    'color'      => '#7d6ef3',
                ],
                [
                    'name'       => 'Monisha Thota',
                    'university' => 'New York Institute of Technology',
                    'rating'     => 5,
                    'text'       => 'Excellent guidance and moral support from the team throughout the process.',
                    'color'      => '#ad37c2db',
                ],
            ],

            'cta' => [
                'title'       => 'Ready to Study in the UK?',
                'subtitle'    => 'Contact us to get a personalised UK study plan for your profile and budget.',
                'button_text' => 'Contact Us',
                'phone'       => '+91 9505889191',
            ],
        ],

        // ---------------- AUSTRALIA ----------------
        'australia' => [
            'name' => 'Australia',
            'flag_emoji' => '🇦🇺',
            'hero_image' => 'assets/imgs/AUSTRALIA.jpg',
            'hero_title' => 'Study in Australia',
            'hero_subtitle' => 'Explore Education in the Land Down Under',

            'intro_text' => 'Merit Minds Overseas supports you through every step of studying in Australia, from course selection to visas.',
            'intro_image' => 'https://www.theflagshop.co.uk/media/catalog/product/cache/1aa45e34d8351bef7860daeb50e7952c/a/u/australia-flag-std_1.jpg',
            'intro_points' => [
                'Learn about the top universities and courses in Australia.',
                'Explore scholarship opportunities and financial aid.',
                'Receive visa and application guidance.',
                'Gain insights into living and working in Australia.',
            ],

            'why_choose' => [
                'title' => 'Why Choose Australia?',
                'subtitle' => 'High‑quality education, great lifestyle and excellent work opportunities.',
                'benefits' => [
                    [
                        'icon' => 'ti-user',
                        'title' => 'World‑Class Education',
                        'text'  => 'Australia offers top‑ranked universities and highly respected degrees recognised globally.',
                    ],
                    [
                        'icon' => 'ti-bar-chart-alt',
                        'title' => 'Diverse Career Opportunities',
                        'text'  => 'Strong job market in healthcare, engineering, IT and more.',
                    ],
                    [
                        'icon' => 'ti-briefcase',
                        'title' => 'Multicultural Experience',
                        'text'  => 'Live in a safe, diverse and student‑friendly environment.',
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '40+',   'label' => 'Universities'],
                ['icon' => '💰', 'number' => 'AUD 20K–45K', 'label' => 'Tuition / Year'],
                ['icon' => '💼', 'number' => '2–4 Years', 'label' => 'Post‑Study Work'],
                ['icon' => '⏰', 'number' => '24 hrs/wk', 'label' => 'Part‑Time Work'],
            ],

            'universities' => [
                [
                    'name' => 'University of Melbourne',
                    'rank' => 'QS Rank: 14',
                    'specialization' => 'Business, Law, Engineering',
                    'flag' => 'assets/imgs/flags/australia.png',
                ],
                [
                    'name' => 'University of Sydney',
                    'rank' => 'QS Rank: 18',
                    'specialization' => 'Health, Engineering, Arts',
                    'flag' => 'assets/imgs/flags/australia.png',
                ],
                [
                    'name' => 'Monash University',
                    'rank' => 'QS Rank: 37',
                    'specialization' => 'Pharmacy, Business, IT',
                    'flag' => 'assets/imgs/flags/australia.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => [
                    'label'  => 'Tuition Fees',
                    'amount' => 'AUD 20,000 – 45,000 / Year',
                ],
                'living' => [
                    'label'  => 'Living Costs',
                    'amount' => 'AUD 1,200 – 1,800 / Month',
                ],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',      'cost' => 'AUD 600 – 900'],
                    ['item' => '🍽️ Food & Groceries',  'cost' => 'AUD 250 – 350'],
                    ['item' => '🚇 Transportation',     'cost' => 'AUD 100 – 150'],
                    ['item' => '📱 Internet & Phone',   'cost' => 'AUD 40 – 80'],
                    ['item' => '🎯 Other Expenses',     'cost' => 'AUD 150 – 250'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    'Completion of 12th grade for Bachelor’s entry.',
                    'Recognised Bachelor’s degree for Master’s programs.',
                    'Academic percentage and prerequisites as per university.',
                ],
                'language' => [
                    'IELTS 6.0–6.5 or PTE Academic equivalent.',
                    'Proof of funds and Overseas Student Health Cover (OSHC).',
                ],
            ],

            'application_process' => [
                ['step' => 1, 'title' => 'Profile Assessment', 'description' => 'Evaluate your academics and finances for Australian options.'],
                ['step' => 2, 'title' => 'Course & University Selection', 'description' => 'Shortlist universities and intakes matching your goals.'],
                ['step' => 3, 'title' => 'Application & Offer Letter', 'description' => 'Submit applications and secure your Confirmation of Enrolment (CoE).'],
                ['step' => 4, 'title' => 'Visa Lodgement', 'description' => 'Prepare GTE statement, financials and lodge the visa.'],
                ['step' => 5, 'title' => 'Pre‑Departure Support', 'description' => 'Travel, accommodation and arrival assistance.'],
            ],

            'testimonials' => [
                [
                    'name'       => 'Lakshma Reddy Pothireddy',
                    'university' => 'Cleveland State University',
                    'rating'     => 5,
                    'text'       => 'Impressive and pleasant experience with MeritMinds; highly student‑centric support.',
                    'color'      => '#38d90b',
                ],
                [
                    'name'       => 'Salma Sultana',
                    'university' => 'Webster University',
                    'rating'     => 5,
                    'text'       => 'Guided me through admissions and visa despite educational gaps.',
                    'color'      => '#cfa153',
                ],
                [
                    'name'       => 'Venkata Saikumar Marri',
                    'university' => 'Wright State University',
                    'rating'     => 5,
                    'text'       => 'Their consistent guidance helped me secure my visa successfully.',
                    'color'      => '#c65858',
                ],
            ],

            'cta' => [
                'title'       => 'Ready to Study in Australia?',
                'subtitle'    => 'Talk to our Australia counsellors for personalised university and visa guidance.',
                'button_text' => 'Contact Us',
                'phone'       => '+91 9505889191',
            ],
        ],

        // ---------------- CANADA ----------------
        'canada' => [
            'name' => 'Canada',
            'flag_emoji' => '🇨🇦',
            'hero_image' => 'assets/imgs/CANADA.jpg',
            'hero_title' => 'Study in Canada',
            'hero_subtitle' => 'Explore Education Opportunities in Canada',

            'intro_text' => 'Merit Minds Overseas provides complete guidance for students interested in studying in Canada, from shortlisting universities to visa filing.',
            'intro_image' => 'https://www.theflagshop.co.uk/media/catalog/product/c/a/canada-flag-std.jpg',
            'intro_points' => [
                'Learn about the top-ranked Canadian universities and programs.',
                'Explore scholarship options and financial aid.',
                'Receive personalised visa and application support.',
                'Understand living and working conditions in Canada.',
            ],

            'why_choose' => [
                'title' => 'Why Choose Canada?',
                'subtitle' => 'A safe, welcoming country with excellent education and PR pathways.',
                'benefits' => [
                    [
                        'icon' => 'ti-user',
                        'title' => 'Quality Education',
                        'text'  => 'Canadian institutions are globally recognised for high academic standards.',
                    ],
                    [
                        'icon' => 'ti-bar-chart-alt',
                        'title' => 'Strong Economy',
                        'text'  => 'Robust job market in IT, engineering, healthcare, finance and more.',
                    ],
                    [
                        'icon' => 'ti-briefcase',
                        'title' => 'Safe & Welcoming',
                        'text'  => 'Canada is known for safety, diversity and immigrant‑friendly policies.',
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '200+',        'label' => 'Public Institutions'],
                ['icon' => '💰', 'number' => 'CAD 15K–35K', 'label' => 'Tuition / Year'],
                ['icon' => '💼', 'number' => 'Up to 3 Yrs', 'label' => 'Post‑Study Work'],
                ['icon' => '⏰', 'number' => '20 hrs/wk',   'label' => 'Part‑Time Work'],
            ],

            'universities' => [
                [
                    'name' => 'University of Toronto',
                    'rank' => 'QS Rank: 21',
                    'specialization' => 'Computer Science, Engineering, Business',
                    'flag' => 'assets/imgs/flags/canada.png',
                ],
                [
                    'name' => 'University of British Columbia',
                    'rank' => 'QS Rank: 34',
                    'specialization' => 'Sciences, Forestry, Sustainability',
                    'flag' => 'assets/imgs/flags/canada.png',
                ],
                [
                    'name' => 'McGill University',
                    'rank' => 'QS Rank: 30',
                    'specialization' => 'Medicine, Law, Arts',
                    'flag' => 'assets/imgs/flags/canada.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => [
                    'label'  => 'Tuition Fees',
                    'amount' => 'CAD 15,000 – 35,000 / Year',
                ],
            'living' => [
                    'label'  => 'Living Costs',
                    'amount' => 'CAD 900 – 1,500 / Month',
                ],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',      'cost' => 'CAD 400 – 800'],
                    ['item' => '🍽️ Food & Groceries',  'cost' => 'CAD 200 – 300'],
                    ['item' => '🚇 Transportation',     'cost' => 'CAD 80 – 120'],
                    ['item' => '📱 Internet & Phone',   'cost' => 'CAD 50 – 80'],
                    ['item' => '🎯 Other Expenses',     'cost' => 'CAD 150 – 250'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    '12th grade completion for undergraduate entry.',
                    'Bachelor’s degree for postgraduate programs.',
                    'Minimum percentage as per college and course.',
                ],
                'language' => [
                    'IELTS 6.0–6.5 or equivalent required by most institutions.',
                    'Proof of funds, GIC (where applicable) and supporting financial documents.',
                ],
            ],

            'application_process' => [
                ['step' => 1, 'title' => 'Profile Assessment & Shortlist', 'description' => 'Evaluate your profile and shortlist colleges across provinces.'],
                ['step' => 2, 'title' => 'Application Submission', 'description' => 'Prepare documents and apply to chosen institutions.'],
                ['step' => 3, 'title' => 'Offer & Fee Payment', 'description' => 'Receive offer letters, pay tuition deposits and arrange GIC if required.'],
                ['step' => 4, 'title' => 'Study Permit Filing', 'description' => 'Prepare SOP, financials and file the Canadian study permit.'],
                ['step' => 5, 'title' => 'Pre‑Departure', 'description' => 'Travel and settlement guidance once your visa is approved.'],
            ],

            'testimonials' => [
                [
                    'name'       => 'Tanishq Kondru',
                    'university' => 'University of Minnesota',
                    'rating'     => 5,
                    'text'       => 'Incredibly grateful for their personalised advice and visa interview preparation.',
                    'color'      => '#7d6ef3',
                ],
                [
                    'name'       => 'Gopalakrishna Reddy Manukonda',
                    'university' => 'University of Florida',
                    'rating'     => 5,
                    'text'       => 'Exceptional support across exam prep, admission and visa approval.',
                    'color'      => '#239bca',
                ],
                [
                    'name'       => 'Monisha Thota',
                    'university' => 'New York Institute of Technology',
                    'rating'     => 5,
                    'text'       => 'Strong guidance and moral support from the team at every step.',
                    'color'      => '#ad37c2db',
                ],
            ],

            'cta' => [
                'title'       => 'Ready to Study in Canada?',
                'subtitle'    => 'Connect with our counsellors and get a clear plan for studying and settling in Canada.',
                'button_text' => 'Contact Us',
                'phone'       => '+91 9505889191',
            ],
        ],

        // ---------------- IRELAND ----------------
        'ireland' => [
            'name' => 'Ireland',
            'flag_emoji' => '🇮🇪',
            'hero_image' => 'assets/imgs/IRELAND.jpg',
            'hero_title' => 'Study in Ireland',
            'hero_subtitle' => 'Your Gateway to a Global Future',

            'intro_text' => 'At Merit Minds Overseas, we guide you through every aspect of studying in Ireland, from choosing universities to managing visas.',
            'intro_image' => 'https://cdn11.bigcommerce.com/s-3wskl27okf/images/stencil/1280x1280/products/2601/4120/Flag_of_Ireland__10258.1662206239.jpg?c=1',
            'intro_points' => [
                'Discover leading universities and industry‑linked programs.',
                'Get support on scholarships and budgeting your studies.',
                'Understand student life and work options in Ireland.',
                'Receive end‑to‑end support from application to arrival.',
            ],

            'why_choose' => [
                'title' => 'Why Choose Ireland?',
                'subtitle' => 'A fast‑growing European tech hub with world‑class education.',
                'benefits' => [
                    [
                        'icon' => 'ti-user',
                        'title' => 'World‑Class Education',
                        'text'  => 'Irish universities offer strong research and industry connections.',
                    ],
                    [
                        'icon' => 'ti-bar-chart-alt',
                        'title' => 'Global Opportunities',
                        'text'  => 'Presence of major tech and pharma companies creates excellent job prospects.',
                    ],
                    [
                        'icon' => 'ti-briefcase',
                        'title' => 'Rich Culture',
                        'text'  => 'Enjoy a friendly, English‑speaking environment with vibrant culture.',
                    ],
                ],
            ],

            'key_facts' => [
                ['icon' => '🎓', 'number' => '7',        'label' => 'Public Universities'],
                ['icon' => '💰', 'number' => '€10K–€25K','label' => 'Tuition / Year'],
                ['icon' => '💼', 'number' => '2 Years',  'label' => 'Post‑Study Stay Back'],
                ['icon' => '⏰', 'number' => '20 hrs/wk','label' => 'Part‑Time Work'],
            ],

            'universities' => [
                [
                    'name' => 'Trinity College Dublin',
                    'rank' => 'QS Rank: 98',
                    'specialization' => 'Computer Science, Engineering, Business',
                    'flag' => 'assets/imgs/flags/ireland.png',
                ],
                [
                    'name' => 'University College Dublin',
                    'rank' => 'QS Rank: 171',
                    'specialization' => 'Business, Agriculture, Medicine',
                    'flag' => 'assets/imgs/flags/ireland.png',
                ],
                [
                    'name' => 'NUI Galway',
                    'rank' => 'QS Rank: 289',
                    'specialization' => 'Health, Arts, Sciences',
                    'flag' => 'assets/imgs/flags/ireland.png',
                ],
            ],

            'cost_of_study' => [
                'tuition' => ['label' => 'Tuition Fees', 'amount' => '€10,000 – €25,000 / Year'],
                'living'  => ['label' => 'Living Costs', 'amount' => '€900 – €1,400 / Month'],
                'breakdown' => [
                    ['item' => '🏠 Accommodation',     'cost' => '€400 – €700'],
                    ['item' => '🍽️ Food & Groceries', 'cost' => '€200 – €300'],
                    ['item' => '🚇 Transportation',    'cost' => '€70 – €120'],
                    ['item' => '📱 Internet & Phone',  'cost' => '€40 – €70'],
                    ['item' => '🎯 Other Expenses',    'cost' => '€150 – €250'],
                ],
            ],

            'requirements' => [
                'academic' => [
                    '12th grade completion for Bachelor’s programs.',
                    'Recognised Bachelor’s degree for Master’s courses.',
                    'Required percentage and subject prerequisites as per course.',
                ],
                'language' => [
                    'IELTS 6.0–6.5 or equivalent.',
                    'Proof of funds and health insurance for visa.',
                ],
            ],

            'application_process' => [
                ['step' => 1, 'title' => 'Profile Evaluation', 'description' => 'Assess eligibility for Irish universities and intakes.'],
                ['step' => 2, 'title' => 'Course & University Selection', 'description' => 'Shortlist best‑fit programs in Ireland based on your goals.'],
                ['step' => 3, 'title' => 'Application & Offers', 'description' => 'Prepare documents, apply and manage conditional offers.'],
                ['step' => 4, 'title' => 'Visa Application', 'description' => 'Support with visa forms, fee payment and documentation.'],
                ['step' => 5, 'title' => 'Pre‑Departure Support', 'description' => 'Travel, accommodation and arrival briefing before you fly.'],
            ],

            'testimonials' => [
                [
                    'name'       => 'Tanishq Kondru',
                    'university' => 'University of Minnesota',
                    'rating'     => 5,
                    'text'       => 'Very detailed visa interview preparation and tailored advice for my profile.',
                    'color'      => '#7d6ef3',
                ],
                [
                    'name'       => 'Gopalakrishna Reddy Manukonda',
                    'university' => 'University of Florida',
                    'rating'     => 5,
                    'text'       => 'Great support from test preparation through final visa approval.',
                    'color'      => '#239bca',
                ],
                [
                    'name'       => 'Salma Sultana',
                    'university' => 'Webster University',
                    'rating'     => 5,
                    'text'       => 'Helped me overcome gaps in my profile and still secure admission and visa.',
                    'color'      => '#cfa153',
                ],
            ],

            'cta' => [
                'title'       => 'Ready to Study in Ireland?',
                'subtitle'    => 'Get personalised counselling on Irish universities, costs and visa options.',
                'button_text' => 'Contact Us',
                'phone'       => '+91 9505889191',
            ],
        ],
    ];

    return $countries[$countryCode] ?? null;
}
