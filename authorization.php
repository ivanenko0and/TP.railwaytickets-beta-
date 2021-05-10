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
        <input id="title" type="submit" value="railwaytickets.ua">
        </form>
    </header>
    
    
    <div class="container">
        
        <?php
        
        
        
        $login = "";
        $pass = "";
        $isAccountExist = "";
        
        
        $loginError = "";
        $passError = "";
        
        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST"){

            $login = $_POST["login"];
            $pass = $_POST["pass"];



            $db = new SQLite3('data_base.db');

            $results = $db->query('SELECT * FROM Users WHERE Email="'. $login. '" AND Pass="'. $pass. '"');

            
            if(($results->fetchArray()) == null){
                
                
                $results = $db->query('SELECT * FROM Users WHERE Email="'. $login. '"');
                if(($results->fetchArray()) == null){
                   $loginError = "Акаунту з таким логіном не існує";
                }else{
                   $passError = "Введіть правильний пароль";
                }
                        
            }else{
             
                $results = $db->query('SELECT * FROM Users WHERE Email="'. $login. '" AND Pass="'. $pass. '"');
                while ($row = $results->fetchArray()) {
                    
                    
                    echo'
                    <form name="authPost" id="authPost" action="index.php" method="post">
                    <input type="hidden" name="login" value="'.$login .'">
                    <script>
                        document.authPost.submit();
                    </script>
                   ';
                    
                }
                    
                
            }
            
            
            
            

        }           
        
        
        
        ?>
        
        
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" name="auth_form" method="post">
           
            <p align=center>Вхід</p>
            <input type="text" class="input_text" placeholder="Логін" name="login" value="<?php echo $login;?>" required>
            
            <p class="error_text"><?php echo $loginError;?></p>
            
            <input type="password" class="input_text" placeholder="Пароль" name="pass" value="<?php echo $pass;?>" required>
            
            <p class="error_text"><?php echo $passError;?></p>
            
            
            <input type="submit" class="input_text" value="Увійти">
            
        </form>
            
        <form action="registration.php">
            <input type="submit" class="input_text" value="Реєстрація">
        </form>
              
        
    </div>
    
    </div>
    
    
    
</body>
</html>
