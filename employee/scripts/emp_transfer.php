<?php 
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    if(isset($_SESSION["loggedin"])){
            if(time()-$_SESSION["login_time_stamp"] >600){
                session_unset();
                session_destroy();
                header("Location: login.php");
            }
        }
    
    $transfer = trim($_POST['transfer']);
    $senderAcctNum = intval(trim($_POST['sender_account_num']));
    $receiverAcctNum = trim($_POST['receiver_account_num']);
    $transferType = trim($_POST['transferType']);
    date_default_timezone_set("America/New_York");
    $sDate = date("Y/m/d H:i:s");
    $rDate = date("Y/m/d H:i:s");
    $rTransactionType = "transfer received";
    $sTransactionType = "transfer sent";
    
    $query = 'SELECT transactionID FROM TRANSACTIONS';
	$results = $db->query($query);
	$senderTransactionid = mt_rand(10000000000, 20000000000);
	$receiverTransactionid = mt_rand(10000000000, 20000000000);
	
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        if ($senderTransactionid == $row['transactionID']){
            $senderTransactionid = mt_rand(10000000000, 20000000000);
            $i=0;
        }
        if ($receiverTransactionid == $row['transactionID']){
            $receiverTransactionid = mt_rand(10000000000, 20000000000);
            $i=0;
        }
	}
    
    
    if (!$transfer || !$senderAcctNum || !$receiverAcctNum || !$transferType){
	    $_SESSION['transfer_failed'] = 'invalid_input';
	    header('Location: ../addTransaction.php');
	    //closes db conection
	    $db->close();
	    exit();
	}
		
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $transfer = addslashes($transfer);
        $senderAcctNum = addslashes($senderAcctNum);
        if ($transferType == "internal"){
            $receiverAcctNum = addslashes($receiverAcctNum);
        }
	}
	
	
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$senderAcctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	if (!$row){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../addTransaction.php');
	   exit();
	}
	$senderCurrentBalance = $row['balance'];
	$senderOwnerID = $row['ownerID'];
	$numTransactions = $row['numOfTransactions'];
	$numTransactions = $numTransactions + 1;
	$results->free();
	
	if ($transferType == "internal"){
    	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$receiverAcctNum'";
    	$results = $db->query($query);
    	$row = $results->fetch_assoc();
    	if (!$row){
    	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
    	   header('Location: ../addTransaction.php');
    	   exit();
    	}
    	$receiverCurrentBalance = $row['balance'];
    	$receiverOwnerID = $row['ownerID'];
    	$recNumTransactions = $row['numOfTransactions'];
    	$recNumTransactions = $recNumTransactions + 1;
    	$results->free();
	}
	

	
	if ($senderCurrentBalance >= $transfer){
        $senderNewBalance = round((doubleval($senderCurrentBalance) - (doubleval($transfer))*1.03),2);
        $senderNewBalance = round($senderNewBalance,2);
        if ($transferType == "internal"){
            $receiverNewBalance = round(doubleval($receiverCurrentBalance) + doubleval($transfer),2);
            $receiverNewBalance = round($receiverNewBalance,2);
	
        }
    }
	
	else{
	 $_SESSION['transaction_failed'] = 'insufficentBalance';
	   header('Location: ../addTransaction.php');
	   exit();
	}
	
	

	
	if ($transferType == "internal"){
    	$sql = "UPDATE ACCOUNTS SET balance='$receiverNewBalance' WHERE bankAccountNumber='$receiverAcctNum'";
    	$receiverResults = $db->query($sql);
	}
	$sql = "UPDATE ACCOUNTS SET balance='$senderNewBalance' WHERE bankAccountNumber='$senderAcctNum'";
	$senderResults = $db->query($sql);
	$rtransfer = $transfer + 0;
	$stransfer = round((-$transfer*1.03 + 0),2);
    if (($receiverResults || $transferType == "external") && $senderResults) {
        
        $query2 = "INSERT INTO TRANSACTIONS VALUES
	    ('".$sDate."', '".$sTransactionType."', '".$stransfer."', '".$senderAcctNum."', '".$senderTransactionid."')";
	
	    //tries to insert user info into db
	    $transactionResults = $db->query($query2);
	    
	    
	    if ($transferType == "internal"){
    	    $query3 = "INSERT INTO TRANSACTIONS VALUES
    	    ('".$rDate."', '".$rTransactionType."', '".$rtransfer."', '".$receiverAcctNum."', '".$receiverTransactionid."')";
    	
    	    //tries to insert user info into db
    	    $senderTransferResults = $db->query($query3);
	    }
	    $sql = "UPDATE ACCOUNTS SET numOfTransactions='$numTransactions' WHERE bankAccountNumber='$senderAcctNum'";
	    $results2 = $db->query($sql);
	    if ($transferType == "internal"){
    	    $sql2 = "UPDATE ACCOUNTS SET numOfTransactions='$recNumTransactions' WHERE bankAccountNumber='$receiverAcctNum'";
    	    $results3 = $db->query($sql2);
	    }
	    
        
	    $_SESSION['transferSuccess'] = 'successful';
	    header('Location: ../addTransaction.php');
	    exit();
	}
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../addTransaction.php');
	    exit();
	}
	
    //closes db connection
    $db->close();
?>