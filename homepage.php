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
    else if ($_SESSION['passwordInput_failed'] == 'pwdnotmatch'){
        $notice = 'Invalid password!';
        $_SESSION['passwordInput_failed'] = '';
    }
    else if ($_SESSION['acctDeletionDone'] == 'done'){
        $notice = 'Account closing request submitted';
        $_SESSION['acctDeletionDone'] = '';
    }
    
    
    //checks if user has logged in. if not, redirects to login page
    if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin']) === false) {
        $_SESSION['needlog'] = true;
        header('Location: login.php');

        //closes db connection
        $db->close();
        exit();
    }
    
    if(isset($_SESSION["loggedin"])){
        if(time()-$_SESSION["login_time_stamp"] > 600){
            session_unset();
            session_destroy();
            header("Location: login.php");
        }
    }
    
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
    
    $query = "SELECT * FROM `ACCOUNTS`as a, `CUSTOMER` as c WHERE c.customerID = a.ownerID AND c.cUsername = '".$_SESSION['user']."' ORDER BY status ASC";
    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $num_results = $result->num_rows;
                    
                    
                    
    $query2 = "SELECT * FROM `ACCOUNTS`as a, `CUSTOMER` as c WHERE c.customerID = a.ownerID AND c.cUsername = '".$_SESSION['user']."' AND status = 'approved'";
    //gets info from db
    $result2s = $db->query($query2);
    $numOfApprovedAccounts = mysqli_num_rows($result2s);
    
    //creates variables from queried values
    $user = $row['cUsername'];
    $bankno = $row['bankAccountNumber'];
    $accountType = $row['accountType'];
    $balance = $row['balance'];
    $numOfAccounts = mysqli_num_rows($results);
    $pending = $row['status'];
    
    function maskAccountNumber($number){
    
        $mask_number =  str_repeat("*", strlen($number)-4) . substr($number, -4);
        
        return $mask_number;
    }
    
    $query3 = "SELECT * FROM `ACCOUNTS`as a, `CUSTOMER` as c WHERE c.customerID = a.ownerID AND c.cUsername = '".$_SESSION['user']."' AND status = 'pending approval'";
    //gets info from db
    $result3s = $db->query($query3);
    $numOfpendingAccounts = mysqli_num_rows($result3s);
    
    
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
            <!--<li><a class="active admin_home" href="./employee/homepage_admin.php">Admin Home</a></li>-->
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
        <!--<div class="hero-wrapper">-->
        <!--    <div class="hero-wrapper-squared">-->
        <!--        <h1>MKJJ Online Banking System</h1>-->
        <!--    </div>-->
        <!--</div>-->
            <nav class="heading">
                <h1><center>Hello,<?php echo " ".$_SESSION['user']; ?> </center></h1>
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
            </nav>
     <hr> 
        <div class="section-wrapper">
            <h2>Account Management</h2>
            <?php
            echo '<button style="background-color: green" class="mkjj-button" onclick="openBankAccountForm()"><b>Create New Bank Account</b></button>';
            if ($numOfAccounts > 0 && $numOfApprovedAccounts > 0){
                echo '<button style = "background-color: red" class="mkjj-button" onclick="opencloseBankAccountForm()"><b>Close Bank Account</b></button>';
                echo '<hr style="border:none;">';
                echo '<button class="mkjj-button" onclick="openDepositForm()">Deposit</button>';
                echo '<button class="mkjj-button" onclick="openWithdrawalForm()">Withdrawal</button>';
                echo '<button class="mkjj-button" onclick="openTransferForm()">Transfer</button>';
                echo '<button class="mkjj-button" onclick="openHistoryForm()">History</button>';
            }
            ?>
        </div>

    <hr> 
        <div class="section-wrapper">
            <h2>Bank Accounts</h2>
            <div>
                <?php
                    if($numOfApprovedAccounts == 0 && $numOfpendingAccounts == 0){
                        echo "No open accounts";
                    } else {
                        for($i = 0; $i < $numOfAccounts; $i++){
                            if($row[status] == "approved"){
                                echo "<div class=\"account-card\">";
                                echo '<div class="card-info"><b>Account Number</b></br>'.maskAccountNumber($row['bankAccountNumber']).'</div>';
                                $acctsList[] = $row['bankAccountNumber'];
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Account Type</b></br>'.$row['accountType'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Balance</b></br>'.money_format("$%i",$row['balance']). '</div>';
                                echo '<br>';
                                echo "</div>";
                            }else if($row[status] == "pending approval"){
                                echo "<div class=\"account-card\">";
                                echo '<div class="card-info"><b>Account Number</b></br>'.maskAccountNumber($row['bankAccountNumber']).'</div>';
                                // echo '<div class="vl"></div>';
                                // echo '<div class="card-info"><b>Account Type</b></br>'.$row['accountType'].'</div>';
                                // echo '<div class="vl"></div>';
                                // echo '<div class="card-info"><b>Balance</b></br>$'.$row['balance'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Status</b></br>Pending Approval</div>';
                                echo '<br>';
                                echo "</div>";
                            }else if($row[status] == "pending deletion"){
                                echo "<div class=\"account-card\">";
                                echo '<div class="card-info"><b>Account Number</b></br>'.maskAccountNumber($row['bankAccountNumber']).'</div>';
                                // echo '<div class="vl"></div>';
                                // echo '<div class="card-info"><b>Account Type</b></br>'.$row['accountType'].'</div>';
                                // echo '<div class="vl"></div>';
                                // echo '<div class="card-info"><b>Balance</b></br>$'.$row['balance'].'</div>';
                                echo '<div class="vl"></div>';
                                echo '<div class="card-info"><b>Status</b></br>Pending Deletion</div>';
                                echo '<br>';
                                echo "</div>";
                            }
                            $row = $results->fetch_assoc();
                        }
                    }
                ?>
            </div>
        </div>
    
    
    <!--FORMS ---------------------------------------------------------------------------------------------------------------------------------------------------------->
    
        <div1 class="form-popup" id="bankAccountForm">
            
          <form action='./scripts/create_bank_account.php' method='post' class="form-container">
            <h1>Create Bank Account</h1>
            
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
                    for($k=0; $k < sizeof($acctsList); $k++){
                    echo '<option value="'.$acctsList[$k].'">'.maskAccountNumber($acctsList[$k]).'</option>';
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
                    for($k=0; $k < sizeof($acctsList); $k++){
                    echo '<option value="'.$acctsList[$k].'">'.maskAccountNumber($acctsList[$k]).'</option>';
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
                    for($k=0; $k < sizeof($acctsList); $k++){
                    echo '<option value="'.$acctsList[$k].'">'.maskAccountNumber($acctsList[$k]).'</option>';
                    }
                ?>
            </select>
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
        </div4>
        
        <div5 class="form-popup" id="historyForm">
            <form action='./history.php' method='post' class="form-container">
            <h1>History</h1>
            <p><label for="account_num"><b>Account Number: </b></label>
            <select name="account_num" id="bankAcctNum">
                <?php
                    for($k=0; $k < sizeof($acctsList); $k++){
                    echo '<option value="'.$acctsList[$k].'">'.maskAccountNumber($acctsList[$k]).'</option>';
                    }
                ?>
            </select>
            </p>
            <button type="submit" class="btn">View History</button>
            <button type="button" class="btn cancel" onclick="closeHistoryForm()">Cancel</button>
            
          </form>
        </div5>
        
        <div6 class="form-popup" id="closeBankAccountForm">
            <form action='./scripts/close_bank_account.php' method='post' class="form-container">
            <h1>Close Bank Account</h1>
            <p>
                <label for="bankAccountNum"><b>Bank Account Number:</b></label>
            <select name="account_num" id="bankAcctNum">
                <?php
                    for($k=0; $k < sizeof($acctsList); $k++){
                    echo '<option value="'.$acctsList[$k].'">'.maskAccountNumber($acctsList[$k]).'</option>';
                    }
                ?>
            </select>
            </p>
            <!--<p><label for="Pass"><b>Password:</b></label>-->
            <!--<input type="password" placeholder="Enter Password" name="pass" onChange="onChange()" required></p>-->
            
            <!--<p><label for="PassConf"><b>Confirm Password:</b></label>-->
            <!--<input type="password" placeholder="Reenter Password" name="conpass" onChange="onChange()" required></p>-->
            <style>
                #bankAcctNum{
                    margin-bottom: 5px;
                }
            </style>
            <script>
                function onChange() {
                    const password = document.querySelector('input[name=pass]');
                    const confirm = document.querySelector('input[name=conpass]');
                    if (confirm.value === password.value) {
                        confirm.setCustomValidity('');
                    } else {
                        confirm.setCustomValidity('Passwords do not match');
                    }
                }
            </script>
            <button type="submit" class="btn">Close Bank Account</button>
            <button type="button" class="btn cancel" onclick="closecloseBankAccountForm()">Cancel</button>
          </form>
        </div6>
        
         <script>
            function openBankAccountForm() {
              document.getElementById("bankAccountForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
              document.getElementById("historyForm").style.display = "none";
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
            
            function closeBankAccountForm() {
              document.getElementById("bankAccountForm").style.display = "none";
            }
            function openDepositForm() {
              document.getElementById("depositForm").style.display = "block";
              document.getElementById("bankAccountForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
              document.getElementById("historyForm").style.display = "none";
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
            
            function closeDepositForm() {
              document.getElementById("depositForm").style.display = "none";
            }
            function openWithdrawalForm() {
              document.getElementById("withdrawalForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
              document.getElementById("historyForm").style.display = "none";
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
            
            function closeWithdrawalForm() {
              document.getElementById("withdrawalForm").style.display = "none";
            }
            function openTransferForm(){
              document.getElementById("transferForm").style.display = "block";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("historyForm").style.display = "none";
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
            function closeTransferForm() {
              document.getElementById("transferForm").style.display = "none";
            }
            
            function openHistoryForm(){
              document.getElementById("historyForm").style.display = "block";
              document.getElementById("transferForm").style.display = "none";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none";
              document.getElementById("withdrawalForm").style.display = "none";
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
            function closeHistoryForm() {
              document.getElementById("historyForm").style.display = "none";
            }
            
            function opencloseBankAccountForm(){
              document.getElementById("closeBankAccountForm").style.display = "block";
              document.getElementById("historyForm").style.display = "none";
              document.getElementById("transferForm").style.display = "none";
              document.getElementById("depositForm").style.display = "none";
              document.getElementById("bankAccountForm").style.display = "none"
              document.getElementById("withdrawalForm").style.display = "none"
            }
            function closecloseBankAccountForm() {
              document.getElementById("closeBankAccountForm").style.display = "none";
            }
        </script>
    </body>
</html>








