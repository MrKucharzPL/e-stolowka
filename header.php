<section>

    <div id="mySidenav2" class="sidenav2">
        <!-- Use any element to open the sidenav -->
        <span onclick="openNav()"><img src="img/menu.png"></span>
        <span style="margin:auto;">
            <?php   
        if(isset($_SESSION['zalogowany'])){
            try{
                echo 'Zalogowany: ' . $_SESSION['user_name'] . ' ' . $_SESSION['user_surname']; 
            }
            catch(Exception $exc){
                echo 'Brak imienia/nazwiska w bazie';
            }
            echo '<a class="btn btn-primary" href="logout.php" role="button">Wyloguj się</a>';
        }
        ?>
        </span>
    </div>

    <div id="mySidenav" class="sidenav">

        <ul>
            <li><a href="index.php"><img src="img/home.png"><span>Strona główna</span></a></li>
            <li><a href="about.php"><img src="img/home.png"><span>O nas</span></a></li>
            <?php
            //Jeśli niezalogowany to wyświetl odnośniki do logowania i rejestracji
            if(!isset($_SESSION['zalogowany'])){
                echo '<li><a href="login.php"><img src="img/login.png"><span>Logowanie</span></a></li>';
                echo '<li><a href="register.php"><img src="img/register.png"><span>Rejestracja</span></a></li>';
            }
            else{
            //Jeśli zalogowany to wyświetl odnośniki w zależności jakie ktoś ma uprawnienia
                if(isset($_SESSION['user_permission'])){
                    $permission = ($_SESSION['user_permission']);
                    switch($permission){
                        case 0: //konto nieaktywne
                            break;
                        case 1: //konto użytkownika
                            break;
                        case 2: //konto zarządcy
                            break;
                        case 3: //konto admina
                            echo '<li><a href="admin_panel.php"><img src="img/admin_panel.png"><span>Panel admina</span></a></li>';
                            break;
                    }


                }

            }
            ?>
        </ul>


        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    </div>

</section>