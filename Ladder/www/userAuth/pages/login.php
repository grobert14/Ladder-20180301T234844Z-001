<?php

include('../server/server.php');
?>

<?php if (isset($_SESSION['message']) && isset($_SESSION['username'])): ?>
    <?php
    header("Location: ladderDisplay.php");
    ?>

<?php else: ?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/index.css">
        <script type="text/javascript" src="../javascript/navigation.js"></script>
        <script type="text/javascript" src="../javascript/loginJS.js"></script>
        <script src="https://use.fontawesome.com/f568bc8bf4.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Login
        </title>
    </head>

    <body>
    <div class="topNav">
        <button class="toHomePage" onclick="toHomePage()"><i class="fa fa-fw fa-3x fa-home" aria-hidden="true"></i></button>
        <button class="backArrow" onclick="goBack()"><i class="fa fa-fw fa-3x fa-arrow-left" aria-hidden="true"></i></button>
    </div>
    <div class="loginForm">
        <!--        <form action="http://dhansen.cs.georgefox.edu/~dhansen/echoForm.php" method="POST" onsubmit="return loginValidation(this);">-->
        <form action="../server/user.php" method="POST" onsubmit="return loginValidation(this);">
            <h2>Welcome</h2>
            <h3>Login Here</h3>
            <input class="userInfo" id="username" name="username" type="text" placeholder="* Username">
            <br>
            <input class="userInfo" id="password" name="password" type="password" placeholder="* Password">
            <br>
            <br>
            <button class="loginSubmit" type="submit" name="loginSubmit">Login</button>
        </form>
        <button class="register" onclick="toRegister()">Don't have an account? Register!</button>
    </div>

    </body>

    </html>

<?php endif; ?>








