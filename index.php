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
        
        if ($_POST["login"] == NULL){
            echo '
            
            <form action="authorization.php" class="authorization"><input class="login_button" type="submit" value="Вхід"></form>
        
            <form action="registration.php" class="registration">
            <input class="login_button" type="submit" value="Реєстрація"></form>
            ';
            
        }else{
            
            
            $name = ""; 
            
            $db = new SQLite3('data_base.db');

            $results1 = $db->query('SELECT * FROM Users WHERE Email="'.$_POST["login"] .'"');
            while ($row = $results1->fetchArray()) {
                $name = $row[1]. " ". $row[2];
            }
            
            
            
            echo '<p class="label1" align="right">'. $name .'</p>';
            echo '<p class="label2" align="right">'. $_POST["login"] .'</p>';
            
            echo '
            <form action="index.php" class="exit"><input class="login_button" type="submit" value="Вихід"></form>
            ';
            
            
        }
        
        
        ?>
    </header>
    
    
    
    
    
    
    <main>     
        
        
        <table>
            
            
            
            
            <h>Пошук:     </h>
            
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post">
            
            
            <input type="text" placeholder="Номер потяга" name="num" class="textbox" size="10">

            <input type="text" placeholder="Початкова станція" name="start" class="textbox" size="20">
            
            <input type="text" placeholder="Кінцева станція" name="end" class="textbox" size="20">
            
            
            <input type="hidden" name="login" value="<?php echo $_POST["login"];?>">
                
            
            
            <input type="submit" value="Знайти" id="find_button">

            </form>
            
            
            
            
            
            
            <?php
            
            $type = "";
            
            
            $user_db = new SQLite3('data_base.db');
            $results = $user_db->query('SELECT AccountType FROM Users WHERE Email="'.$_POST["login"] .'"');
            while ($row = $results->fetchArray()) {
                $type = $row[0];
            }
            
            
            
            if($type == "cashier"){

                echo '

                <br>
                <br>
                <form action="orderlist.php" method="post">

                <input type="submit" value="Список замовлень" id="order_list_button">
                <input type="hidden" name="login" value="'. $_POST["login"].'">

                </form>';
            }
            
            ?>
            
            
            
            
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
                
                $trainNumber = $_POST["trainNumber"];
                $startStation = $_POST["startStation"];
                $endStation = $_POST["endStation"];
                $intermediateStations = $_POST["intermediateStations"];
                $startDate = $_POST["startDate"];
                $endDate = $_POST["endDate"];
                $cost = $_POST["cost"];
                $remainingTickets = $_POST["remainingTickets"];
                
                
                if(!empty($trainNumber)){
                    
                    $db = new SQLite3('data_base.db');
                
                    $db->query('INSERT INTO Routes(TrainNumber, StartStation, EndStation, IntermediateStations, StartDate, EndDate, Cost, RemainingTickets) VALUES ("'. $trainNumber. '","'. $startStation. '","'. $endStation. '","'. $intermediateStations. '", "'. $startDate. '", "'. $endDate. '", "'. $cost. '", "'. $remainingTickets. '" );');

                
                    $_POST["trainNumber"] = "";
                    $_POST["startStation"] = "";
                    $_POST["endStation"] = "";
                    $_POST["intermediateStations"] = "";
                    $_POST["startDate"] = "";
                    $_POST["endDate"] = "";
                    $_POST["cost"] = "";
                    $_POST["remainingTickets"] = "";
                    
                    echo '
                    
                    <script>
                    document.mainForm.submit();
                    </script>
                    
                    ';
                    
                    
                }
                     
                
            }           
            ?>
            
            
            <tr>
            <th>Номер потяга</th>
            <th>Початкова станція</th>
            <th>Кінцева станція</th>
            <th>Проміжні станції</th>
            <th>Час відбуття</th>
            <th>Час прибуття</th>
            <th>Ціна</th>
            <th>Кількість квитків</th>
            
            <?php
                
                if($type == "admin"){
                    echo '
                    <td></td>
                    ';
                }
                
            ?>
            
            </tr>
            
            
            <?php
            
            
            
            if($type == "admin"){
                
                $trainNumber = "";
                $startStation = "";
                $endStation = "";
                $intermediateStations = "";
                $startDate = "";
                $endDate = "";
                $cost = "";
                $remainingTickets = "";
                
                
                echo '
                
                
                <form action="'. htmlentities($_SERVER["PHP_SELF"]).'" name="addForm" method="post">
                
                
                <td><input type="text" placeholder="Номер потяга" name="trainNumber" value="'. $trainNumber.'" class="add_text" required></td>

                <td><input type="text" placeholder="Початкова станція" name="startStation" value="'. $startStation.'" class="add_text" required></td>

                <td><input type="text" placeholder="Кінцева станція" name="endStation" value="'. $endStation.'" class="add_text" required></td>

                <td><input type="text" placeholder="Проміжні станції" name="intermediateStations" value="'. $intermediateStations.'" class="add_text"></td>

                <td><input type="text" placeholder="Час відбуття" name="startDate" value="'. $startDate.'" class="add_text" required></td>

                <td><input type="text" placeholder="Час прибуття" name="endDate" value="'. $endDate.'" class="add_text" required></td>

                <td><input type="text" placeholder="Ціна" name="cost" value="'. $cost.'" class="add_text" required></td>

                <td><input type="text" placeholder="Кількість квитків" name="remainingTickets" value="'. $remainingTickets.'" class="add_text" required></td>
                     
                     
                <input type="hidden" name="login" value="'. $_POST["login"].'">
                
                <td>
                <input type="submit" value="Додати" id="add_button">
                </td>
                </form>
            
            
                ';
                }
            
            
            ?>
            
            
            
            
            
            <?php
            
            
            
            if(!empty($_POST["del_route"])){
                
                $db = new SQLite3('data_base.db');
                
                $db->query('DELETE FROM Routes WHERE Id="'. $_POST["del_route"].'"');
                
            }
            
            

            
            
            function route_list($row){
                
                if(empty($_POST["login"])){

                    echo '<tr><td align="center"> ', $row[1], ' </td><td> ', $row[2], ' </td><td> ', $row[3], ' </td><td> ', $row[4], ' </td><td> ', $row[5], ' </td><td> ', $row[6], ' </td><td> ', $row[7], ' </td><td> ', $row[8], ' </td></tr>';

                }else{
                    

                    $user_db = new SQLite3('data_base.db');
                    $results = $user_db->query('SELECT AccountType FROM Users WHERE Email="'.$_POST["login"] .'"');
                    while ($r = $results->fetchArray()) {
                        $type = $r[0];
                    }
                    
                    if($type == "admin"){
                        
                        
                        
                        echo '<tr><td>

                        <form name="orderingPost" action="ordering.php" method="post">
                        <input type="hidden" name="login" value="'. $_POST["login"]. '">
                        <input type="hidden" name="route" value="'. $row[0]. '">
                        <input type="submit" value="'. $row[1].'" class="id_button">
                        </form>

                        </td><td> ', $row[2], ' </td><td> ', $row[3], ' </td><td> ', $row[4], ' </td><td> ', $row[5], ' </td><td> ', $row[6], ' </td><td> ', $row[7], ' </td><td> ', $row[8], ' </td><td>
                        
                        
                        
                        <form name="delPost" action="index.php" method="post">
                        <input type="hidden" name="login" value="'. $_POST["login"]. '">
                        <input type="hidden" name="del_route" value="'. $row[0]. '">
                        <input type="submit" value="Видалити" class="del_button">
                        </form>
                        
                        
                        </td></tr>';
                        
                        
                        
                    }else{
                        
                        echo '<tr><td>

                        <form name="orderingPost" action="ordering.php" method="post">
                        <input type="hidden" name="login" value="'. $_POST["login"]. '">
                        <input type="hidden" name="route" value="'. $row[0]. '">
                        <input type="submit" value="'. $row[1].'" class="id_button">
                        </form>

                        </td><td> ', $row[2], ' </td><td> ', $row[3], ' </td><td> ', $row[4], ' </td><td> ', $row[5], ' </td><td> ', $row[6], ' </td><td> ', $row[7], ' </td><td> ', $row[8], ' </td></tr>';
                        
                    }
                    
                    
                    

                }
                
                
            }    
            
            
            ?>
            
            
            
            
            
            
            
            
            
            
            
            <?php

            
            
            $db = new SQLite3('data_base.db');
			
			
			
			if(!empty($_POST["num"])){
				
				$routes = $db->query('SELECT * FROM Routes WHERE TrainNumber="'. $_POST["num"].'"');
				
                
                
                while ($row = $routes->fetchArray()) {
					
                    route_list($row);
					
				}
                
				
				
			}else{
			
				$routes = $db->query('SELECT * FROM Routes');
				
				if(empty($_POST["start"]) && empty($_POST["end"])){
					
					while ($row = $routes->fetchArray()) {
					
                        route_list($row);
                    }
				
				}else{
				
					if(!empty($_POST["start"]) && !empty($_POST["end"])){
						
						
						
						while ($row = $routes->fetchArray()) {
						
						
							if(		( $row[2]==$_POST["start"] || !empty(strpos($row[4], $_POST["start"])) ) && ( $row[3]==$_POST["end"] || !empty(strpos($row[4], $_POST["end"])) )	){
									
                                route_list($row);
						
				                }
						
						}
						
					}else{
                        
                        if(!empty($_POST["start"])){
                        
                            while ($row = $routes->fetchArray()) {


                                if(	$row[2]==$_POST["start"] || !empty(strpos($row[4], $_POST["start"]))	){

                                    route_list($row);

                                }

                            }
                        
                        }
                    
                    
                        if(!empty($_POST["end"])){
                        
                            while ($row = $routes->fetchArray()) {



                                if(		$row[3]==$_POST["end"] || !empty(strpos($row[4], $_POST["end"]))	){

                                    route_list($row);

                                }

                            }
                        
                        }              
                    
                    }
				
				
				
				
				
				
				}
			
			}
            
            
            
            ?>

            
        </table>
        
        
    </main>
    
    </div>
    
    
    
    
</body>
</html>