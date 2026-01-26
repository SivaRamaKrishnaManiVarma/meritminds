<?php
// This file contains the sidebar navigation code
// It assumes that the session has already been started in the including file

// Check if user is logged in - safety check
if(!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("location: admin_login.php");
    exit;
}

// Get the current page filename to highlight the active menu item
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<div class="sidebar" style="width: 200px;">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'admin_dashboard.php') ? 'active' : ''; ?>" href="admin_dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'view_enquiries.php') ? 'active' : ''; ?>" href="view_enquiries.php">
                    <i class="fas fa-user-graduate"></i> Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'application_status.php') ? 'active' : ''; ?>" href="application_status.php">
                    <i class="fas fa-clipboard-list"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'documents.php') ? 'active' : ''; ?>" href="documents.php">
                    <i class="fas fa-file-alt"></i> Documents
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'financials.php') ? 'active' : ''; ?>" href="financials.php">
                    <i class="fas fa-money-bill"></i> Financials
                </a>
            </li>
            <?php if($_SESSION["admin_role"] === "Admin"): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'manage_partners.php') ? 'active' : ''; ?>" href="manage_partners.php">
                    <i class="fas fa-users-cog"></i> Partners
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>" href="reports.php">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'enquiry_conversion_report.php') ? 'active' : ''; ?>" href="enquiry_conversion_report.php">
                    <i class="fas fa-handshake"></i> Enquiry Conversion Reports
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'manage_studyoptions.php') ? 'active' : ''; ?>" href="manage_studyoptions.php">
                <i class="fas fa-cogs"></i> Manage Study Options
            </a>
        </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'view_admin_logs.php') ? 'active' : ''; ?>" href="view_admin_logs.php">
                    <i class="fas fa-history"></i> Admin Logs
                </a>
            </li>
        </ul>
    </div>
</div>