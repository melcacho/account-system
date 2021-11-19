<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: error.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$first_name = $last_name = $student_number = $year_level = $email = $program = $sex = $contact_number = $birth_date = 
$birth_year = $birth_day = $birth_month = $password = $alert_status = "";
$name_err = $student_number_err = $year_level_err = $email_err = $program_err = 
$sex_err = $contact_number_err = $birth_date_err = "";
$email_new = $contact_number_new = $year_level_new = $program_new = $sex_new = ""; 

if (isset($_SESSION["id"]) && !empty(trim($_SESSION["id"]))) {
    // Get URL parameter
    $id =  trim($_SESSION["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM accounts WHERE ID = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $first_name = $row["FNAME"];
                $last_name = $row["LNAME"];
                $student_number = $row["STUD_NUMB"];
                $year_level = $row["YR_LEVEL"];
                $email = $row["UE_EMAIL"];
                $program = $row["PROGRAM"];
                $contact_number = $row["CONTACT"];
                $sex = $row["SEX"];
                $birth_date = $row["BIRTH_YEAR"] . "-" . $row["BIRTH_MONTH"] . "-" . $row["BIRTH_DAY"];
            } else {
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $year_level_new = trim($_POST["year-level"]);
    $program_new = trim($_POST["program"]);
    $sex_new = trim($_POST["sex"]);

    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter email address.";
    } elseif(!in_array('ue.edu.ph', explode('@', trim($_POST["email"])))) {
        $email_err = "Please enter a valid UE email address.";
    } elseif(trim($_POST["email"]) == $email) {
        $email_new = trim($_POST["email"]);
    }else {
        $sql = "SELECT ID FROM accounts WHERE UE_EMAIL = ?";

        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);

            if($stmt->execute()) {
                $stmt->store_result();

                if($stmt->num_rows > 0) {
                    $email_err = "This Email is already taken.";
                } else {
                    $email_new = trim($_POST["email"]);
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if(empty(trim($_POST["contact-number"])) || strlen(trim($_POST["contact-number"])) < 11) {
        $contact_number_err = "Invalid contact number.";
    } else {
        $contact_number_new = trim($_POST["contact-number"]);
    }

    // Check input errors before inserting in database
    if(($year_level == $year_level_new) && ($program == $program_new) && ($contact_number == $contact_number_new) && 
    ($sex == $sex_new) && ($email == $email_new)) {
        $alert_status = "warning";
    } elseif(empty($email_err) && empty($contact_number_err)) {
        // Prepare an insert statement
        $sql = "UPDATE accounts SET YR_LEVEL=?, UE_EMAIL=?, PROGRAM=?, CONTACT=?,
        SEX=? WHERE id=?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssi", $param_year_level, $param_email, $param_program, 
            $param_contact_number, $param_sex, $param_id);

            // Set parameters
            $param_year_level = $year_level_new;
            $param_email = $email_new;
            $param_program =  $program_new;
            $param_contact_number = $contact_number_new;
            $param_sex = $sex_new;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $alert_status = "success";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    } else {
        $alert_status = "warning";
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

        <title>Profile</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <script>
            function myFunction() {
                var x = document.getElementById(THIS);
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
    </head>

    <body>
        <div class="bg-gradient"></div>

        <div class="container-xl h-100 d-flex justify-content-center">
            <div class="custom-form col-md-8 my-auto">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                    <div class="row">
                        <div class="col-md-8">
                            <h2>SIGN UP</h2>
                            <p>Please fill in this form to create an account!</p>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning"
                            <?php echo ($alert_status == "warning") ? '' : 'hidden'; ?>>
                                <strong>Data Maintained</strong>
                            </div>
                            <div class="alert alert-success"
                                <?php echo ($alert_status == "success") ? '' : 'hidden'; ?>>
                                    <strong>Data Updated!</strong>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group mb-4">
                    <!-- Full  Name -->
                        <div class="input-group">
                            <input
                            type="text"
                            class="form-control"
                            name="first-name"
                            placeholder="First Name"
                            size="11"
                            style="pointer-events: none;"
                            readonly
                            value="<?php echo $last_name . ", " . $first_name; ?>">
                            <span class="form-label">Full Name</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- student-number -->
                        <div class="input-group col-md-6 mb-4">
                            <input
                            type="text"
                            class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>"
                            name="student-number"
                            placeholder="Student Number"
                            maxlength="11"
                            onkeypress="if(isNaN(String.fromCharCode(event.keyCode))) return false;"
                            style="pointer-events: none;"
                            readonly
                            value="<?php echo $student_number; ?>">
                            <span class="form-label" for="last-name">Student Number</span>
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
                            value="<?php echo (empty($contact_number_new)) ? $contact_number : $contact_number_new;?>">
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
                            value="<?php echo (empty($year_level_new)) ? $year_level : $year_level_new;?>">
                                <option value="1" <?php echo (((empty($year_level_new)) ? $year_level : $year_level_new ) == 1) ? 'selected': ''?>>1st</option>
                                <option value="2" <?php echo (((empty($year_level_new)) ? $year_level : $year_level_new ) == 2) ? 'selected': ''?>>2nd</option>
                                <option value="3" <?php echo (((empty($year_level_new)) ? $year_level : $year_level_new ) == 3) ? 'selected': ''?>>3rd</option>
                                <option value="4" <?php echo (((empty($year_level_new)) ? $year_level : $year_level_new ) == 4) ? 'selected': ''?>>4th</option>
                                <option value="5" <?php echo (((empty($year_level_new)) ? $year_level : $year_level_new ) == 5) ? 'selected': ''?>>5th</option>
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
                            value="<?php echo (empty($program_new)) ? $program : $program_new;?>">
                                <option value="ce" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'ce') ? 'selected': ''?>>Civil Engineering</option>
                                <option value="cpe" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'cpe') ? 'selected': ''?>>Computer Engineering</option>
                                <option value="ee" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'ee') ? 'selected': ''?>>Electrical Engineering</option>
                                <option value="me" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'me') ? 'selected': ''?>>Mechanical Engineering</option>
                                <option value="cs" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'cs') ? 'selected': ''?>>Computer Science</option>
                                <option value="it" <?php echo (((empty($program_new)) ? $program : $program_new ) == 'it') ? 'selected': ''?>>Information Technology</option>
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
                            style="pointer-events: none;"
                            readonly
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
                            value="<?php echo (empty($sex_new)) ? $sex : $sex_new;?>">
                                <option value="male" <?php echo (((empty($sex_new)) ? $sex : $sex_new ) == 'male') ? 'selected': ''?>>Male</option>
                                <option value="female" <?php (((empty($sex_new)) ? $sex : $sex_new ) == 'female') ? 'selected': ''?>>Female</option>
                                <option value="n/a" <?php (((empty($sex_new)) ? $sex : $sex_new ) == 'n/a') ? 'selected': ''?>>Prefer not to disclose</option>
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
                            value="<?php echo (empty($email_new)) ? $email : $email_new;?>">
                            <span class="form-label" for="last-name">UE Email</span>
                            <span class="invalid-feedback">
                                <?php echo (!empty($email_err)) ? $email_err : '_'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <a href="delete.php" class="btn btn-warning btn-block">Delete Record</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-block">Save Changes</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="logout.php" class="btn btn-danger btn-block">Sign Out</a>
                    </div>

                </form>
                <!--<div class="text-center"><a href="forgo.php">Change Password</a></div>-->
            </div>
        </div>
    </body>
</html>