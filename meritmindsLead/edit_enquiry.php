<?php include 'header.php'; ?>
<body>
    <style>
        .header1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0 10px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 100px;
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .section-header {
            background-color: #e7f3ff;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        
        /* Select2 Custom Styling */
        .select2-container {
            width: 100% !important;
        }
        
        .select2-container .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            list-style-type: none;
            padding: 5px;
            margin: 0;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4CAF50;
            border: 1px solid #4CAF50;
            color: white;
            border-radius: 4px;
            padding: 3px 8px;
            margin: 3px;
            display: inline-flex;
            align-items: center;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
            border: none;
            background: none;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff6666;
        }
        
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0 0 0.25rem 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
        }
        
        .select2-container--default .select2-results__option {
            padding: 8px 12px;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4CAF50;
            color: white;
        }
        
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        /* Hide bullet points from parent container */
        form ul, 
        .form-container ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        /* Hide extra bullet points that appear */
        ul.select2-selection__rendered + ul,
        ul.select2-selection__rendered + ul li {
            display: none !important;
        }
        
        /* Remove the duplicate list that appears */
        .select2-selection__rendered + ul {
            display: none !important;
        }
        
        /* Remove bullet points from the form */
        .form-container .col-md-9 ul {
            list-style-type: none;
            padding-left: 0;
        }
    </style>

    <!-- Database connection -->
    <?php include 'dbconfig.php';

    // Fetch active intakes from database
    $intakes_query = "SELECT * FROM intakes WHERE is_active = 1 ORDER BY name ASC";
    $intakes_result = $conn->query($intakes_query);

    // Fetch active countries from database
    $countries_query = "SELECT * FROM countries WHERE is_active = 1 ORDER BY name ASC";
    $countries_result = $conn->query($countries_query);

    // Fetch active universities from database
    $universities_query = "SELECT u.*, c.name as country_name 
                         FROM universities u 
                         JOIN countries c ON u.country_id = c.id 
                         WHERE u.is_active = 1 
                         ORDER BY u.name ASC";
    $universities_result = $conn->query($universities_query);

    // Fetch tuition fee budgets from database
    $budgets_query = "SELECT * FROM tuition_fee_budgets WHERE is_active = 1 ORDER BY display_order ASC";
    $budgets_result = $conn->query($budgets_query);

    // Initialize variables
    $id = "";
    $studentName = $surname = $givenName = $fatherName = $motherName = $gender = $dob = "";
    $mobile = $email = $newEmail = $intake = $country = $program = "";
    $qualification = $yearOfPass = $percentage = $interEnglishMarks = $interPercentage = $backlogs = "";
    $preferredUniversities = $preferredLocations = $tuitionFeeBudget = "";
    $financialAbility = $travelHistory = $visaRefusals = $branchName = "";
    $error = $success = "";

    // Arrays to store selected values
    $selected_intakes = [];
    $selected_countries = [];
    $selected_universities = [];

    // Check if ID is provided in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Basic information
            $studentName = $_POST['studentName'];
            $surname = $_POST['surname'];
            $givenName = $_POST['givenName'];
            $fatherName = $_POST['fatherName'];
            $motherName = $_POST['motherName'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $newEmail = $_POST['newEmail'];
            
            // Academic information
            $qualification = $_POST['qualification'];
            $yearOfPass = $_POST['yearOfPass'];
            $percentage = $_POST['percentage'];
            $interEnglishMarks = $_POST['interEnglishMarks'];
            $interPercentage = $_POST['interPercentage'];
            $backlogs = $_POST['backlogs'];
            
            // Program and preference information
            $program = $_POST['program'];
            $preferredLocations = $_POST['preferredLocations'];
            
            // Additional information
            $financialAbility = $_POST['financialAbility'];
            $travelHistory = $_POST['travelHistory'];
            $visaRefusals = $_POST['visaRefusals'];
            $branchName = $_POST['branchName'];
            
            // Get names for dropdowns
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
                $intake = implode(", ", $intakeNames);
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
                $country = implode(", ", $countryNames);
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
                $preferredUniversities = implode(", ", $universityNames);
            }
            
            // Get tuition fee budget name
            if(isset($_POST['tuitionFeeBudget']) && !empty($_POST['tuitionFeeBudget']) && is_numeric($_POST['tuitionFeeBudget'])) {
                $query = "SELECT price_range FROM tuition_fee_budgets WHERE id = " . intval($_POST['tuitionFeeBudget']);
                $result = $conn->query($query);
                if($result && $result->num_rows > 0) {
                    $tuitionFeeBudget = $result->fetch_assoc()['price_range'];
                }
            }
            
            // Update query
            $sql = "UPDATE new_enquiries SET 
                    studentName = ?, 
                    surname = ?,
                    given_name = ?,
                    fatherName = ?,
                    motherName = ?,
                    gender = ?, 
                    dob = ?,
                    mobile = ?, 
                    email = ?,
                    new_email = ?,
                    intake = ?,
                    country = ?,
                    program = ?,
                    qualification = ?,
                    year_of_pass = ?,
                    percentage = ?,
                    backlogs = ?,
                    inter_english_marks = ?,
                    inter_percentage = ?,
                    preferred_universities = ?,
                    preferred_locations = ?,
                    tuition_fee_budget = ?,
                    financial_ability = ?,
                    travel_history = ?,
                    visa_refusals = ?,
                    branchName = ?
                    WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssssssssssssssi", 
                $studentName, $surname, $givenName, $fatherName, $motherName, 
                $gender, $dob, $mobile, $email, $newEmail, $intake, $country, 
                $program, $qualification, $yearOfPass, $percentage, $backlogs, 
                $interEnglishMarks, $interPercentage, $preferredUniversities, 
                $preferredLocations, $tuitionFeeBudget, $financialAbility, 
                $travelHistory, $visaRefusals, $branchName, $id);
            
            if ($stmt->execute()) {
                $success = "Enquiry updated successfully!";
            } else {
                $error = "Error updating record: " . $conn->error;
            }
            
            $stmt->close();
        }
        
        // Fetch the current data
        $sql = "SELECT * FROM new_enquiries WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $studentName = $row['studentName'];
            $surname = isset($row['surname']) ? $row['surname'] : '';
            $givenName = isset($row['given_name']) ? $row['given_name'] : '';
            $fatherName = isset($row['fatherName']) ? $row['fatherName'] : '';
            $motherName = isset($row['motherName']) ? $row['motherName'] : '';
            $gender = $row['gender'];
            $dob = isset($row['dob']) ? $row['dob'] : '';
            $mobile = $row['mobile'];
            $email = $row['email'];
            $newEmail = isset($row['new_email']) ? $row['new_email'] : '';
            $intake = $row['intake'];
            $country = $row['country'];
            $program = $row['program'];
            $qualification = isset($row['qualification']) ? $row['qualification'] : '';
            $yearOfPass = isset($row['year_of_pass']) ? $row['year_of_pass'] : '';
            $percentage = isset($row['percentage']) ? $row['percentage'] : '';
            $interEnglishMarks = isset($row['inter_english_marks']) ? $row['inter_english_marks'] : '';
            $interPercentage = isset($row['inter_percentage']) ? $row['inter_percentage'] : '';
            $backlogs = isset($row['backlogs']) ? $row['backlogs'] : '';
            $preferredUniversities = isset($row['preferred_universities']) ? $row['preferred_universities'] : '';
            $preferredLocations = isset($row['preferred_locations']) ? $row['preferred_locations'] : '';
            $tuitionFeeBudget = isset($row['tuition_fee_budget']) ? $row['tuition_fee_budget'] : '';
            $financialAbility = isset($row['financial_ability']) ? $row['financial_ability'] : '';
            $travelHistory = isset($row['travel_history']) ? $row['travel_history'] : '';
            $visaRefusals = isset($row['visa_refusals']) ? $row['visa_refusals'] : '';
            $branchName = isset($row['branchName']) ? $row['branchName'] : '';
            
            // Parse the stored values for multi-select fields
            $selected_intakes = explode(", ", $intake);
            $selected_countries = explode(", ", $country);
            $selected_universities = explode(", ", $preferredUniversities);
        } else {
            $error = "No enquiry found with that ID";
        }
        
        $stmt->close();
    } else {
        $error = "No enquiry ID provided";
    }
    ?>

    <div class="container">
        <div class="header header1">
            <h2>Edit Student Enquiry</h2>
            <div class="mt-3">
                <a href="view_enquiries.php" class="btn btn-success">Back to Enquiries</a>
            </div>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (empty($error) || !empty($success)): ?>
            <div class="form-container">
                <form method="POST" action="edit_enquiry.php?id=<?php echo $id; ?>">
                    
                    <!-- Basic Information Section -->
                    <div class="section-header">Basic Information</div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="studentName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="studentName" name="studentName" value="<?php echo htmlspecialchars($studentName); ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="givenName" class="form-label">Given Name</label>
                            <input type="text" class="form-control" id="givenName" name="givenName" value="<?php echo htmlspecialchars($givenName); ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fatherName" class="form-label">Father's Name</label>
                            <input type="text" class="form-control" id="fatherName" name="fatherName" value="<?php echo htmlspecialchars($fatherName); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="motherName" class="form-label">Mother's Name</label>
                            <input type="text" class="form-control" id="motherName" name="motherName" value="<?php echo htmlspecialchars($motherName); ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="branchName" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" id="branchName" name="branchName" value="<?php echo htmlspecialchars($branchName); ?>">
                        </div>
                    </div>
                    
                    <!-- Contact Information Section -->
                    <div class="section-header">Contact Information</div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="newEmail" class="form-label">Alternative Email</label>
                            <input type="email" class="form-control" id="newEmail" name="newEmail" value="<?php echo htmlspecialchars($newEmail); ?>">
                        </div>
                    </div>
                    
                    <!-- Academic Information Section -->
                    <div class="section-header">Academic Information</div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="qualification" class="form-label">Highest Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="yearOfPass" class="form-label">Year of Pass</label>
                            <input type="text" class="form-control" id="yearOfPass" name="yearOfPass" value="<?php echo htmlspecialchars($yearOfPass); ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="percentage" class="form-label">Overall Percentage</label>
                            <input type="text" class="form-control" id="percentage" name="percentage" value="<?php echo htmlspecialchars($percentage); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="interEnglishMarks" class="form-label">Intermediate English Marks</label>
                            <input type="text" class="form-control" id="interEnglishMarks" name="interEnglishMarks" value="<?php echo htmlspecialchars($interEnglishMarks); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="interPercentage" class="form-label">Intermediate Percentage</label>
                            <input type="text" class="form-control" id="interPercentage" name="interPercentage" value="<?php echo htmlspecialchars($interPercentage); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="backlogs" class="form-label">Backlogs</label>
                        <input type="text" class="form-control" id="backlogs" name="backlogs" value="<?php echo htmlspecialchars($backlogs); ?>">
                    </div>
                    
                    <!-- Program and Preferences Section -->
                    <div class="section-header">Program and Preferences</div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="intake" class="form-label">Intake</label>
                            <select class="form-select select2-multi" id="intake" name="intake[]" multiple
                                   aria-label="Select intakes" data-placeholder="Click to select intakes">
                                <?php 
                                $intakes_result->data_seek(0);
                                if($intakes_result && $intakes_result->num_rows > 0): 
                                    while($intake_row = $intakes_result->fetch_assoc()): 
                                        $is_selected = in_array($intake_row['name'], $selected_intakes);
                                ?>
                                    <option value="<?php echo $intake_row['id']; ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($intake_row['name']); ?>
                                    </option>
                                <?php 
                                    endwhile; 
                                endif; 
                                ?>
                            </select>
                            <div class="form-text text-muted">You can select multiple options using Ctrl/cmd+select</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="country" class="form-label">Countries</label>
                            <select class="form-select select2-multi" id="country" name="country[]" multiple
                                    aria-label="Select countries" data-placeholder="Click to select countries">
                                <?php 
                                $countries_result->data_seek(0);
                                if($countries_result && $countries_result->num_rows > 0): 
                                    while($country_row = $countries_result->fetch_assoc()): 
                                        $is_selected = in_array($country_row['name'], $selected_countries);
                                ?>
                                    <option value="<?php echo $country_row['id']; ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($country_row['name']); ?>
                                    </option>
                                <?php 
                                    endwhile; 
                                endif; 
                                ?>
                                <option value="other" <?php echo in_array('Other', $selected_countries) ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <div class="form-text text-muted">You can select multiple options using Ctrl/cmd+select</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="program" class="form-label">Program</label>
                            <input type="text" class="form-control" id="program" name="program" value="<?php echo htmlspecialchars($program); ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="preferredUniversities" class="form-label">Preferred Universities</label>
                            <select class="form-select select2-multi" id="preferredUniversities" name="preferredUniversities[]" multiple
                                    aria-label="Select universities" data-placeholder="Click to select universities">
                                <?php 
                                $universities_result->data_seek(0);
                                if($universities_result && $universities_result->num_rows > 0): 
                                    while($university_row = $universities_result->fetch_assoc()): 
                                        $is_selected = in_array($university_row['name'], $selected_universities);
                                ?>
                                    <option value="<?php echo $university_row['id']; ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($university_row['name']); ?> (<?php echo htmlspecialchars($university_row['country_name']); ?>)
                                    </option>
                                <?php 
                                    endwhile; 
                                endif; 
                                ?>
                                <option value="other" <?php echo in_array('Other', $selected_universities) ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <div class="form-text text-muted">You can select multiple options using Ctrl/cmd+select</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="preferredLocations" class="form-label">Preferred Locations</label>
                            <input type="text" class="form-control" id="preferredLocations" name="preferredLocations" value="<?php echo htmlspecialchars($preferredLocations); ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="tuitionFeeBudget" class="form-label">Tuition Fee Budget</label>
                            <select class="form-select" id="tuitionFeeBudget" name="tuitionFeeBudget"
                                    aria-label="Select tuition fee budget" data-placeholder="Select budget range">
                                <option value="">-- Select Budget Range --</option>
                                <?php 
                                $budgets_result->data_seek(0);
                                if($budgets_result && $budgets_result->num_rows > 0): 
                                    while($budget_row = $budgets_result->fetch_assoc()): 
                                        $is_selected = ($budget_row['price_range'] == $tuitionFeeBudget);
                                ?>
                                    <option value="<?php echo $budget_row['id']; ?>" <?php echo $is_selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($budget_row['price_range']); ?>
                                    </option>
                                <?php 
                                    endwhile; 
                                endif; 
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Additional Information Section -->
                    <div class="section-header">Additional Information</div>
                    
                    <div class="mb-3">
                        <label for="financialAbility" class="form-label">Financial Ability</label>
                        <textarea class="form-control" id="financialAbility" name="financialAbility" rows="2"><?php echo htmlspecialchars($financialAbility); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="travelHistory" class="form-label">Travel History</label>
                        <textarea class="form-control" id="travelHistory" name="travelHistory" rows="2"><?php echo htmlspecialchars($travelHistory); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="visaRefusals" class="form-label">Visa Refusals</label>
                        <textarea class="form-control" id="visaRefusals" name="visaRefusals" rows="2"><?php echo htmlspecialchars($visaRefusals); ?></textarea>
                    </div>
                    
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Update Enquiry</button>
                        <a href="view_enquiries.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Destroy any existing Select2 instances to avoid duplicates
            // Destroy any existing Select2 instances to avoid duplicates
           $('.select2-multi').select2('destroy');
           
           // Initialize Select2 for better multi-select experience
           $('.select2-multi').select2({
               width: '100%',
               placeholder: function() {
                   return $(this).data('placeholder') || 'Select options';
               },
               allowClear: true,
               closeOnSelect: false,
               language: {
                   noResults: function() {
                       return "No matching options found";
                   }
               }
           });
           
           // Apply to single select elements too
           $('#tuitionFeeBudget').select2({
               width: '100%',
               placeholder: "-- Select Budget Range --",
               allowClear: true
           });
           
           // Fix for input focus on search
           $(document).on('select2:open', () => {
               document.querySelector('.select2-search__field').focus();
           });
           
           // Clean up any duplicate elements
           $('.select2-container').each(function() {
               var selectId = $(this).attr('id');
               if ($('.select2-container[id="' + selectId + '"]').length > 1) {
                   $('.select2-container[id="' + selectId + '"]:not(:first)').remove();
               }
           });
           
           // Remove any unwanted bullet lists
           setTimeout(function() {
               $('ul:not(.select2-selection__rendered)').each(function() {
                   if ($(this).find('li').length === 0 || $(this).find('li:empty').length === $(this).find('li').length) {
                       $(this).remove();
                   }
               });
               
               // Hide any dot bullets that might be showing
               $('.form-container ul').css('list-style', 'none').css('padding-left', '0');
           }, 500);
       });
   </script>
</body>
</html>