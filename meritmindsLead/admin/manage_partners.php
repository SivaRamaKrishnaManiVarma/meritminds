<?php
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Partners - Lead Tracking Admin</title>
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
    </style>
</head>
<?php

    // Include database configuration
    include 'dbconfig.php';

    // Initialize status message
    $status_message = '';
    $status_type = '';

    // Process delete user request
    if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        // Don't allow deleting your own account
        if($user_id == $_SESSION['admin_id']) {
            $status_message = "You cannot delete your own account!";
            $status_type = "danger";
        } else {
            // Delete the user
            $delete_sql = "DELETE FROM partner_login WHERE id = ?";
            
            if($stmt = $conn->prepare($delete_sql)) {
                $stmt->bind_param("i", $user_id);
                
                if($stmt->execute()) {
                    $status_message = "User deleted successfully!";
                    $status_type = "success";
                } else {
                    $status_message = "Error deleting partner: " . $stmt->error;
                    $status_type = "danger";
                }
                $stmt->close();
            }
        }
    }

    // Process add new user request
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];
        $role = $conn->real_escape_string($_POST['role']);
        $branch_name = $conn->real_escape_string($_POST['branch_name']);
        
        // Check if partner name already exists
        $check_sql = "SELECT id FROM partner_login WHERE username = ?";
        if($stmt = $conn->prepare($check_sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0) {
                $status_message = "Username already exists!";
                $status_type = "danger";
            } else {
                // Insert new user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO partner_login (username, password, role, branch_name) VALUES (?, ?, ?, ?)";
                
                if($insert_stmt = $conn->prepare($insert_sql)) {
                    $insert_stmt->bind_param("ssss", $username, $hashed_password, $role, $branch_name);
                    
                    if($insert_stmt->execute()) {
                        $status_message = "Partner added successfully!";
                        $status_type = "success";
                    } else {
                        $status_message = "Error adding partner: " . $insert_stmt->error;
                        $status_type = "danger";
                    }
                    $insert_stmt->close();
                }
            }
            $stmt->close();
        }
    }

    // Get all users
    $users_query = "SELECT id, username, role, branch_name FROM partner_login ORDER BY username";
    $users_result = $conn->query($users_query);
    $users = [];

    if($users_result) {
        while($row = $users_result->fetch_assoc()) {
            $users[] = $row;
        }
    }
?>


<body>
    <!-- Navigation -->
    <?php include 'topbar.php'; ?>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>


    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Partners</h1>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-1"></i> Add New Partner
            </button>
        </div>
        
        <?php if(!empty($status_message)): ?>
            <div class="alert alert-<?php echo $status_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $status_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users me-1"></i> Partner Accounts
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Partner Name</th>
                                <th>Role</th>
                                <th>Branch Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; if(!empty($users)): ?>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><?php echo $i;$i++; ?></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                                        <td><?php echo htmlspecialchars($user['branch_name']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-user" 
                                                    data-id="<?php echo $user['id']; ?>" 
                                                    data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                    data-role="<?php echo htmlspecialchars($user['role']); ?>"
                                                    data-branch="<?php echo htmlspecialchars($user['branch_name']); ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUserModal">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            
                                            <button class="btn btn-sm btn-warning change-password" 
                                                    data-id="<?php echo $user['id']; ?>" 
                                                    data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#changePasswordModal">
                                                <i class="fas fa-key"></i> Change Password
                                            </button>
                                            
                                            <?php if($user['id'] != $_SESSION['admin_id']): ?>
                                                <a href="manage_partners.php?action=delete&id=<?php echo $user['id']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure you want to delete this partner?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No partners found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="branch_name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_user" class="btn btn-success">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_user.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_branch_name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" id="edit_branch_name" name="branch_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change User Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="change_user_password.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="change_password_user_id" name="user_id">
                        <div class="mb-3">
                            <label for="user_display" class="form-label">Username</label>
                            <input type="text" class="form-control" id="user_display" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <small class="form-text text-danger">Password must be at least 6 characters long.</small>

                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit user event handlers
        document.querySelectorAll('.edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                const role = this.getAttribute('data-role');
                const branch = this.getAttribute('data-branch');
                
                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_branch_name').value = branch;
            });
        });
        
        // Change password event handlers
        document.querySelectorAll('.change-password').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');
                
                document.getElementById('change_password_user_id').value = userId;
                document.getElementById('user_display').value = username;
            });
        });
        
        // Form validation for password match
        document.querySelector('#changePasswordModal form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>