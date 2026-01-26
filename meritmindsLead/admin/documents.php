<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Initialize pagination variables
$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

// Initialize filter variables
$student_filter = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$document_type_filter = isset($_GET['document_type']) ? $_GET['document_type'] : '';
$where_clause = '';

// Build WHERE clause based on filters
if ($student_filter > 0 && !empty($document_type_filter)) {
    $document_type_filter = $conn->real_escape_string($document_type_filter);
    $where_clause = " WHERE a.student_id = $student_filter AND a.material = '$document_type_filter'";
} elseif ($student_filter > 0) {
    $where_clause = " WHERE a.student_id = $student_filter";
} elseif (!empty($document_type_filter)) {
    $document_type_filter = $conn->real_escape_string($document_type_filter);
    $where_clause = " WHERE a.material = '$document_type_filter'";
}

// Query for pagination
$total_records_query = "SELECT COUNT(*) as total FROM application_materials a" . $where_clause;
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to get documents with student info
$documents_query = "
    SELECT a.*, e.studentName 
    FROM application_materials a
    JOIN enquiries e ON a.student_id = e.id
    $where_clause
    ORDER BY a.uploaded_at DESC 
    LIMIT $offset, $records_per_page
";
$documents_result = $conn->query($documents_query);

// Get list of students for filter dropdown
$students_query = "SELECT id, studentName FROM enquiries ORDER BY studentName";
$students_result = $conn->query($students_query);

