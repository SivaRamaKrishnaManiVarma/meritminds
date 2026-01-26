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
$status_filter = isset($_GET['fee_status']) ? $_GET['fee_status'] : '';
$where_clause = '';

if (!empty($status_filter)) {
    $status_filter = $conn->real_escape_string($status_filter);
    $where_clause = " WHERE sf.fee_status = '$status_filter'";
}

// Query for pagination
$total_records_query = "SELECT COUNT(*) as total FROM student_financials sf" . $where_clause;
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to get student financials with student info
$financials_query = "
    SELECT sf.*, e.studentName,e.branchName, e.email, e.mobile, e.program, e.country
    FROM student_financials sf
    JOIN enquiries e ON sf.student_id = e.id
    $where_clause
    ORDER BY sf.updated_at DESC 
    LIMIT $offset, $records_per_page
";
$financials_result = $conn->query($financials_query);

// Get all students for the add payment form
$students_query = "
    SELECT e.id, e.studentName,e.branchName
    FROM enquiries e
    LEFT JOIN student_financials sf ON e.id = sf.student_id
    WHERE sf.id IS NULL
    ORDER BY e.studentName
";
$students_result = $conn->query($students_query);

// Summary statistics
$total_paid_query = "SELECT COUNT(*) as count FROM student_financials WHERE fee_status = 'paid'";
$total_paid_result = $conn->query($total_paid_query);
$total_paid = $total_paid_result->fetch_assoc()['count'];

$total_unpaid_query = "SELECT COUNT(*) as count FROM student_financials WHERE fee_status = 'unpaid'";
$total_unpaid_result = $conn->query($total_unpaid_query);
$total_unpaid = $total_unpaid_result->fetch_assoc()['count'];

// Get recent payments (last 5)
$recent_payments_query = "
    SELECT sf.*, e.studentName,e.branchName
    FROM student_financials sf
    JOIN enquiries e ON sf.student_id = e.id
    WHERE sf.fee_status = 'paid'
    ORDER BY sf.updated_at DESC
    LIMIT 5
