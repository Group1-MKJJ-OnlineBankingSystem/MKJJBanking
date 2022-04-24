<?php 
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    $acctNum = trim($_POST['accept']);
    //echo $acctNum;
    
	$query = "SELECT status FROM ACCOUNTS WHERE bankAccountNumber = '$acctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	$currentStatus = $row['status'];
	$results->free();
	//echo $currentStatus;
	
	$currentStatus = "approved";
	
	$sql = "UPDATE ACCOUNTS SET status='$currentStatus' WHERE bankAccountNumber='$acctNum'";
    $results = $db->query($sql);
    
    if ($results) {
	    $_SESSION['account_approval'] = 'approved';
	    header('Location: ../account_requests.php');
	    exit();
	}
	
	//closes db connection
    $db->close();
?>