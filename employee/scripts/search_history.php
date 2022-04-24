<?php 
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    ## Start - stop user from viewing page
    $userTest = "SELECT cUsername FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $isUSR = $db->query($userTest);
    $num_USR = $isUSR->num_rows;
    if ($num_USR > 0){
        $_SESSION['hasAccess'] = false;
        header('Location: ../../login.php');

        //closes db connection
        $db->close();
        exit();
    }
    ## End - stop uder from viewing page
    
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
    $numOfTransactions = $row['numOfTransactions'];
    $acctType = $row['accountType'];
    $balance = $row['balance'];
	
	$query2 = "SELECT * FROM ACCOUNTS WHERE bankAccountNumber = '$acctNum'";
	$results2 = $db->query($query2);
	$row2 = $results2->fetch_assoc();
	if (!$row2){
	   $_SESSION['invalid_acctNum'] = 'invalid account number';
	   header('Location: ../homepage_admin.php');
	   echo "invalid account num";
	   exit();
	}
	
	//closes db connection
    $db->close();
    
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>MKJJ</title>
    <link rel="icon" type="image/x-icon" href="assets/icon_draft1.png">
    
</head>
<body>
    <ul>
            <li><a class="active admin_home" href="../homepage_admin.php">Admin Home</a></li>
            <!--<li><a class="active" href="../homepage.php">Home</a></li>-->
            <!--<form action="search_apparel.php" method="post">-->
            <!--<li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">-->
            <!--    <input name="searchterm" type="text" size="20">-->
            <!--    <input type="submit" name="submit" value="Search">-->
            <!--</li>-->
            <!--</form>-->
            <li style="float:right"><a class="active" href="../../scripts/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href="../../account.php">Settings</a></li>
            <!--<li style="float:right"><a class="active" href="../about.html">About</a></li>-->
            <!--<li style="float:right"><a class="active" href="../services.php">Services</a></li>-->
        </ul>
        <?php
        $acctsList = array();
        ?>
        <!--<ul>-->
        <!--    <li><a class="active" href="./homepage.php">Home</a></li>-->
            <!--<form action="search_apparel.php" method="post">-->
            <!--<li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">-->
            <!--    <input name="searchterm" type="text" size="20">-->
            <!--    <input type="submit" name="submit" value="Search">-->
            <!--</li>-->
            <!--</form>-->
        <!--    <li style="float:right"><a class="active" href="./scripts/logout.php">Log Out</a></li>-->
        <!--    <li style="float:right"><a class="active" href="./account.php">Settings</a></li>-->
        <!--    <li style="float:right"><a class="active" href="./about.html">About</a></li>-->
        <!--    <li style="float:right"><a class="active" href="./services.php">Services</a></li>-->
        <!--</ul>-->
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
                <h3>Balance: $<?php echo $balance ?></h3>
                <button class="mkjj-button" onclick="window.print()">Print this page</button>
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
            </nav>
     <hr> 
     <div>
                <?php
                    if($numOfTransactions == 0){
                        echo "<center>";
                        echo "No transaction history";
                        echo "</center>";
                    } else {
                        echo '<div style="background-color: LightGray" class="history-card">';
                        echo '<div class="card-info"><b>Date of Transaction</b></br>'.$row['dateOfTransaction'].'</div>';
                        echo '<div class="vl"></div>';
                        echo '<div class="card-info"><b>Transaction ID</b></br>'.$row['transactionID'].'</div>';
                        echo '<div class="vl"></div>';
                        echo '<div class="card-info"><b>Transaction Type</b></br>'.$row['transactionType'].'</div>';
                        echo '<div class="vl"></div>';
                        echo '<div class="card-info"><b>Amount</b></br>'.money_format("$%i",$row['changeInBalance']).'</div>';
                        echo '<br>';
                        echo "</div>";
                        for($i = 1; $i < $numOfTransactions; $i++){
                            $row = $results->fetch_assoc();
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
                            echo '<br>';
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </body>
</html>