// Get list of document types for filter dropdown
$document_types_query = "SELECT DISTINCT material FROM application_materials ORDER BY material";
$document_types_result = $conn->query($document_types_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents - Lead Tracking Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
            color: white;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
        }
        .nav-link:hover {
            color: #fff;
        }
        .nav-link.active {
            color: #fff;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 200px;
            padding: 30px;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .table thead th {
            background-color: #4CAF50;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        .filter-box {
            margin-bottom: 20px;
        }
        .file-icon {
            font-size: 1.5rem;
        }
        .pdf-icon {
            color: #dc3545;
        }
        .doc-icon {
            color: #0d6efd;
        }
        .xls-icon {
            color: #198754;
        }
        .img-icon {
            color: #6f42c1;
        }
        .txt-icon {
            color: #6c757d;
        }
        .file-size {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php include 'topbar.php'; ?>


    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Document Management</h1>
            <!-- <a href="upload_document.php" class="btn btn-success">
                <i class="fas fa-file-upload"></i> Upload New Document
            </a> -->
        </div>
        
        <!-- Filter Box -->
        <div class="card filter-box">
            <div class="card-body">
                <form method="GET" action="documents.php" class="row g-3">
                    <div class="col-md-5">
                        <label for="student_id" class="form-label">Filter by Student:</label>
                        <select class="form-select" id="student_id" name="student_id">
                            <option value="0">All Students</option>
                            <?php while($student = $students_result->fetch_assoc()): ?>
                                <option value="<?php echo $student['id']; ?>" <?php if($student_filter == $student['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($student['studentName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="document_type" class="form-label">Filter by Document Type:</label>
                        <select class="form-select" id="document_type" name="document_type">
                            <option value="">All Document Types</option>
                            <?php while($doc_type = $document_types_result->fetch_assoc()): ?>
                                <option value="<?php echo $doc_type['material']; ?>" <?php if($document_type_filter == $doc_type['material']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($doc_type['material']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="documents.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Documents Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt me-1"></i> Documents List (<?php echo $total_records; ?> records found)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Document Type</th>
                                <th>File</th>
                                <th>Uploaded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($documents_result && $documents_result->num_rows > 0):
                                $i=1;
                                while($row = $documents_result->fetch_assoc()): 
                                    // Determine file icon based on file extension
                                    $file_extension = pathinfo($row['file_name'], PATHINFO_EXTENSION);
                                    $icon_class = 'txt-icon';
                                    $icon_name = 'file-alt';
                                    
                                    switch(strtolower($file_extension)) {
                                        case 'pdf':
                                            $icon_class = 'pdf-icon';
                                            $icon_name = 'file-pdf';
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            $icon_class = 'doc-icon';
                                            $icon_name = 'file-word';
                                            break;
                                        case 'xls':
                                        case 'xlsx':
                                        case 'csv':
                                            $icon_class = 'xls-icon';
                                            $icon_name = 'file-excel';
                                            break;
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                        case 'gif':
                                            $icon_class = 'img-icon';
                                            $icon_name = 'file-image';
                                            break;
                                        case 'txt':
                                            $icon_class = 'txt-icon';
                                            $icon_name = 'file-alt';
                                            break;
                                        default:
                                            $icon_class = 'txt-icon';
                                            $icon_name = 'file-alt';
                                    }
                            ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                <td><?php echo htmlspecialchars($row['material']); ?></td>
                                <td>
                                    <i class="fas fa-<?php echo $icon_name; ?> file-icon <?php echo $icon_class; ?> me-2"></i>
                                    <?php echo htmlspecialchars($row['file_name']); ?>
                                    <?php if(isset($row['file_size'])): ?>
                                        <span class="file-size d-block"><?php echo round($row['file_size']/1024, 2); ?> KB</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('M d, Y H:i', strtotime($row['uploaded_at'])); ?></td>
                                <td>
                                    <!-- <a href="../<?php echo $row['file_path']; ?>" class="btn btn-sm btn-info" title="View/Download" target="_blank">
                                        <i class="fas fa-download"></i>
                                    </a> -->
                                    <!-- <a href="replace_document.php?id=<?php //echo $row['id']; ?>" class="btn btn-sm btn-warning" title="Replace">
                                        <i class="fas fa-sync-alt"></i>
                                    </a> -->
                                    <a href="delete_document.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this document?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">No documents found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1).(($student_filter > 0) ? '&student_id='.$student_filter : '').((!empty($document_type_filter)) ? '&document_type='.$document_type_filter : ''); ?>">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo ($student_filter > 0) ? '&student_id='.$student_filter : ''; ?><?php echo (!empty($document_type_filter)) ? '&document_type='.$document_type_filter : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1).(($student_filter > 0) ? '&student_id='.$student_filter : '').((!empty($document_type_filter)) ? '&document_type='.$document_type_filter : ''); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Document Upload Modal -->
        <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="uploadDocumentModalLabel">Upload New Document</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="process_document_upload.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="student_id_upload" class="form-label">Student:</label>
                                <select class="form-select" id="student_id_upload" name="student_id" required>
                                    <option value="">Select Student</option>
                                    <?php 
                                    // Reset pointer for students result
                                    $students_result->data_seek(0);
                                    while($student = $students_result->fetch_assoc()): 
                                    ?>
                                        <option value="<?php echo $student['id']; ?>">
                                            <?php echo htmlspecialchars($student['studentName']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="document_type_upload" class="form-label">Document Type:</label>
                                <select class="form-select" id="document_type_upload" name="document_type" required>
                                    <option value="">Select Document Type</option>
                                    <option value="SSC Certificate">SSC Certificate</option>
                                    <option value="Inter Certificate">Inter Certificate</option>
                                    <option value="Graduation Certificate">Graduation Certificate</option>
                                    <option value="Provisional Certificate">Provisional Certificate</option>
                                    <option value="Resume">Resume</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Statement of Purpose">Statement of Purpose</option>
                                    <option value="Recommendation Letter">Recommendation Letter</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3" id="other_document_type_container" style="display: none;">
                                <label for="other_document_type" class="form-label">Specify Document Type:</label>
                                <input type="text" class="form-control" id="other_document_type" name="other_document_type">
                            </div>
                            <div class="mb-3">
                                <label for="document_file" class="form-label">File:</label>
                                <input type="file" class="form-control" id="document_file" name="document_file" required>
                                <small class="text-muted">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max size: 5MB)</small>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes (Optional):</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Upload Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide other document type field based on selection
        document.getElementById('document_type_upload').addEventListener('change', function() {
            const otherContainer = document.getElementById('other_document_type_container');
            if (this.value === 'Other') {
                otherContainer.style.display = 'block';
            } else {
                otherContainer.style.display = 'none';
            }
        });
        
        // Initialize upload document modal
        document.querySelector('a[href="upload_document.php"]').addEventListener('click', function(e) {
            e.preventDefault();
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadDocumentModal'));
            uploadModal.show();
        });
    </script>
</body>
</html>