<?php
    //includes db connection
    require_once '../../db_connect.php';
    
    //includes session info
    session_start();
    
    //assigns value passed to variable
    $apparelid = $_POST['apparelID'];
    
    //checks if employee was successfully deleted and redirects to emp_info.php
    if ($results) {
        $_SESSION['apparel_del'] = 'done';
        header('Location: ../delete_apparel.php');
    }

    else {
        $_SESSION['emp_del'] = 'failed';
        header('Location: ../delete_apparel.php');
    }
    
    //closes connection
    $db->close();
    exit();
?>