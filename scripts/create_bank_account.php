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
    $acctType = strtolower(trim($_POST['acct']));
    $deposit = trim($_POST['initDeposit']);
    date_default_timezone_set("America/New_York");
    $date = date("Y/m/d");
    $transactionDate = date("Y/m/d H:i:s");
    $transactionType = "initial deposit";
    $status = "pending approval";
    

    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$numAccounts = $row['numOfAccounts'];
// 	$numTransactions = $row['numOfTransactions'];
	$cID = $row['customerID'];
	$results->free();
	$numAccounts = $numAccounts + 1;
// 	$numTransactions = $numTransactions + 1;
	
	$query = 'SELECT * FROM ACCOUNTS';
	$results = $db->query($query);
	$row = $results->fetch_assoc();
// 	$numTransactions = $row['numOfTransactions'];
	$bankAcctNum = mt_rand(400000000000, 499999999999);
	$numTransactions = 1;
	
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current ids with new ids
        if ($bankAcctNum == $row['bankAccountNumber']){
            //creates a new random id if there is a match
            $bankAcctNum = mt_rand(400000000000, 499999999999);
            $i=0;
        }
	}
	
	$query = 'SELECT transactionID FROM TRANSACTIONS';
	$results = $db->query($query);
	$transactionid = mt_rand(10000000000, 20000000000);
	
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current ids with new ids
        if ($transactionid == $row['transactionID']){
            //creates a new random id if there is a match
            $transactionid = mt_rand(10000000000, 20000000000);
            $i=0;
        }
	}
	
	
	if (!$deposit){
	    $deposit = 0.0;
	}
	
	if (!$acctType) {
	    $_SESSION['registration_failed'] = 'invalid_input';
	    header('Location: ../homepage.php');
	    
	    //closes db conection
	    $db->close();
	    exit();
	}
	
	//adds slashes for any quotes in inputs
	if (!get_magic_quotes_gpc()) {
        $acctType = addslashes($acctType);
        $deposit = addslashes($deposit);
	}
	
    $deposit = doubleval($deposit);
    
	//creates insert query for db with user info

    $query = "INSERT INTO ACCOUNTS VALUES ('".$bankAcctNum."', '".$acctType."', '".$deposit."', '".$cID."', '".$date."', '".$numTransactions."', '".$status."')";

	//tries to insert user info into db
	$results = $db->query($query);
	
	//checks if insert was successful
	if ($results) {
	    $sql = "UPDATE CUSTOMER SET numOfAccounts='$numAccounts' WHERE customerID='$cID'";
	    $results2 = $db->query($sql);
	   // $sql = "UPDATE CUSTOMER SET numOfTransactions='$numTransactions' WHERE customerID='$cID'";
	   // $results2 = $db->query($sql);
	    
	    $query = "INSERT INTO TRANSACTIONS VALUES
	('".$transactionDate."', '".$transactionType."', '".$deposit."', '".$bankAcctNum."', '".$transactionid."')";
	
	//tries to insert user info into db
	$transactionResults = $db->query($query);
	    
	    
	    $_SESSION['acctCreationDone'] = 'done';
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