<?php include 'header.php'; ?>
<?php
// Start session
session_start();

// Include database configuration
require_once 'dbconfig.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Student Enquiry - Merit Minds</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
            padding-bottom: 40px;
        }
        .form-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .section-title {
            color: #4CAF50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
        select[multiple] {
            height: auto;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        
        <?php
        // Display error or success messages if any
        if(isset($_GET['message']) && isset($_GET['status'])) {
            $alertClass = ($_GET['status'] == 'success') ? 'alert-success' : 'alert-danger';
            echo '<div class="alert ' . $alertClass . '">' . htmlspecialchars($_GET['message']) . '</div>';
        }
        ?>
        
        <form action="process_enquiry.php" method="POST" id="enquiryForm">
            <!-- Personal Information Section -->
            <div class="form-section">
                <h4 class="section-title">Personal Information</h4>
                <div class="row mb-3">
                    <label for="studentName" class="col-sm-3 col-form-label">Student Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Full Name" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="surname" class="col-sm-3 col-form-label">Surname:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="givenName" class="col-sm-3 col-form-label">Given Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="givenName" name="givenName" placeholder="Given Name">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="fatherName" class="col-sm-3 col-form-label">Father's Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Father's Full Name">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="motherName" class="col-sm-3 col-form-label">Mother's Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="motherName" name="motherName" placeholder="Mother's Full Name">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Gender:</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth:</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="mobile" class="col-sm-3 col-form-label">Contact Number:</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="XXX XXX XXXX" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label">E-mail:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@xyz.com" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="newEmail" class="col-sm-3 col-form-label">New Email:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="Alternative email">
                    </div>
                </div>
            </div>
            
            <!-- Horizontal Line -->
            <hr>
            
            <!-- Academic Information Section -->
            <div class="form-section">
                <h4 class="section-title">Academic Information</h4>
                
                <div class="row mb-3">
                    <label for="qualification" class="col-sm-3 col-form-label">Qualification:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Highest Qualification">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="yearOfPass" class="col-sm-3 col-form-label">Year of Pass:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="yearOfPass" name="yearOfPass" placeholder="Year of Passing">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="percentage" class="col-sm-3 col-form-label">Percentage:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="percentage" name="percentage" placeholder="Overall Percentage">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="interEnglishMarks" class="col-sm-3 col-form-label">Inter English Marks:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="interEnglishMarks" name="interEnglishMarks" placeholder="Intermediate English Marks">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="interPercentage" class="col-sm-3 col-form-label">Inter Percentage:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="interPercentage" name="interPercentage" placeholder="Intermediate Percentage">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="backlogs" class="col-sm-3 col-form-label">Backlogs:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="backlogs" name="backlogs" placeholder="Number of Backlogs if any">
                    </div>
                </div>
            </div>
            
            <!-- Horizontal Line -->
            <hr>
            
            <!-- Intake Interested Section -->
            <div class="form-section">
                <h4 class="section-title">Intake Interested</h4>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Select Intake(s):</label>
                    <div class="col-sm-9">
                        <select class="form-select select2-multi" id="intake" name="intake[]" multiple>
                            <?php if($intakes_result && $intakes_result->num_rows > 0): ?>
                                <?php while($intake = $intakes_result->fetch_assoc()): ?>
                                    <option value="<?php echo $intake['id']; ?>"><?php echo htmlspecialchars($intake['name']); ?></option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No intakes available</option>
                            <?php endif; ?>
                        </select>
                        <small class="form-text text-muted">You can select multiple options</small>
                    </div>
                </div>
            </div>
            
            <!-- Country Interested Section -->
            <div class="form-section">
                <h4 class="section-title">Country Interested</h4>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Select Country(s):</label>
                    <div class="col-sm-9">
                        <select class="form-select select2-multi" id="country" name="country[]" multiple>
                            <?php if($countries_result && $countries_result->num_rows > 0): ?>
                                <?php while($country = $countries_result->fetch_assoc()): ?>
                                    <option value="<?php echo $country['id']; ?>"><?php echo htmlspecialchars($country['name']); ?></option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No countries available</option>
                            <?php endif; ?>
                            <option value="other">Other</option>
                        </select>
                        <small class="form-text text-muted">You can select multiple options</small>
                    </div>
                </div>
            </div>
            
            <!-- Program and Universities Section -->
            <div class="form-section">
                <h4 class="section-title">Program & University Information</h4>
                
                <div class="row mb-3">
                    <label for="program" class="col-sm-3 col-form-label">Program Interested:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="program" name="program" placeholder="Program Interested">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="preferredUniversities" class="col-sm-3 col-form-label">Preferred Universities:</label>
                    <div class="col-sm-9">
                        <select class="form-select select2-multi" id="preferredUniversities" name="preferredUniversities[]" multiple>
                            <?php if($universities_result && $universities_result->num_rows > 0): ?>
                                <?php while($university = $universities_result->fetch_assoc()): ?>
                                    <option value="<?php echo $university['id']; ?>"><?php echo htmlspecialchars($university['name']); ?> (<?php echo htmlspecialchars($university['country_name']); ?>)</option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No universities available</option>
                            <?php endif; ?>
                            <option value="other">Other</option>
                        </select>
                        <small class="form-text text-muted">You can select multiple options</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="preferredLocations" class="col-sm-3 col-form-label">Preferred Locations:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="preferredLocations" name="preferredLocations" placeholder="Preferred Locations">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="tuitionFeeBudget" class="col-sm-3 col-form-label">Tuition Fee Budget:</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="tuitionFeeBudget" name="tuitionFeeBudget">
                            <option value="">-- Select Budget Range --</option>
                            <?php if($budgets_result && $budgets_result->num_rows > 0): ?>
                                <?php while($budget = $budgets_result->fetch_assoc()): ?>
                                    <option value="<?php echo $budget['id']; ?>"><?php echo htmlspecialchars($budget['price_range']); ?></option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No budget ranges available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Section -->
            <div class="form-section">
                <h4 class="section-title">Additional Information</h4>
                
                <div class="row mb-3">
                    <label for="financialAbility" class="col-sm-3 col-form-label">Financial Ability:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="financialAbility" name="financialAbility" placeholder="Financial Capability Details">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="travelHistory" class="col-sm-3 col-form-label">Previous Travel History:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="travelHistory" name="travelHistory" placeholder="Previous International Travel">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="visaRefusals" class="col-sm-3 col-form-label">Previous Visa Refusals:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="visaRefusals" name="visaRefusals" placeholder="Previous Visa Refusals if any">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="branchName" class="col-sm-3 col-form-label">Enquiry handled by(Your Branch): </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="branchName" name="branchName" placeholder="Branch Name">
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg">Submit Enquiry</button>
                <a href="view_enquiries.php" class="btn btn-primary btn-lg">View Enquiries</a>
                <input type="hidden" name="form_submitted" value="1">
            </div>
        </form>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 for better multi-select experience
            $('.select2-multi').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Select options',
                allowClear: true
            });
        });
    </script>
</body>
</html>