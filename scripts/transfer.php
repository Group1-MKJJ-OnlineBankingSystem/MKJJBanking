<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    
    $transfer = trim($_POST['transfer']);
    $senderAcctNum = trim($_POST['sender_account_num']);
    $receiverAcctNum = trim($_POST['receiver_account_num']);
    
    if (!$transfer || !$senderAcctNum || !$receiverAcctNum){
	    $_SESSION['transfer_failed'] = 'invalid_input';
	    header('Location: ../homepage.php');
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	$query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$cID = $row['customerID'];
	$results->free();
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$senderAcctNum' AND ownerID = '$cID'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	if (!$row){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit();
	}
	$senderCurrentBalance = $row['balance'];
	$senderOwnerID = $row['ownerID'];
	$results->free();
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$receiverAcctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	if (!$row){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit();
	}
	$receiverCurrentBalance = $row['balance'];
	$receiverOwnerID = $row['ownerID'];
	$results->free();
	
	
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $transfer = addslashes($transfer);
        $senderAcctNum = addslashes($senderAcctNum);
        $receiverAcctNum = addslashes($receiverAcctNum);
	}
	
	if ($senderCurrentBalance >= $transfer){
        $senderNewBalance = round(doubleval($senderCurrentBalance) - doubleval($transfer),2);
        $receiverNewBalance = round(doubleval($receiverCurrentBalance) + doubleval($transfer),2);
	}
	else{
	 $_SESSION['transaction_failed'] = 'insufficentBalance';
	   header('Location: ../homepage.php');
	   exit();
	}
	
	if ($senderOwnerID != $cID){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit(); 
	}
	
	$sql = "UPDATE ACCOUNTS SET balance='$receiverNewBalance' WHERE bankAccountNumber='$receiverAcctNum' AND ownerID='$receiverOwnerID'";
	$receiverResults = $db->query($sql);
	$sql = "UPDATE ACCOUNTS SET balance='$senderNewBalance' WHERE bankAccountNumber='$senderAcctNum' AND ownerID='$senderOwnerID'";
	$senderResults = $db->query($sql);
	
    if ($receiverResults && $senderResults) {
	    $_SESSION['transferSuccess'] = 'successful';
	    header('Location: ../homepage.php');
	    exit();
	}
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../homepage.php');
	    exit();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    //closes db connection
    $db->close();
?>