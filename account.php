<?php
    //gets db connection info
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
    <title>citycentral.com</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>
    <body>
        <ul>
            <li><a class="active" href="./homepage.html">Home</a></li>
            <form action="search_apparel.php" method="post">
            <li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">
                <input name="searchterm" type="text" size="20">
                <input type="submit" name="submit" value="Search">
            </li>
            </form>
            <li style="float:right"><a class="active" href="./scripts/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href="./account.php">My Account</a></li>
            <li style="float:right"><a class="active" href="./about.html">About</a></li>
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
                <h1>CityCentral</h1>
            </div>
        </div>
            <nav class="heading">
                <h1><center>My Account Profile</center></h1>
            </nav>

    <hr> 
        <div>
            <center><p>Welcome back, <?php echo $Fname; ?>!</p></center>
        </div>

        <!--prompts user's information-->
        <div>
            <center>
                <div>
                    Username: <?php echo $user; ?>
                </div>
                <div>
                    Email Address: <?php echo $email; ?>
                </div>
                <div>
                    First Name: <?php echo $Fname; ?>
                </div>
                <div>
                    Last Name: <?php echo $Lname; ?>
                </div>
                <div>
                    Primary Address: <?php echo $address; ?>
                </div>
            </center>
        </div>
    </body>
</html>