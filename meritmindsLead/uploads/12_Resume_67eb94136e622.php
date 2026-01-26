<?php
include 'dbconfig.php';

/**
 * Student Application Progress Tracker
 * 
 * This file tracks the progress of a student's application across all stages:
 * - Application Materials
 * - University Shortlists
 * - University Applications
 * - Bank Statements
 * - Application Fee Status
 * 
 * Uses student_id as the foreign key to link all related data.
 */

// Validate student ID
if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])) {
    die("Invalid student ID");
}
$student_id = intval($_GET['student_id']);

// Verify student exists
$student_check = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
$student_check->bind_param("i", $student_id);
$student_check->execute();
$student_result = $student_check->get_result();

if ($student_result->num_rows == 0) {
    die("Student not found");
}
$student = $student_result->fetch_assoc();

// Track all application components
function getApplicationProgress($conn, $student_id) {
    $progress = [
        'student' => null,
        'application_materials' => [
            'status' => 'Not Started',
            'count' => 0,
            'required_count' => 0,
            'last_updated' => null,
            'details' => []
        ],
        'university_shortlists' => [
            'status' => 'Not Started',
            'has_initial' => false,
            'has_final' => false,
            'last_updated' => null,
            'details' => []
        ],
        'university_applications' => [
            'status' => 'Not Started',
            'count' => 0,
            'last_updated' => null,
            'details' => []
        ],
        'bank_statements' => [
            'status' => 'Not Started',
            'count' => 0,
            'types_submitted' => [],
            'last_updated' => null,
            'details' => []
        ],
        'fee_status' => [
            'status' => 'Not Started',
            'is_paid' => false,
            'payment_date' => null,
            'last_updated' => null
        ],
        'overall_status' => 'Not Started',
        'completion_percentage' => 0
    ];

    // Get student info
    $student_query = $conn->prepare("SELECT * FROM enquiries WHERE id = ?");
    $student_query->bind_param("i", $student_id);
    $student_query->execute();
    $student_result = $student_query->get_result();
    
    if ($student_result->num_rows > 0) {
        $progress['student'] = $student_result->fetch_assoc();
    }

    // 1. Get Application Materials
    $materials_query = $conn->prepare("SELECT * FROM application_materials WHERE student_id = ? ORDER BY uploaded_at DESC");
    $materials_query->bind_param("i", $student_id);
    $materials_query->execute();
    $materials_result = $materials_query->get_result();
    
    // Define required document types
    $required_documents = [
        'SSC Certificate', 'Inter Certificate', 'Graduation Certificate', 
        'Passport', 'Resume', 'English Exam Score'
    ];
    $progress['application_materials']['required_count'] = count($required_documents);
    
    $uploaded_documents = [];
    $latest_update = null;
    
    if ($materials_result->num_rows > 0) {
        while ($row = $materials_result->fetch_assoc()) {
            $uploaded_documents[] = $row['material'];
            $progress['application_materials']['details'][] = $row;
            
            // Track latest update
            if ($latest_update === null || strtotime($row['uploaded_at']) > strtotime($latest_update)) {
                $latest_update = $row['uploaded_at'];
            }
        }
        
        $progress['application_materials']['count'] = count($uploaded_documents);
        $progress['application_materials']['last_updated'] = $latest_update;
        
        // Check if all required documents are uploaded
        $missing_documents = array_diff($required_documents, $uploaded_documents);
        
        if (count($missing_documents) === 0) {
            $progress['application_materials']['status'] = 'Complete';
        } else if (count($uploaded_documents) > 0) {
            $progress['application_materials']['status'] = 'In Progress';
        }
    }

    // 2. Get University Shortlists
    $shortlist_query = $conn->prepare("SELECT * FROM student_university_shortlists WHERE student_id = ? ORDER BY upload_date DESC");
    $shortlist_query->bind_param("i", $student_id);
    $shortlist_query->execute();
    $shortlist_result = $shortlist_query->get_result();
    
    $latest_shortlist_update = null;
    
    if ($shortlist_result->num_rows > 0) {
        while ($row = $shortlist_result->fetch_assoc()) {
            $progress['university_shortlists']['details'][] = $row;
            
            if ($row['file_type'] == 'initial_shortlist') {
                $progress['university_shortlists']['has_initial'] = true;
            } else if ($row['file_type'] == 'final_shortlist') {
                $progress['university_shortlists']['has_final'] = true;
            }
            
            // Track latest update
            if ($latest_shortlist_update === null || strtotime($row['upload_date']) > strtotime($latest_shortlist_update)) {
                $latest_shortlist_update = $row['upload_date'];
            }
        }
        
        $progress['university_shortlists']['last_updated'] = $latest_shortlist_update;
        
        if ($progress['university_shortlists']['has_initial'] && $progress['university_shortlists']['has_final']) {
            $progress['university_shortlists']['status'] = 'Complete';
        } else if ($progress['university_shortlists']['has_initial'] || $progress['university_shortlists']['has_final']) {
            $progress['university_shortlists']['status'] = 'In Progress';
        }
    }

    // 3. Get University Applications
    $applications_query = $conn->prepare("SELECT * FROM university_applications WHERE student_id = ? ORDER BY created_at DESC");
    $applications_query->bind_param("i", $student_id);
    $applications_query->execute();
    $applications_result = $applications_query->get_result();
    
    $latest_application_update = null;
    
    if ($applications_result->num_rows > 0) {
        while ($row = $applications_result->fetch_assoc()) {
            $progress['university_applications']['details'][] = $row;
            
            // Track latest update
            if ($latest_application_update === null || strtotime($row['created_at']) > strtotime($latest_application_update)) {
                $latest_application_update = $row['created_at'];
            }
        }
        
        $progress['university_applications']['count'] = $applications_result->num_rows;
        $progress['university_applications']['last_updated'] = $latest_application_update;
        
        if ($applications_result->num_rows >= 1) {
            $progress['university_applications']['status'] = 'Complete';
        } else {
            $progress['university_applications']['status'] = 'In Progress';
        }
    }

    // 4. Get Bank Statements
    $bank_query = $conn->prepare("SELECT * FROM bank_statements WHERE student_id = ? ORDER BY uploaded_at DESC");
    $bank_query->bind_param("i", $student_id);
    $bank_query->execute();
    $bank_result = $bank_query->get_result();
    
    $latest_bank_update = null;
    $statement_types = [];
    
    if ($bank_result->num_rows > 0) {
        while ($row = $bank_result->fetch_assoc()) {
            $progress['bank_statements']['details'][] = $row;
            $statement_types[] = $row['statement_type'];
            
            // Track latest update
            if ($latest_bank_update === null || strtotime($row['uploaded_at']) > strtotime($latest_bank_update)) {
                $latest_bank_update = $row['uploaded_at'];
            }
        }
        
        $progress['bank_statements']['count'] = $bank_result->num_rows;
        $progress['bank_statements']['types_submitted'] = array_unique($statement_types);
        $progress['bank_statements']['last_updated'] = $latest_bank_update;
        
        if (count($statement_types) >= 1) {
            $progress['bank_statements']['status'] = 'Complete';
        } else {
            $progress['bank_statements']['status'] = 'In Progress';
        }
    }

    // 5. Get Fee Status
    $fee_query = $conn->prepare("SELECT * FROM student_financials WHERE student_id = ?");
    $fee_query->bind_param("i", $student_id);
    $fee_query->execute();
    $fee_result = $fee_query->get_result();
    
    if ($fee_result->num_rows > 0) {
        $fee_data = $fee_result->fetch_assoc();
        $progress['fee_status']['is_paid'] = ($fee_data['fee_status'] == 'paid');
        $progress['fee_status']['payment_date'] = $fee_data['payment_date'];
        $progress['fee_status']['last_updated'] = $fee_data['updated_at'];
        $progress['fee_status']['status'] = $progress['fee_status']['is_paid'] ? 'Complete' : 'In Progress';
    }

    // Calculate overall progress
    $statuses = [
        $progress['application_materials']['status'],
        $progress['university_shortlists']['status'],
        $progress['university_applications']['status'],
        $progress['bank_statements']['status'],
        $progress['fee_status']['status']
    ];
    
    $complete_count = 0;
    $in_progress_count = 0;
    
    foreach ($statuses as $status) {
        if ($status == 'Complete') {
            $complete_count++;
        } else if ($status == 'In Progress') {
            $in_progress_count++;
        }
    }
    
    if ($complete_count == 5) {
        $progress['overall_status'] = 'Complete';
        $progress['completion_percentage'] = 100;
    } else if ($complete_count > 0 || $in_progress_count > 0) {
        $progress['overall_status'] = 'In Progress';
        $progress['completion_percentage'] = ($complete_count / 5) * 100;
    }
    
    return $progress;
}

