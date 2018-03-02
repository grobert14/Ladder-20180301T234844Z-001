<?php
/**
 * Created by PhpStorm.
 * User: gohar
 * Date: 9/27/17
 * Time: 4:37 PM
 */
session_start();
?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <script src="https://use.fontawesome.com/f568bc8bf4.js"></script>
    <script type="text/javascript" src="../javascript/navigation.js"></script>
    <title>
        Error
    </title>
</head>

<body>
<div class="errorPage">
    <div class="topNav">
        <button class="toHomePage" onclick="toHomePage()"><i class="fa fa-fw fa-3x fa-home" aria-hidden="true"></i></button>
        <button class="backArrow" onclick="goBack()"><i class="fa fa-fw fa-3x fa-arrow-left" aria-hidden="true"></i></button>
    </div>
    <p>Error Bruh!</p>
    <h4><?php
        echo "Sorry! ".$_SESSION['errorMessage'];
        session_unset();
        session_destroy();
        ?></h4>

    <button class="loginSubmit" name="loginSubmit" onclick="toLogin()">Try Logging in Again!</button>

</div>

</body>

</html>

