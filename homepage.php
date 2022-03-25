<?php
    //gets db connection info
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    
    if ($_SESSION['registration_failed'] == 'randerr') {
        $notice = 'An error has occurred. Please try again.';
            
        $_SESSION['registration_failed'] = '';
    }
    else if ($_SESSION['registration_failed'] == 'invalid_input') {
        $notice = 'Missing input. Please try again.';
            
        $_SESSION['registration_failed'] = '';
    }
    else if($_SESSION['acctCreationDone'] == 'done'){
        $notice = 'Account Successfully Created.';
            
        $_SESSION['acctCreationDone'] = '';
    }
    else if ($_SESSION['depositSuccess'] == 'successful'){
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
        $notice = 'That Account Does Not Belong to You or Does Not Exist';
        $_SESSION['transaction_failed'] = '';
    }
    else if ($_SESSION['transaction_failed'] == 'insufficentBalance'){
        $notice = 'Insufficent Balance';
        $_SESSION['transaction_failed'] = '';
    }
    
    $query = "SELECT * FROM `ACCOUNTS`as a, `CUSTOMER` as c WHERE c.customerID = a.ownerID AND c.cUsername = '".$_SESSION['user']."'";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $num_results = $result->num_rows;
                    
    //creates variables from queried values
    $user = $row['cUsername'];
    $bankno = $row['bankAccountNumber'];
    $accountType = $row['accountType'];
    $balance = $row['balance'];
    $numOfAccounts = $row['numOfAccounts'];
    
    //closes connection
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
            <form action="search_apparel.php" method="post">
            <li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">
                <input name="searchterm" type="text" size="20">
                <input type="submit" name="submit" value="Search">
            </li>
            </form>
            <li style="float:right"><a class="active" href="./scripts/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href="./account.php">Settings</a></li>
            <li style="float:right"><a class="active" href="./about.html">About</a></li>
            <li style="float:right"><a class="active" href="./services.php">Services</a></li>
        </ul>
            <style>
                body{
                    font-size:24px;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
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
        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>MKJJ Online Banking System</h1>
            </div>
        </div>
            <nav class="heading">
                <h1><center>Hello,<?php echo " ".$_SESSION['user']; ?> </center></h1>
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
            </nav>
    <hr> 
        <div class="section-wrapper">
            <h2>Bank Accounts</h2>
            <button class="mkjj-button" onclick="openBankAccountForm()">Create New Bank Account</button>
            <h3>My Bank accounts:</h3>
            <div>
                <div>
                    <?php
                        if($numOfAccounts == 0){
                            echo "No open accounts.";
                        } else {
                            echo "<div class=\"account-card\">";
                            echo 'Bank Account Number: '.$row['bankAccountNumber'].'<br>';
                            $acctsList[] = $row['bankAccountNumber'];
                            echo 'Account Type: '.$row['accountType'].'<br>';
                            echo 'Balance: $'.$row['balance'].'<br>';
                            echo '<br>';
                            echo "</div>";
                            for($i = 1; $i < $numOfAccounts; $i++){
                                $row = $results->fetch_assoc();
                                echo "<div class=\"account-card\">";
                                echo 'Bank Account Number: '.$row['bankAccountNumber'].'<br>';
                                $acctsList[] = $row['bankAccountNumber'];
                                echo 'Account Type: '.$row['accountType'].'<br>';
                                echo 'Balance: $'.$row['balance'].'<br>';
                                echo '<br>';
                                echo "</div>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    <hr> 
        <div class="section-wrapper">
            <h2>Deposits and Withdrawals</h2>
            <button class="mkjj-button" onclick="openDepositForm()">Deposit</button>
            <button class="mkjj-button" onclick="openWithdrawalForm()">Withdrawal</button>
            <button class="mkjj-button" onclick="openTransferForm()">Transfer</button>
        </div>
    <hr>
    
    <!--FORMS ---------------------------------------------------------------------------------------------------------------------------------------------------------->
    
        <div1 class="form-popup" id="bankAccountForm">
            
          <form action='./scripts/create_bank_account.php' method='post' class="form-container">
            <h1>Create Bank account</h1>
            
            <label for="acctType"><b>Account Type: </b></label>
            <select name="acct" id="accttype">
                <option value="savings">Savings</option>
                <option value="checking">Checking</option>
            </select>
            
            <p><label for="initalDeposit"><b>Inital Deposit: $</b></label>
            <input type="number" min="0.0" step="0.01" placeholder="Enter deposit amount" name="initDeposit" required></p>
        
            <button type="submit" class="btn">Create Account</button>
            <button type="button" class="btn cancel" onclick="closeBankAccountForm()">Cancel</button>
            
          </form>
        </div1>
        
        <div2 class="form-popup" id="depositForm">
            <form action='./scripts/deposit.php' method='post' class="form-container">
            <h1>Deposit</h1>
        
            <p><label for="deposit"><b>Deposit: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter deposit amount" name="deposit" required></p>
            <p><label for="account_num"><b>Account Number: </b></label>
            <!--<input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="account_num" required></p>-->
            <select name="account_num" id="bankAcctNum">
                <?php
                    for($k=0; $k < $numOfAccounts; $k++){
                    echo '<option value="'.$acctsList[$k].'">'.$acctsList[$k].'</option>';
                    }
                ?>
            </select>
            </p>
            <button type="submit" class="btn">Confirm Deposit</button>
            <button type="button" class="btn cancel" onclick="closeDepositForm()">Cancel</button>
            
          </form>
        </div2>
        
        <div3 class="form-popup" id="withdrawalForm">
            <form action='./scripts/withdrawal.php' method='post' class="form-container">
            <h1>Withdrawal</h1>
        
            <p><label for="withdrawal"><b>Withdrawal: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter withdrawal amount" name="withdrawal" required></p>
            <p><label for="account_num"><b>Account Number: </b></label>
            <!--<input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="account_num" required></p>-->
            <select name="account_num" id="bankAcctNum">
                <?php
                    for($k=0; $k < $numOfAccounts; $k++){
                    echo '<option value="'.$acctsList[$k].'">'.$acctsList[$k].'</option>';
                    }
                ?>
            </select>
            </p>
            <button type="submit" class="btn">Confirm Withdrawal</button>
            <button type="button" class="btn cancel" onclick="closeWithdrawalForm()">Cancel</button>
            
          </form>
        </div3>
        
        <div4 class="form-popup" id="transferForm">
            <form action='./scripts/transfer.php' method='post' class="form-container">
            <h1>Transfer</h1>
        
            <p><label for="transfer"><b>Transfer: $</b></label>
            <input type="number" min="0.01" step="0.01" placeholder="Enter transfer amount" name="transfer" required></p>
            <p><label for="account_num"><b>Your Account Number: </b></label>
            <!--<input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="sender_account_num" required> </p>-->
            <select name="sender_account_num" id="bankAcctNum">
                <?php
                    for($k=0; $k < $numOfAccounts; $k++){
                    echo '<option value="'.$acctsList[$k].'">'.$acctsList[$k].'</option>';
                    }
                ?>
            </select>
            </p>
            <p><label for="receiver_num"><b>Receiver Account Number: </b></label>
            <input type="acctNumber" pattern="4+[0-9]{11}" title="A valid account number starts with a 4 that is followed by 11 more digits. Ex: 412345678901" placeholder="Ex: 444444444444" name="receiver_account_num" required> </p>
            <button type="submit" class="btn">Confirm Transfer</button>
            <button type="button" class="btn cancel" onclick="closeTransferForm()">Cancel</button>
            
          </form>
        </div4>
        
         <script>
            function openBankAccountForm() {
              document.getElementById("bankAccountForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
            }
            
            function closeBankAccountForm() {
              document.getElementById("bankAccountForm").style.display = "none";
            }
            function openDepositForm() {
              document.getElementById("depositForm").style.display = "block";
              document.getElementById("bankAccountForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
            }
            
            function closeDepositForm() {
              document.getElementById("depositForm").style.display = "none";
            }
            function openWithdrawalForm() {
              document.getElementById("withdrawalForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none"
              document.getElementById("transferForm").style.display = "none";
            }
            
            function closeWithdrawalForm() {
              document.getElementById("withdrawalForm").style.display = "none";
            }
            function openTransferForm(){
              document.getElementById("transferForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none"
              document.getElementById("withdrawalForm").style.display = "none"
            }
            function closeTransferForm() {
              document.getElementById("transferForm").style.display = "none";
            }
        </script>
    </body>
</html>








