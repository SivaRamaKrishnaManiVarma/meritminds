<?php
session_start(); // Start the session
include 'dbconfig.php';

// Check if manager is logged in and has branch info
if (!isset($_SESSION["manager_logged_in"]) || !isset($_SESSION["manager_branch"])) {
    header("location: manager_login.php");
    exit;
}

// Get manager's branch
$manager_branch = $_SESSION["manager_branch"];

// Set headers for Excel file download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_data_export.xls"');
header('Cache-Control: max-age=0');

// Get parameters
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'all_students';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-30 days'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');

// Function to display error and exit
function showError($message) {
    echo '<h2>Error:</h2>';
    echo '<p>' . $message . '</p>';
    exit;
}

// Generate appropriate export based on type
try {
    switch ($report_type) {
        case 'all_students':
            exportAllStudents($conn, $manager_branch);
            break;
        case 'application_status':
            exportApplicationStatus($conn, $date_from, $date_to, $manager_branch);
            break;
        case 'document_submissions':
            exportDocumentSubmissions($conn, $date_from, $date_to, $manager_branch);
            break;
        case 'university_applications':
            exportUniversityApplications($conn, $date_from, $date_to, $manager_branch);
            break;
        case 'fee_status':
            exportFeeStatus($conn, $date_from, $date_to, $manager_branch);
            break;
        default:
            exportAllStudents($conn, $manager_branch);
    }
} catch (Exception $e) {
    showError("An error occurred: " . $e->getMessage());
}

