<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    
    $deposit = trim($_POST['deposit']);
    $acctNum = trim($_POST['account_num']);
    
    
    
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$cID = $row['customerID'];
	
	$results->free();
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$acctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	$currentBalance = $row['balance'];
	$acctOwner = $row['ownerID'];
	$results->free();
	
	
	if (!$deposit || !$acctNum){
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../homepage.php');
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $acctNum = addslashes($acctNum);
        $deposit = addslashes($deposit);
	}
	
	
    $newBalance = doubleval($currentBalance) + doubleval($deposit);
    $sql = "UPDATE ACCOUNTS SET balance='$newBalance' WHERE bankAccountNumber='$acctNum' AND ownerID='$cID'";
    $results = $db->query($sql);
    if ($acctOwner != $cID){
	   $_SESSION['deposit_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit(); 
	}
    else if ($results) {
	    $_SESSION['depositSuccess'] = 'successful';
	    header('Location: ../homepage.php');
	    exit();
	}
	//checks if some other error has occurred
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../homepage.php');
	    exit();
	}
    //closes db connection
    $db->close();
?>