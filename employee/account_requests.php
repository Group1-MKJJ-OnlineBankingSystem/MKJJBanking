<?php 
    //includes file with db connection
    require_once '../db_connect.php';
    
    //gets session info
    session_start();
    
    ## Start - stop user from viewing page
    $userTest = "SELECT cUsername FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $isUSR = $db->query($userTest);
    $num_USR = $isUSR->num_rows;
    if ($num_USR > 0){
        $_SESSION['hasAccess'] = false;
        header('Location: ../login.php');

        //closes db connection
        $db->close();
        exit();
    }
    ## End - stop uder from viewing page

    //checks if user has logged in. if not, redirects to login page
    if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin']) === false) {
        $_SESSION['needlog'] = true;
        header('Location: login.php');

        //closes db connection
        $db->close();
        exit();
    } else if($_SESSION['account_approval'] == 'approved'){
        $notice = 'Account Approval was Successful';
            
        $_SESSION['account_approval'] = '';
    } else if($_SESSION['account_approval'] == 'denied'){
        $notice = 'Account Denial was Successful';
            
        $_SESSION['account_approval'] = '';
    }
    else if($_SESSION['acctDeletionDone'] == 'done'){
        $notice = 'Account Deletion was Successful';
            
        $_SESSION['acctDeletionDone'] = '';
    }
    else if($_SESSION['acctDeletionDone'] == 'denied'){
        $notice = 'Deletion was denied, account has been restored.';
            
        $_SESSION['acctDeletionDone'] = '';
    }
    
    
    $query = "SELECT * FROM ACCOUNTS WHERE status = 'pending approval' OR status = 'pending deletion'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $num_results = $result->num_rows;
    
    //creates variables from queried values
    $bankAccountNumber = $row['bankAccountNumber'];
    $accountType = $row['accountType'];
    $balance = $row['balance'];
    $status = $row['status'];
    $numOfaccts = mysqli_num_rows($results);
	//closes db connection
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>MKJJ</title>
    <link rel="icon" type="image/x-icon" href="../assets/icon_draft1.png">
    
</head>
<body>
        <ul>
            <li><a class="active" href="./homepage_admin.php">Home</a></li>
            <!--<form action="search_apparel.php" method="post">-->
            <!--<li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">-->
            <!--    <input name="searchterm" type="text" size="20">-->
            <!--    <input type="submit" name="submit" value="Search">-->
            <!--</li>-->
            <!--</form>-->
            <li style="float:right"><a class="active" href="../scripts/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href="./emp_settings.php">Settings</a></li>
        </ul>
            <style>
                body{
                    font-size:24px;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
                </style>
        <!--<div class="hero-wrapper">-->
        <!--    <div class="hero-wrapper-squared">-->
        <!--        <h1>MKJJ Online Banking System</h1>-->
        <!--    </div>-->
        <!--</div>-->
            <nav class="heading" style='text-align: center'>
                <h2>Account Requests</h2>
                <!--<button class="mkjj-button" onclick="window.print()">Print this page</button>-->
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
            </nav>
     <hr> 
     <div>
                <?php
                    if($numOfaccts == 0){
                        echo "<center>No pending accounts :)</center>";
                    } else {
                        for($i = 0; $i < $numOfaccts; $i++){
                            if($row[status] == "pending approval"){
                                echo '<div class="history-card">';
                                
                                echo '<div class="card-info"><b>Account Number</b></br>'.$row['bankAccountNumber'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Account Type</b></br>'.$row['accountType'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Inital Deposit</b></br>'.money_format("$%i",$row['balance']).'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Status</b></br>'.$row['status'].'</div>';
                                echo '<form action="./scripts/approveAccount.php" method="post">
                                <button style="background-color: green" class = "mkjj-button" name="accept" value='.$row['bankAccountNumber'].'>Approve</button>';
                                echo '</form>';
                                echo '<br>';
                                echo '<form action="./scripts/denyAccount.php" method="post">
                                <button style="background-color: red" class = "mkjj-button" name="decline" value='.$row['bankAccountNumber'].'>Deny</button>';
                                echo '</form>';
                                echo '<br>';
                                echo "</div>";
                                $row = $results->fetch_assoc();
                            } else if($row[status] == "pending deletion"){
                                echo '<div class="history-card">';
                                
                                echo '<div class="card-info"><b>Account Number</b></br>'.$row['bankAccountNumber'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Account Type</b></br>'.$row['accountType'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Inital Deposit</b></br>'.money_format("$%i",$row['balance']).'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Status</b></br>'.$row['status'].'</div>';
                                echo '<form action="./scripts/approveDeletion.php" method="post">
                                <button style="background-color: green" class = "mkjj-button" name="accept" value='.$row['bankAccountNumber'].'>Approve</button>';
                                echo '</form>';
                                echo '<br>';
                                echo '<form action="./scripts/denyDeletion.php" method="post">
                                <button style="background-color: red" class = "mkjj-button" name="decline" value='.$row['bankAccountNumber'].'>Deny</button>';
                                echo '</form>';
                                echo '<br>';
                                echo "</div>";
                                $row = $results->fetch_assoc();
                            }
                        }
                    }
                ?>
            </div>
        </body>
</html>

