<?php 
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    $transactionID = trim($_POST['transactionID']);
    $amount = trim($_POST['amount']);
    
    // echo $transactionID;
    // echo '<br>';
    // echo $amount;
    
    
    $query = "SELECT * FROM TRANSACTIONS WHERE transactionID = '$transactionID'";
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $date = $row['dateOfTransaction'];
    $accountNum = $row['bankAccountNumber'];
    $orginalAmount = $row['changeInBalance'];
    $type = $row['transactionType'];
    
    $newAmount = abs(abs($amount) - abs($orginalAmount));
    if ($orginalAmount < 0 && $orginalAmount < $amount){
        $newAmount = $newAmount;
    }
    else if ($orginalAmount < 0 && $orginalAmount > $amount){
        $newAmount = -1 * $newAmount;
    }
    else if ($orginalAmount > 0 && $orginalAmount < $amount){
        $newAmount = $newAmount;
    }
    else if ($orginalAmount > 0 && $orginalAmount > $amount){
        $newAmount = -1 * $newAmount;
    }
    
    $query = "SELECT balance FROM ACCOUNTS WHERE bankAccountNumber = '$accountNum'";
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $balance = $row['balance'];
    $newAmount = $newAmount + $balance;
    $sql = "UPDATE ACCOUNTS SET balance ='$newAmount' WHERE bankAccountNumber='$accountNum'";
    $results1 = $db->query($sql);
    $sql = "UPDATE TRANSACTIONS SET changeInBalance='$amount' WHERE transactionID='$transactionID'";
    $results = $db->query($sql);
    
    // if ($type == "transfer received"){
    //     $query = "SELECT * FROM TRANSACTIONS WHERE dateOfTransaction = '$date' AND changeInBalance = '$orginalAmount*1.03'";
    //     $results = $db->query($query);
    //     $row = $results->fetch_assoc();
    //     $date = $row['dateOfTransaction'];
    //     $accountNum = $row['bankAccountNumber'];
    //     $orginalAmount = $row['changeInBalance'];
    //     $type = $row['transactionType'];
        
    //     $query = "SELECT balance FROM ACCOUNTS WHERE bankAccountNumber = '$accountNum'";
    //     $results = $db->query($query);
    //     $row = $results->fetch_assoc();
    //     $balance = $row['balance'];
    //     $newAmount = (-1*$newAmount) + $balance;
    //     $sql = "UPDATE ACCOUNTS SET balance ='$newAmount' WHERE bankAccountNumber='$accountNum'";
    //     $results1 = $db->query($sql);
    //     $sql = "UPDATE TRANSACTIONS SET changeInBalance='$amount' WHERE transactionID='$transactionID'";
    //     $results = $db->query($sql);
        
    // }
    
    // else if ($type == "transfer sent"){
    //     $query = "SELECT * FROM TRANSACTIONS WHERE dateOfTransaction = '$date' AND transactionType = 'transfer received'";
    //     $results = $db->query($query);
    //     $row = $results->fetch_assoc();
    //     $date = $row['dateOfTransaction'];
    //     $accountNum = $row['bankAccountNumber'];
    //     $orginalAmount = $row['changeInBalance'];
    //     $type = $row['transactionType'];
        
    //     $query = "SELECT balance FROM ACCOUNTS WHERE bankAccountNumber = '$accountNum'";
    //     $results = $db->query($query);
    //     $row = $results->fetch_assoc();
    //     $balance = $row['balance'];
    //     $newAmount = (-1*$newAmount) + $balance;
    //     $sql = "UPDATE ACCOUNTS SET balance ='$newAmount' WHERE bankAccountNumber='$accountNum'";
    //     $results1 = $db->query($sql);
    //     $sql = "UPDATE TRANSACTIONS SET changeInBalance='$amount' WHERE transactionID='$transactionID'";
    //     $results = $db->query($sql);
        
    // }
    
    if ($results) {
	    $_SESSION['account_approval'] = 'approved';
	    header('Location: ../emp_search.php');
	    exit();
	}
    
    
    
	//closes db connection
    $db->close();
?>