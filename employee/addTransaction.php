<?php
    //gets db connection info
    require_once '../db_connect.php';
    
    //gets session info
    session_start();

if ($_SESSION['depositSuccess'] == 'successful'){
        $notice = 'Deposit was Successful';
        $_SESSION['depositSuccess'] = '';
    } 
    else if ($_SESSION['withdrawalSuccess'] == 'successful'){
        $notice = 'Withdrawal was Successful';
        $_SESSION['withdrawalSuccess'] = '';
    } 
    else if ($_SESSION['transferSuccess'] == 'successful'){
        $notice = 'Transfer was Successful';
        $_SESSION['transferSuccess'] = '';
    } 
    else if ($_SESSION['transaction_failed'] == 'doesntOwnAcct'){
        $notice = 'That Account Does Not Exist';
        $_SESSION['transaction_failed'] = '';
    }
    else if ($_SESSION['transaction_failed'] == 'insufficentBalance'){
        $notice = 'Insufficent Balance';
        $_SESSION['transaction_failed'] = '';
    }
    
        //closes connection
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
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>
    <body>
        
        <style>
                .form-popup {
                    display: none;
                    position: fixed;
                    bottom: 25px;
                    right: 25px;
                    border: 5px solid #000000;
                    z-index: 9;
                    
                }
                .form-container {
                    max-width: 800px;
                    padding: 20px;
                    background-color: white;
                }
                .form-container .btn {
                     background-color: #04AA6D;
                     color: white;
                     padding: 16px 20px;
                     border: none;
                     cursor: pointer;
                     width: 100%;
                     margin-bottom:10px;
                     opacity: 0.8;
                }
                .form-container .cancel {
                    background-color: red;
                }
            </style>
        
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
            <center><div style='color: red;'><?php echo $notice; ?></div></center>
            <button class="mkjj-button" onclick="openDepositForm()">Deposit</button>
            <button class="mkjj-button" onclick="openWithdrawalForm()">Withdrawal</button>
            <button class="mkjj-button" onclick="openTransferForm()">Transfer</button>
        </center>
    
        <div class="form-popup" id="depositForm">
            <form action='./scripts/emp_deposit.php' method='post' class="form-container">
            <h1>Deposit</h1>
        
            <p><label for="deposit"><b>Deposit: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter deposit amount" name="deposit" required></p>
            <p><label for="account_num"><b>Account Number: </b></label>
            <input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="account_num" required></p>
            </p>
            <button type="submit" class="btn">Confirm Deposit</button>
            <button type="button" class="btn cancel" onclick="closeDepositForm()">Cancel</button>
            
          </form>
        </div>
        
        <div class="form-popup" id="withdrawalForm">
            <form action='./scripts/emp_withdrawal.php' method='post' class="form-container">
            <h1>Withdrawal</h1>
        
            <p><label for="withdrawal"><b>Withdrawal: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter withdrawal amount" name="withdrawal" required></p>
            <p><label for="account_num"><b>Account Number: </b></label>
            <input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="account_num" required></p>
            <button type="submit" class="btn">Confirm Withdrawal</button>
            <button type="button" class="btn cancel" onclick="closeWithdrawalForm()">Cancel</button>
            
          </form>
        </div>
        
        <div class="form-popup" id="transferForm">
            <form action='./scripts/emp_transfer.php' method='post' class="form-container">
            <h1>Transfer</h1>
        
            <p><label for="transfer"><b>Transfer: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter transfer amount" name="transfer" required></p>
            <p><label for="account_num"><b>Sender Account Number: </b></label>
            <input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="sender_account_num" required> </p>
            </p>
            <label for="acctType"><b>Transaction Type: </b></label>
            <select name="transferType" id="typeOfTransfer">
                <option value="internal">Internal</option>
                <option value="external">External</option>
                </select>
            <p><label for="receiver_num"><b>Receiver Account Number: </b></label>
            <input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="receiver_account_num" required> </p>
            <button type="submit" class="btn">Confirm Transfer</button>
            <button type="button" class="btn cancel" onclick="closeTransferForm()">Cancel</button>
            
          </form>
        </div>
    
    <script>
        function openDepositForm() {
          document.getElementById("depositForm").style.display = "block";
          document.getElementById("withdrawalForm").style.display = "none";
          document.getElementById("transferForm").style.display = "none";
        }
        function closeDepositForm() {
          document.getElementById("depositForm").style.display = "none";
        }
        function openWithdrawalForm() {
          document.getElementById("depositForm").style.display = "none";
          document.getElementById("withdrawalForm").style.display = "block";
          document.getElementById("transferForm").style.display = "none";
        }
        function closeWithdrawalForm() {
          document.getElementById("withdrawalForm").style.display = "none";
        }
        function openTransferForm() {
          document.getElementById("depositForm").style.display = "none";
          document.getElementById("withdrawalForm").style.display = "none";
          document.getElementById("transferForm").style.display = "block";
        }
        function closeTransferForm() {
          document.getElementById("transferForm").style.display = "none";
        }
    </script>    
    </body>
</html>