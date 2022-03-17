<?php 
    require_once '../db_connect.php';
?>

<html>
    <head>
        
    </head>
    
    <body>
        <h1>Delete Apparel</h1>
    
        <?php
    // create short variable names
    $delete=$_POST['delete_token'];
    
    if (!$delete) {
        echo "You have not entered all the required details.<br />"."Please go back and try again.";
        exit;
    }
    
    if (!get_magic_quotes_gpc()) {
        $delete = addslashes($delete);
    }
    
    $query = "delete from APPAREL_INVENTORY where inventoryID = ".$delete;
    
    $result = $db->query($query);
        
    if ($result) {
    echo $db->affected_rows." apparel deleted from database.";
    } else {
    echo "An error has occurred. The item was not deleted.";
    }
    $db->close();
    ?>
    </div>
        
    </body>
</html>