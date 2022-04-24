<?php 
    //includes file with db connection
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    
    //takes input passed from form and assigns to variables
    $acctNum = intval(trim($_POST['account_num']));
    
    //checks if user has logged in. if not, redirects to login page
    if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin']) === false) {
        $_SESSION['needlog'] = true;
        header('Location: login.php');

        //closes db connection
        $db->close();
        exit();
    }
    
    if(isset($_SESSION["loggedin"])){
        if(time()-$_SESSION["login_time_stamp"] >600){
            session_unset();
            session_destroy();
            header("Location: login.php");
        }
    }
    
    $query = "SELECT * FROM TRANSACTIONS as t, ACCOUNTS as a WHERE t.bankAccountNumber = '$acctNum' AND a.bankAccountNumber = '$acctNum' ORDER BY t.dateOfTransaction DESC";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $num_results = $result->num_rows;
    
    //creates variables from queried values
    $dateOfTransaction = $row['dateOfTransaction'];
    $tranactionType = $row['transactionType'];
    $changeInBalance = $row['changeInBalance'];
    $transactionID = $row['transactionID'];
    $dateOfTransaction = strtotime($row['dateOfTransaction']);
    $numOfTransactions = mysqli_num_rows($results);
    $acctType = $row['accountType'];
    $currentDate = strtotime(date("Y/m/d H:i:s"));
    $secs = $currentDate - $dateOfTransaction;
    $days = $secs / 86400;
    
    ## Start - stop admin from viewing page
    $employeeTest = "SELECT eUsername FROM EMPLOYEE WHERE eUsername = '".$_SESSION['user']."'";
    //gets info from db
    $isEMP = $db->query($employeeTest);
    $num_EMP = $isEMP->num_rows;
    if ($num_EMP > 0){
        $_SESSION['hasAccess'] = false;
        header('Location: ./employee/emp_login.php');

        //closes db connection
        $db->close();
        exit();
    }
    ## End - stop admin from viewing page
	
	//closes db connection
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>MKJJ</title>
    <link rel="icon" type="image/x-icon" href="assets/icon_draft1.png">
    
</head>
<body>
        <?php
        $acctsList = array();
        ?>
        <ul>
            <li><a class="active" href="./homepage.php">Home</a></li>
            <!--<form action="search_apparel.php" method="post">-->
            <!--<li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">-->
            <!--    <input name="searchterm" type="text" size="20">-->
            <!--    <input type="submit" name="submit" value="Search">-->
            <!--</li>-->
            <!--</form>-->
            <li style="float:right"><a class="active" href="./scripts/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href="./account.php">Settings</a></li>
            <li style="float:right"><a class="active" href="./about.php">About</a></li>
            <li style="float:right"><a class="active" href="./services.php">Services</a></li>
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
                <h2>History</h2>
                <h3>Account Number: <?php echo $acctNum ?></h3>
                <h3>Account Type: <?php echo $acctType ?></h3>
                <button class="mkjj-button" onclick="window.print()">Print this page</button>
                
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
            </nav>
     <hr> 
     <div>
                <?php
                    if($numOfTransactions == 0){
                        echo "No transaction history";
                    } else {
                        for($i = 0; $i < $numOfTransactions; $i++){
                            $secs = $currentDate - strtotime($row['dateOfTransaction']);
                            $days = $secs / 86400;
                            if ($days <= 365){
                                if ( $i % 2 == 0){
                                    echo '<div style="background-color: LightGray" class="history-card">';
                                }
                                else{
                                    echo '<div class="history-card">';
                                }
                                
                                echo '<div class="card-info"><b>Date of Transaction</b></br>'.$row['dateOfTransaction'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Transaction ID</b></br>'.$row['transactionID'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Transaction Type</b></br>'.$row['transactionType'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Amount</b></br>'.money_format("$%i",$row['changeInBalance']).'</div>';
                                // echo '<div class="vl"></div>';
                                // echo '<div class="card-info"><b>Days Since Transaction</b></br>'.$days.'</div>';
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
