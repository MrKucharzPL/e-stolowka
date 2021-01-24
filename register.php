<!-- 
    Dodać sanitize do innych pól!!!! 

    ogarnąć funkcje dla isset i unset w html

    Jest błąd jeśli istnieje login lub email, jest to ok bo zrobione na indeksach
    Ale trzeba utworzyć jeszcze obsługę tego
-->
<?php
require_once 'start.php';

if(isset($_SESSION['zalogowany'])){
    exit(header('Location: stronaglowna.php'));
}
?>
<?php
    // $correct_register;
    //oznaczenie błędu rejestracji
    function set_false(){
        $correct_register = false;
    }
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
    //Jeśli znaleziono null lub tablica jest pusta nie przeprowadzać rejestracji
    if((!is_array_empty($_POST) && (count($_POST) != 0))){
        // $_SESSION['test'] = 'beng';
        // header('localhost/login.php');
        $correct_register = true;

        $login = $_POST['login'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];
        $email_val;
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        //login
        if((strlen($login)<4) || (strlen($login)>20)){
            set_false();
            $_SESSION['e_login'] = "Login musi zawierać od 3 do 20 znaków";
        }

        //hasło
        if((strlen($password1)<8) || (strlen($password1)>30)){
            set_false();
            $_SESSION['e_password'] = "Hasło musi zawierać od 3 do 30 znaków";
        }
        if((strlen($password2)<8) || (strlen($password2)>30)){
            set_false();
            $_SESSION['e_password'] = "Hasło musi zawierać od 3 do 30 znaków";
        }
        if($password1 != $password2){
            set_false();
            $_SESSION['e_repassword'] = "Hasła muszą być takie same";
        }

        //email
        $email_val = filter_var($email, FILTER_SANITIZE_EMAIL);
        if((filter_var($email_val, FILTER_VALIDATE_EMAIL) == false) || $email != $email_val){
            set_false();
            $_SESSION['e_email'] = "Błędny adres email";
        }

        //imię
        if((strlen($name)<2) || (strlen($name)>30)){
            set_false();
            $_SESSION['e_name'] = "Wprowadź poprawne imię";
        }

        //nazwisko
        if((strlen($surname)<2) || (strlen($surname)>30)){
            set_false();
            $_SESSION['e_nazwisko'] = "Wprowadź poprawne nazwisko";
        }

        //poprawna walidacja danych wejściowych
        if($correct_register == true){
            require_once "dbConfig.php";

            //Ustawienie trybu wyświetlania błędów
            mysqli_report(MYSQLI_REPORT_STRICT);
            try{
                if($db->connect_errno != 0){
                    throw new Exception(mysqli_connect_errno());
                }
                else{
                    //Dodawanie do bazy
                    if($db->query("INSERT INTO users VALUES(NULL, '$login', '$password1', '$email', '$name', '$surname')")){
                        $_SESSION['correct_register'] = true;
                    }
                    //Błąd może wystąpić w przypadku istniejącego maila bądź loginu lub inny nieznany
                    else{
                        throw new Exception($db->error);
                    }
                }
            }
            catch(Exception $exc){
                echo $exc;
            }
        }
    }
    elseif(count($_POST) == 6){
        $_SESSION['e_register_info'] = '<span style="color:red;">Wypełnij wszystkie pola</span>';
    }
?>
<html>

<body>
    <?php
    require_once 'header.php';
    ?>

    <div class="wrapper fadeInDown">
        <div id="formContent">

            <?php
                    // $_SESSION['test'] = 'beng';
                    // if(isset($_SESSION['test'])){
                        // echo ' '.$_SESSION['test'];
                        // unset($_SESSION['test']);
                        // print_r($_POST);
                        // var_dump($_POST);
                    // }
                    //Jeśli wystąpił jakiś błąd bądź wszystkie pola nie zostały wypełnione
                    if(isset($_SESSION['e_register_info'])){
                        echo $_SESSION['e_register_info'];
                        unset($_SESSION['e_register_info']);
                    }

                ?>

            <form method="POST" action="register.php">
                <h1>
                    <?php
                    //Jeśli zakończono pozytywnie rejestracje
                    if(isset($_SESSION['correct_register'])){
                        echo 'Zarejestrowano!';
                        unset($_SESSION['correct_register']);
                    }
                    ?>
                </h1>

                <!-- Pole login -->
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" class="form-control" placeholder="Podaj login">
                    <small class="text-muted">Login musi zawierać minimum 4 znaki</small>
                    <?php
                        if(isset($_SESSION['e_login'])){
                            echo '<small class="text-muted">'.$_SESSION['e_login'].'</small>';
                            unset($_SESSION['e_login']);
                        }
                    ?>
                </div>

                <!-- Pole hasło -->
                <div class="form-group">
                    <label for="password1">Hasło</label>
                    <input type="password" id="password1" name="password1" class="form-control"
                        placeholder="Podaj hasło">
                    <small class="text-muted">Hasło musi zawierać minumum 8 znaków, małe i duże litery oraz
                        cyfre</small>
                    <?php
                        if(isset($_SESSION['e_password'])){
                            echo '<small class="text-muted">'.$_SESSION['e_password'].'</small>';
                            unset($_SESSION['e_password']);
                        }
                    ?>
                </div>

                <!-- Pole potwierdź hasło -->
                <div class="form-group">
                    <label for="password2">Potwierdź hasło</label>
                    <input type="password" id="password2" name="password2" class="form-control"
                        placeholder="Potwierdź hasło">
                    <small class="text-muted">Wprowadź hasło ponownie</small>
                    <?php
                        if(isset($_SESSION['e_repassword'])){
                            echo '<small class="text-muted">'.$_SESSION['e_password'].'</small>';
                            unset($_SESSION['e_repassword']);
                        }
                    ?>
                </div>

                <!-- Pole email -->
                <div class="form-group">
                    <label for="email">Podaj adres email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Podaj adres email">
                    <small class="text-muted">Wprowadź hasło ponownie</small>
                    <?php
                        if(isset($_SESSION['e_email'])){
                            echo '<small class="text-muted">'.$_SESSION['e_email'].'</small>';
                            unset($_SESSION['e_email']);
                        }
                    ?>
                </div>

                <!-- Pole imię -->
                <div class="form-group">
                    <label for="name">Podaj imię</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Podaj imię">
                    <small class="text-muted">Imię rodzica</small>
                    <?php
                        if(isset($_SESSION['e_name'])){
                            echo '<small class="text-muted">'.$_SESSION['e_name'].'</small>';
                            unset($_SESSION['e_name']);
                        }
                    ?>
                </div>

                <!-- Pole nazwisko -->
                <div class="form-group">
                    <label for="surname">Podaj imię</label>
                    <input type="text" id="surname" name="surname" class="form-control" placeholder="Podaj nazwisko">
                    <small class="text-muted">Nazwisko rodzica</small>
                    <?php
                        if(isset($_SESSION['e_surname'])){
                            echo '<small class="text-muted">'.$_SESSION['e_surname'].'</small>';
                            unset($_SESSION['e_surname']);
                        }
                    ?>
                </div>
                
                <button type="submit" id="send" class="btn btn-primary">Zarejestruj</button>
            </form>

        </div>

</body>

</html>