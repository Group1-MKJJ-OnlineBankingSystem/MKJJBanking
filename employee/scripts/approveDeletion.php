<?php
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    $bankAccountNum = trim($_POST['accept']);

    $query = "DELETE FROM ACCOUNTS WHERE bankAccountNumber='$bankAccountNum'";
    $results = $db->query($query);
    if ($results){
        // $query = "DELETE FROM TRANSACTIONS WHERE bankAccountNumber='$bankAccountNum'";
        // $results = $db->query($query);
        
    //     $sql = "UPDATE ACCOUNTS SET status='$status' WHERE ownerID='$cID' AND bankAccountNumber='$bankAccountNum'";
	   // $results2 = $db->query($sql);
	    
	    $_SESSION['acctDeletionDone'] = 'done';
	    header('Location: ../account_requests.php');
	    exit();
    }else{$_SESSION['registration_failed'] = 'randerr';
	    header('Location: ../account_requests.php');
	    $db->close();
	    exit();
    }
	//closes db connection
    $db->close();
    


?>