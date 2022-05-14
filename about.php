<?php
    //includes file with db connection
    require_once './db_connect.php';
    
    //gets session info
    session_start();
    
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
        <ul>
            <li><a class="active" href="./homepage.php">Home</a></li>
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
            </style>
        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>MKJJ Online Banking System</h1>
            </div>
        </div>
            <nav class="heading">
                <h1><center>About</center></h1>
            </nav>
    <hr> 
        <div>
          <center>
          <p>The MKJJ Banking system was designed and developed by 2 Montclair State University Students of the Computer Science Department.</p>
          <div>
		  <p>Kenneth Doerflein</p>
          <p>Mark Mauro</p>
          </div>
          
          <div>
          <p>Our mission is to provide you with the easiest and most mainstream way to manage your online banking.</p>
          <p>We strive for the satisfaction for all of our clients, in terms of ease of use, security, customer support, and much much more.</p>
        </div>
        </center>
        </div>
    </body>
</html>