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

        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>Add a Transaction</h1>
            </div>
        </div>
        <br>
        <center>
            <button class="mkjj-button" onclick="openDepositForm()">Deposit</button>
            <button class="mkjj-button" onclick="openWithdrawalForm()">Withdrawal</button>
            <button class="mkjj-button" onclick="openTransferForm()">Transfer</button>
        </center>
        
    </body>
</html>