<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    if(isset($_SESSION["loggedin"])){
            if(time()-$_SESSION["login_time_stamp"] >600){
                session_unset();
                session_destroy();
                header("Location: login.php");
            }
        }
    //takes input passed from form and assigns to variables
    $pass = trim($_POST['pass']);
    $newUsername = strtolower(trim($_POST['newuser']));
    
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$user = $row['cUsername'];
	$cpass = $row['cPassword'];
	$custID = $row['customerID'];
	$results->free();
	
    if (!$pass || !$newUsername) {
	    $_SESSION['uNameChange_failed'] = 'invalid_input';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if (!password_verify($pass, $cpass)) {
	    $_SESSION['uNameChange_failed'] = 'pwdnotmatch';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if ($user === $newUsername) {
	    $_SESSION['uNameChange_failed'] = 'sameasold';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $pass = addslashes($pass);
        $newUsername = addslashes($newUsername);
	}
	
	$query2 = 'SELECT cUsername FROM CUSTOMER';
	$results2 = $db->query($query2);
	$num_results = $results2->num_rows;
    for ($i = 0; $i < $num_results; $i++) {
        $row2 = $results2->fetch_assoc();
        
        //compares current usernames with new username    
        if ($newUsername == $row2['cUsername']) {
            //exits program is there is a match
            $_SESSION['uNameChange_failed'] = 'usertaken';
            header('Location: ../account.php');
            
            //closes db conection
            $results->free();
	        $db->close();
            exit();
        }
        
    }
	
// 	#################################################
// 	# probably should remove and take ownerUsername out of ACCOUNTS table
// 	$query3 = 'SELECT ownerUsername, ownerID FROM ACCOUNTS';
// 	$results3 = $db->query($query3);
// 	$num_results3 = $results3->num_rows;
//     for ($i = 0; $i < $num_results3; $i++) {
//         $row3 = $results3->fetch_assoc();
        
//         //compares current usernames with new username    
//         if ($user == $row3['ownerUsername'] && $custID == $row3['ownerID']) {
//             $sql = "UPDATE ACCOUNTS SET ownerUsername='$newUsername' WHERE ownerUsername='$user'";
//             $db->query($sql);
//         }
        
//     }
// 	#################################################
	
	$sql = "UPDATE CUSTOMER SET cUsername='$newUsername' WHERE cUsername='$user'";
	if ($db->query($sql) === TRUE) {
	    $_SESSION['uNameChanged'] = 'usernamechanged';
	    
	    $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $newUsername;
        $_SESSION['name'] = $row['cFname'];
        
        $_SESSION['newlog'] = true;
        header('Location: ../account.php');
        
        //closes db connection
        //$result->free();
        //$db->close();-->
        exit();
	    
	}
	else{
      $_SESSION['uNameChange_failed'] = 'updateERR';
	    header('Location: ../account.php');
	    //closes db conection
	    //$result->free();
	    //$db->close();
	    exit();
    }
    header('Location: ../account.php');
	//closes db connection
    //$db->close();
    exit();
?>