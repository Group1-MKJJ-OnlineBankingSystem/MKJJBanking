<?php
    //includes page with db connection
    require_once '../db_connect.php';

    //gets session info
    session_start();

    //gets total price from cart
    $total_price = $_POST['total_price'];
    
    //checks if cart is empty
    if (empty($total_price) || empty($_SESSION['cart_id']) || empty ($_SESSION['cart_id'])) {
        $_SESSION['ord_failed'] = 'empty';
        header('Location: ../cart.php');
        
        //closes db conection
	    $db->close();
        exit();
    }
    
    //generates a 7 digit random number for order id
    $ordid = mt_rand(1000000, 9999999);
    
    //gets orderids from previous orders
    $query = 'SELECT orderID FROM ORDER';
	$results = $db->query($query);
	
	//gets the number of results
	$num_results = $results->num_rows;
	
	//loops through all current customers
    for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        
        //compares current order ids with new id
        if ($ordid == $row['orderID'])
            //creates a new random id if there is a match
            $ordid = mt_rand(1000000, 9999999);
    }
    
    //converts order id into string
    $ordid = strval($ordid);
    
    //gets customer's id and address
    $query = "SELECT customerID, cAddress FROM CUSTOMER WHERE cUsername = '".$_SESSION['user']."'";
    $results = $db->query($query);
    
    //gets associative array of results
    $row = $results->fetch_assoc();
    
    //gets current date
    $curr_date = date('Y-m-d');
    
    //sets proper timezone
    date_default_timezone_set('America/New_York');
    
    //get current time
    $curr_time = date('H:i:s');
    
    //creates query for inserting into db
    $query = "INSERT INTO ORDER VALUES
    ('".$ordid."',
     '".$row['customerID']."',
     '".$total_price."', 
     '".$row['cAddress']."', 
     '".$curr_date."',
     '".$curr_time."', 
     'NULL')";
    
    //inserts into db
    $results = $db->query($query);
    
    //checks if insertion was sucessful. if insertion fails, redirects to cart
    if (empty($results)) {
        $_SESSION['ord_failed'] = 'failedinsert';
        header('Location: ../cart.php');
        
        //closes db connection
        $db->close();
        exit();
    }
    
    //creates string of product ids
    $item_ids = implode("', '", $_SESSION['cart_id']);
    
    //gets stock of products in order
    $query = "SELECT Pname, Pquant FROM APPAREL_INVENTORY WHERE inventoryID IN ('".$item_ids."')";
    $results = $db->query($query);
    
    //gets number of results
    $num_results = $results->num_rows;
    
    //gets number of each products sold
    $num_items = $_SESSION['cart_qty'];
    
    $prod_names = [];
    
    //gets number of products left in stock
    for ($i = 0; $i < $num_results; $i++) {
        $row = $results->fetch_assoc();
        $num_items[$i] = $row['Pquant'] - $num_items[$i];
        
        //stores names of products bought
        array_push($prod_names, $row['Pname']);
    }
    
    //creates query to create list of items in order
    $stmt = "INSERT INTO ORDER_CONTAIN VALUES (?, ?, ?, ?, ?)";
    $query = $db->prepare($stmt);
    $query->bind_param('sssdi', $ordid, $prodid, $item_name, $price, $qty);
    
    
    //iterates through each item to create list
    for ($i = 0; $i < $num_results; $i++) {
        //gets id, name, and qty bought for each item
        $prodid = $_SESSION['cart_id'][$i];
        $item_name = $prod_names[$i];
        $price = $_SESSION['cart_price'][$i];
        $qty = $_SESSION['cart_qty'][$i];
        
        
        //tries to insert each item into ORDER_CONTAIN. redirects to homepage if failed
        if (!$query->execute()) {
            $_SESSION['ordfailed'] = 'ordinfofail';
            header('Location: ../homepage.html');
            
            //closes db connection
            $results->free();
            $db->close();
        }
    }
    
    //creates query to update stock info
    $stmt = "UPDATE APPAREL_INVENTORY SET Pquant = ? WHERE inventoryID = ?";
    $query = $db->prepare($stmt);
    $query->bind_param('is', $new_stock, $item_bought);
    
    
    //iterates through each bought item to update stock
    for ($i = 0; $i < $num_results; $i++) {
        //gets id and new stock for each item
        $item_bought = $_SESSION['cart_id'][$i]; 
        $new_stock = $num_items[$i];
        
        //updates stock. redirects to homepage if failed
        if (!$query->execute()) {
            $_SESSION['ordfailed'] = 'stockupdatefail';
            header('Location: ../homepage.html');
            
            //closes db connection
            $results->free();
            $db->close();
        }
    }
    
    //empties cart
    $_SESSION['cart_id'] = [];
    $_SESSION['cart_qty'] = [];
    $_SESSION['cart_price'] = [];
        
    //redirects to homepage
    $_SESSION['ord_saved'] = true;
    header('Location: ../homepage.html');
        
    //closes db connection
    $db->close();
    exit();
?>