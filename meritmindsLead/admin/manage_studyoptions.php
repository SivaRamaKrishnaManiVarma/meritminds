<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Check if admin has appropriate permissions
if($_SESSION["admin_role"] !== "Admin") {
    header("location: admin_dashboard.php");
    exit;
}

// Include database configuration
include 'dbconfig.php';

// Set default tab
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'intakes';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_intake':
                $name = $conn->real_escape_string($_POST['name']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "INSERT INTO intakes (name, is_active) VALUES ('$name', $is_active)";
                $conn->query($sql);
                break;
                
            case 'edit_intake':
                $id = $conn->real_escape_string($_POST['id']);
                $name = $conn->real_escape_string($_POST['name']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "UPDATE intakes SET name = '$name', is_active = $is_active WHERE id = $id";
                $conn->query($sql);
                break;
                
            case 'delete_intake':
                $id = $conn->real_escape_string($_POST['id']);
                
                // Check if intake is in use before deleting
                $check_sql = "SELECT COUNT(*) as count FROM student_intakes WHERE intake_id = $id";
                $result = $conn->query($check_sql);
                $row = $result->fetch_assoc();
                
                if ($row['count'] == 0) {
                    $sql = "DELETE FROM intakes WHERE id = $id";
                    $conn->query($sql);
                } else {
                    $_SESSION['error_message'] = "Cannot delete intake as it is being used by students. Deactivate it instead.";
                }
                break;
                
            case 'add_country':
                $name = $conn->real_escape_string($_POST['name']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "INSERT INTO countries (name, is_active) VALUES ('$name', $is_active)";
                $conn->query($sql);
                break;
                
            case 'edit_country':
                $id = $conn->real_escape_string($_POST['id']);
                $name = $conn->real_escape_string($_POST['name']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "UPDATE countries SET name = '$name', is_active = $is_active WHERE id = $id";
                $conn->query($sql);
                break;
                
            case 'delete_country':
                $id = $conn->real_escape_string($_POST['id']);
                
                // Check if country is in use before deleting
                $check_sql = "SELECT COUNT(*) as count FROM student_countries WHERE country_id = $id";
                $result = $conn->query($check_sql);
                $row = $result->fetch_assoc();
                
                $check_universities = "SELECT COUNT(*) as count FROM universities WHERE country_id = $id";
                $result_uni = $conn->query($check_universities);
                $row_uni = $result_uni->fetch_assoc();
                
                if ($row['count'] == 0 && $row_uni['count'] == 0) {
                    $sql = "DELETE FROM countries WHERE id = $id";
                    $conn->query($sql);
                } else {
                    $_SESSION['error_message'] = "Cannot delete country as it is being used by students or universities. Deactivate it instead.";
                }
                break;
                
            case 'add_university':
                $name = $conn->real_escape_string($_POST['name']);
                $country_id = $conn->real_escape_string($_POST['country_id']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "INSERT INTO universities (name, country_id, is_active) VALUES ('$name', $country_id, $is_active)";
                $conn->query($sql);
                break;
                
            case 'edit_university':
                $id = $conn->real_escape_string($_POST['id']);
                $name = $conn->real_escape_string($_POST['name']);
                $country_id = $conn->real_escape_string($_POST['country_id']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "UPDATE universities SET name = '$name', country_id = $country_id, is_active = $is_active WHERE id = $id";
                $conn->query($sql);
                break;
                
            case 'delete_university':
                $id = $conn->real_escape_string($_POST['id']);
                
                // Check if university is in use before deleting
                $check_sql = "SELECT COUNT(*) as count FROM student_universities WHERE university_id = $id";
                $result = $conn->query($check_sql);
                $row = $result->fetch_assoc();
                
                if ($row['count'] == 0) {
                    $sql = "DELETE FROM universities WHERE id = $id";
                    $conn->query($sql);
                } else {
                    $_SESSION['error_message'] = "Cannot delete university as it is being used by students. Deactivate it instead.";
                }
                break;
                
            case 'add_budget':
                $price_range = $conn->real_escape_string($_POST['price_range']);
                $display_order = $conn->real_escape_string($_POST['display_order']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "INSERT INTO tuition_fee_budgets (price_range, display_order, is_active) VALUES ('$price_range', $display_order, $is_active)";
                $conn->query($sql);
                break;
                
            case 'edit_budget':
                $id = $conn->real_escape_string($_POST['id']);
                $price_range = $conn->real_escape_string($_POST['price_range']);
                $display_order = $conn->real_escape_string($_POST['display_order']);
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $sql = "UPDATE tuition_fee_budgets SET price_range = '$price_range', display_order = $display_order, is_active = $is_active WHERE id = $id";
                $conn->query($sql);
                break;
                
            case 'delete_budget':
                $id = $conn->real_escape_string($_POST['id']);
                $sql = "DELETE FROM tuition_fee_budgets WHERE id = $id";
                $conn->query($sql);
                break;
        }
        
        // Redirect to prevent form resubmission
        header("Location: manage_studyoptions.php?tab=$tab");
        exit;
    }
}

// Get data for each tab
$intakes_query = "SELECT * FROM intakes ORDER BY created_at DESC";
$intakes_result = $conn->query($intakes_query);

$countries_query = "SELECT * FROM countries ORDER BY name ASC";
$countries_result = $conn->query($countries_query);

$universities_query = "SELECT u.*, c.name as country_name 
                       FROM universities u 
                       LEFT JOIN countries c ON u.country_id = c.id 
                       ORDER BY u.name ASC";
$universities_result = $conn->query($universities_query);

$budgets_query = "SELECT * FROM tuition_fee_budgets ORDER BY display_order ASC";
$budgets_result = $conn->query($budgets_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Study Options - Lead Tracking Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
           /* Add this to your CSS or update your existing styles */
           body {
            padding-top: 56px; /* For fixed navbar */
            background-color: #f8f9fa;
        }

        /* Sidebar positioning and styling */
        .sidebar {
            position: fixed;
            top: 56px; /* Height of navbar */
            left: 0;
            bottom: 0;
            width: 220px; /* Fixed width */
            padding-top: 20px;
            background-color: #343a40;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 8px 16px;
            margin: 4px 0;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content area positioning */
        .main-content {
            margin-left: 220px; /* Should match sidebar width */
            padding: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 20px;
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        /* Main content styling - adjust for proper alignment */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
        
        /* DataTables styling */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
        
        /* Table styling */
        .table th {
            background-color: #f8f9fa;
        }
        
        /* Active/inactive status styling */
        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }
        
        /* Form elements styling */
        .form-check-input:checked {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        
        /* Button styles */
        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        
        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
        
        /* Modal header styling */
        .modal-header {
            background-color: #4CAF50;
            color: white;
        }
        
        /* Modal header for delete modals */
        .modal-header.bg-danger {
            background-color: #dc3545 !important;
        }
        
        /* Tab navigation styling */
        .nav-tabs {
            margin-bottom: 20px;
        }
        
        .nav-tabs .nav-link.active {
            color: #4CAF50;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: bold;
        }
        
        .nav-tabs .nav-link:not(.active) {
            color: #6c757d;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            color: #4CAF50;
        }
        
        /* Action buttons in table */
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Card styling */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 1rem;
        }
    </style>
</head>
<body>
    <!-- Include Top Navigation Bar -->
    <?php include 'topbar.php'; ?>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    
    <div class="main-content">
        <h1 class="mb-4">Manage Study Options</h1>
        
        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?php echo $tab == 'intakes' ? 'active' : ''; ?>" href="?tab=intakes">
                    <i class="fas fa-calendar-alt me-2"></i>Intakes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $tab == 'countries' ? 'active' : ''; ?>" href="?tab=countries">
                    <i class="fas fa-globe me-2"></i>Countries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $tab == 'universities' ? 'active' : ''; ?>" href="?tab=universities">
                    <i class="fas fa-university me-2"></i>Universities
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $tab == 'budgets' ? 'active' : ''; ?>" href="?tab=budgets">
                    <i class="fas fa-money-bill me-2"></i>Tuition Fee Budgets
                </a>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Intakes Tab -->
            <?php if($tab == 'intakes'): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Intakes</h5>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addIntakeModal">
                            <i class="fas fa-plus me-1"></i> Add New Intake
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="intakesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Intake Name</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                     while($intake = $intakes_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $i;$i++; ?></td>
                                            <td><?php echo htmlspecialchars($intake['name']); ?></td>
                                            <td>
                                                <span class="badge <?php echo $intake['is_active'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $intake['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($intake['created_at'])); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($intake['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-primary btn-sm edit-intake" 
                                                            data-id="<?php echo $intake['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($intake['name']); ?>"
                                                            data-active="<?php echo $intake['is_active']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-intake" 
                                                            data-id="<?php echo $intake['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($intake['name']); ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Add Intake Modal -->
                <div class="modal fade" id="addIntakeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Intake</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="add_intake">
                                    <div class="mb-3">
                                        <label for="intakeName" class="form-label">Intake Name</label>
                                        <input type="text" class="form-control" id="intakeName" name="name" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="intakeActive" name="is_active" checked>
                                        <label class="form-check-label" for="intakeActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add Intake</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Intake Modal -->
                <div class="modal fade" id="editIntakeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Intake</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_intake">
                                    <input type="hidden" name="id" id="editIntakeId">
                                    <div class="mb-3">
                                        <label for="editIntakeName" class="form-label">Intake Name</label>
                                        <input type="text" class="form-control" id="editIntakeName" name="name" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="editIntakeActive" name="is_active">
                                        <label class="form-check-label" for="editIntakeActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update Intake</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Intake Modal -->
                <div class="modal fade" id="deleteIntakeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete Intake</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="delete_intake">
                                    <input type="hidden" name="id" id="deleteIntakeId">
                                    <p>Are you sure you want to delete the intake: <strong id="deleteIntakeName"></strong>?</p>
                                    <p class="text-danger">This action cannot be undone. If this intake is being used by students, consider deactivating it instead.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Countries Tab -->
            <?php if($tab == 'countries'): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Countries</h5>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                            <i class="fas fa-plus me-1"></i> Add New Country
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="countriesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Country Name</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                     while($country = $countries_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $i; $i++ ?></td>
                                            <td><?php echo htmlspecialchars($country['name']); ?></td>
                                            <td>
                                                <span class="badge <?php echo $country['is_active'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $country['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($country['created_at'])); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($country['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-primary btn-sm edit-country" 
                                                            data-id="<?php echo $country['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($country['name']); ?>"
                                                            data-active="<?php echo $country['is_active']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-country" 
                                                            data-id="<?php echo $country['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($country['name']); ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Add Country Modal -->
                <div class="modal fade" id="addCountryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Country</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="add_country">
                                    <div class="mb-3">
                                        <label for="countryName" class="form-label">Country Name</label>
                                        <input type="text" class="form-control" id="countryName" name="name" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="countryActive" name="is_active" checked>
                                        <label class="form-check-label" for="countryActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Country Modal -->
                <div class="modal fade" id="editCountryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Country</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_country">
                                    <input type="hidden" name="id" id="editCountryId">
                                    <div class="mb-3">
                                        <label for="editCountryName" class="form-label">Country Name</label>
                                        <input type="text" class="form-control" id="editCountryName" name="name" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="editCountryActive" name="is_active">
                                        <label class="form-check-label" for="editCountryActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update Country</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Country Modal -->
                <div class="modal fade" id="deleteCountryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete Country</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="delete_country">
                                    <input type="hidden" name="id" id="deleteCountryId">
                                    <p>Are you sure you want to delete the country: <strong id="deleteCountryName"></strong>?</p>
                                    <p class="text-danger">This action cannot be undone. If this country is being used by students or universities, consider deactivating it instead.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Universities Tab -->
            <?php if($tab == 'universities'): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Universities</h5>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUniversityModal">
                            <i class="fas fa-plus me-1"></i> Add New University
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="universitiesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>University Name</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; 
                                    while($university = $universities_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php echo htmlspecialchars($university['name']); ?></td>
                                            <td><?php echo htmlspecialchars($university['country_name']); ?></td>
                                            <td>
                                                <span class="badge <?php echo $university['is_active'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $university['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($university['created_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-primary btn-sm edit-university" 
                                                            data-id="<?php echo $university['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($university['name']); ?>"
                                                            data-country="<?php echo $university['country_id']; ?>"
                                                            data-active="<?php echo $university['is_active']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-university" 
                                                            data-id="<?php echo $university['id']; ?>"
                                                            data-name="<?php echo htmlspecialchars($university['name']); ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Add University Modal -->
                <div class="modal fade" id="addUniversityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New University</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="add_university">
                                    <div class="mb-3">
                                        <label for="universityName" class="form-label">University Name</label>
                                        <input type="text" class="form-control" id="universityName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="universityCountry" class="form-label">Country</label>
                                        <select class="form-select" id="universityCountry" name="country_id" required>
                                            <option value="">Select Country</option>
                                            <?php 
                                            $countries_result->data_seek(0);
                                            while($country = $countries_result->fetch_assoc()): 
                                            ?>
                                                <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="universityActive" name="is_active" checked>
                                        <label class="form-check-label" for="universityActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add University</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Edit University Modal -->
                <div class="modal fade" id="editUniversityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit University</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_university">
                                    <input type="hidden" name="id" id="editUniversityId">
                                    <div class="mb-3">
                                        <label for="editUniversityName" class="form-label">University Name</label>
                                        <input type="text" class="form-control" id="editUniversityName" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editUniversityCountry" class="form-label">Country</label>
                                        <select class="form-select" id="editUniversityCountry" name="country_id" required>
                                            <option value="">Select Country</option>
                                            <?php 
                                            $countries_result->data_seek(0);
                                            while($country = $countries_result->fetch_assoc()): 
                                            ?>
                                                <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="editUniversityActive" name="is_active">
                                        <label class="form-check-label" for="editUniversityActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update University</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete University Modal -->
                <div class="modal fade" id="deleteUniversityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete University</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="delete_university">
                                    <input type="hidden" name="id" id="deleteUniversityId">
                                    <p>Are you sure you want to delete the university: <strong id="deleteUniversityName"></strong>?</p>
                                    <p class="text-danger">This action cannot be undone. If this university is being used by students, consider deactivating it instead.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Tuition Fee Budgets Tab -->
            <?php if($tab == 'budgets'): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tuition Fee Budgets</h5>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
                            <i class="fas fa-plus me-1"></i> Add New Budget Range
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="budgetsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Price Range</th>
                                        <th>Display Order</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                    while($budget = $budgets_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $i; $i++; ?></td>
                                            <td><?php echo htmlspecialchars($budget['price_range']); ?></td>
                                            <td><?php echo $budget['display_order']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $budget['is_active'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $budget['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($budget['created_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-primary btn-sm edit-budget" 
                                                            data-id="<?php echo $budget['id']; ?>"
                                                            data-price="<?php echo htmlspecialchars($budget['price_range']); ?>"
                                                            data-order="<?php echo $budget['display_order']; ?>"
                                                            data-active="<?php echo $budget['is_active']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-budget" 
                                                            data-id="<?php echo $budget['id']; ?>"
                                                            data-price="<?php echo htmlspecialchars($budget['price_range']); ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Add Budget Modal -->
                <div class="modal fade" id="addBudgetModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Budget Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="add_budget">
                                    <div class="mb-3">
                                        <label for="budgetPrice" class="form-label">Price Range</label>
                                        <input type="text" class="form-control" id="budgetPrice" name="price_range" required placeholder="e.g. $15,000 - $25,000">
                                    </div>
                                    <div class="mb-3">
                                        <label for="budgetOrder" class="form-label">Display Order</label>
                                        <input type="number" class="form-control" id="budgetOrder" name="display_order" min="1" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="budgetActive" name="is_active" checked>
                                        <label class="form-check-label" for="budgetActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add Budget Range</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Budget Modal -->
                <div class="modal fade" id="editBudgetModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Budget Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="edit_budget">
                                    <input type="hidden" name="id" id="editBudgetId">
                                    <div class="mb-3">
                                        <label for="editBudgetPrice" class="form-label">Price Range</label>
                                        <input type="text" class="form-control" id="editBudgetPrice" name="price_range" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editBudgetOrder" class="form-label">Display Order</label>
                                        <input type="number" class="form-control" id="editBudgetOrder" name="display_order" min="1" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="editBudgetActive" name="is_active">
                                        <label class="form-check-label" for="editBudgetActive">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update Budget Range</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Budget Modal -->
                <div class="modal fade" id="deleteBudgetModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete Budget Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="action" value="delete_budget">
                                    <input type="hidden" name="id" id="deleteBudgetId">
                                    <p>Are you sure you want to delete the budget range: <strong id="deleteBudgetName"></strong>?</p>
                                    <p class="text-danger">This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#intakesTable, #countriesTable, #universitiesTable, #budgetsTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "desc"]]
            });
            
            // Intake edit functionality
            $('.edit-intake').click(function() {
                $('#editIntakeId').val($(this).data('id'));
                $('#editIntakeName').val($(this).data('name'));
                $('#editIntakeActive').prop('checked', $(this).data('active') == 1);
                $('#editIntakeModal').modal('show');
            });
            
            // Intake delete functionality
            $('.delete-intake').click(function() {
                $('#deleteIntakeId').val($(this).data('id'));
                $('#deleteIntakeName').text($(this).data('name'));
                $('#deleteIntakeModal').modal('show');
            });
            
            // Country edit functionality
            $('.edit-country').click(function() {
                $('#editCountryId').val($(this).data('id'));
                $('#editCountryName').val($(this).data('name'));
                $('#editCountryActive').prop('checked', $(this).data('active') == 1);
                $('#editCountryModal').modal('show');
            });
            
            // Country delete functionality
            $('.delete-country').click(function() {
                $('#deleteCountryId').val($(this).data('id'));
                $('#deleteCountryName').text($(this).data('name'));
                $('#deleteCountryModal').modal('show');
            });
            
            // University edit functionality
            $('.edit-university').click(function() {
                $('#editUniversityId').val($(this).data('id'));
                $('#editUniversityName').val($(this).data('name'));
                $('#editUniversityCountry').val($(this).data('country'));
                $('#editUniversityActive').prop('checked', $(this).data('active') == 1);
                $('#editUniversityModal').modal('show');
            });
            
            // University delete functionality
            $('.delete-university').click(function() {
                $('#deleteUniversityId').val($(this).data('id'));
                $('#deleteUniversityName').text($(this).data('name'));
                $('#deleteUniversityModal').modal('show');
            });
            
            // Budget edit functionality
            $('.edit-budget').click(function() {
                $('#editBudgetId').val($(this).data('id'));
                $('#editBudgetPrice').val($(this).data('price'));
                $('#editBudgetOrder').val($(this).data('order'));
                $('#editBudgetActive').prop('checked', $(this).data('active') == 1);
                $('#editBudgetModal').modal('show');
            });
            
            // Budget delete functionality
            $('.delete-budget').click(function() {
                $('#deleteBudgetId').val($(this).data('id'));
                $('#deleteBudgetName').text($(this).data('price'));
                $('#deleteBudgetModal').modal('show');
            });
        });
    </script>
</body>
</html>