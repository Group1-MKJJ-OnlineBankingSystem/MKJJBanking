<?php
    //gets session info
    session_start();
    
    //notifies user if not everything was input
    if ($_SESSION['registration_failed'] == 'invalid_input') {
        $notice = 'Registration info was not properly input. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if password is not long enough
    else if ($_SESSION['registration_failed'] == 'invalid_password') {
        $notice = 'Password must be at least 6 characters. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if passwords do not match
    else if ($_SESSION['registration_failed'] == 'pwdnotmatch') {
        $notice = 'Passwords do not match. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if username is already taken
    else if ($_SESSION['registration_failed'] == 'usertaken') {
        $notice = 'Username already taken. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    else if ($_SESSION['registration_failed'] == 'emailtaken') {
        $notice = 'Email already in use. Please try again.';
        
        $_SESSION['registration_failed'] = '';
    }
    
    //notifies user if some other error occurs
    else if ($_SESSION['registration_failed'] == 'randerr') {
        $notice = 'An error has occurred. Please try again.';
        
        $_SESSION['registration_failed'] = '';
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
    
    <!--register.php takes a new user's username, password, first name, middle name, last name, street address,
        city, state, and zip code-->
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
            </style>
        <!--outputs notice for user-->
        <div style='color: red;'><?php echo $notice; ?></div>
        
            <div id="log-in">
            
            <!--passes inputs to register_confirm.php to scripts-->
            <form action='scripts/emp_register_confirm.php' method='post'>
                <div class="log-in">
                    <h1><center>EMPLOYEE REGISTER</center></h1>
                    <p><center>Please fill in the information below:</center></p>
                    <div>
                        <!--input for username-->
                        <input type="text" placeholder="Username" name="user" required />
                    </div>
                    <div>
                        <!--input for password-->
                        <input type="password" placeholder="Password" name="pass" required />
                    </div>
                    <div>
                        <!--input for confirm password-->
                        <input type="password" placeholder="Confirm Password" name="conpass" required />
                    </div>
                    <div>
                        <!--input for email-->
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div>
                        <!--input for first name-->
                        <input type="text" placeholder="First Name" name="fname" rquired />
                    </div>
                    <!--<div>-->
                        <!--input for middle name-->
                        <!--<input type="text" placeholder="Middle Name" name="mname" />-->
                    <!--</div>-->
                    <div>
                        <!--input for last name-->
                        <input type="text" placeholder="Last Name" name="lname" required/>
                    </div>
                    <div>
                        <!--input for street address-->
                        <input type="text" placeholder="Street Address" name="stadd" required/>
                    </div>
                    <div>
                        <!--input for city-->
                        <input type="text" placeholder="City" name="city" required/>
                    </div>
                    <div>
                        <!--input for state-->
                        <input type="text" placeholder="State" name="state" required/>
                    </div>
                    <div>
                        <!--input for zip code-->
                        <input type="text" placeholder="Zip Code" name="zip" required/>
                    </div>
                        <!--submit inputs-->
                    <div>
                        <input type="submit" value="CREATE MY ACCOUNT" name="submit" id="button_submit" /> <input type="reset" value="CLEAR" />
                    </div>
                </div>
            </form>
            
            <!--other access links-->
            <div>
                <center>
                    Already have an employee account? <a class="link" href="../login.php">Log In</a> <br>
                </center>
            </div>
        </div>
    </body>
</html>