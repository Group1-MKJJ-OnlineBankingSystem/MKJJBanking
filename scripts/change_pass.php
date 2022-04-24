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
    $oldPassword= trim($_POST['oldpass']);
    $pass = trim($_POST['newpass']);
    $confirmNewPassword = trim($_POST['connewpass']);
    
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$user = $row['cUsername'];
	$cpass = $row['cPassword'];
	$results->free();
	
    if (!$oldPassword || !$pass || !$confirmNewPassword) {
	    $_SESSION['passwordChange_failed'] = 'invalid_input';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	//checks if password is at least 6 characters
	else if (strlen($pass) < 6) {
	    $_SESSION['passwordChange_failed'] = 'pass_short';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if (!password_verify($oldPassword, $cpass)) {
	    $_SESSION['passwordChange_failed'] = 'pwdnotmatch';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	else if ($pass != $confirmNewPassword) {
	    $_SESSION['passwordChange_failed'] = 'newpwdnotmatch';
	    header('Location: ../account.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $pass = addslashes($pass);
	}
	
	//hashes password
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	
	$sql = "UPDATE CUSTOMER SET cPassword='$pass' WHERE cUsername='$user'";
	if ($db->query($sql) === TRUE) {
	    $_SESSION['passwordChange_success'] = 'pass_changed';
	    header('Location: ../account.php');
	}
	else{
      $_SESSION['passwordChange_failed'] = 'updateERR';
	    header('Location: ../account.php');
	    //closes db conection
	    $db->close();
	    exit();
    }
    header('Location: ../account.php');
	//closes db connection
    $db->close();
    exit();
?>