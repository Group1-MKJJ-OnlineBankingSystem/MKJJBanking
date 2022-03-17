<?php 
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    //takes input passed from form and assigns to variables
    $user = strtolower(trim($_POST['user']));
    $pass = trim($_POST['pass']);
    $conpass = trim($_POST['conpass']);
    $email = trim($_POST['email']);
    $fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$stadd = trim($_POST['stadd']);
	$city = trim($_POST['city']);
	$state = trim($_POST['state']);
	$zip = trim($_POST['zip']);
	
	//checks if all inputs have been passed
	if (!$user || !$pass || !$conpass || !$fname || !$lname || !$email || !$stadd || !$city || !$state || !$zip) {
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../emp_register.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//checks if password is at least 6 characters
	else if (strlen($pass) < 6) {
	    $_SESSION['registration_failed'] = 'invalid_password';
	    header('Location: ../emp_register.php');
	    echo "<p style:\"color:red;\">Password too short, try again!<p>";
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//checks if password and confirm password inputs match
	else if ($pass != $conpass) {
	    $_SESSION['registration_failed'] = 'pwdnotmatch';
	    header('Location: ../emp_register.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
    //gets id and username from current employee
    $query = 'SELECT employeeID, eUsername, eEmail FROM EMPLOYEE';
	$results = $db->query($query);
	
	//gets the number of results
	$num_results = $results->num_rows;
    
    //generates a 6 digit random number for employee id
    $empid = mt_rand(100000, 999999);
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $user = addslashes($user);
        $pass = addslashes($pass);
        $fname = addslashes($fname);
        $lname = addslashes($lname);
        $email = addslashes($email);
        $city = addslashes($city);
	}
	
	//concatenates address
	$address = $stadd.' '.$city.', '.$state.' '.$zip;
	
	//hashes password
	$pass = password_hash($pass, PASSWORD_DEFAULT);
  
    //loops through all current customers
    for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current ids with new ids
        if ($empid == $row['customerID'])
            //creates a new random id if there is a match
            $empid = mt_rand(100000, 999999);
        
        //compares current usernames with new username    
        if ($user == $row['username']) {
            //exits program is there is a match
            $_SESSION['registration_failed'] = 'usertaken';
            header('Location: ../emp_register.php');
            
            //closes db conection
            $results->free();
	        $db->close();
            exit();
        }
        
        if ($email == $row['email']) {
            //exits program is there is a match
            $_SESSION['registration_failed'] = 'emailtaken';
            header('Location: ../emp_register.php');
            
            //closes db conection
            $results->free();
	        $db->close();
            exit();
        }
    }
    
    //converts customer id into string
    $empid = strval($empid);
	
	//creates insert query for db with user info
	$query = "INSERT INTO EMPLOYEE VALUES 
	('".$empid."', '".$user."', '".$pass."', '".$email."', '".$fname."', '".$lname."', '".$address."')";
	
	//tries to insert user info into db
	$results = $db->query($query);
	
	//checks if insert was successful
	if ($results) {
	    $_SESSION['regdone'] = true;
	    header('Location: ../../homepage_employee.php');
	    exit();
	}
	
	//checks if some other error has occurred
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../emp_register.php');
	    exit();
	}
	
	//closes db connection
    $db->close();
?>