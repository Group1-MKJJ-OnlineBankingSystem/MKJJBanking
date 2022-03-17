<?php 
    require_once '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../product.css">
    <link rel="stylesheet" href="../login.css">
    <title>citycentral.com</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>
    <body>
            <style>
                body{
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
                button{
                    dont-size:16px;
                }
                .phpcode{
                    padding:12px;
                    }
            </style>
        <div id="log-in">
            
        <!--passes input to insert_apparel.php-->
        <form action="process_delete_apparel.php" method="post">
            <div class="log-in">
                <h1><center>EMPLOYEE DELETE APPAREL SYSTEM</center></h1>
                <h2><center>Enter the inventory ID to be deleted</center></h2>
                <div>
                    <!--input for inventoryID-->
                    <input name="delete_token" placeholder="Paste Inventory ID" type="text">
                </div>
                <div>
                    <!--submit inputs-->
                    <input type="submit" name="submit" value="Delete">
                </div>
        </form>
            </div>
        <h2>Browse inventory and their ID numbers</h2>
        <div>
        <?php
        
        
        $query = "select * from APPAREL_INVENTORY inventoryID";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        
        if($num_results == 0){
            echo "No results found.";
        }
        
        for($i=0; $i < $num_results; $i++){
            $row = $result->fetch_assoc();
            echo "<br/>";
            echo "Inventory ID: ".$row['inventoryID'];
            echo "<br/>";
            echo "Product: ".$row['Pname'];
            echo "<br/>";
            echo "Description: ".$row['Pdesc'];
            echo "<br/>";
            echo "Quantity: ".$row['Pquant'];
            echo "<br/>";
            echo "Price: $".$row['Pprice'];
            echo "<br></br>";
        }
        $result->free();
        $db->close();
        echo "</center>";
        ?>
        </div>
    </body>
</html>