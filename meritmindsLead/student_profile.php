<?php
include 'dbconfig.php';

// Validate student ID
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])) {
    die("Invalid student ID");
}
$student_id = intval($_GET['student_id']);

// Verify student exists
$student_query = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
$student_query->bind_param("i", $student_id);
$student_query->execute();
$student_result = $student_query->get_result();

if ($student_result->num_rows == 0) {
    die("Student not found");
}
$student = $student_result->fetch_assoc();

// Get application status
$status_query = $conn->prepare("SELECT * FROM application_status WHERE student_id = ?");
$status_query->bind_param("i", $student_id);
$status_query->execute();
$status_result = $status_query->get_result();
$application_status = ($status_result->num_rows > 0) ? $status_result->fetch_assoc() : null;

// Get fee status
$fee_query = $conn->prepare("SELECT * FROM student_financials WHERE student_id = ?");
$fee_query->bind_param("i", $student_id);
$fee_query->execute();
$fee_result = $fee_query->get_result();
$fee_status = ($fee_result->num_rows > 0) ? $fee_result->fetch_assoc() : null;

// Get document counts and details
$docs_query = $conn->prepare("SELECT * FROM application_materials WHERE student_id = ? ORDER BY uploaded_at DESC");
$docs_query->bind_param("i", $student_id);
$docs_query->execute();
$docs_result = $docs_query->get_result();
$documents = [];
while ($row = $docs_result->fetch_assoc()) {
    $documents[] = $row;
}
$document_count = count($documents);

// Get university applications
$univ_query = $conn->prepare("SELECT * FROM university_applications WHERE student_id = ? ORDER BY created_at DESC");
$univ_query->bind_param("i", $student_id);
$univ_query->execute();
$univ_result = $univ_query->get_result();
$university_apps = [];
while ($row = $univ_result->fetch_assoc()) {
    $university_apps[] = $row;
}

