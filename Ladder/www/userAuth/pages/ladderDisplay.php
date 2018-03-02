<?php
/**
 * Created by PhpStorm.
 * User: gohar
 * Date: 10/9/17
 * Time: 11:32 AM
 */
session_start();
include('../server/server.php');

?>

<html>
<head>


    <title>
        Ladder Time
    </title>
    <?php
    // This page gets all the javascript and css anyone will ever need!

    include('ladder/header.php');
    ?>
</head>
<body class="ladderPage">


<?php if (isset($_SESSION['message']) && isset($_SESSION['username'])): ?>
    <?php
    //Get all the navigation items
    include('ladder/nav.php');
    ?>

    <!-- Display game over message after match is completed -->
    <?php if (isset($_SESSION['gameOverMsg'])){
        echo "<h6>".$_SESSION['gameOverMsg']."</h6>";
        unset ($_SESSION['gameOverMsg']);
    }
    ?>

    <hr>


    <?php
    echo "Welcome ". $_SESSION['name'];
    $name = $_SESSION['name'];
    $username = $_SESSION['username'];
    ?>


    <?php
    //Get all the ranking
    include('ladder/ranks.php');
    echo"<button type=\"button\" class=\"btn btn-success statsButton\" onclick=\"toStats()\">
                        <i class=\"fa fa-bar-chart fa-fw\" aria-hidden=\"true\"></i>Statistics
                    </button>";
    ?>

    <!-- Display errors -->
<?php else: ?>

    <div class="ladderError">
        <button class="goToLogin" onclick="toLogin()">Login</button>
        <button class="goToRegister" onclick="toRegister()">Register</button>

        <h4>You are not logged in</h4>
    </div>

<?php endif; ?>


</body>

</html>
