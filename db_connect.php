<?php
    //creates new database object
    @ $db = new mysqli('localhost', 'maurom3_mkjj_user', 'onlinebankingsystem', 'maurom3_mkjj');
    
    //checks connection to database
    if (mysqli_connect_errno()) {
        echo 'Error: could not connect to database. Please try again later.';
        exit();
    }
?>