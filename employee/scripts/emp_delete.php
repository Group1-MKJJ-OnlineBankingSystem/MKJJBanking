<?php
    //includes db connection
    require_once '../../db_connect.php';
    
    //includes session info
    session_start();
    
    //assigns value passed to variable
    $empid = $_POST['empid'];
    
    //checks if user is trying to delete owner. if so, redirects to employee_info.php
    if ($empid == '00001') {
        $_SESSION['emp_del'] = 'owner';
        header('Location: ../emp_info.php');
        
        //closes db connection
        $db->close();
        exit();
    }
    
    //deletes entry of employee with passed id
    $query = "DELETE FROM EMPLOYEE WHERE employeeID = '".$empid."'";
    $results = $db->query($query);
    
    //checks if employee was successfully deleted and redirects to emp_info.php
    if ($results) {
        $_SESSION['emp_del'] = 'done';
        header('Location: ../emp_info.php');
    }

    else {
        $_SESSION['emp_del'] = 'failed';
        header('Location: ../emp_info.php');
    }
    
    //closes connection
    $db->close();
    exit();
?>