// Get most recent activities
$activity_query = $conn->prepare("
    SELECT * FROM activity_log 
    WHERE student_id = ? 
    ORDER BY created_at DESC 
    LIMIT 10
");
$activity_query->bind_param("i", $student_id);
$activity_query->execute();
$activity_result = $activity_query->get_result();
$recent_activities = [];
while ($row = $activity_result->fetch_assoc()) {
    $recent_activities[] = $row;
}

// Get education details
$education_fields = [
    'qualification' => 'Qualification',
    'year_of_pass' => 'Year of Passing',
    'percentage' => 'Percentage',
    'backlogs' => 'Backlogs',
    'inter_percentage' => 'Intermediate Percentage',
    'inter_english_marks' => 'English Marks'
];

// Get personal details
$personal_fields = [
    'gender' => 'Gender',
    'dob' => 'Date of Birth',
    'fatherName' => 'Father\'s Name',
    'motherName' => 'Mother\'s Name',
    'country' => 'Preferred Countries',
    'intake' => 'Preferred Intake'
];

// Calculate application progress percentage
$progress_items = [
    'documents' => $document_count > 0,
    'universities' => count($university_apps) > 0,
    'fees' => $fee_status && $fee_status['fee_status'] == 'paid',
    'status' => $application_status && $application_status['status'] != 'Not Started'
];
$completed_count = array_sum(array_map('intval', $progress_items));
$progress_percentage = ($completed_count / count($progress_items)) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - <?php echo htmlspecialchars($student['studentName']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #3a4f7a;
            --secondary-color: #6098d1;
            --accent-color: #557c93;
            --light-color: #f0f7ff;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-top: 20px;
        }
        
        .profile-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            margin-right: 2rem;
            font-weight: 300;
        }
        
        .profile-info h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        .profile-info p {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }
        
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .status-not-started { background-color: #e9ecef; color: #495057; }
        .status-in-progress { background-color: #fff3cd; color: #856404; }
        .status-complete { background-color: #d4edda; color: #155724; }
        .status-on-hold { background-color: #cce5ff; color: #004085; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .status-withdrawn { background-color: #d6d8db; color: #383d41; }
        
        .profile-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .profile-card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .profile-card-body {
            padding: 1.5rem;
        }
        
        .progress-container {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .progress {
            height: 0.8rem;
            border-radius: 0.4rem;
            background-color: #e9ecef;
            margin-bottom: 0.5rem;
        }
        
        .progress-bar {
            background-color: var(--primary-color);
            border-radius: 0.4rem;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 24px;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .icon-primary { background-color: rgba(58, 79, 122, 0.1); color: var(--primary-color); }
        .icon-success { background-color: rgba(46, 204, 113, 0.1); color: var(--success-color); }
        .icon-warning { background-color: rgba(243, 156, 18, 0.1); color: var(--warning-color); }
        .icon-danger { background-color: rgba(231, 76, 60, 0.1); color: var(--danger-color); }
        .icon-info { background-color: rgba(52, 152, 219, 0.1); color: var(--info-color); }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .detail-section {
            margin-bottom: 1.5rem;
        }
        
        .detail-label {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }
        
        .detail-value {
            color: #6c757d;
        }
        
        .activity-timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .timeline-dot {
            position: absolute;
            left: -2rem;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid var(--primary-color);
            z-index: 1;
        }
        
        .timeline-content {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }
        
        .timeline-description {
            margin-bottom: 0;
            color: #6c757d;
        }
        
        .university-card {
            display: flex;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .university-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }
        
        .university-logo {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: 600;
        }
        
        .university-info {
            flex: 1;
        }
        
        .university-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }
        
        .university-program {
            margin-bottom: 0.25rem;
            color: #6c757d;
        }
        
        .university-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .document-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        
        .document-item:hover {
            background-color: rgba(58, 79, 122, 0.05);
        }
        
        .document-icon {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background-color: rgba(58, 79, 122, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .document-info {
            flex: 1;
        }
        
        .document-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }
        
        .document-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .tabs-container {
            margin-bottom: 2rem;
        }
        
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 1rem;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-right: 0.5rem;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background-color: rgba(58, 79, 122, 0.05);
            color: var(--dark-color);
        }
        
        .nav-tabs .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .tab-pane {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075);
        }
        
        .action-btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2c3e5d;
            border-color: #2c3e5d;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-with-icon {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        @media (max-width: 767.98px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .quick-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 575.98px) {
            .quick-stats {
                grid-template-columns: 1fr;
            }
            
            .university-card {
                flex-direction: column;
            }
            
            .university-logo {
                margin-right: 0;
                margin-bottom: 1rem;
                align-self: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Profile Header -->
                <div class="profile-container">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <?php echo strtoupper(substr($student['studentName'], 0, 1)); ?>
                        </div>
                        <div class="profile-info">
                            <h1><?php echo htmlspecialchars($student['studentName']); ?></h1>
                            <p class="d-flex align-items-center">
                                <i class="bi bi-envelope me-2"></i> <?php echo htmlspecialchars($student['email']); ?>
                            </p>
                            <p class="d-flex align-items-center">
                                <i class="bi bi-telephone me-2"></i> <?php echo htmlspecialchars($student['mobile']); ?>
                            </p>
                            <p class="d-flex align-items-center">
                                <i class="bi bi-geo-alt me-2"></i> <?php echo htmlspecialchars($student['branchName']); ?> Branch
                            </p>
                            <div>
                                <?php if ($application_status): ?>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $application_status['status'])); ?>">
                                        <i class="bi bi-clipboard-check me-1"></i>
                                        <?php echo $application_status['status']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-not-started">
                                        <i class="bi bi-hourglass me-1"></i>
                                        Not Started
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Application Progress -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percentage; ?>%" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress-label">
                            <span>Application Progress</span>
                            <span><?php echo round($progress_percentage); ?>% Complete</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="quick-stats">
                    <div class="stat-card">
                        <div class="stat-icon icon-primary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="stat-value"><?php echo $document_count; ?></div>
                        <div class="stat-label">Documents Uploaded</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-info">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="stat-value"><?php echo count($university_apps); ?></div>
                        <div class="stat-label">Universities Applied</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon <?php echo $fee_status && $fee_status['fee_status'] == 'paid' ? 'icon-success' : 'icon-danger'; ?>">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="stat-value">
                            <?php if ($fee_status && $fee_status['fee_status'] == 'paid'): ?>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            <?php else: ?>
                                <i class="bi bi-x-circle-fill text-danger"></i>
                            <?php endif; ?>
                        </div>
                        <div class="stat-label">
                            <?php echo $fee_status && $fee_status['fee_status'] == 'paid' ? 'Fee Paid' : 'Fee Pending'; ?>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-warning">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="stat-value">
                            <?php 
                            $date_created = new DateTime($student['created_at']);
                            echo $date_created->format('M d');
                            ?>
                        </div>
                        <div class="stat-label">Registration Date</div>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="tabs-container">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">
                                <i class="bi bi-person me-1"></i> Personal Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="applications-tab" data-bs-toggle="tab" data-bs-target="#applications" type="button" role="tab" aria-controls="applications" aria-selected="false">
                                <i class="bi bi-building me-1"></i> Applications
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">
                                <i class="bi bi-file-earmark-text me-1"></i> Documents
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">
                                <i class="bi bi-activity me-1"></i> Activity
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Personal Details Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Personal Information</h5>
                                    <?php foreach ($personal_fields as $field => $label): ?>
                                        <?php if (isset($student[$field]) && !empty($student[$field])): ?>
                                            <div class="detail-section">
                                                <div class="detail-label"><?php echo $label; ?></div>
                                                <div class="detail-value">
                                                    <?php 
                                                    if ($field == 'dob' && !empty($student[$field]) && $student[$field] != '0000-00-00') {
                                                        echo date('F j, Y', strtotime($student[$field]));
                                                    } else {
                                                        echo htmlspecialchars($student[$field]);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="mb-3">Educational Background</h5>
                                    <?php foreach ($education_fields as $field => $label): ?>
                                        <?php if (isset($student[$field]) && !empty($student[$field])): ?>
                                            <div class="detail-section">
                                                <div class="detail-label"><?php echo $label; ?></div>
                                                <div class="detail-value"><?php echo htmlspecialchars($student[$field]); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Applications Tab -->
                        <div class="tab-pane fade" id="applications" role="tabpanel" aria-labelledby="applications-tab">
                            <h5 class="mb-3">University Applications</h5>
                            <?php if (count($university_apps) > 0): ?>
                                <?php foreach ($university_apps as $app): ?>
                                    <div class="university-card">
                                        <div class="university-logo">
                                            <?php echo strtoupper(substr($app['university_name'], 0, 2)); ?>
                                        </div>
                                        <div class="university-info">
                                            <div class="university-name"><?php echo htmlspecialchars($app['university_name']); ?></div>
                                            <div class="university-program"><?php echo htmlspecialchars($app['program_name']); ?></div>
                                            <div class="university-meta">
                                                <span><i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars($app['location']); ?></span>
                                                <span><i class="bi bi-calendar me-1"></i> <?php echo date('M d, Y', strtotime($app['application_date'])); ?></span>
                                                <span><i class="bi bi-cash me-1"></i> 
                                                    <?php 
                                                    $currency_symbol = '';
                                                    switch($app['currency']) {
                                                        case 'USD': 
                                                            $currency_symbol = '$'; 
                                                            break;
                                                        case 'GBP': 
                                                            $currency_symbol = '£'; 
                                                            break;
                                                        case 'EUR': 
                                                            $currency_symbol = '€'; 
                                                            break;
                                                        default: 
                                                            $currency_symbol = ''; 
                                                            break;
                                                    }
                                                    
                                                    echo $currency_symbol . number_format($app['tuition_fee'], 2); 
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="text-center mt-4">
                                    <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary btn-with-icon">
                                        <i class="bi bi-plus-circle"></i> Add New Application
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-building" style="font-size: 3rem; color: #6c757d;"></i>
                                    </div>
                                    <h5>No university applications yet</h5>
                                    <p class="text-muted mb-4">Add the student's first university application</p>
                                    <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary btn-with-icon">
                                        <i class="bi bi-plus-circle"></i> Add Application
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Documents Tab -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <h5 class="mb-3">Application Materials</h5>
                            <?php if (count($documents) > 0): ?>
                                <?php foreach ($documents as $doc): ?>
                                    <div class="document-item">
                                        <div class="document-icon">
                                            <?php
                                            $file_ext = pathinfo($doc['file_name'], PATHINFO_EXTENSION);
                                            $icon = 'bi-file-earmark';
                                            
                                            switch(strtolower($file_ext)) {
                                                case 'pdf':
                                                    $icon = 'bi-file-earmark-pdf';
                                                    break;
                                                case 'doc':
                                                case 'docx':
                                                    $icon = 'bi-file-earmark-word';
                                                    break;
                                                case 'xls':
                                                case 'xlsx':
                                                    $icon = 'bi-file-earmark-excel';
                                                    break;
                                                case 'ppt':
                                                case 'pptx':
                                                    $icon = 'bi-file-earmark-ppt';
                                                    break;
                                                case 'jpg':
                                                case 'jpeg':
                                                case 'png':
                                                    $icon = 'bi-file-earmark-image';
                                                    break;
                                            }
                                            ?>
                                            <i class="bi <?php echo $icon; ?>"></i>
                                        </div>
                                        <div class="document-info">
                                            <div class="document-name"><?php echo htmlspecialchars($doc['material']); ?></div>
                                            <div class="document-meta">
                                                <span><?php echo htmlspecialchars($doc['file_name']); ?></span>
                                                <span class="ms-3"><i class="bi bi-calendar me-1"></i> <?php echo date('M d, Y', strtotime($doc['uploaded_at'])); ?></span>
                                            </div>
                                        </div>
                                        <a href="serve_file.php?path=<?php echo urlencode($doc['file_path']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    </div>
                                <?php endforeach; ?>
                                <div class="text-center mt-4">
                                    <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary btn-with-icon">
                                        <i class="bi bi-plus-circle"></i> Add More Documents
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #6c757d;"></i>
                                    </div>
                                    <h5>No documents uploaded yet</h5>
                                    <p class="text-muted mb-4">Upload the student's application materials</p>
                                    <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary btn-with-icon">
                                        <i class="bi bi-upload"></i> Upload Documents
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Activity Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            <h5 class="mb-3">Recent Activities</h5>
                            <?php if (count($recent_activities) > 0): ?>
                                <div class="activity-timeline">
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-content">
                                                <div class="timeline-date">
                                                    <?php 
                                                    $date = new DateTime($activity['created_at']);
                                                    $now = new DateTime();
                                                    $diff = $now->diff($date);
                                                    
                                                    if ($diff->days == 0) {
                                                        if ($diff->h == 0) {
                                                            echo $diff->i . ' minutes ago';
                                                        } else {
                                                            echo $diff->h . ' hours ago';
                                                        }
                                                    } else if ($diff->days == 1) {
                                                        echo 'Yesterday';
                                                    } else {
                                                        echo $date->format('M d, Y');
                                                    }
                                                    ?>
                                                </div>
                                                <div class="timeline-title"><?php echo htmlspecialchars($activity['activity_type']); ?></div>
                                                <p class="timeline-description"><?php echo htmlspecialchars($activity['description']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-activity" style="font-size: 3rem; color: #6c757d;"></i>
                                    </div>
                                    <h5>No activity recorded yet</h5>
                                    <p class="text-muted">Activities will appear here as the application progresses</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="profile-card">
                    <div class="profile-card-header">
                        <span>Quick Actions</span>
                    </div>
                    <div class="profile-card-body">
                        <div class="d-flex flex-wrap gap-3 justify-content-between">
                            <a href="application_status.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary btn-with-icon action-btn">
                                <i class="bi bi-clipboard-check"></i> Track Application
                            </a>
                            <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-primary btn-with-icon action-btn">
                                <i class="bi bi-building"></i> University Applications
                            </a>
                            <a href="bank_statement.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-primary btn-with-icon action-btn">
                                <i class="bi bi-cash-stack"></i> Bank Statements
                            </a>
                            <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-primary btn-with-icon action-btn">
                                <i class="bi bi-file-earmark-text"></i> Documents
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Back Button -->
                <div class="text-center mt-4 mb-5">
                    <a href="dashboard.php" class="btn btn-secondary btn-with-icon">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>