<?php
    //get session info
    session_start();
    
    //clears all session variables
    session_unset();
    
    //destroys all session variables
    session_destroy();
    
    //redirects to index
    $_SESSION['logout'] = true;
    header('Location: ../index.php');
    exit();
?>