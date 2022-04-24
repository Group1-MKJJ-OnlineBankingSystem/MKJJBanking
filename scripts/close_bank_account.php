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
    // $password = trim($_POST['pass']);
    // $confirm_password = trim($_POST['conpass']);
    $bankAccountNum = trim($_POST['account_num']);
    
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$user = $row['cUsername'];
	$cpass = $row['cPassword'];
	$numOfAccts = $row['numOfAccounts'];
	$numOfAccts = $numOfAccts - 1;
	$cID = $row['customerID'];
	$results->free();
	$status = "pending deletion";
	
    if (!$bankAccountNum) {
	    $_SESSION['passwordInput_failed'] = 'invalid_input';
	    header('Location: ../homepage.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
// 	else if (!password_verify($confirm_password, $cpass)) {
// 	    $_SESSION['passwordInput_failed'] = 'pwdnotmatch';
// 	    header('Location: ../homepage.php');
// 	    //closes db conection
// 	    $db->close();
// 	    exit();
// 	}
    
//     //adds slashes for any quotes in inputs
// 	if (!get_magic_quotes_gpc()) {
//         $password = addslashes($pass);
//         $confirm_password = addslashes($pass);
// 	}
	
    // $query = "DELETE FROM ACCOUNTS WHERE bankAccountNumber='$bankAccountNum' AND ownerID='$cID'";
    // $results = $db->query($query);
    if ($results){
        // $query = "DELETE FROM TRANSACTIONS WHERE bankAccountNumber='$bankAccountNum'";
        // $results = $db->query($query);
        
        $sql = "UPDATE ACCOUNTS SET status='$status' WHERE ownerID='$cID' AND bankAccountNumber='$bankAccountNum'";
	    $results2 = $db->query($sql);
	    
	    $_SESSION['acctDeletionDone'] = 'done';
	    header('Location: ../homepage.php');
	    exit();
    }else{$_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../homepage.php');
	    $db->close();
	    exit();
    }
	//closes db connection
    $db->close();
    
?>