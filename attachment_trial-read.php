<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "attachment_config.php";
    
    // Prepare a select statement
    $sql = "SELECT id,firstname,lastname,course FROM student WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $course = $row["course"];
                
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: attachment_error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: attachment_error.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User</title>
    <link rel="stylesheet" type="text/css" href="user.css">
</head>
<body>
<div class="card-container">
    
    <img class="round" src="user.png" alt="user"  height="100px" width="100px" />
    <h3><?php echo $row["firstname"]; ?></h3>
    <h3><?php echo $row["lastname"]; ?></h3>
    <h6><?php echo $row["course"]; ?></h6>
    <p>Student</p>
    <div class="buttons">
        <a href="attachment_admin.php">
            <button class="primary">
            Back
            </button>
        </a>
        
      <!--   <button class="primary ghost">
            Following
        </button> -->
    </div>
    <!-- <div class="skills">
        <h6>Skills</h6>
        <ul>
            <li>UI / UX</li>
            <li>Front End Development</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>JavaScript</li>
            <li>React</li>
            <li>Node</li>
        </ul>
    </div> -->
</div>

<!-- <footer>
    <p>
        Created with <i class="fa fa-heart"></i> by
        <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
        - Read how I created this
        <a target="_blank" href="https://florin-pop.com/blog/2019/04/profile-card-design">here</a>
        - Design made by
        <a target="_blank" href="https://dribbble.com/shots/6276930-Profile-Card-UI-Design">Ildiesign</a>
    </p>
</footer> -->
</body>
</html>