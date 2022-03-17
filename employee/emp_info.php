<?php
    //includes db connection
    require_once '../db_connect.php';
    
    //includes session info
    session_start();
    
    //informs user if employee was successfully deleted
    if ($_SESSION['emp_del'] == 'done') {
        $notice = "<p style='color: green;'>Employee successfully deleted!</p>";
        
        $_SESSION['emp_del'] = '';
    }
    
    //informs user if employee deletion failed
    else if ($_SESSION['emp_del'] == 'failed') {
        $notice = "<p style='color: red;'>ERROR: Could not delete employee. Please try again.";
        
        $_SESSION['emp_del'] = '';
    }
    
    else if ($_SESSION['add_done'] == true) {
        $notice = "<p style='color: green;'>New employee added!</p>";
        
        $_SESSION['add_done'] == false;
    }
    
    //gets employee info
    $query = "SELECT * FROM EMPLOYEE";
    $results = $db->query($query);
    
    //gets number of results
    $num_results = $results->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../product.css">
    <title>citycentral.com</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>
    <body>
        <style>
            body {
                text-align: center;
                font-size:20px;
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
            table {
                position: relative;
                margin-left: auto;
                margin-right: auto;
                border-collapse: collapse;
            }
            
            th, td {
                border-bottom: 1px solid #ddd;
            }
        </style>
        <div id="log-in">
            <div class="log-in">
                <h1><center>EMPLOYEE INFOMATION</center></h1>
            </div>
        <!--outputs header of all employee info-->
        <?php echo $notice; ?>
        <table>
            <tr>
                <th>
                    Employee ID
                </th>
                <th>
                    Username
                </th>
                <th>
                    First Name
                </th>
                <th>
                    Last Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Address
                </th>
                <th>
                    Remove
                </th>
            </tr>
            <?php
        for ($i = 0; $i < $num_results; $i++) {
            //outputs info for each employee as rows
            //allows user to click button to delete employee
            //form redirects to delete_employee.php for processing
            //sends employee id by post
            $row = $results->fetch_assoc();
            
            echo "<form action='scripts/emp_delete.php' method='post'> 
                <tr>
                    <td>
                        ".$row['employeeID']."
                    </td>
                    <td>
                        ".$row['eUsername']."
                    <td>
                        ".$row['eFname']."
                    </td>
                    <td>
                        ".$row['eLname']."
                    </td>
                    <td>
                        ".$row['eEmail']."
                    </td>
                    <td>
                        ".$row['eAddress']."
                    </td>
                    <td>
                        <input type='hidden' name='empid' value='".$row['employeeID']."'>
                        <input type='submit' value='Remove'>
                    </td>
                </tr>
            </form>";
        }
        ?>
        </table>
        <br>
        <!--redirects user to add_employee.php or admin_home.php-->
        <p>
            Add a new member? <a href='emp_register.php'>Click here</a>
            <br>
        </p>
    </body>
</html>
<?php
    //closes db connection
    $results->free();
    $db->close();
?>