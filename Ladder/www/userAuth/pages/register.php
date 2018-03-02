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
        <script type="text/javascript" src="../javascript/registerJS.js"></script>
        <script src="https://use.fontawesome.com/f568bc8bf4.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            User Registration
        </title>
    </head>

    <body>
    <div class="registrationForm">
        <div class="topNav">
            <button class="toHomePage" onclick="toHomePage()"><i class="fa fa-fw fa-3x fa-home" aria-hidden="true"></i></button>
            <button class="backArrow" onclick="goBack()"><i class="fa fa-fw fa-3x fa-arrow-left" aria-hidden="true"></i></button>
        </div>
        <!--    <form  action="http://dhansen.cs.georgefox.edu/~dhansen/echoForm.php" method="POST" onsubmit="return registerValidation(this);">-->
        <form  action="../server/user.php" method="POST" onsubmit="return registerValidation(this);">
            <h2>Welcome</h2>
            <h3>Register Below!</h3>


            <input class="userInfo" id="name" name="name" type="text" placeholder="* First Name ex. John Smith">

            <br>
            <input class="userInfo" id="phone" name="phone" type="number" placeholder="* Phone ex. 1234567890">

            <br>
            <input class="userInfo" id="email" name="email" type="email" placeholder="* Email ex. jsmith@example.com">

            <br>
            <input class="userInfo" id="username" name="username" type="text" placeholder="* Username ex. jsmith..."><div id="status"></div>

            <br>
            <input class="userInfo" id="password" name="password" type="password" placeholder="* Password">
            <br>
            <input class="userInfo" id="password2" name="password2" type="password" placeholder="* Confirm Password">

            <br>
            <br>
            <button class="register" type="submit" name="registerSubmit">Register</button>
        </form>
        <button class="loginSubmit" name="loginSubmit" onclick="toLogin()">Already a member? Login here!</button>
    </div>
    </body>
    </html>

<?php endif; ?>
