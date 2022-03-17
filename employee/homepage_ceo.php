<html>
    <head>
        
    </head>
    
    <body>
        <style>
            body{
                    font-size:32px;
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
        </style>
        <div>
        <?php
            echo "Profits for today: $".rand(0,10000);
        ?>
        
        </br>
        <a href="../scripts/logout.php">Logout</a>
        </div>
    </body>
</html>