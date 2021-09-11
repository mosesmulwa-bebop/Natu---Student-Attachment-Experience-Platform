<?php
// Include config file
require_once "attachment_config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $course = $username = $password = $confirm_password = "";
$firstname_err = $lastname_err = $course_err = $username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate Firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a first name.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["firstname"]))){
        $firstname_err = "Firstname can only contain letters, numbers, and underscores.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    // Validate Lastname
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a last name.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["lastname"]))){
        $lastname_err = "Lastname can only contain letters, numbers, and underscores.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }
   
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM student WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

     // Validate Course
    if(empty(trim($_POST["course"]))){
        $course_err = "Please enter a course.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["course"]))){
        $course_err = "course can only contain letters, numbers, and underscores.";
    } else{
        $course = trim($_POST["course"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($course_err) && 
        empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO student (firstname,lastname,username,course, password) VALUES (?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_firstname,$param_lastname,$param_username,$param_course,   $param_password);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_username = $username;
            $param_course = $course;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("Location: attachment_login.php");
               //echo "Everything Works";
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
    <title>Login</title>
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
                    <input type="text"  name="firstname" class="login__input form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>" placeholder="First name">
                    <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="lastname" class="login__input form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>" placeholder="Last name">
                    <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                </div>
                
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="username" class="login__input form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="User name">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text"  name="course" class="login__input form-control <?php echo (!empty($course_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $course; ?>" placeholder="Course">
                    <span class="invalid-feedback"><?php echo $course_err; ?></span>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="confirm_password" class="login__input form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <button class="button login__submit">
                    <span class="button__text">Sign Up</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>               
            </form>
            <div class="social-login">
                <a href="attachment_login.php"><h3>Login</h3></a> 
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


