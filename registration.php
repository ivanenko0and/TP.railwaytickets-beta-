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
        
        $name = "";
        $surname = "";
        $email = "";
        $pass = "";
        
        ?>
        
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" name="registerForm" method="post">
           
            <p align=center>Реєстрація</p>
            <input type="text" class="input_text2" placeholder="Ім'я" name="name" value="<?php echo $name;?>" required>
            
            <input type="text" class="input_text2" placeholder="Прізвище" name="surname" value="<?php echo $surname;?>" required>
            
            <input type="text" class="input_text2" placeholder="Електронна пошта" name="email" value="<?php echo $email;?>" required>
            
            <input type="password" class="input_text2" placeholder="Пароль" name="pass" value="<?php echo $pass;?>" required>
            
            
            <input type="submit" class="input_text2" value="Зареєструватись">
            
        </form>
        
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $pass = $_POST["pass"];
            
              
            $db = new SQLite3('data_base.db');

            $results = $db->query('SELECT * FROM Users WHERE Email="'. $email. '" AND Pass="'. $pass. '"');

            $isExist = "";

            while ($row = $results->fetchArray()) {
                $isExist .= $row[0];
            }

            if(empty($isExist)){




                $db->query('INSERT INTO Users(Name, Surname, Email, Pass, AccountType) VALUES ("'. $name. '", "'. $surname. '", "'. $email. '", "'. $pass. '", "client" );');



                echo'
                <form name="authPost" id="authPost" action="index.php" method="post">
                <input type="hidden" name="login" value="'.$email .'">
                <script>
                    document.authPost.submit();
                </script>
                ';
            }
            
        }           
        ?>
        
        
        
        
    </div>
    
    </div>
    
    
    
</body>
</html>
