<?php
// Start session
session_start();

// Check if user is logged in
// if(!isset($_SESSION["manager_logged_in"]) && !isset($_SESSION["admin_logged_in"])) {
//     header("location: welcome.php");
//     exit;
// }

// Include database configuration
include 'dbconfig.php';

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="enquiry_conversion_report.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Get parameters
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-30 days'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'overall_conversion';

// Function to get overall conversion rate report data
function getOverallConversionReportData($conn, $date_from, $date_to) {
    // Get total enquiries (new_enquiries + enquiries)
    $total_query = "
        SELECT 
            DATE_FORMAT(created_date, '%Y-%m') as month,
            COUNT(*) as total_enquiries
        FROM (
            SELECT created_at as created_date FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT created_at as created_date FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            DATE_FORMAT(created_date, '%Y-%m')
        ORDER BY 
            month
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $monthly_data = [];
    
    while ($row = $total_result->fetch_assoc()) {
        $month = $row['month'];
        $monthly_data[$month]['total_enquiries'] = $row['total_enquiries'];
        $monthly_data[$month]['converted'] = 0; // Initialize
    }
    
    // Get converted enquiries (those in the enquiries table)
    $converted_query = "
        SELECT 
            COUNT(*) as converted,
            DATE_FORMAT(created_at, '%Y-%m') as month
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY 
            month
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    while ($row = $converted_result->fetch_assoc()) {
        $month = $row['month'];
        if (isset($monthly_data[$month])) {
            $monthly_data[$month]['converted'] = $row['converted'];
        } else {
            $monthly_data[$month]['total_enquiries'] = $row['converted']; 
            $monthly_data[$month]['converted'] = $row['converted'];
        }
    }
    
    // Format data for export
    $export_data = [];
    foreach ($monthly_data as $month => $data) {
        $month_name = date('F Y', strtotime($month . '-01'));
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $export_data[] = [
            'Month' => $month_name,
            'Total Enquiries' => $data['total_enquiries'],
            'Converted to Prospective' => $data['converted'],
            'Conversion Rate (%)' => $conversion_rate
        ];
    }
    
    return $export_data;
}

// Function to get conversion by country report data
function getConversionByCountryReportData($conn, $date_from, $date_to) {
    // Get total enquiries by country
    $total_query = "
        SELECT 
            country,
            COUNT(*) as total_enquiries
        FROM (
            SELECT country, created_at FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT country, created_at FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            country
        ORDER BY 
            total_enquiries DESC
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $country_data = [];
    
    while ($row = $total_result->fetch_assoc()) {
        $country = $row['country'] ? $row['country'] : 'Not Specified';
        $country_data[$country]['total_enquiries'] = $row['total_enquiries'];
        $country_data[$country]['converted'] = 0; // Initialize
    }
    
    // Get converted enquiries by country
    $converted_query = "
        SELECT 
            country,
            COUNT(*) as converted
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            country
        ORDER BY 
            converted DESC
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    while ($row = $converted_result->fetch_assoc()) {
        $country = $row['country'] ? $row['country'] : 'Not Specified';
        if (isset($country_data[$country])) {
            $country_data[$country]['converted'] = $row['converted'];
        } else {
            $country_data[$country]['total_enquiries'] = $row['converted'];
            $country_data[$country]['converted'] = $row['converted'];
        }
    }
    
    // Format data for export
    $export_data = [];
    foreach ($country_data as $country => $data) {
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $export_data[] = [
            'Country' => $country,
            'Total Enquiries' => $data['total_enquiries'],
            'Converted to Prospective' => $data['converted'],
            'Conversion Rate (%)' => $conversion_rate
        ];
    }
    
    // Sort by total enquiries
    usort($export_data, function($a, $b) {
        return $b['Total Enquiries'] - $a['Total Enquiries'];
    });
    
    return $export_data;
}

// Function to get conversion by program report data
function getConversionByProgramReportData($conn, $date_from, $date_to) {
    // Get total enquiries by program
    $total_query = "
        SELECT 
            program,
            COUNT(*) as total_enquiries
        FROM (
            SELECT program, created_at FROM new_enquiries WHERE created_at BETWEEN ? AND ?
            UNION ALL
            SELECT program, created_at FROM enquiries WHERE created_at BETWEEN ? AND ?
        ) as all_enquiries
        GROUP BY 
            program
        ORDER BY 
            total_enquiries DESC
    ";
    
    $stmt = $conn->prepare($total_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ssss", $date_from_start, $date_to_end, $date_from_start, $date_to_end);
    $stmt->execute();
    $total_result = $stmt->get_result();
    
    $program_data = [];
    
    while ($row = $total_result->fetch_assoc()) {
        $program = $row['program'] ? $row['program'] : 'Not Specified';
        $program_data[$program]['total_enquiries'] = $row['total_enquiries'];
        $program_data[$program]['converted'] = 0; // Initialize
    }
    
    // Get converted enquiries by program
    $converted_query = "
        SELECT 
            program,
            COUNT(*) as converted
        FROM 
            enquiries
        WHERE 
            created_at BETWEEN ? AND ?
        GROUP BY 
            program
        ORDER BY 
            converted DESC
    ";
    
    $stmt = $conn->prepare($converted_query);
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $converted_result = $stmt->get_result();
    
    while ($row = $converted_result->fetch_assoc()) {
        $program = $row['program'] ? $row['program'] : 'Not Specified';
        if (isset($program_data[$program])) {
            $program_data[$program]['converted'] = $row['converted'];
        } else {
            $program_data[$program]['total_enquiries'] = $row['converted'];
            $program_data[$program]['converted'] = $row['converted'];
        }
    }
    
    // Format data for export
    $export_data = [];
    foreach ($program_data as $program => $data) {
        $conversion_rate = $data['total_enquiries'] > 0 ? round(($data['converted'] / $data['total_enquiries']) * 100, 1) : 0;
        
        $export_data[] = [
            'Program' => $program,
            'Total Enquiries' => $data['total_enquiries'],
            'Converted to Prospective' => $data['converted'],
            'Conversion Rate (%)' => $conversion_rate
        ];
    }
    
    // Sort by total enquiries
    usort($export_data, function($a, $b) {
        return $b['Total Enquiries'] - $a['Total Enquiries'];
    });
    
    return $export_data;
}

// Function to get staff performance report data
function getStaffPerformanceReportData($conn, $date_from, $date_to) {
    // Query for staff who moved enquiries to prospective students
    $staff_query = "
        SELECT 
            a.admin_username as staff_name,
            COUNT(*) as conversions,
            MIN(e.created_at) as first_conversion,
            MAX(e.created_at) as last_conversion
        FROM 
            enquiries e
        JOIN 
            admin_logs a ON a.details LIKE CONCAT('%', e.studentName, '%') AND a.action = 'Move Enquiry'
        WHERE 
            e.created_at BETWEEN ? AND ?
        GROUP BY 
            a.admin_username
        ORDER BY 
            conversions DESC
    ";
    
    $stmt = $conn->prepare($staff_query);
    $date_from_start = $date_from . ' 00:00:00';
    $date_to_end = $date_to . ' 23:59:59';
    $stmt->bind_param("ss", $date_from_start, $date_to_end);
    $stmt->execute();
    $staff_result = $stmt->get_result();
    
    $export_data = [];
    
    while ($row = $staff_result->fetch_assoc()) {
        $export_data[] = [
            'Staff Member' => $row['staff_name'],
            'Conversions' => $row['conversions'],
            'First Conversion' => date('F d, Y', strtotime($row['first_conversion'])),
            'Last Conversion' => date('F d, Y', strtotime($row['last_conversion']))
        ];
    }
    
    return $export_data;
}

// Get report data based on report type
switch ($report_type) {
    case 'overall_conversion':
        $export_data = getOverallConversionReportData($conn, $date_from, $date_to);
        $report_title = 'Enquiry to Prospective Student Conversion Report';
        break;
    case 'conversion_by_country':
        $export_data = getConversionByCountryReportData($conn, $date_from, $date_to);
        $report_title = 'Conversion Rate by Country Report';
        break;
    case 'conversion_by_program':
        $export_data = getConversionByProgramReportData($conn, $date_from, $date_to);
        $report_title = 'Conversion Rate by Program Report';
        break;
    case 'staff_performance':
        $export_data = getStaffPerformanceReportData($conn, $date_from, $date_to);
        $report_title = 'Staff Performance Report';
        break;
    default:
        $export_data = getOverallConversionReportData($conn, $date_from, $date_to);
        $report_title = 'Enquiry to Prospective Student Conversion Report';
}

// Output Excel content
echo "<table border='1'>";
echo "<tr><th colspan='" . count(reset($export_data)) . "'>" . $report_title . " (" . date('M d, Y', strtotime($date_from)) . " - " . date('M d, Y', strtotime($date_to)) . ")</th></tr>";

// Output headers
if (!empty($export_data)) {
    echo "<tr>";
    foreach (array_keys(reset($export_data)) as $header) {
        echo "<th>" . $header . "</th>";
    }
    echo "</tr>";
    
    // Output data rows
    foreach ($export_data as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
}

echo "</table>";
exit;
?>