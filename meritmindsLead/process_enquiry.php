<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbconfig.php';

// Check if form was submitted
if(isset($_POST['studentName'])) {
    // Basic information
    $studentName = $conn->real_escape_string($_POST['studentName']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $givenName = $conn->real_escape_string($_POST['givenName']);
    $fatherName = $conn->real_escape_string($_POST['fatherName']);
    $motherName = $conn->real_escape_string($_POST['motherName']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $email = $conn->real_escape_string($_POST['email']);
    $newEmail = $conn->real_escape_string($_POST['newEmail']);
    
    // Academic information
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $yearOfPass = $conn->real_escape_string($_POST['yearOfPass']);
    $percentage = $conn->real_escape_string($_POST['percentage']);
    $interEnglishMarks = $conn->real_escape_string($_POST['interEnglishMarks']);
    $interPercentage = $conn->real_escape_string($_POST['interPercentage']);
    $backlogs = $conn->real_escape_string($_POST['backlogs']);
    
    // Program and preference information
    $program = $conn->real_escape_string($_POST['program']);
    $preferredLocations = $conn->real_escape_string($_POST['preferredLocations']);
    
    // Additional information
    $financialAbility = $conn->real_escape_string($_POST['financialAbility']);
    $travelHistory = $conn->real_escape_string($_POST['travelHistory']);
    $visaRefusals = $conn->real_escape_string($_POST['visaRefusals']);
    $branchName = $conn->real_escape_string($_POST['branchName']);
    
    // Get the actual names for intakes, countries, and universities instead of IDs
    $intakeNames = [];
    $countryNames = [];
    $universityNames = [];
    $tuitionFeeBudgetName = '';
    
    // Process intake IDs to names
    if(isset($_POST['intake']) && is_array($_POST['intake'])) {
        foreach($_POST['intake'] as $intake_id) {
            if(is_numeric($intake_id)) {
                $query = "SELECT name FROM intakes WHERE id = " . intval($intake_id);
                $result = $conn->query($query);
                if($result && $result->num_rows > 0) {
                    $intakeNames[] = $result->fetch_assoc()['name'];
                }
            }
        }
    }
    
    // Process country IDs to names
    if(isset($_POST['country']) && is_array($_POST['country'])) {
        foreach($_POST['country'] as $country_id) {
            if($country_id != 'other' && is_numeric($country_id)) {
                $query = "SELECT name FROM countries WHERE id = " . intval($country_id);
                $result = $conn->query($query);
                if($result && $result->num_rows > 0) {
                    $countryNames[] = $result->fetch_assoc()['name'];
                }
            } elseif($country_id == 'other') {
                $countryNames[] = 'Other';
            }
        }
    }
    
    // Process university IDs to names
    if(isset($_POST['preferredUniversities']) && is_array($_POST['preferredUniversities'])) {
        foreach($_POST['preferredUniversities'] as $university_id) {
            if($university_id != 'other' && is_numeric($university_id)) {
                $query = "SELECT name FROM universities WHERE id = " . intval($university_id);
                $result = $conn->query($query);
                if($result && $result->num_rows > 0) {
                    $universityNames[] = $result->fetch_assoc()['name'];
                }
            } elseif($university_id == 'other') {
                $universityNames[] = 'Other';
            }
        }
    }
    
    // Get tuition fee budget name
    if(isset($_POST['tuitionFeeBudget']) && !empty($_POST['tuitionFeeBudget']) && is_numeric($_POST['tuitionFeeBudget'])) {
        $query = "SELECT price_range FROM tuition_fee_budgets WHERE id = " . intval($_POST['tuitionFeeBudget']);
        $result = $conn->query($query);
        if($result && $result->num_rows > 0) {
            $tuitionFeeBudgetName = $result->fetch_assoc()['price_range'];
        }
    }
    
    // Convert arrays to comma-separated strings
    $intakeStr = implode(", ", $intakeNames);
    $countryStr = implode(", ", $countryNames);
    $universityStr = implode(", ", $universityNames);

    // Insert into new_enquiries table
    $sql = "INSERT INTO new_enquiries (
        studentName, surname, given_name, fatherName, motherName, gender, dob, 
        mobile, email, new_email, intake, country, program, qualification,
        year_of_pass, percentage, backlogs, inter_english_marks, inter_percentage,
        preferred_universities, preferred_locations, tuition_fee_budget,
        financial_ability, travel_history, visa_refusals, created_at, branchName
    ) VALUES (
        '$studentName', '$surname', '$givenName', '$fatherName', '$motherName', '$gender', '$dob',
        '$mobile', '$email', '$newEmail', '$intakeStr', '$countryStr', '$program', '$qualification',
        '$yearOfPass', '$percentage', '$backlogs', '$interEnglishMarks', '$interPercentage',
        '$universityStr', '$preferredLocations', '$tuitionFeeBudgetName',
        '$financialAbility', '$travelHistory', '$visaRefusals', NOW(), '$branchName'
    )";

    if ($conn->query($sql) === TRUE) {
        // Success message
        $message = "Enquiry submitted successfully!";
        $status = "success";
    } else {
        // Error message
        $message = "Error: " . $conn->error;
        $status = "error";
    }

    // Redirect with status message
    header("Location: thank_you.php?message=" . urlencode($message) . "&status=" . $status);
    exit();
}

$conn->close();
?>