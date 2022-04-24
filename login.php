<?php
    //gets session info
    session_start();

    //informs user if input was not put in correctly
    if ($_SESSION['login_failed'] == 'bad_input') {
        $notice = 'ERROR: Log in info was not properly input. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if username does not exist
    else if ($_SESSION['login_failed'] == 'userdne') {
        $notice = 'ERROR: Username does not exist. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    else if ($_SESSION['regdone'] == true) {
        $notice2 = 'Account successfully created, please sign in.';
        $_SESSION['regdone'] = false;
    }
    //informs user if password is incorrect
    else if ($_SESSION['login_failed'] == 'wrong_password') {
        $notice = 'ERROR: Incorrect password. Please try again.';
        $_SESSION['login_failed'] = '';
    }
    
    //informs user if they tried to add items to cart prior to logging in
    else if ($_SESSION['needlog'] == true ) {
        $notice = 'ERROR: You are not logged in. Please log in and try again.';
        $_SESSION['needlog'] = false;
    }
    // // variables: user 
    // $username = $_POST["username"];
    
    // if(isset($_POST["Login"])){
    //     $_SESSION["user"] = $username;
        
    //     $_SESSION["login_time_stamp"] = time();
    //     header("Location:homepage.php");
    // }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="login.css">
        <title>MKJJ</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico">

    </head>
    
    <!--login.php takes username and password input from a user that already made an account-->
    <body>
        <style>
            body{
                font-size:22px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            a{
                text-decoration;
                color:grey;
            }
            a:hover{
                text-decoration;
                color: #953636;
                transition:1s;
            }
            button{
                dont-size:16px;
            }
            .phpcode{
                padding:12px;
                }
            #log-in {
  width: 30%;
  padding: 60px;
  margin: auto;
  text-align: center;
}

input {
  width: 100%;
  padding: 12px;
  margin: 10px 0px;
  box-sizing: border-box;
}

select {
  width: 100%;
  padding: 12px;
  margin: 10px 0px;
  box-sizing: border-box;
}

button[type="submit"] {
  background-color: black;
  border: none;
  color: white;
  padding: 12px 30px;
  text-decoration: none;
  margin: 12px 2px;
  cursor: pointer;
}

input[type="submit"] {
  background-color: black;
  border: none;
  color: white;
  padding: 12px 30px;
  text-decoration: none;
  margin: 12px 2px;
  cursor: pointer;
}

label {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 18px;
  font-weight: 100;

  line-height: 30px;
  padding-top: 10px;
}
        </style>
        <!--outputs notice for user-->
        <div style='color: red;'><?php echo $notice; ?></div>
            <div id="log-in">
            
            <!--passes inputs to login_confirm.php to scripts-->
            <form action='scripts/login_confirm.php' method='post'>
                <div class="log-in">
                    <h1><center>CUSTOMER LOGIN</center></h1>
                    <div style='color: red;'><?php echo $notice2; ?></div>
                    
                    <p><center>Please enter your username and password:</center></p>
                    <div>
                        <!--input for username-->
                        <input type="text" placeholder="Username" name='user' required autofocus/>
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
                    Don't have an account? <a class="link" href="register.php">Create one!</a> <br>
                    Are you an Admin? <a class="link" href="employee/emp_login.php">Admin Log In</a>
                </center>
            </div>
        </div>
    </body>
</html>