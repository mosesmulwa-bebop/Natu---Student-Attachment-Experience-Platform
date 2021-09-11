<?php


session_start();
// Process delete operation after confirmation
require_once "attachment_config.php";
   




    
    // Prepare a delete statement
    //$sql = "SELECT *  FROM student WHERE id = ?";
     $sql = "INSERT INTO attachment(name_of_company,location,description,studentid) VALUES (?,?,?,?)";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssi", $param_name_of_company, $param_location, $param_description, 
        	$param_id);
        
        // Set parameters
       // $param_id = 4;
        $param_name_of_company = "Stuff";
        $param_location = "Another";
        $param_description = "Last stuff";
        $param_id = $_SESSION["id"];
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to admin page
            echo "It works well enough";
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Stuff</title>
</head>
<body>
   

</body>
</html>