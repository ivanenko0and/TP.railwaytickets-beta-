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

        $results1 = $db->query('SELECT * FROM Users WHERE Email="'.$_POST["login"] .'"');
        while ($row = $results1->fetchArray()) {

            $name = $row[1]. " ". $row[2];

        }



        echo '<p class="label1" align="right">'. $name .'</p>';
        echo '<p class="label2" align="right">'. $_POST["login"] .'</p>';

        echo '
        <form action="index.php" class="exit"><input class="login_button" type="submit" value="Вихід"></form>
        ';
        
        
        ?>
    </header>
    
    
    <div class="order_container">
        
        
        
        <?php
        
        
        $currentStage = '1';
        
        
        if(!preg_match("/[^0-9\.\-]+/", $_POST["ticketsNumber"])){
            

            
            if($_POST["paymentType"] == "gpay"){
                $currentStage = '2a';
            }else{

                if($_POST["paymentType"] == "card"){
                    $currentStage = '2b';
                }

            }
            
            
            if(!preg_match("/[^0-9\.\-]+/", $_POST["card_num"]) && !preg_match("/[^0-9\.\-]+/", $_POST["pin_code"])){
                
                if($_POST["order"] == "true"){
                    $currentStage = '3';
                }
                                 
            }
            
            if($_POST["download"] == "true"){
                $currentStage = '4';
            }
            
            
        }
        
        
        ?>
        

        
        
        
        <?php
        
        if($currentStage == '1' || $currentStage == '3' || $currentStage == '4'){
            
            echo '
            
            <form action="index.php" method="post">
            <input type="submit" value="Назад" id="return_button">
            <input type="hidden" name="login" value="'. $_POST["login"].'">
            </form>
            
            ';
            
        }else{
            
            if($currentStage == '2a' || $currentStage == '2b'){
                
                echo '
                
                <form action="ordering.php" method="post">
                <input type="submit" value="Назад" id="return_button">
                <input type="hidden" name="login" value="'. $_POST["login"].'">
                <input type="hidden" name="route" value="'. $_POST["route"]. '">
                </form>
                
                ';
                
            }   
            
        }
        
        
        ?>
        
        
        
        
        
        
        
        
        
        
        <?php
        
        $ticketsNumber = "";
        $paymentType = "";
        
        
        
        $ticketsNumberError = "";
        
        
        $cardNumError = "";
        $pinCodeError = "";
        
        
        ?>
        
        <p align=center>Оформлення квитків</p>
            
            
        <?php

            if($currentStage == '1'){
                
                
                
                if(preg_match("/[^0-9\.\-]+/", $_POST["ticketsNumber"])){
                    
                    $ticketsNumberError = "Введіть правильні дані!";
                }
                
                
                
                
                echo '

                <form action="'. htmlentities($_SERVER["PHP_SELF"]).'" name="registerForm" method="post">



                <p>Кількість квитків:</p>
                <input type="text" id="input_text2" name="ticketsNumber" value="'. $ticketsNumber.'" required>
                
                <p class="error_text">'. $ticketsNumberError.' </p>
                
                
                <p>Спосіб оплати:</p>

                <p> <input type="radio" name="paymentType" value="card"  required>VISA/Mastercard
                <input type="radio" name="paymentType" value="gpay"  required>GooglePay </p>


                <input type="hidden" name="login" value="'.$_POST["login"].'">
                <input type="hidden" name="route" value="'.$_POST["route"].'">


                <input type="submit" id="order_button" value="Далі">


                </form>
                ';
                
                
            }
            
        
        
        ?>
            
            

        
        <?php
        
        
        if($currentStage == '2a' || $currentStage == '2b'){
            
            
            
            echo '
            
            <form action="ordering.php" method="post">
            
            ';
            
            
            if($currentStage == '2a'){

                
                echo'

                <p>Пароль:</p>
                <input type="password" id="input_text2" required>

                ';
                
                

            }else{
                if($currentStage == '2b'){

                    if(preg_match("/[^0-9\.\-]+/", $_POST["card_num"])){
                        $cardNumError = "Введіть правильні дані!";
                    }
                    if(preg_match("/[^0-9\.\-]+/", $_POST["pin_code"])){
                        $pinCodeError = "Введіть правильні дані!";
                    }  


                    echo'

                    <p>Номер картки:</p>
                    <input type="text" id="input_text2" name="card_num" required>
                    <p class="error_text">'. $cardNumError.' </p>


                    <p>Пін код:</p>
                    <input type="password" id="input_text2" name="pin_code" required>
                    <p class="error_text">'. $pinCodeError.' </p>

                    ';
                    

                }
            }
            
            
            
            echo '
            
            
            <input type="hidden" name="login" value="'.$_POST["login"].'">
            <input type="hidden" name="route" value="'. $_POST["route"].'">
            <input type="hidden" name="ticketsNumber" value="'. $_POST["ticketsNumber"].'">
            <input type="hidden" name="paymentType" value="'. $_POST["paymentType"].'">
            
            <input type="hidden" name="order" value="true">
            
            <input id="order_button" type="submit" value="Замовити">
            </form>
            
            ';
            
            
            
            
            
        }
        

        
        
        
        if($currentStage == '3'){
            
            $db = new SQLite3('data_base.db');

            $results = $db->query('SELECT Id FROM Users WHERE Email="'. $_POST["login"]. '"');
            while ($row = $results->fetchArray()) {
                $id = $row[0];
            }
            $results = $db->query('SELECT Cost FROM Routes WHERE Id="'. $_POST["route"]. '"');
            while ($row = $results->fetchArray()) {
                $cost = $row[0];
            }

            $db->query('INSERT INTO Orders(UserId, RouteId, TicketsNumber, PaymentType, OrderTime, Price) VALUES ("'. $id. '","'. $_POST["route"]. '","'. $_POST["ticketsNumber"]. '","'. $_POST["paymentType"]. '", "'. date('Y-m-d H:m:s') . '", "'. $_POST["ticketsNumber"]*$cost. '" );');

            echo '<div align="center" id="complete_text">Замовлення оформлено!</div>';
            
            
            
            
            echo '
            
            <form action="ordering.php" method="post">
            <input type="hidden" name="login" value="'.$_POST["login"].'">
            <input type="hidden" name="route" value="'. $_POST["route"].'">
            <input type="hidden" name="ticketsNumber" value="'. $_POST["ticketsNumber"].'">
            <input type="hidden" name="paymentType" value="'. $_POST["paymentType"].'">
            
            <input type="hidden" name="download" value="true">
            
            <input id="order_button" type="submit" value="Завантажити копію квитка">
            </form>
            
            ';
            
            
            
            $db = new SQLite3('data_base.db');

            $results = $db->query('SELECT Id FROM Orders');
            while ($row = $results->fetchArray()) {
                $num = $row[0];
            }
            $results = $db->query('SELECT * FROM Routes WHERE Id="'. $_POST["route"]. '"');
            while ($row = $results->fetchArray()) {
                
                $trainNumber = $row[1];
                
                $startStation = $row[2];
                
                $endStation = $row[3];
                    
                $startDate = $row[5];
                    
                $endDate = $row[6];
                
                
            }
            
            
            

            $new_ticket = fopen("tickets\\ticket№". $num.".txt", "w");

            $text = 'Бланк замовлення

Код: '.$num.'

Відправлення:				
'. $startStation.'
'. $startDate.'
        
Прибуття:
'. $endStation.'
'. $endDate.'

Потяг:
'. $trainNumber.'


Кількість місць:
'. $_POST["ticketsNumber"].'

Ціна:
'. $cost.'

Загальна вартість замовлення:
'. $_POST["ticketsNumber"]*$cost;
        
        
            fwrite($new_ticket, $text);

            fclose($new_ticket);
            
            

        }
        
        
        
        
        if($currentStage == '4'){
            
            
            
            $db = new SQLite3('data_base.db');

            $results = $db->query('SELECT Id FROM Orders');
            while ($row = $results->fetchArray()) {
                $num = $row[0];
            }
            
            
            
            $url='tickets\\ticket№'. $num.'.txt';
            $local='D:\\Download\\ticket№'. $num.'.txt';
            file_put_contents($local, file_get_contents($url));
            
            
            
            
            
            
            echo '<div align="center" id="complete_text">Замовлення оформлено!</div>';
            
            
            echo '
            
            <form action="ordering.php" method="post">
            <input type="hidden" name="login" value="'.$_POST["login"].'">
            <input type="hidden" name="route" value="'. $_POST["route"].'">
            <input type="hidden" name="ticketsNumber" value="'. $_POST["ticketsNumber"].'">
            <input type="hidden" name="paymentType" value="'. $_POST["paymentType"].'">
            
            <input type="hidden" name="download" value="true">
            
            <input id="order_button" type="submit" value="Завантажити копію квитка">
            </form>
            
            ';
            
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        ?>
        
        
        
        
    </div>
    
    </div>
    
    
    
</body>
</html>
