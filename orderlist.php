<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Залізничні квитки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    
    
    <div class="wrapper">
    
    <header>
       
       
        <form name="mainForm" id="mainForm" action="index.php" method="post">
        <input type="hidden" name="login" value="<?php echo $_POST["login"];?>">
        <input id="title" type="submit" value="railwaytickets.ua">
        </form>
       
        
       
        <?php
        
        
        $name = ""; 
            
        $db = new SQLite3('data_base.db');

        $results = $db->query('SELECT * FROM Users WHERE Email="'.$_POST["login"] .'"');
        while ($row = $results->fetchArray()) {

            $name = $row[1]. " ". $row[2];

        }



        echo '<p class="label1" align="right">'. $name .'</p>';
        echo '<p class="label2" align="right">'. $_POST["login"] .'</p>';

        echo '
        <form action="index.php" class="exit"><input class="login_button" type="submit" value="Вихід"></form>
        ';
        
        
        ?>
    </header>
    
    
    
    
    
    
    <main>     
        
        
        <form action="index.php" method="post">
        <input type="submit" value="Назад" id="return_button">
        <input type="hidden" name="login" value="<?php echo $_POST["login"];?>">
        </form>
        
        
        
        
        
        
        
        <table class="order_table">
            
            
            
            
            <tr>
            <th>Замовник</th>
            <th>Маршрут</th>
            <th>Кількість квитків</th>
            <th>Тип оплати</th>
            <th>Час замовлення</th>
            <th>Вартість</th>
            </tr>
            
            
            
            
            
            <?php
            
            
            $db = new SQLite3('data_base.db');
            
            
            $results = $db->query('SELECT * FROM Orders');
            while ($row = $results->fetchArray()) {

                
                $users = $db->query('SELECT * FROM Users WHERE Id="'. $row[1].'"');
                $routes = $db->query('SELECT * FROM Routes WHERE Id="'. $row[2].'"');
                
                $name = "";
                while ($users_row = $users->fetchArray()) {
                   $name = $users_row[1]. " ". $users_row[2];
                }
                $route_name = "";
                while ($routes_row = $routes->fetchArray()) {
                    $route_name = $routes_row[2]. "-". $routes_row[3];
                }
                
                
                echo '<tr><td> ', $name, ' </td><td> ', $route_name, ' </td><td> ', $row[3], ' </td><td> ', $row[4], ' </td><td> ', $row[5], ' </td><td> ', $row[6], ' </td></tr>';

            }
            
            
            
            
            
            

            ?>

            
        </table>
        
    </main>
    
    </div>
    
    
    
    
</body>
</html>