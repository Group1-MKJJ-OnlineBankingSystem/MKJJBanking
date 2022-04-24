<?php
    //gets db connection info
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    
    if ($_SESSION['uNameChanged'] == 'usernamechanged') {
        $notice2 = 'Username Successfully Changed!';
        
        $_SESSION['uNameChanged'] = '';
    }
    
    else if ($_SESSION['uNameChange_failed'] == 'invalid_input') {
        $notice2 = 'Invalid input';
        
        $_SESSION['uNameChange_failed'] = '';
    }
    
    else if ($_SESSION['uNameChange_failed'] == 'pwdnotmatch') {
        $notice2 = 'Incorrect password';
        
        $_SESSION['uNameChange_failed'] = '';
    }
    
    else if ($_SESSION['uNameChange_failed'] == 'sameasold') {
        $notice2 = 'Same as current username';
        
        $_SESSION['uNameChange_failed'] = '';
    }
    
    else if ($_SESSION['uNameChange_failed'] == 'usertaken') {
        $notice2 = 'That username is already taken.';
        
        $_SESSION['uNameChange_failed'] = '';
    }
    
    else if ($_SESSION['uNameChange_failed'] == 'updateERR') {
        $notice2 = 'There was an error updating the username, Try Again.';
        
        $_SESSION['uNameChange_failed'] = '';
    }
    
    
    if ($_SESSION['passwordChange_failed'] == 'pwdnotmatch') {
        $notice = 'Old Password is incorrect.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if ($_SESSION['passwordChange_failed'] == 'updateERR') {
        $notice = 'There was an error please try again.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if ($_SESSION['passwordChange_failed'] == 'pass_short') {
        $notice = 'The new password needs to be at least 6 characters.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if ($_SESSION['passwordChange_failed'] == 'newpwdnotmatch') {
        $notice = 'The new passwords did not match.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if ($_SESSION['passwordChange_failed'] == 'invalid_input') {
        $notice = 'Invalid input.';
        
        $_SESSION['passwordChange_failed'] = '';
    }
    
    else if ($_SESSION['passwordChange_success'] == 'pass_changed') {
        $notice = 'SUCCESS!';
        
        $_SESSION['passwordChange_success'] = '';
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
        if(time()-$_SESSION["login_time_stamp"] >600){
            session_unset();
            session_destroy();
            header("Location: login.php");
        }
    }

    //creates query to get user info from CUSTOMER view
    $query = "SELECT * FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";

    //gets info from db
    $results = $db->query($query);
    $row = $results->fetch_assoc();

    //creates variables from queried values
    $user = $row['cUsername'];
    $email = $row['cEmail'];
    $Fname = $row['cFname'];
    $Lname = $row['cLname'];
    $address = $row['cAddress'];
    $password = $row['cPassword'];
    $phone_num = $row['phoneNumber'];
    
    
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

    //closes connection and clears results
    $results->free();
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
    <link rel="icon" type="image/x-icon" href="../assets/icon_draft1.png">
</head>
    <body>
        <ul>
            <li><a class="active" href="./homepage.php">Home</a></li>
            <!-- <form action="search_apparel.php" method="post">
            <li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">
                <input name="searchterm" type="text" size="20">
                <input type="submit" name="submit" value="Search">
            </li>
            </form>
            -->
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
                .editusername{color: dodgerblue;}
                .editpass{color: dodgerblue;}
                .form-popup {
                    display: none;
                    position: fixed;
                    bottom: 10px;
                    right: 10px;
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
                /*div2{*/
                /*    padding: 200px 200px 200px 200px;*/
                /*    margin: 25px 50px 75px 100px;*/
                /*}*/
                
                .info{
                    text-align:center;
                }
            </style>
        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>MKJJ Online Banking System</h1>
            </div>
        </div>
            <nav class="heading">
                <h1><center>Account Details</center></h1>
            </nav>

    <hr> 
        <div>
            <center><p>Welcome back, <?php echo $Fname; ?>!</p></center>
        </div>

        <!--prompts user's information-->
        <div class="info">
            
            <div2><b><u>User Information:</u></div2></b>
            <div></div>
            <center>
                <div>
                    First Name: <?php echo $Fname; ?>
                </div>
                <div>
                    Last Name: <?php echo $Lname; ?>
                </div>
                <div>
                    Email Address: <?php echo $email; ?>
                </div>
                <div>
                    Primary Address: <?php echo $address; ?>
                </div>
                <div>
                    Phone Number: <?php echo $phone_num; ?>
                </div>
            </center>
            
            <div2><b><u>Security:</u></b></div2>
            <center>
                <center><div style='color: red;'><?php echo $notice2; ?></div></center>
                <div>
                    Username | <button class="editusername" onclick="openUsernameForm()">edit</button>
                </div>
                <div><?php echo $user; ?></div>
                <center><div style='color: red;'><?php echo $notice; ?></div></center>
                <div>
                    Password | <button class="editpass" onclick="openPasswordForm()">edit</button>
                </div>
                <div>*******</div>
            </center>
        </div>
        
        <div1 class="form-popup" id="passwordForm">
          <form action='./scripts/change_pass.php' method='post' class="form-container">
            <h1>Change Password</h1>
            
            <label for="oldPass"><b>Old Password</b></label>
            <input type="password" placeholder="Enter Old Password" name="oldpass" required>
        
            <p><label for="newPass"><b>New Password</b></label>
            <input type="password" placeholder="Enter New Password" name="newpass" onChange="onChange()" required></p>
            
            <p><label for="newPassConf"><b>Confirm New Password</b></label>
            <input type="password" placeholder="Reenter New Password" name="connewpass" onChange="onChange()" required></p>
        
            <button type="submit" class="btn">Update Password</button>
            <button type="button" class="btn cancel" onclick="closePasswordForm()">Cancel</button>
            
          </form>
        </div1>
        
        <script>
            function onChange() {
            const password = document.querySelector('input[name=newpass]');
            const confirm = document.querySelector('input[name=connewpass]');
            if (confirm.value === password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
            }
        }
        </script>
        
        <div1 class="form-popup" id="usernameForm">
          <form action='./scripts/change_user.php' method='post' class="form-container">
            <h1>Change Username</h1>
            
            <label for="oldPass"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pass" required>
        
            <p><label for="newPass"><b>New Username</b></label>
            <input type="text" placeholder="Enter New Username" name="newuser" required></p>
            
        
            <button type="submit" class="btn">Change Username</button>
            <button type="button" class="btn cancel" onclick="closeUsernameForm()">Cancel</button>
            
          </form>
        </div1>
        
        
        <script>
        function openPasswordForm() {
          document.getElementById("passwordForm").style.display = "block";
          document.getElementById("usernameForm").style.display = "none";
        }
        
        function closePasswordForm() {
          document.getElementById("passwordForm").style.display = "none";
        }
        
        function openUsernameForm() {
          document.getElementById("usernameForm").style.display = "block";
          document.getElementById("passwordForm").style.display = "none";
        }
        
        function closeUsernameForm() {
          document.getElementById("usernameForm").style.display = "none";
        }
        </script>

        
    </body>
</html>