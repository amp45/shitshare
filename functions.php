<?php

// W3 shit required for the login to work
$connect = mysqli_connect('localhost', 'root', '', 'shitshare') or die ("Database error!");

if(isset($_COOKIE["username"])) {
$username = $_COOKIE["username"];
}

// goom's login script

if(isset($_POST["login"])) {	
	$username = $_POST["username"];
	$unhashed_password = $_POST["password"];
	$hashed_password = PASSWORD_HASH($unhashed_password, PASSWORD_DEFAULT);
	$stmt = $connect->prepare("SELECT * FROM users WHERE username = ?"); 
	$stmt->bind_param("s", $username); 
	$stmt->execute();
	$result = $stmt->get_result();
	$fetch = $result->fetch_assoc();
	$username_check = $result->num_rows;
	if ($username_check == 0) {
		exit("No users in the DB.");
	}
    if (password_verify($unhashed_password, $fetch["password"]) == FALSE) {
        exit("Incorrect password.");
    }
	setcookie("username", $fetch["username"], 2147483647); // yuh we got cookies yo (lol i made da script 4 cookies --amp)
	header("Location: index.php");
	$stmt->close();
}

// stackoverflow signup script

	if(isset($_POST["signup"])){
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";
	if(ctype_alnum($_POST["username"])) {
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim(htmlspecialchars($_POST["username"]));
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim(htmlspecialchars($_POST["username"]));
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	} else {
		$username_err = "Username must be alphabetical-numerical, special characters or spaces not permitted.";
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
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && $username !== "default/default"){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script>window.location = 'login.php'</script>";
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else {
		$username_err = "Please re-enter your account credentials.";
	}
    
    // Close connection
    mysqli_close($link);
}



// include the header for cool easy inclusion

include('header.php');


?>