";
$recent_payments_result = $conn->query($recent_payments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Financials - Lead Tracking Admin</title>
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
        .badge-paid {
            background-color: #28a745;
            color: white;
        }
        .badge-unpaid {
            background-color: #dc3545;
            color: white;
        }
        .stats-card {
            text-align: center;
            padding: 20px;
        }
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #4CAF50;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stats-text {
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
            <h1>Student Financials</h1>
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fas fa-plus"></i> Add Payment Record
            </a>
        </div>
        
        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card stats-card">
                    <i class="fas fa-check-circle text-success"></i>
                    <div class="stats-number"><?php echo $total_paid; ?></div>
                    <div class="stats-text">Payments Received</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stats-card">
                    <i class="fas fa-clock text-danger"></i>
                    <div class="stats-number"><?php echo $total_unpaid; ?></div>
                    <div class="stats-text">Pending Payments</div>
                </div>
            </div>
        </div>
        
        <!-- Filter Box -->
        <div class="card filter-box">
            <div class="card-body">
                <form method="GET" action="financials.php" class="row g-3">
                    <div class="col-md-6">
                        <label for="fee_status" class="form-label">Filter by Payment Status:</label>
                        <select class="form-select" id="fee_status" name="fee_status">
                            <option value="">All Statuses</option>
                            <option value="paid" <?php if($status_filter == 'paid') echo 'selected'; ?>>Paid</option>
                            <option value="unpaid" <?php if($status_filter == 'unpaid') echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                        <a href="financials.php" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Financials Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-money-bill me-1"></i> Financial Records (<?php echo $total_records; ?> records found)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Bramch Name</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Notes</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            if($financials_result && $financials_result->num_rows > 0):
                                while($row = $financials_result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($row['studentName']); ?>
                                    <div class="small text-muted"><?php echo htmlspecialchars($row['email']); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($row['branchName']); ?></td>

                                <td><?php echo htmlspecialchars($row['program']); ?></td>
                                <td>
                                    <?php if($row['fee_status'] == 'paid'): ?>
                                        <span class="badge badge-paid">Paid</span>
                                    <?php else: ?>
                                        <span class="badge badge-unpaid">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    if($row['payment_date']) {
                                        echo date('M d, Y', strtotime($row['payment_date']));
                                    } else {
                                        echo 'Not Applicable';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['fee_notes'] ?? ''); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($row['updated_at'])); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary edit-payment" data-id="<?php echo $row['id']; ?>" data-student="<?php echo htmlspecialchars($row['studentName']); ?>" data-status="<?php echo $row['fee_status']; ?>" data-date="<?php echo $row['payment_date']; ?>" data-notes="<?php echo htmlspecialchars($row['fee_notes'] ?? ''); ?>" title="Edit" data-bs-toggle="modal" data-bs-target="#editPaymentModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- <a href="bank_statements.php?student_id=<?php echo $row['student_id']; ?>" class="btn btn-sm btn-info" title="Bank Statements">
                                        <i class="fas fa-file-invoice-dollar"></i> -->
                                    </a>
                                    <a href="delete_payment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this payment record?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="8" class="text-center">No financial records found</td>
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
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1).((!empty($status_filter)) ? '&fee_status='.$status_filter : ''); ?>">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo (!empty($status_filter)) ? '&fee_status='.$status_filter : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1).((!empty($status_filter)) ? '&fee_status='.$status_filter : ''); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Payments -->
        <!-- <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-history me-1"></i> Recent Payments
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Payment Date</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($recent_payments_result && $recent_payments_result->num_rows > 0):
                                while($row = $recent_payments_result->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['payment_date'])); ?></td>
                                <td><?php echo htmlspecialchars($row['fee_notes'] ?? ''); ?></td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="3" class="text-center">No recent payments</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add Payment Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="process_payment.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student:</label>
                            <select class="form-select" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                <?php while($student = $students_result->fetch_assoc()): ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['studentName']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fee_status" class="form-label">Payment Status:</label>
                            <select class="form-select" id="fee_status" name="fee_status" required>
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div class="mb-3" id="payment_date_container" style="display: none;">
                        <label for="payment_date" class="form-label">Payment Date:</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date">
                        </div>
                        <div class="mb-3">
                            <label for="fee_notes" class="form-label">Notes:</label>
                            <textarea class="form-control" id="fee_notes" name="fee_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Payment Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Payment Modal -->
    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_payment.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_payment_id" name="payment_id">
                        <div class="mb-3">
                            <label for="edit_student_name" class="form-label">Student:</label>
                            <input type="text" class="form-control" id="edit_student_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_fee_status" class="form-label">Payment Status:</label>
                            <select class="form-select" id="edit_fee_status" name="fee_status" required>
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div class="mb-3" id="edit_payment_date_container">
                            <label for="edit_payment_date" class="form-label">Payment Date:</label>
                            <input type="date" class="form-control" id="edit_payment_date" name="payment_date">
                        </div>
                        <div class="mb-3">
                            <label for="edit_fee_notes" class="form-label">Notes:</label>
                            <textarea class="form-control" id="edit_fee_notes" name="fee_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Payment Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide payment date field based on fee status selection
        document.getElementById('fee_status').addEventListener('change', function() {
            const paymentDateContainer = document.getElementById('payment_date_container');
            if (this.value === 'paid') {
                paymentDateContainer.style.display = 'block';
            } else {
                paymentDateContainer.style.display = 'none';
            }
        });
        
        // Edit payment record functionality
        const editButtons = document.querySelectorAll('.edit-payment');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const student = this.getAttribute('data-student');
                const status = this.getAttribute('data-status');
                const date = this.getAttribute('data-date');
                const notes = this.getAttribute('data-notes');
                
                document.getElementById('edit_payment_id').value = id;
                document.getElementById('edit_student_name').value = student;
                document.getElementById('edit_fee_status').value = status;
                document.getElementById('edit_payment_date').value = date;
                document.getElementById('edit_fee_notes').value = notes;
                
                // Show/hide payment date field based on fee status
                const editPaymentDateContainer = document.getElementById('edit_payment_date_container');
                if (status === 'paid') {
                    editPaymentDateContainer.style.display = 'block';
                } else {
                    editPaymentDateContainer.style.display = 'none';
                }
            });
        });
        
        // Edit status change handler
        document.getElementById('edit_fee_status').addEventListener('change', function() {
            const editPaymentDateContainer = document.getElementById('edit_payment_date_container');
            if (this.value === 'paid') {
                editPaymentDateContainer.style.display = 'block';
            } else {
                editPaymentDateContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>