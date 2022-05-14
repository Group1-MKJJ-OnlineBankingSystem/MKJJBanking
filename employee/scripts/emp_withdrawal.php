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
    
    $deposit = -1 * trim($_POST['withdrawal']);
    $acctNum = intval(trim($_POST['account_num']));
    date_default_timezone_set("America/New_York");
    $date = date("Y/m/d H:i:s");
    $transactionType = "withdrawal";
    
    $query = 'SELECT * FROM TRANSACTIONS';
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	$transactionid = mt_rand(10000000000, 20000000000);
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        if ($transactionid == $row['transactionID']){
            $transactionid = mt_rand(10000000000, 20000000000);
            $i=0;
        }
	}
    
	
	$query = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$acctNum'";
	$results = $db->query($query);
	$row = $results->fetch_assoc();
	if (!$row){
	   $_SESSION['transaction_failed'] = 'doesntOwnAcct';
	   header('Location: ../addTransaction.php');
	   exit();
	}
	$currentBalance = $row['balance'];
	$acctOwner = $row['ownerID'];
	$numTransactions = $row['numOfTransactions'];
	$numTransactions = $numTransactions + 1;
	$results->free();
	
	
	if (!$deposit || !$acctNum){
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../addTransaction.php');
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $acctNum = addslashes($acctNum);
        $deposit = addslashes($deposit);
	}
	
	
    $newBalance = round(doubleval($currentBalance) + doubleval($deposit),2);
    $sql = "UPDATE ACCOUNTS SET balance='$newBalance' WHERE bankAccountNumber='$acctNum'";
    $results = $db->query($sql);
    
    if ($results) {
        
        $query = "INSERT INTO TRANSACTIONS VALUES
	    ('".$date."', '".$transactionType."', '".$deposit."', '".$acctNum."', '".$transactionid."')";
	
	//tries to insert user info into db
	$transactionResults = $db->query($query);
	
	$sql = "UPDATE ACCOUNTS SET numOfTransactions='$numTransactions' WHERE ownerID='$cID' AND bankAccountNumber='$acctNum'";
	$results2 = $db->query($sql);
        
	    $_SESSION['withdrawalSuccess'] = 'successful';
	    header('Location: ../addTransaction.php');
	    exit();
	}
	//checks if some other error has occurred
	else {
	    $_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../addTransaction.php');
	    exit();
	}
    //closes db connection
    $db->close();
?>