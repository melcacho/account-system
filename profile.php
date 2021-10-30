<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Profile</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <dvi class="bg-gradient"></dvi>
        <div class="container-xl h-100 d-flex align-items-center justify-content-center bg-dark">
            <div class="custom-form col-md-8">
                <form
                name="RegForm"
                action="index.php"
                onsubmit="return checkValidates()"
                method="post">
                
                    <h2>PROFILE</h2>
                    <hr>

                    <div class="form-group row">
                    <!-- First Name -->
                        <div class="input-group col-md-6 mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </span>                    
                            </div>
                            <input
                            class="form-control" 
                            name="first-name"
                            placeholder="First Name"
                            size="11"
                            disabled>
                        </div>
                    <!-- Last Name -->
                        <div class="input-group col-md-6 mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </span>                    
                            </div>
                            <input
                            type="text" 
                            class="form-control" 
                            name="last-name"
                            placeholder="Last Name"
                            size="11"
                            disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                    <!-- Student Number -->
                        <div class="input-group col-md-6 mb-2">
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
                            disabled>
                        </div>
                    <!-- Year Level -->
                        <div class="col-md-6">
                            <select class="form-control" 
                            aria-label="Default select example" 
                            name="year-level">
                                <option disabled selected hidden>Year Level</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                    <!-- UE Email Address -->
                        <div class="input-group col-lg-6 mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-paper-plane"></i>
                                </span>
                            </div>
                            <input 
                            type="email" 
                            class="form-control" 
                            name="email" 
                            placeholder="UE Email Address">
                        </div>
                    <!-- Program -->
                        <div class="input-group col-lg-6">
                            <select class="form-control" 
                            aria-label="Default select example" 
                            name="program">
                                <option disabled selected hidden>Program</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                    <!-- Birth date -->
                        <div class="input-group col-lg-6 mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="birth-date">Birth Date</label>
                            </div>
                            <input 
                            type="date"
                            class="form-control"
                            placeholder="MM/DD/YYYY"
                            disabled>
                        </div>
                    <!-- Sex -->
                        <div class="input-group col-lg-6">
                            <select class="form-control" 
                            aria-label="Default select example" 
                            name="sex">
                                <option disabled selected hidden>Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="female">Prefer not to disclose</option>
                            </select>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="form-group">
                        <label class="form-check-label">
                            <input type="checkbox"> I accept the <a href="#">Terms of Use</a> & <a href="#">Privacy Policy</a></label>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg col-md-6" disabled>Save Changes</button>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg col-md-6">Sign Out</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>