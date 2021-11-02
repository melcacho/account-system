<?php
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
        $sql = "SELECT ID, STUD_NUMB, PASSWORD FROM accounts WHERE STUD_NUMB = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_student_number);
            $param_student_number = $student_number;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $student_number, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["student-number"] = $student_number;

                            header("location: profile.php");
                        } else {
                            $student_number_err = $password_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $student_number_err = $password_err = "Invalid username or password.";
                }
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

        <title>Sign In</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="bg-gradient"></div>
        <div class="row m-0 h-100 d-flex justify-content-end align-items-stretch">
            <img src="res/img/flower.jpg" class="p-2 col-sm-7" alt="Flower">
            <div class="col-lg-5 bg-dark d-flex align-items-center justify-content-center">
                <div class="custom-form col-sm-10 rounded">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                        <h2>Welcome  Back!</h2>
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
                                    value="<?php echo $password; ?>"
                                    >
                                <span class="form-label">Password</span>
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
                    <div class="text-center">Don't have an account? <a href="register2.php">Register here</a></div>
                </div>
            </div>
        </div>    
    </body>
</html>