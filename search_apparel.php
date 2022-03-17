<?php
    require_once './db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="product.css">
    <title>citycentral.com</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
</head>
    <body>
        <ul>
            <li><a class="active" href="/~sarmieb1/citycentral/homepage.html">Home</a></li>
            <li><a class="active" href="about.html">About</a></li>
            <li style="float:right"><a class="active" href="/~sarmieb1/citycentral/process/logout.php">Log Out</a></li>
            <li style="float:right"><a class="active" href=#mycart>My Cart</a></li>
            <li style="float:right"><a class="active" href=#myaccount>My Account</a></li>
            <form action="search_apparel.php" method="post">
            <li style="float:right; display: relative; padding-top: 12px; padding-right: 10px;">
                <input name="searchterm" type="text" size="20">
                <input type="submit" name="submit" value="Search">
            </li>
            </form>
        </ul>
            <style>
                body{
                    font-size:24px;
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
        <div class="hero-wrapper">
            <div class="hero-wrapper-squared">
                <h1>CityCentral</h1>
            </div>
        </div>
            <nav class="product-filter" id="apparel">
                <h1><center>Results</center></h1>
            </nav>
    <hr> 
    
    <div class = "results">
        <?php
        $searchterm = trim($_POST['searchterm']);
        echo "<center>";
        
        if(!$searchterm){
          echo "You have not entered any search details, please go back and try again.";
          exit;
        }
        if(!get_magic_quotes_gpc()){
            $searchterm = addslashes($searchterm);
        }
        
        $query = "select * from APPAREL_INVENTORY where Pname like '%".$searchterm."%'";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        
        if($num_results == 0){
            echo "No results found.";
        }
        
        for($i=0; $i < $num_results; $i++){
            $row = $result->fetch_assoc();
            echo "<br/>";
            echo "Product: ".$row['Pname'];
            //insert image
            echo "<br/>";
            echo "link to product: <a href=\"".$row['Plink']."\"> <b>click here</b> </a>";
            echo "<br></br>";
        }
        $result->free();
        $db->close();
        echo "</center>";
        ?>
    </div>
    
    </body>
</html>