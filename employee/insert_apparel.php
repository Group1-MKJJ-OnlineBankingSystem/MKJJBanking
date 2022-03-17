<?php
  require_once '../db_connect.php';
?>

<html>
    <head>
    <title>CityCentral Entry Results</title>
    </head>
    <body>
    <h1>CityCentral Entry Results</h1>
<?php
    // create short variable names
    $invID=$_POST['apparel_id'];
    $name=$_POST['apparel_name'];    
    $desc=$_POST['apparel_desc'];
    $qty=$_POST['apparel_qty'];
    $type=$_POST['apparel_type'];
    $link=$_POST['apparel_link'];
    $price=$_POST['apparel_price'];
    
    if (!$invID || !$name || !$desc || !$qty || !$type || !$link || !$price) {
        echo "You have not entered all the required details.<br />"."Please go back and try again.";
        exit;
    }
    
    if (!get_magic_quotes_gpc()) {
        $invID = addslashes($invID);
        $name = addslashes($name);
        $desc = addslashes($desc);
        $qty = addslashes($qty);
        $type = addslashes($type);
        $link = addslashes($link);
        $price = addslashes($price);
    }
    
    $query = "insert into APPAREL_INVENTORY values 
    ('".$invID."',' ".$name."', '".$desc."', '".$qty."', '".$type."', '".$link."', '".$price."')";
    
    $result = $db->query($query);
        
    if ($result) {
    echo $db->affected_rows." apparel inserted into database.";
    } else {
    echo "An error has occurred. The item was not added.";
    }
    $db->close();
    ?>
    </body>
</html>