<?php
require_once 'start.php';
if(isset($_SESSION['zalogowany'])){
    exit(header('Location: stronaglowna.php'));
}
?>
<?php

    //Sprawdzenie czy istnieje jakiś null w tablicy
    function is_array_empty($arr){
        if(is_array($arr)){     
            foreach($arr as $key => $value){
                if(empty($value) || $value == NULL || $value == ""){
                    return true;
                    break;
                }
            }
            return false;
        }
      }

// if(isset($_SESSION['zalogowany']))
// {
//     header('Location: index.php');
//     exit();
// }


if((!is_array_empty($_POST) && (count($_POST) != 0))){

    $correct_login = true;

    // Przypisanie wartości z POSTa i sprawdzenie sqlinjection, może coś innego niż htmlentities
    $login1 = $_POST['login'];
    $login2 = htmlentities($login1, ENT_QUOTES, "UTF-8");
    $password1 = $_POST['password'];
    $password2 = htmlentities($password1, ENT_QUOTES, "UTF-8");
    
    //Jeśli żadna wartość loginu i hasła się nie zmieniła
    if(($login1 == $login2) && ($password1 == $password2)){
        require_once "dbConfig.php";

        // if($try_login = @$db->query(sprintf("SELECT * FROM users WHERE login='%s' AND password='%s'",
        // mysqli_real_escape_string($db, $login),
        // mysqli_real_escape_string($db, $password1))));
        if($try_login = $db->prepare("SELECT * FROM users WHERE login = ? AND password = ?")){
            $try_login->bind_param('ss', $login1, $password1);
            $try_login->execute();
            $result = $try_login->get_result();
            // $_SESSION['test'] = $result;
            $users_count = $result->num_rows;
            if($users_count > 0){
                while($row = $result->fetch_assoc()){
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_surname'] = $row['surname'];
                }
                
                // $_SESSION['test'] = "zalogowano";   
                $_SESSION['zalogowany'] = true;
                header('Location: stronaglowna.php');
            }
            else{
                $_SESSION['e_login_info'] = '<span style="color:red;">Błędne dane logowania</span>';
            }         
        }
    }  
}
elseif(count($_POST) == 2){
    $_SESSION['e_login_info'] = '<span style="color:red;">Wypełnij wszystkie pola</span>';

}

?>

<html>

<body>
    <?php
    require_once 'header.php';
    ?>

    <div class="wrapper fadeInDown">
        <div id="formContent">

            <form method="POST" action="login.php">
                <h1>
                    <?php
                    // mysqli_info($_SESSION['test']);
                        // var_dump($_SESSION['test']);
                        // unset($_SESSION['test']);
                    if(isset($_SESSION['zalogowany'])){
                        // var_dump($try_login);
                        // echo 123;  
                        // echo $_SESSION['user_name'];
                        // echo $_SESSION['user_surname']; 
                        
                    }
                    // var_dump($_SESSION['zalogowany']);
                    // //Jeśli zakończono pozytywnie rejestracje
                    // if(isset($_SESSION['correct_register'])){
                    //     echo 'Zarejestrowano!';
                    //     unset($_SESSION['correct_register']);
                    // }
                    if(isset($_SESSION['e_login_info'])){
                        echo $_SESSION['e_login_info'];
                        unset($_SESSION['e_login_info']);
                    }
                    ?>
                </h1>

                <!-- Pole login -->
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" class="form-control" placeholder="Podaj login">
                </div>

                <!-- Pole hasło -->
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password1" name="password" class="form-control"
                        placeholder="Podaj hasło">

                </div>

                <button type="submit" id="send" class="btn btn-primary">Zaloguj się</button>
            </form>

        </div>
</body>

</html>