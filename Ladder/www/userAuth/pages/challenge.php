<?php
/**
 * Created by PhpStorm.
 * User: grobert14
 * Date: 11/21/2017
 * Time: 12:27 AM
 */

include('../server/server.php');
include('ladder/header.php');


?>
<html>
<head>


    <title>
        Player Challenged
    </title>
</head>
<body class="ladderPage">

<?php if (isset($_SESSION['message']) && isset($_SESSION['username']) && isset($_SESSION['challengeeName'])): ?>
    <?php
    include('ladder/nav.php');

    $timeStampIssued = date("Y-m-d");
    $challenger = $_SESSION['username'];
    $challengee = $_SESSION['challengeeUserName'];
    $challengeScheduled = $_SESSION['challengeScheduled'];
    echo "You have successfully challenged: " . $_SESSION['challengeeName'];
    echo "<br> <b>Issued on: </b>".$timeStampIssued;
    echo "<br> <b>Your Challenge has been scheduled for: </b>".$challengeScheduled;


    $challengeQuery = "insert into challenge values('$challenger', '$challengee', '$timeStampIssued', NULL , '$challengeScheduled')";
    $challengeQuery = pg_query($dbconn, $challengeQuery);
    ?>
    <br>

    <button class="button btn btn-success" onclick="toLogin()">Back to Ladder</button>
<?php else: ?>

    <div class="ladderError">
        <button class="goToLogin" onclick="toLogin()">Login</button>
        <button class="goToRegister" onclick="toRegister()">Register</button>

        <h4>You are not logged in</h4>
    </div>

<?php endif; ?>
</body>
</html>
