<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    
    
    $withdrawal = trim($_POST['withdrawal']);
    $acctNum = intval(trim($_POST['account_num']));
    date_default_timezone_set("America/New_York");
    $date = date("Y/m/d h:i:s");
    $transactionType = "withdrawal";
    
    if (!$withdrawal || !$acctNum){
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../homepage.php');
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	$query = 'SELECT transactionID FROM TRANSACTIONS';
	$results = $db->query($query);
	$transactionid = mt_rand(10000000000, 20000000000);
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        if ($transactionid == $row['transactionID']){
            $transactionid = mt_rand(10000000000, 20000000000);
            $i=0;
        }
	}
    
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$cID = $row['customerID'];
	$results->free();
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$acctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	if (!$row){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit();
	}
	
	$currentBalance = $row['balance'];
	$acctOwner = $row['ownerID'];
	$results->free();
	
	
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $acctNum = addslashes($acctNum);
        $withdrawal = addslashes($withdrawal);
	}
	
	if ($currentBalance >= $withdrawal){
        $newBalance = round(doubleval($currentBalance) - doubleval($withdrawal),2);
	}
	else{
	   $_SESSION['transaction_failed'] = 'insufficentBalance';
	   header('Location: ../homepage.php');
	   exit();
	}
    $sql = "UPDATE ACCOUNTS SET balance='$newBalance' WHERE bankAccountNumber='$acctNum' AND ownerID='$cID'";
    $results = $db->query($sql);
    if ($acctOwner != $cID){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../homepage.php');
	   exit(); 
	}
    else if ($results) {
        $query = "INSERT INTO TRANSACTIONS VALUES
	    ('".$date."', '".$transactionType."', '".-$withdrawal."', '".$acctNum."', '".$transactionid."')";
	
	    //tries to insert user info into db
	    $transactionResults = $db->query($query);
        
	    $_SESSION['withdrawalSuccess'] = 'successful';
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