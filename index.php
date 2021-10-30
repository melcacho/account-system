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
                <div class="custom-form col-sm-auto rounded">
                    <form
                    name="LogForm"
                    action="profile.php"
                    onsubmit="return checkValidates()"
                    method="post">
                    
                        <h2>Welcome  Back!</h2>
                        <hr>

                        <!-- Student Number-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="fas fa-id-card"></span>
                                    </span>                    
                                </div>
                                <input 
                                type="text" 
                                class="form-control" 
                                name="student-number" 
                                placeholder="Student Number"
                                size="11"
                                required="required">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="fas fa-key"></span>
                                    </span>                    
                                </div>
                                <input 
                                type="password" 
                                class="form-control" 
                                name="password" 
                                placeholder="Password"
                                required="required">
                            </div>
                        </div>
                        <!-- Terms -->
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