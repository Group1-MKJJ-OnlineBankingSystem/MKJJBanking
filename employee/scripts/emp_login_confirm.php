<?php
    //includes file with db connection
    require_once '../../db_connect.php';
    
    //gets session info
    session_start();
    
    //checks if user is already logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('Location: ../homepage_admin.php');
        $_SESSION['relog'] = true;
        
        //closes db conection
	    $db->close();
        exit();
    }
    
    //takes input passed from form and assigns to variables
    $user = strtolower(trim($_POST['user']));
    $pass = trim($_POST['pass']);
    
    //informs user if not all inputs are entered and exits
    if (!$user || !$pass) {
        $_SESSION['login_failed'] = 'bad_input';
        header('Location: ../emp_login.php');
        
        //close db conection
	    $db->close();
        exit();
  }
  
  if ($user == "siteemployee" && $pass == "ccemployeepassword") {
        header('Location: ../homepage_siteemployee.php');
        //close db conection
	    $db->close();
        exit();
  }
  
  if ($user == "ceo" && $pass == "ccceopassword") {
        header('Location: ../homepage_ceo.php');
        //close db conection
	    $db->close();
        exit();
  }
    
    //queries db for username entered
    $query = "SELECT ePassword, eFname FROM EMPLOYEE WHERE eUsername = '".$user."'";
    $result = $db->query($query);
    
    
    //checks if results were returned
    if ($result->num_rows == 0) {
        $_SESSION['login_failed'] = 'user_DNE';
        header('Location: ../emp_login.php');
        
        //closes db conection
	    $db->close();
	    $result->free();
        exit();
    }
    
    //gets associative array from result
    $row = $result->fetch_assoc();
    
    //compares password hashed saved with password entered; logs in and redirects to homepage if passwords match
    if (password_verify($pass, $row['ePassword'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $user;
        $_SESSION['name'] = $row['eFname'];
        
        $_SESSION['newlog'] = true;
        header('Location: ../homepage_admin.php');
        
        //closes db connection
        $result->free();
        $db->close();
        exit();
    }
    
    //if password is wrong, returns to login page
    else {
        $_SESSION['login_failed'] = 'wrong_password';
        header('Location: ../emp_login.php');
        
        //closes db connection
        $result->free();
        $db->close();
        exit();
    }
?>