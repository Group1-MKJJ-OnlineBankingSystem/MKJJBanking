<?php
    //gets session info
    session_start();
    
    //informs user if input was not put in correctly
    if ($_SESSION['login_failed'] == 'bad_input') {
        $notice = 'ERROR: Log in info was not properly input. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if username does not exist
    else if ($_SESSION['login_failed'] == 'user_DNE') {
        $notice = 'ERROR: Username does not exist. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if password is incorrect
    else if ($_SESSION['login_failed'] == 'wrong_password') {
        $notice = 'ERROR: Incorrect password. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if they tried to add items to cart prior to logging in
    else if ($_SESSION['needlog'] == true) {
        $notice = 'ERROR: You are not logged in. Please log in and try again.';
        $_SESSION['needlog'] = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../login.css">
        <title>citycentral.com</title>
        <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    </head>
    
    <!--login.php takes username and password input from a user that already made an account-->
    <body>
        <style>
            body{
                font-size:24px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            a{
                text-decoration: underline;
                color:grey;
            }
            a:hover{
                text-decoration: underline;
                color: #953636;
                transition:1s;
            }
            button{
                dont-size:16px;
            }
            .phpcode{
                padding:12px;
                }
            </style>
        <!--outputs notice for user-->
        <div style='color: red;'><?php echo $notice; ?></div>
        
            <div id="log-in">
            
            <!--passes inputs to emp_confirm.php to process-->
            <form action='scripts/emp_login_confirm.php' method='post'>
                <div class="log-in">
                    <h1><center>EMPLOYEE LOGIN</center></h1>
                    <p><center>Please enter your employee username and password:</center></p>
                    <div>
                        <!--input for username-->
                        <input type="text" placeholder="Username" name='user' required />
                    </div>
                    <div>
                        <!--input for password-->
                        <input type="password" placeholder="Password" name='pass' required />
                    </div>
                        <!--submit inputs-->
                    <div>
                        <input type="submit" value="LOGIN" name="submit" id="button_submit" /> <input type="reset" value="CLEAR" />
                    </div>
                </div>
            </form>
            
            <!--other access links-->
            <div>
                <center>
                    A customer? <a class="link" href="../login.php">Log In</a>
                </center>
            </div>
        </div>
    </body>
</html>