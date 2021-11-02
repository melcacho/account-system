<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$student_number = $password = "";
$student_number_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty(trim($_POST["student-number"]))) {
        $student_number_err = "Please enter student number.";
    } elseif(strlen(trim($_POST["student-number"])) < 11) {
        $student_number_err = "Invalid student number.";
    } else {
        $student_number = trim($_POST["student-number"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($student_number_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT ID, STUD_NUMB, PASSWORD FROM accounts WHERE STUD_NUMB = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_student_number);

            // Set parameters
            $param_student_number = $student_number;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $student_number, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["student-number"] = $student_number;

                            // Redirect user to welcome page
                            header("location: profile.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
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

        <title>Sign In</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <dvi class="bg-gradient"></dvi>
        <div class="m-0 h-100 d-flex justify-content-end align-items-stretch">
            <div class="col-xl-5 bg-dark d-flex align-items-center justify-content-center">
                <div class="custom-form col-md-8 rounded">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                        <h2>Welcome  Back!</h2>
                        <hr>

                        <div class="form-group mb-0">
                        <!-- Student Number -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>">
                                        <span class="fas fa-id-card"></span>
                                    </span>                    
                                </div>
                                <input
                                type="text"
                                class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>"
                                name="student-number"
                                placeholder="Student Number"
                                maxlength="11"
                                onkeypress="if(isNaN(String.fromCharCode(event.keyCode))) return false;"
                                value="<?php echo $student_number; ?>">
                                <span class="invalid-feedback">
                                    <?php echo (!empty($student_number_err)) ? $student_number_err : '_'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group mb-0">
                        <!-- Password -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                        <span class="fas fa-key"></span>
                                    </span>                    
                                </div>
                                <input 
                                type="password" 
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                                name="password" 
                                placeholder="Password"
                                value="">
                                <span class="invalid-feedback">
                                    <?php echo (!empty($password_err)) ? $password_err : '_'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <span>
                            <?php echo (!empty($login_err)) ? $login_err : ''; ?>
                        </span>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <div class="form-group text-center">
                            <label class="form-check-label">
                                <a href="recovery.php">Forgot Password?</a></label>
                        </div>
                    </form>
                    <div class="text-center">Don't have an account? <a href="register.php">Register here</a></div>
                </div>
            </div>
        </div>    
    </body>
</html>