// Get application progress for the student
$progress = getApplicationProgress($conn, $student_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; padding-top: 50px; }
        .tracker-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-not-started { background-color: #e9ecef; color: #495057; }
        .status-in-progress { background-color: #fff3cd; color: #856404; }
        .status-complete { background-color: #d4edda; color: #155724; }
        .progress-section {
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .last-updated {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="tracker-container">
                    <h2 class="text-center mb-4">Application Status Tracker</h2>
                    
                    <!-- Student Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Student Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['studentName']); ?></p>
                                    <p><strong>ID:</strong> <?php echo $student_id; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Overall Status:</strong> 
                                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['overall_status'])); ?>">
                                            <?php echo $progress['overall_status']; ?>
                                        </span>
                                    </p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress['completion_percentage']; ?>%" 
                                            aria-valuenow="<?php echo $progress['completion_percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo round($progress['completion_percentage']); ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Application Status Change Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Update Application Status</h4>
                        </div>
                        <div class="card-body">
                            <form action="update_application_status.php" method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="application_status" class="form-label">Application Status</label>
                                        <select name="application_status" id="application_status" class="form-select">
                                            <option value="In Progress" <?php echo ($progress['overall_status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Complete" <?php echo ($progress['overall_status'] == 'Complete') ? 'selected' : ''; ?>>Complete</option>
                                            <option value="On Hold">On Hold</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Withdrawn">Withdrawn</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status_update_date" class="form-label">Status Date</label>
                                        <input type="date" class="form-control" name="status_update_date" id="status_update_date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="status_notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="status_notes" name="status_notes" rows="2"></textarea>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Application Components -->
                    <div class="row">
                        <!-- Application Materials -->
                        <div class="col-md-6">
                            <div class="progress-section">
                                <div class="section-header">
                                    <h5>Application Materials</h5>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['application_materials']['status'])); ?>">
                                        <?php echo $progress['application_materials']['status']; ?>
                                    </span>
                                </div>
                                <p>Uploaded: <?php echo $progress['application_materials']['count']; ?> / 
                                   Required: <?php echo $progress['application_materials']['required_count']; ?>
                                </p>
                                <?php if (!empty($progress['application_materials']['last_updated'])): ?>
                                    <p class="last-updated">Last updated: <?php echo $progress['application_materials']['last_updated']; ?></p>
                                <?php endif; ?>
                                <a href="upload_materials.php?student_id=<?php echo $student_id; ?>" class="btn btn-sm btn-outline-primary">Manage Documents</a>
                            </div>
                        </div>
                        
                        <!-- University Shortlists -->
                        <div class="col-md-6">
                            <div class="progress-section">
                                <div class="section-header">
                                    <h5>University Shortlists</h5>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['university_shortlists']['status'])); ?>">
                                        <?php echo $progress['university_shortlists']['status']; ?>
                                    </span>
                                </div>
                                <div>
                                    <p>Initial Shortlist: 
                                        <?php echo $progress['university_shortlists']['has_initial'] ? 
                                            '<span class="text-success">✓ Uploaded</span>' : 
                                            '<span class="text-danger">✗ Missing</span>'; ?>
                                    </p>
                                    <p>Final Shortlist: 
                                        <?php echo $progress['university_shortlists']['has_final'] ? 
                                            '<span class="text-success">✓ Uploaded</span>' : 
                                            '<span class="text-danger">✗ Missing</span>'; ?>
                                    </p>
                                </div>
                                <?php if (!empty($progress['university_shortlists']['last_updated'])): ?>
                                    <p class="last-updated">Last updated: <?php echo $progress['university_shortlists']['last_updated']; ?></p>
                                <?php endif; ?>
                                <a href="upload_university_shortlist.php?student_id=<?php echo $student_id; ?>" class="btn btn-sm btn-outline-primary">Manage Shortlists</a>
                            </div>
                        </div>
                        
                        <!-- University Applications -->
                        <div class="col-md-6">
                            <div class="progress-section">
                                <div class="section-header">
                                    <h5>University Applications</h5>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['university_applications']['status'])); ?>">
                                        <?php echo $progress['university_applications']['status']; ?>
                                    </span>
                                </div>
                                <p>Total Applications: <?php echo $progress['university_applications']['count']; ?></p>
                                <?php if (!empty($progress['university_applications']['last_updated'])): ?>
                                    <p class="last-updated">Last updated: <?php echo $progress['university_applications']['last_updated']; ?></p>
                                <?php endif; ?>
                                <a href="upload_university_finalist.php?student_id=<?php echo $student_id; ?>" class="btn btn-sm btn-outline-primary">Manage Applications</a>
                            </div>
                        </div>
                        
                        <!-- Bank Statements -->
                        <div class="col-md-6">
                            <div class="progress-section">
                                <div class="section-header">
                                    <h5>Bank Statements</h5>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['bank_statements']['status'])); ?>">
                                        <?php echo $progress['bank_statements']['status']; ?>
                                    </span>
                                </div>
                                <p>Statements Uploaded: <?php echo $progress['bank_statements']['count']; ?></p>
                                <?php if (!empty($progress['bank_statements']['types_submitted'])): ?>
                                    <p>Types: <?php echo implode(', ', $progress['bank_statements']['types_submitted']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($progress['bank_statements']['last_updated'])): ?>
                                    <p class="last-updated">Last updated: <?php echo $progress['bank_statements']['last_updated']; ?></p>
                                <?php endif; ?>
                                <a href="bank_statement.php?student_id=<?php echo $student_id; ?>" class="btn btn-sm btn-outline-primary">Manage Statements</a>
                            </div>
                        </div>
                        
                        <!-- Fee Status -->
                        <div class="col-md-6">
                            <div class="progress-section">
                                <div class="section-header">
                                    <h5>Application Fee Status</h5>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $progress['fee_status']['status'])); ?>">
                                        <?php echo $progress['fee_status']['status']; ?>
                                    </span>
                                </div>
                                <p>Payment Status: 
                                    <?php echo $progress['fee_status']['is_paid'] ? 
                                        '<span class="text-success">Paid</span>' : 
                                        '<span class="text-danger">Unpaid</span>'; ?>
                                </p>
                                <?php if (!empty($progress['fee_status']['payment_date'])): ?>
                                    <p>Payment Date: <?php echo $progress['fee_status']['payment_date']; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($progress['fee_status']['last_updated'])): ?>
                                    <p class="last-updated">Last updated: <?php echo $progress['fee_status']['last_updated']; ?></p>
                                <?php endif; ?>
                                <a href="bank_statement.php?student_id=<?php echo $student_id; ?>" class="btn btn-sm btn-outline-primary">Manage Fee Status</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity Timeline -->
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h4>Application Activity Timeline</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <?php
                                // Combine all timestamps and sort
                                $activities = [];
                                
                                // Application Materials
                                foreach ($progress['application_materials']['details'] as $material) {
                                    $activities[] = [
                                        'date' => $material['uploaded_at'],
                                        'type' => 'Document',
                                        'description' => 'Uploaded ' . $material['material'],
                                        'file_name' => $material['file_name']
                                    ];
                                }
                                
                                // University Shortlists
                                foreach ($progress['university_shortlists']['details'] as $shortlist) {
                                    $activities[] = [
                                        'date' => $shortlist['upload_date'],
                                        'type' => 'Shortlist',
                                        'description' => 'Uploaded ' . str_replace('_', ' ', $shortlist['file_type']),
                                        'file_name' => $shortlist['file_name']
                                    ];
                                }
                                
                                // University Applications
                                foreach ($progress['university_applications']['details'] as $application) {
                                    $activities[] = [
                                        'date' => $application['created_at'],
                                        'type' => 'Application',
                                        'description' => 'Added application for ' . $application['university_name'] . ' - ' . $application['program_name'],
                                        'file_name' => ''
                                    ];
                                }
                                
                                // Bank Statements
                                foreach ($progress['bank_statements']['details'] as $statement) {
                                    $activities[] = [
                                        'date' => $statement['uploaded_at'],
                                        'type' => 'Bank Statement',
                                        'description' => 'Uploaded ' . $statement['statement_type'] . ' bank statement',
                                        'file_name' => $statement['file_name']
                                    ];
                                }
                                
                                // Sort by date (newest first)
                                usort($activities, function($a, $b) {
                                    return strtotime($b['date']) - strtotime($a['date']);
                                });
                                
                                // Display activities (limit to 10 most recent)
                                $count = 0;
                                foreach ($activities as $activity) {
                                    if ($count++ >= 10) break;
                                    
                                    echo '<li class="list-group-item">';
                                    echo '<div class="d-flex justify-content-between">';
                                    echo '<span class="badge bg-secondary">' . $activity['type'] . '</span>';
                                    echo '<small>' . date('M d, Y H:i', strtotime($activity['date'])) . '</small>';
                                    echo '</div>';
                                    echo '<p class="mb-0 mt-1">' . htmlspecialchars($activity['description']) . '</p>';
                                    if (!empty($activity['file_name'])) {
                                        echo '<small class="text-muted">' . htmlspecialchars($activity['file_name']) . '</small>';
                                    }
                                    echo '</li>';
                                }
                                
                                if (empty($activities)) {
                                    echo '<li class="list-group-item">No activities recorded yet</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-3 mb-5">
        <a href="dashboard.php" class="btn btn-secondary me-2">Back to Dashboard</a>
        <a href="student_profile.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary">View Student Profile</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>