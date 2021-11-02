<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$student_number = $password = $password_confirm = "";
$student_number_err = $password_err = "";

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
    } elseif(trim($_POST["password"]) == trim($_POST["password-confirm"])) {
        $password = trim($_POST["password"]);
    } else {
        $password_err = "Password mismatch.";
    }

    // Validate credentials
    if (empty($student_number_err) && empty($password_err)) {
        $sql = "UPDATE accounts SET PASSWORD = ? WHERE STUD_NUMB = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("si", $param_password, $param_student_number);

            $param_student_number = $student_number;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                session_start();
                header("location: index.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Account Recovery</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="bg-gradient"></div>
        <div class="container-xl h-100 d-flex align-items-center justify-content-center bg-dark">
            <div class="custom-form col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                    <h2>Forgot Password?</h2>
                    <hr>

                    <div class="form-group">
                        <!-- student-number -->
                            <div class="input-group">
                                <input
                                type="text"
                                class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>"
                                name="student-number"
                                placeholder="Student Number"
                                maxlength="11"
                                onkeypress="if(isNaN(String.fromCharCode(event.keyCode))) return false;"
                                value="<?php echo $student_number; ?>">
                                <span class="form-label">Student Number</span>
                                <span class="invalid-feedback">
                                    <?php echo (!empty($student_number_err)) ? $student_number_err : '_'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        <!-- password -->
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                    name="password"
                                    placeholder="Password"
                                    value=""
                                    >
                                <span class="form-label">Password</span>
                                <span class="invalid-feedback">
                                    <?php echo (!empty($password_err)) ? $password_err : '_'; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        <!-- password-confirm -->
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                    name="password-confirm"
                                    placeholder="Confirm Password"
                                    value=""
                                    >
                                <span class="form-label">Confirm Password</span>
                                <span class="invalid-feedback">
                                    <?php echo (!empty($password_err)) ? $password_err : '_'; ?>
                                </span>
                            </div>
                        </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                    </div>
                </form>
                <div class="text-center">Remembered password? <a href="index.php">Login here</a></div>
            </div>
        </div>
    </body>
</html>