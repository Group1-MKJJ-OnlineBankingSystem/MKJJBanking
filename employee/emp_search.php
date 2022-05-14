<?php
    require_once '../db_connect.php';
    
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>MKJJ</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>
    <body>
        <ul>
            <li><a class="active admin_home" href="./homepage_admin.php">Admin Home</a></li>
            <!--<li><a class="active" href="../homepage.php">Home</a></li>-->
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
                /*a{*/
                /*    text-decoration;*/
                /*    color:grey;*/
                /*}*/
                /*a:hover{*/
                /*    text-decoration;*/
                /*    color: #953636;*/
                /*    transition:1s;*/
                /*}*/
                button{
                    dont-size:16px;
                }
                .phpcode{
                    padding:12px;
                    }
            </style>
        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>MKJJ Online Banking System</h1>
            </div>
        </div>
        
        <div style="text-align: center;">
            <h3>
                Input Transcation ID: 
                <form action='./emp_search.php' method='post'>
                <input name="trans_num" type="text" size="20"> <input type="submit" name="submit" value="Search">
                </form>
            </h3>
        </div>
    <hr> 
    
    <div class = "results">
        <?php
        $searchterm = trim($_POST['trans_num']);
        
        
        if(!get_magic_quotes_gpc()){
            $searchterm = addslashes($searchterm);
        }
        
        
        $query = "SELECT * FROM TRANSACTIONS where transactionID = ".$searchterm;
        $result = $db->query($query);
        $num_results = $result->num_rows;
        
        if(empty($searchterm)){
            echo "<p style='text-align:center;'>No transaction ID entered yet."."</p>";
        }
        else if($num_results == 0){
            echo "<p style='text-align:center;'>No results found."."</p>";
        }
        
        // for($i=0; $i < $num_results; $i++) {
        //     $row = $result->fetch_assoc();
        //     if ( $i % 2 == 0) {
        //         echo '<div style="background-color: LightGray" class="history-card">';
        //     }
        //     else {
        //         echo '<div class="history-card">';
        //     }
            
            
        // }
        else{
        $row = $result->fetch_assoc();
        echo '<div class="history-card">';
        echo '<div class="card-info"><b>Date of Transaction</b></br>'.$row['dateOfTransaction'].'</div>';
        echo '<div class="vl"></div>';
        echo '<div class="card-info"><b>Transaction Type</b></br>'.$row['transactionType'].'</div>';
        echo '<div class="vl"></div>';   
        echo '<div class="card-info"><b>Bank Account Number</b></br>'.$row['bankAccountNumber'].'</div>';
        echo '<div class="vl"></div>';
        echo '<div class="card-info"><b>transactionID</b></br>'.$row['transactionID'].'</div>';
        echo '<div class="vl"></div>';
        echo '<div class="card-info"><b>Amount</b></br>'.money_format("$%i",$row['changeInBalance']).'</div>';
        echo "<br/> </div>";
        
        if($row['transactionType'] != "transfer sent" && $row['transactionType'] != "transfer received"){
        echo "<div><h2 style=\"text-align: center;\">Modify Transaction</h2></div>";
        echo '<form action="./scripts/transaction_edit.php" method="post">';
            echo '<div class="history-card">';
            echo '<div class="card-info"><b>Date of Transaction</b></br>'.$row['dateOfTransaction'].'</div>';
            echo '<div class="vl"></div>';
            echo '<div class="card-info"><b>Transaction Type</b></br>'.$row['transactionType'].'</div>';
            echo '<div class="vl"></div>';   
            echo '<div class="card-info"><b>Bank Account Number</b></br>'.$row['bankAccountNumber'].'</div>';
            echo '<div class="vl"></div>';
            
            echo '<div class="card-info" name="transactionID" ><b>transactionID</b></br>'.$row['transactionID'].'</div>';
            echo '<div class="vl"></div>';
            echo '<div class="card-info"><b>Amount</b></br>$'.'<input type="number" name="amount">'.'</input>';
            //echo '<input type="submit"></input>';
            echo '<button name="transactionID" value='.$row['transactionID'].'>Submit</button>';
            //echo '<div class="card-info"><b>Amount</b></br>$'.'<form action="./scripts/transaction_edit.php" method="post"><input type="number">'.'</input><input type="submit"></input></form>'.'</div>'.'</div>';
            echo "<br/> </div>";
        echo "</form>";
        }else{
         echo "<center>Sorry you cant modify transfers</center>";
        }
        }
        $result->free();
        $db->close();
        ?>
    </div>

    
    </body>
</html>