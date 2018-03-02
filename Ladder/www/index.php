<?php
/**
 * Created by PhpStorm.
 * User: gohar
 * Date: 9/28/17
 * Time: 7:24 PM
 */


include('userAuth/server/server.php');
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="userAuth/css/index.css">
    <script type="text/javascript" src="userAuth/javascript/navigation.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Home
    </title>
</head>
<body class="homePage">
<p class="welcome">Welcome to the Ladder!!</p>
<p>The Ladder is a ranked game structure allowing players to challenge each other.
    <br><br>
    The way it works is that a challenge is presented from one player to another which is subject to either be accepted or denied.

    If accepted, the two players become part of one match, in which the first player to win three out of five games wins the match.
    <br><br>
    A player can only challenge other players who are within three ranks above them and who have not already accepted another challenge. Beating a player ranked higher than the challenger advances the rank of the challenging player.
    Ranking takes into account how many games a player had to play to reach three wins and the average margin of the score within games.
    <br>
    The game is one by the player who first reaches 15 points and wins by 2.
</p>

<div class="navButtons">
    <?php if (isset($_SESSION['message']) && isset($_SESSION['username'])): ?>
        <?php include('userAuth/pages/ladder/header.php');?>
        <button class="btn btn-info" onclick="toLadderDisplay()">You're Already Logged In. Go to Ladder</button>

    <?php else: ?>
        <button class="goToLogin" onclick="toLogin()">Login</button>
        <button class="goToRegister" onclick="toRegister()">Register</button>

    <?php endif; ?>
</div>


</body>
</html>
