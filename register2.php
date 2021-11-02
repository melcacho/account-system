<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$first_name = $last_name = $student_number = $year_level = $email = $program = $sex = $contact_number = $birth_date = 
$birth_year = $birth_day = $birth_month = $password = "";
$name_err = $student_number_err = $year_level_err = $email_err = $program_err = 
$sex_err = $contact_number_err = $birth_date_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first_name
    if (empty(trim($_POST["first-name"])) || empty(trim($_POST["last-name"]))) {
        $name_err = "Please enter a full name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["first-name"]))) {
        $name_err = "Name can only contain letters";
    } else {
        $first_name = trim($_POST["first-name"]);
        $last_name = trim($_POST["last-name"]);
    }


    if(empty(trim($_POST["student-number"]))) {
        $student_number_err = "Please enter student number.";
    } elseif(strlen(trim($_POST["student-number"])) < 11) {
        $student_number_err = "Invalid student number.";
    } else {
        $sql = "SELECT ID FROM accounts WHERE STUD_NUMB = ?";

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["student-number"]);

            if($stmt->execute()) {
                $stmt->store_result();

                if($stmt->num_rows > 0) {
                    $student_number_err = "This Student Number is already taken.";
                } else {
                    $student_number = trim($_POST["student-number"]);
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if(trim($_POST["year-level"]) == 0) {
        $year_level_err = "Please choose year level.";
    } else {
        $year_level = trim($_POST["year-level"]);
    }

    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter email address.";
    } elseif(!in_array('ue.edu.ph', explode('@', trim($_POST["email"])))) {
        $email_err = "Please enter a valid UE email address.";
    } else {
        $sql = "SELECT ID FROM accounts WHERE UE_EMAIL = ?";

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);

            if($stmt->execute()) {
                $stmt->store_result();

                if($stmt->num_rows > 0) {
                    $email_err = "This Email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if(trim($_POST["program"]) == 0) {
        $program_err = "Please choose program.";
    } else {
        $program = trim($_POST["program"]);
    }

    if(empty(trim($_POST["contact-number"]))) {
        $contact_number_err = "Please enter contact number.";
    } elseif(strlen(trim($_POST["contact-number"])) < 11) {
        $student_number_err = "Invalid contact number.";
    } else {
        $contact_number = trim($_POST["contact-number"]);
    }

    if(trim($_POST["sex"]) == 0) {
        $sex_err = "Please choose sex.";
    } else {
        $sex = trim($_POST["sex"]);
    }

    if(empty(trim($_POST["birth-date"]))) {
        $birth_date_err = "Please enter birthday.";
    } else {
        $birth_date = trim($_POST["birth-date"]);
        $birth_year = explode('-', $birth_date)[0];
        $birth_month = explode('-', $birth_date)[1];
        $birth_day = explode('-', $birth_date)[2];
    }

    $password = strtolower($last_name) . $birth_month . $birth_day . $birth_year;

    // Check input errors before inserting in database
    if (empty($name_err) && empty($student_number_err) && empty($year_level_err) && empty($email_err) && 
    empty($program_err) && empty($contact_number_err) && empty($sex_err) && empty($birth_date_err)) {
        echo "in";
        // Prepare an insert statement
        $sql = "INSERT INTO accounts (FNAME, LNAME, STUD_NUMB, YR_LEVEL, UE_EMAIL, PROGRAM, 
        CONTACT, SEX, BIRTH_MONTH, BIRTH_DAY, BIRTH_YEAR, PASSWORD) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssssss", $param_first_name, $param_last_name, $param_student_number, 
            $param_year_level, $param_email, $param_program, $param_contact_number, $param_sex,
            $param_birth_month, $param_birth_day, $param_birth_year, $param_password);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_student_number = $student_number;
            $param_year_level = $year_level;
            $param_email = $email;
            $param_program =  $program;
            $param_contact_number = $contact_number;
            $param_sex = $sex;
            $param_birth_month = $birth_month;
            $param_birth_day = $birth_day;
            $param_birth_year = $birth_year; 
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Sign Up</title>
        <link rel="stylesheet" href="css/styles.css">
        <script type="text/javascript" src="js/check.js"></script>
        <!--<script type="text/javascript" src="fa/fontawesome-free-5.15.4-web/js/fontawesome.js"></script>-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="bg-gradient"></div>
        <div class="container-xl h-100 d-flex justify-content-center">
            <div class="custom-form col-md-8 my-auto">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                    <h2>SIGN UP</h2>
                    <p>Please fill in this form to create an account!</p>
                    <hr>
                    
                    <div class="form-group row">
                    <!-- first-name -->
                        <div class="input-group col-md-6">
                            <input
                                type="text"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                name="first-name"
                                placeholder="First Name"
                                value="<?php echo $first_name; ?>"
                                >
                            <span class="form-label" for="first-name">First Name</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($name_err)) ? $name_err : '_'; ?>
                            </span>
                        </div>
                    <!-- last-name -->
                        <div class="input-group col-md-6">
                            <input
                                type="text"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                name="last-name"
                                placeholder="Last Name"
                                value="<?php echo $last_name; ?>"
                                >
                            <span class="form-label">Last Name</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($name_err)) ? $name_err : '_'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- student-number -->
                        <div class="input-group col-md-6">
                            <input
                            type="text"
                            class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>"
                            name="student-number"
                            placeholder="Student Number"
                            maxlength="11"
                            onkeypress="if(isNaN(String.fromCharCode(event.keyCode))) return false;"
                            value="<?php echo $student_number; ?>">
                            <span class="form-label" for="last-name">Student Number</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($student_number_err)) ? $student_number_err : '_'; ?>
                            </span>
                        </div>
                    <!-- contact-number -->
                        <div class="input-group col-md-6">
                            <input
                            type="text"
                            class="form-control <?php echo (!empty($contact_number_err)) ? 'is-invalid' : ''; ?>"
                            name="contact-number"
                            placeholder="Contact Number"
                            maxlength="11"
                            onkeypress="if(isNaN(String.fromCharCode(event.keyCode))) return false;"
                            value="<?php echo $contact_number; ?>">
                            <span class="form-label">Contact Number</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($contact_number_err)) ? $contact_number_err : '_'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <!-- year-level -->
                        <div class="input-group col-md-6">
                            <select class="form-control <?php echo (!empty($year_level_err)) ? 'is-invalid' : ''; ?>" 
                            aria-label="Default select example" 
                            name="year-level"
                            required
                            value="<?php echo $year_level; ?>">
                                <option value="" <?php echo ($year_level == 0) ? 'selected': ''?> hidden>Year Level</option>
                                <option value="1" <?php echo ($year_level == 1) ? 'selected': ''?>>1st</option>
                                <option value="2" <?php echo ($year_level == 2) ? 'selected': ''?>>2nd</option>
                                <option value="3" <?php echo ($year_level == 3) ? 'selected': ''?>>3rd</option>
                                <option value="4" <?php echo ($year_level == 4) ? 'selected': ''?>>4th</option>
                                <option value="5" <?php echo ($year_level == 5) ? 'selected': ''?>>5th</option>
                            </select>
                            <span class="form-label">Year Level</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($year_level_err)) ? $year_level_err : '_'; ?>
                            </span>
                        </div>
                        <!-- program -->
                        <div class="input-group col-md-6">
                            <select class="form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?>" 
                            aria-label="Default select example" 
                            name="program"
                            required
                            value="<?php echo $program; ?>">
                                <option value="" <?php echo ($program == 0) ? 'selected': ''?> hidden>Program</option>
                                <option value="ce" <?php echo ($program == 'ce') ? 'selected': ''?>>Civil Engineering</option>
                                <option value="cpe" <?php echo ($program == 'cpe') ? 'selected': ''?>>Computer Engineering</option>
                                <option value="ee" <?php echo ($program == 'ee') ? 'selected': ''?>>Electrical Engineering</option>
                                <option value="me" <?php echo ($program == 'me') ? 'selected': ''?>>Mechanical Engineering</option>
                                <option value="cs" <?php echo ($program == 'cs') ? 'selected': ''?>>Computer Science</option>
                                <option value="it" <?php echo ($program == 'it') ? 'selected': ''?>>Information Technology</option>
                            </select>
                            <span class="form-label">Program</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($program_err)) ? $program_err : '_'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <!-- birth-date -->
                        <div class="input-group col-lg-6">
                            <input 
                            type="date"
                            name="birth-date"
                            class="form-control <?php echo (!empty($birth_date_err)) ? 'is-invalid' : ''; ?>"
                            placeholder="Birth Date"
                            value="<?php echo $birth_date; ?>">
                            <span class="form-label">Birth Date</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($birth_date_err)) ? $birth_date_err : '_'; ?>
                            </span>
                        </div>
                        <!-- sex -->
                        <div class="input-group col-lg-6">
                            <select class="form-control <?php echo (!empty($sex_err)) ? 'is-invalid' : ''; ?>" 
                            aria-label="Default select example" 
                            name="sex"
                            required
                            value="<?php echo $sex; ?>">
                                <option value="" <?php echo ($sex == 0) ? 'selected': ''?> hidden>Sex</option>
                                <option value="male" <?php echo ($sex == 'male') ? 'selected': ''?>>Male</option>
                                <option value="female" <?php echo ($sex == 'female') ? 'selected': ''?>>Female</option>
                                <option value="n/a" <?php echo ($sex == 'n/a') ? 'selected': ''?>>Prefer not to disclose</option>
                            </select>
                            <span class="form-label">Sex</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($sex_err)) ? $sex_err : '_'; ?>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- email -->
                        <div class="input-group">
                            <input 
                            type="email" 
                            class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                            name="email" 
                            placeholder="UE Email Address"
                            value="<?php echo $email; ?>">
                            <span class="form-label" for="last-name">UE Email</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($email_err)) ? $email_err : '_'; ?>
                            </span>
                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </div>
                </form>
                <div class="text-center">Already have an account? <a href="index.php">Login here</a></div>
            </div>
        </div>
    </body>
</html>