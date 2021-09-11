<?php
session_start();
// Include config file
require_once "attachment_config.php";
 
// Define variables and initialize with empty values
$name_of_company = $location = $description = "";
$name_of_company_err = $location_err =  $description_err  = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name_of_company
    if(empty(trim($_POST["name_of_company"]))){
        $name_of_company_err = "Please enter the name of the company.";
    } else{
        $name_of_company = trim($_POST["name_of_company"]);
    }

    // Validate location
    if(empty(trim($_POST["location"]))){
        $location_err = "Please enter a location.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["location"]))){
        $location_err = "location can only contain letters, numbers, and underscores.";
    } else{
        $location = trim($_POST["location"]);
    }
   
 
    // Validate description
    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter a description.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["location"]))){
        $description_err = "description can only contain letters, numbers, and underscores.";
    } else{
        $description = trim($_POST["description"]);
    }
    
  
    
    // Check input errors before inserting in database
    if( empty($name_of_company_err) && empty($location_err) && empty($description_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO attachment (name_of_company,location,description,studentid) VALUES (?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name_of_company,$param_location,$param_description,$param_studentid);
            
            // Set parameters
            $param_name_of_company = $name_of_company;
            $param_location = $location;
            $param_description = $description;
            $param_studentid = $_SESSION["id"];
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               header("Location: attachment_landing.php");
               //echo "Everything Works well so far";
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    else{
        echo "ERRORS NOT EMPTY";
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 

 <!DOCTYPE html>
<html>
<head>
    <title>Experience</title>
    <link rel="stylesheet" href="triallogin2.css">
    <link rel="stylesheet" href="link.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <div class="screen">
        <div class="screen__content">
            <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="name_of_company" class="login__input form-control <?php echo (!empty($name_of_company_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_of_company; ?>" placeholder="Name of company">
                    <span class="invalid-feedback"><?php echo $name_of_company_err; ?></span>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="location" class="login__input form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>" placeholder="Location">
                    <span class="invalid-feedback"><?php echo $location_err; ?></span>
                </div>
                
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="description" class="login__input form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>" placeholder="Description">
                    <span class="invalid-feedback"><?php echo $description_err; ?></span>
                </div>
               
                <button class="button login__submit">
                    <span class="button__text">Add</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>               
            </form>
            <div class="social-login">
                <a href="attachment_landing.php"><h3>Back</h3></a> 
            </div>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>      
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>      
    </div>
</div>
 
</body>
</html>


