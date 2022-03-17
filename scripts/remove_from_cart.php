<?php
    //gets session info
    session_start();
    
    //assigns passed values to variables
    $id = $_GET['id'];
    $qty = $_POST['qty'];
    
        
    //checks if cart is empty. if so, redirects user to cart page
    if (empty($_SESSION['cart_id']) && empty($_SESSION['cart_qty'])) {
        $_SESSION['cart_rm_fail'] == 'empty';
        header('../cart.php');
        exit();
    }
        
        //checks if item is not in cart. if so, redirects user to cart page
    else if (!in_array($id, $_SESSION['cart_id'])) {
        $_SESSION['cart_rm_fail'] == 'notincart';
        header('../cart.php');
        exit();
    }
        
    //finds the index of chosen item and removes to the quantity
    else {
        $index = array_search($id, $_SESSION['cart_id']);
        $_SESSION['cart_qty'][$index] -= $qty;
            
        //checks if number of removed item has been reduced to 0
        if ($_SESSION['cart_qty'][$index] == 0) {
            //removes item id from id array and removes 0 value from quantity array
            array_splice($_SESSION['cart_qty'], $index, 1);
            array_splice($_SESSION['cart_id'], $index, 1);
        }
            
        //gives confirmation that items were added to the cart
        $_SESSION['removed'] = true;
        
        //redirects to cart
        header('Location: ../cart.php');
        exit();
    }
?>  