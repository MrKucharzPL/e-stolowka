<html>
<?php
require_once 'start.php';
?>

<body>
    <?php
require_once 'header.php';
?>

    <div class="wrapper fadeInDown">
        <div id="formContent">

            <!-- Login Form -->
            <form method="POST">
                <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
                <input type="password" id="password" class="fadeIn third" name="login" placeholder="password">
                <input type="submit" class="fadeIn fourth">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div>

        </div>
    </div>
</body>

</html>