// Function to export all student data
function exportAllStudents($conn, $manager_branch) {
    // Query to get student data with their application status
    $query = "
    SELECT 
        e.id,
        e.studentName,
        e.email,
        e.mobile,
        e.branchName,
        COALESCE(s.status, 'Not Started') as application_status,
        COALESCE(f.fee_status, 'unpaid') as fee_status,
        (SELECT COUNT(*) FROM application_materials WHERE student_id = e.id) as document_count,
        (SELECT COUNT(*) FROM university_applications WHERE student_id = e.id) as university_count,
        s.updated_at as last_updated
    FROM 
        enquiries e
    LEFT JOIN 
        application_status s ON e.id = s.student_id
    LEFT JOIN 
        student_financials f ON e.id = f.student_id
    WHERE
        e.branchName = ?
    ORDER BY 
        e.id
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        showError("Error preparing query: " . $conn->error);
    }
    
    $stmt->bind_param("s", $manager_branch);
    
    if (!$stmt->execute()) {
        showError("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    // Start the Excel file
    echo '<table border="1">';
    
    // Header row
    echo '<tr>';
    echo '<th>Branch Name</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Phone</th>';
    echo '<th>Application Status</th>';
    echo '<th>Fee Status</th>';
    echo '<th>Documents Uploaded</th>';
    echo '<th>Universities Applied</th>';
    echo '<th>Last Updated</th>';
    echo '</tr>';
    
    // Data rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['branchName'] . '</td>';
            echo '<td>' . htmlspecialchars($row['studentName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['mobile']) . '</td>';
            echo '<td>' . $row['application_status'] . '</td>';
            echo '<td>' . ucfirst($row['fee_status']) . '</td>';
            echo '<td>' . $row['document_count'] . '</td>';
            echo '<td>' . $row['university_count'] . '</td>';
            echo '<td>' . ($row['last_updated'] ? $row['last_updated'] : 'N/A') . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9">No student data found</td></tr>';
    }
    
    echo '</table>';
}

// Function to export application status data
function exportApplicationStatus($conn, $date_from, $date_to, $manager_branch) {
    // Get students with their status in the date range
    $query = "
        SELECT 
            e.id,
            e.studentName,
            e.email,
            e.mobile,
            e.branchName,
            COALESCE(s.status, 'Not Started') as status,
            s.status_date,
            s.notes,
            s.updated_at
        FROM 
            enquiries e
        LEFT JOIN 
            application_status s ON e.id = s.student_id
        WHERE 
            e.branchName = ? AND
            (s.updated_at BETWEEN ? AND ? OR s.updated_at IS NULL)
        ORDER BY 
            FIELD(COALESCE(s.status, 'Not Started'), 'Complete', 'In Progress', 'Not Started', 'On Hold', 'Rejected', 'Withdrawn'),
            e.studentName
    ";
    
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        showError("Error preparing query: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$stmt->execute()) {
        showError("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    // Report title and date range
    echo '<table border="0"><tr><td colspan="8"><h2>Application Status Report</h2>';
    echo '<p>Branch: ' . htmlspecialchars($manager_branch) . '</p>';
    echo '<p>Date Range: ' . date('M d, Y', strtotime($date_from)) . ' - ' . date('M d, Y', strtotime($date_to)) . '</p></td></tr></table>';
    
    // Start the Excel file
    echo '<table border="1">';
    
    // Header row
    echo '<tr>';
    echo '<th>Branch Name</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Phone</th>';
    echo '<th>Status</th>';
    echo '<th>Status Date</th>';
    echo '<th>Notes</th>';
    echo '<th>Last Updated</th>';
    echo '</tr>';
    
    // Data rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['branchName'] . '</td>';
            echo '<td>' . htmlspecialchars($row['studentName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['mobile']) . '</td>'; // Fixed from 'number' to 'mobile'
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . ($row['status_date'] ? $row['status_date'] : 'N/A') . '</td>';
            echo '<td>' . htmlspecialchars($row['notes'] ?? '') . '</td>';
            echo '<td>' . ($row['updated_at'] ? $row['updated_at'] : 'N/A') . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="8">No data found for the selected date range</td></tr>';
    }
    
    echo '</table>';
    
    // Status Summary
    $summary_query = "
        SELECT 
            COALESCE(s.status, 'Not Started') as status,
            COUNT(*) as count
        FROM 
            enquiries e
        LEFT JOIN 
            application_status s ON e.id = s.student_id
        WHERE 
            e.branchName = ? AND
            (s.updated_at BETWEEN ? AND ? OR s.updated_at IS NULL)
        GROUP BY 
            COALESCE(s.status, 'Not Started')
    ";
    
    $summary_stmt = $conn->prepare($summary_query);
    if ($summary_stmt === false) {
        showError("Error preparing summary query: " . $conn->error);
    }
    
    $summary_stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$summary_stmt->execute()) {
        showError("Error executing summary query: " . $summary_stmt->error);
    }
    
    $summary_result = $summary_stmt->get_result();
    
    // Summary table
    echo '<br><table border="1">';
    echo '<tr><th colspan="2">Status Summary</th></tr>';
    echo '<tr><th>Status</th><th>Count</th></tr>';
    
    $total = 0;
    while ($row = $summary_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['count'] . '</td>';
        echo '</tr>';
        $total += $row['count'];
    }
    
    echo '<tr><th>Total</th><th>' . $total . '</th></tr>';
    echo '</table>';
}

// Function to export document submissions data
function exportDocumentSubmissions($conn, $date_from, $date_to, $manager_branch) {
    // Get document submissions in the date range
    $query = "
        SELECT 
            m.id,
            e.studentName,
            m.material,
            m.file_name,
            m.received_date,
            m.uploaded_at
        FROM 
            application_materials m
        JOIN 
            enquiries e ON m.student_id = e.id
        WHERE 
            e.branchName = ? AND
            m.uploaded_at BETWEEN ? AND ?
        ORDER BY 
            m.uploaded_at DESC
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        showError("Error preparing query: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$stmt->execute()) {
        showError("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    // Report title and date range
    echo '<table border="0"><tr><td colspan="6"><h2>Document Submissions Report</h2>';
    echo '<p>Branch: ' . htmlspecialchars($manager_branch) . '</p>';
    echo '<p>Date Range: ' . date('M d, Y', strtotime($date_from)) . ' - ' . date('M d, Y', strtotime($date_to)) . '</p></td></tr></table>';
    
    // Start the Excel file
    echo '<table border="1">';
    
    // Header row
    echo '<tr>';
    echo '<th>Document ID</th>';
    echo '<th>Student Name</th>';
    echo '<th>Document Type</th>';
    echo '<th>File Name</th>';
    echo '<th>Received Date</th>';
    echo '<th>Uploaded At</th>';
    echo '</tr>';
    
    // Data rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['studentName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['material']) . '</td>';
            echo '<td>' . htmlspecialchars($row['file_name']) . '</td>';
            echo '<td>' . $row['received_date'] . '</td>';
            echo '<td>' . $row['uploaded_at'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6">No document submissions found for the selected date range</td></tr>';
    }
    
    echo '</table>';
    
    // Document Type Summary
    $summary_query = "
        SELECT 
            m.material,
            COUNT(*) as count
        FROM 
            application_materials m
        JOIN
            enquiries e ON m.student_id = e.id
        WHERE 
            e.branchName = ? AND
            m.uploaded_at BETWEEN ? AND ?
        GROUP BY 
            m.material
        ORDER BY 
            count DESC
    ";
    
    $summary_stmt = $conn->prepare($summary_query);
    if ($summary_stmt === false) {
        showError("Error preparing summary query: " . $conn->error);
    }
    
    $summary_stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$summary_stmt->execute()) {
        showError("Error executing summary query: " . $summary_stmt->error);
    }
    
    $summary_result = $summary_stmt->get_result();
    
    // Summary table
    echo '<br><table border="1">';
    echo '<tr><th colspan="2">Document Type Summary</th></tr>';
    echo '<tr><th>Document Type</th><th>Count</th></tr>';
    
    $total = 0;
    while ($row = $summary_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['material']) . '</td>';
        echo '<td>' . $row['count'] . '</td>';
        echo '</tr>';
        $total += $row['count'];
    }
    
    echo '<tr><th>Total</th><th>' . $total . '</th></tr>';
    echo '</table>';
}

// Function to export university application data
function exportUniversityApplications($conn, $date_from, $date_to, $manager_branch) {
    // Get university applications in the date range
    $query = "
        SELECT 
            a.id,
            e.studentName,
            a.university_name,
            a.program_name,
            a.location,
            a.duration,
            a.application_fee,
            a.tuition_fee,
            a.currency,
            a.created_at
        FROM 
            university_applications a
        JOIN 
            enquiries e ON a.student_id = e.id
        WHERE 
            e.branchName = ? AND
            a.created_at BETWEEN ? AND ?
        ORDER BY 
            a.created_at DESC
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        showError("Error preparing query: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$stmt->execute()) {
        showError("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    // Report title and date range
    echo '<table border="0"><tr><td colspan="10"><h2>University Applications Report</h2>';
    echo '<p>Branch: ' . htmlspecialchars($manager_branch) . '</p>';
    echo '<p>Date Range: ' . date('M d, Y', strtotime($date_from)) . ' - ' . date('M d, Y', strtotime($date_to)) . '</p></td></tr></table>';
    
    // Start the Excel file
    echo '<table border="1">';
    
    // Header row
    echo '<tr>';
    echo '<th>Application ID</th>';
    echo '<th>Student Name</th>';
    echo '<th>University</th>';
    echo '<th>Program</th>';
    echo '<th>Location</th>';
    echo '<th>Duration (months)</th>';
    echo '<th>Application Fee (₹)</th>';
    echo '<th>Tuition Fee</th>';
    echo '<th>Currency</th>';
    echo '<th>Created At</th>';
    echo '</tr>';
    
    // Data rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['studentName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['university_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['program_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td>' . $row['duration'] . '</td>';
            echo '<td>' . $row['application_fee'] . '</td>';
            echo '<td>' . $row['tuition_fee'] . '</td>';
            echo '<td>' . $row['currency'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="10">No university applications found for the selected date range</td></tr>';
    }
    
    echo '</table>';
    
    // University Summary
    $summary_query = "
        SELECT 
            a.university_name,
            COUNT(*) as applications,
            AVG(a.tuition_fee) as avg_tuition,
            a.currency
        FROM 
            university_applications a
        JOIN
            enquiries e ON a.student_id = e.id
        WHERE 
            e.branchName = ? AND
            a.created_at BETWEEN ? AND ?
        GROUP BY 
            a.university_name, a.currency
        ORDER BY 
            applications DESC
    ";
    
    $summary_stmt = $conn->prepare($summary_query);
    if ($summary_stmt === false) {
        showError("Error preparing summary query: " . $conn->error);
    }
    
    $summary_stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$summary_stmt->execute()) {
        showError("Error executing summary query: " . $summary_stmt->error);
    }
    
    $summary_result = $summary_stmt->get_result();
    
    // Summary table
    echo '<br><table border="1">';
    echo '<tr><th colspan="4">University Summary</th></tr>';
    echo '<tr><th>University</th><th>Applications</th><th>Avg. Tuition Fee</th><th>Currency</th></tr>';
    
    $total = 0;
    while ($row = $summary_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['university_name']) . '</td>';
        echo '<td>' . $row['applications'] . '</td>';
        echo '<td>' . number_format($row['avg_tuition'], 2) . '</td>';
        echo '<td>' . $row['currency'] . '</td>';
        echo '</tr>';
        $total += $row['applications'];
    }
    
    echo '<tr><th>Total</th><th>' . $total . '</th><th colspan="2"></th></tr>';
    echo '</table>';
}

// Function to export fee status data
function exportFeeStatus($conn, $date_from, $date_to, $manager_branch) {
    // Get fee status in the date range
    $query = "
        SELECT 
            f.id,
            e.studentName,
            f.fee_status,
            f.payment_date,
            f.fee_notes,
            f.updated_at,
            (SELECT application_fee FROM university_applications WHERE student_id = e.id LIMIT 1) as application_fee
        FROM 
            student_financials f
        JOIN 
            enquiries e ON f.student_id = e.id
        WHERE 
            e.branchName = ? AND
            f.updated_at BETWEEN ? AND ?
        ORDER BY 
            f.updated_at DESC
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        showError("Error preparing query: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$stmt->execute()) {
        showError("Error executing query: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    // Report title and date range
    echo '<table border="0"><tr><td colspan="7"><h2>Fee Status Report</h2>';
    echo '<p>Branch: ' . htmlspecialchars($manager_branch) . '</p>';
    echo '<p>Date Range: ' . date('M d, Y', strtotime($date_from)) . ' - ' . date('M d, Y', strtotime($date_to)) . '</p></td></tr></table>';
    
    // Start the Excel file
    echo '<table border="1">';
    
    // Header row
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Student Name</th>';
    echo '<th>Fee Status</th>';
    echo '<th>Payment Date</th>';
    echo '<th>Application Fee</th>';
    echo '<th>Notes</th>';
    echo '<th>Last Updated</th>';
    echo '</tr>';
    
    // Data rows
    $total_paid = 0;
    $total_unpaid = 0;
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['studentName']) . '</td>';
            echo '<td>' . ucfirst($row['fee_status']) . '</td>';
            echo '<td>' . ($row['payment_date'] ? $row['payment_date'] : 'N/A') . '</td>';
            echo '<td>' . ($row['application_fee'] ? '₹' . $row['application_fee'] : 'N/A') . '</td>';
            echo '<td>' . htmlspecialchars($row['fee_notes'] ?? '') . '</td>';
            echo '<td>' . $row['updated_at'] . '</td>';
            echo '</tr>';
            
            if ($row['fee_status'] == 'paid' && isset($row['application_fee'])) {
                $total_paid += $row['application_fee'];
            } else if (isset($row['application_fee'])) {
                $total_unpaid += $row['application_fee'];
            }
        }
    } else {
        echo '<tr><td colspan="7">No fee status data found for the selected date range</td></tr>';
    }
    
    echo '</table>';
    
    // Fee Summary
    $summary_query = "
        SELECT 
            f.fee_status,
            COUNT(*) as count
        FROM 
            student_financials f
        JOIN
            enquiries e ON f.student_id = e.id
        WHERE 
            e.branchName = ? AND
            f.updated_at BETWEEN ? AND ?
        GROUP BY 
            f.fee_status
    ";
    
    $summary_stmt = $conn->prepare($summary_query);
    if ($summary_stmt === false) {
        showError("Error preparing summary query: " . $conn->error);
    }
    
    $summary_stmt->bind_param("sss", $manager_branch, $date_from, $date_to);
    
    if (!$summary_stmt->execute()) {
        showError("Error executing summary query: " . $summary_stmt->error);
    }
    
    $summary_result = $summary_stmt->get_result();
    
    // Summary table
    echo '<br><table border="1">';
    echo '<tr><th colspan="2">Fee Status Summary</th></tr>';
    echo '<tr><th>Status</th><th>Count</th></tr>';
    
    $total = 0;
    while ($row = $summary_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . ucfirst($row['fee_status']) . '</td>';
        echo '<td>' . $row['count'] . '</td>';
        echo '</tr>';
        $total += $row['count'];
    }
    
    echo '<tr><th>Total</th><th>' . $total . '</th></tr>';
    echo '</table>';
    
    // Financial Summary
    echo '<br><table border="1">';
    echo '<tr><th colspan="2">Financial Summary</th></tr>';
    echo '<tr><td>Total Fees Paid</td><td>₹' . number_format($total_paid, 2) . '</td></tr>';
    echo '<tr><td>Total Fees Pending</td><td>₹' . number_format($total_unpaid, 2) . '</td></tr>';
    echo '<tr><th>Total Potential Revenue</th><th>₹' . number_format($total_paid + $total_unpaid, 2) . '</th></tr>';
    echo '</table>';
}
?>