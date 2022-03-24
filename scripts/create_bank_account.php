<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    
    //takes input passed from form and assigns to variables
    $acctType = strtolower(trim($_POST['acct']));
    $deposit = trim($_POST['initDeposit']);
    date_default_timezone_set("America/New_York");
    $date = date("Y/m/d");

    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
	$numAccounts = $row['numOfAccounts'];
	$cID = $row['customerID'];
	$results->free();
	$numAccounts = $numAccounts + 1;
	
	$query = 'SELECT bankAccountNumber FROM ACCOUNTS';
	$results = $db->query($query);
	$bankAcctNum = mt_rand(400000000000, 499999999999);
	
	for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current ids with new ids
        if ($bankAcctNum == $row['bankAccountNumber']){
            //creates a new random id if there is a match
            $bankAcctNum = mt_rand(400000000000, 499999999999);
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

    $query = "INSERT INTO ACCOUNTS VALUES ('".$bankAcctNum."', '".$acctType."', '".$deposit."', '".$cID."', '".$date."')";

	//tries to insert user info into db
	$results = $db->query($query);
	
	//checks if insert was successful
	if ($results) {
	    $sql = "UPDATE CUSTOMER SET numOfAccounts='$numAccounts' WHERE customerID='$cID'";
	    $results2 = $db->query($sql);
	    
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