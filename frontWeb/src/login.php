<!doctype html>
<meta charset="utf-8" />
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LoginPage</title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
        <link href="/src/css/loginPage.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            include_once ("./nav.php");
        ?>

        <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <!-- Icon -->
            <div class="fadeIn first">
            <img src="/imgs/account.png" id="icon" alt="User Icon" style="width:100px"/>
            </div>

            <!-- Login Form -->
            <form method='post' action='/src/func/checklogin.php'>
            <input type="text" id="login" class="fadeIn second" name="id" placeholder="login">
            <input type="password" id="password" class="fadeIn third" name="pw" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
            <a class="underlineHover" href="#">Forgot Password?</a>
            </div>

        </div>
        </div>

        <?php include("./footer.php");?>
    </body>
</html>