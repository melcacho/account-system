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
        <dvi class="bg-gradient"></dvi>
        <div class="container-xl h-100 d-flex align-items-center justify-content-center bg-dark">
            <div class="custom-form col-md-6">
                <form
                name="RegForm"
                action="confirmation.html"
                onsubmit="return checkValidates()"
                method="post">
                
                    <h2>Forgo Password?</h2>
                    <p>It OK WE GOTCHA!</p>
                    <hr>

                    <div class="form-group input-group">
                    <!-- Student Number -->
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
                        size="11">
                    </div>

                    <div class="form-group input-group">
                    <!-- Password -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-key"></span>
                            </span>                    
                        </div>
                        <input
                        type="text"
                        class="form-control" 
                        name="password"
                        placeholder="Password"
                        size="11">
                    </div>

                    <div class="form-group input-group">
                    <!-- Confirm Password -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-key"></span>
                            </span>                    
                        </div>
                        <input
                        type="text"
                        class="form-control" 
                        name="confirm-password"
                        placeholder="Confirm Password"
                        size="11">
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