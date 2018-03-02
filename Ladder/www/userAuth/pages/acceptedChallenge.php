<?php
/**
 * Created by PhpStorm.
 * User: grobert14
 * Date: 11/25/2017
 * Time: 12:04 AM
 */

include('../server/server.php');
include('ladder/header.php');
?>
<html>
<head>
    <title>
        Challenge Time
    </title>
    <script src="../javascript/score.js"></script>
</head>
<body class="ladderPage">

<?php if (isset($_SESSION['message']) && isset($_SESSION['username'])): ?>

    <?php
    include('ladder/nav.php');
    ?>



    <?php if(isset($_SESSION['challenger']) && isset($_SESSION['challengee'])): ?>
        <?php
        $challenger = $_SESSION['challenger'];
        $challengee = $_SESSION['challengee'];
        $challengerName = "select name from player where username = '$challenger'";
        $challengerName = pg_fetch_row(pg_query($dbconn, $challengerName));
        $challengeeName = "select name from player where username = '$challengee'";
        $challengeeName = pg_fetch_row(pg_query($dbconn, $challengeeName));
        $dateScheduled = "select scheduled from challenge where challenger = '$challenger' and challengee = '$challengee'";
        $dateScheduled = pg_fetch_row(pg_query($dbconn, $dateScheduled));
        $dateScheduled = $dateScheduled[0];
        $gameTime = $dateScheduled;

        echo "Date Scheduled: ".$dateScheduled;
        $checkGames = "select number from game where played = '$dateScheduled' and winner = '$challengee' and loser = '$challenger' or played = '$dateScheduled' and winner = '$challenger' and loser = '$challengee'";
        $checkGames = pg_fetch_all_columns(pg_query($dbconn, $checkGames));

        $challengerWins = [];
        $challengeeWins = [];
        ?>

        <h2>Challenge Time!</h2>
        <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-3">
                <h3><?php echo $challengerName[0]?></h3>
            </div>
            <div class="col-md-4 col-sm-2 col-xs-2">
                <h5>VS.</h5>
            </div>
            <div class="col-md-4 col-sm-3 col-xs-3">
                <h3><?php echo $challengeeName[0]?></h3>
            </div>
        </div>
        <hr>



        <?php if(in_array(1, $checkGames)) : ?>
            <?php
            $gameOneScores = "select winner, winner_score, loser, loser_score from game where played = '$dateScheduled' and number = 1 and winner = '$challenger' and loser ='$challengee' or played = '$dateScheduled' and number = 1 and loser = '$challenger' and winner = '$challengee'";
            $gameOneScores = pg_fetch_row(pg_query($dbconn, $gameOneScores));
            $winner = $gameOneScores[0];
            $winnerName = "select name from player where username = '$winner'";
            $winnerName = pg_fetch_row(pg_query($winnerName));
            $winnerName = $winnerName[0];
            ?>
            <div class="row">
                <div class="col-md-3">
                    <?php if($challenger == $gameOneScores[0]){
                        echo  $gameOneScores[1];
                        $challengerWins[] = $challenger;
                    }

                    else
                    {
                        echo  $gameOneScores[3];
                    }
                    ?>


                </div>
                <div class="col-md-6">
                    <h6>Game 1 won by: <?php echo $winnerName?></h6>
                </div>
                <div class="col-md-3">
                    <?php if($challengee == $gameOneScores[0]){
                        echo  $gameOneScores[1];
                        $challengeeWins[] = $challengee;
                    }

                    else
                    {
                        echo  $gameOneScores[3];
                    }
                    ?>
                </div>
            </div>

        <?php else: ?>

            <form class="row" method="POST" action="../server/user.php" onsubmit="return scoreValidation(this);">

                <div class="col-md-4 col-sm-5 col-xs-5" ><input type="number" min="0" class="userInfo" name="challengerScore" id="challengerScore"></div>
                <input type="number" value="1" style="display: none;" id="gameNumber" name="gameNumber">
                <input type="text" value="<?php echo $gameTime; ?>" style="display: none;" id="gameTime" name="gameTime">
                <div class="col-md-4 col-sm-2 col-xs-2">
                    <button type="submit" class="gamePlayedButton" name="gamePlayed">Game 1 Submit</button>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-5"><input type="number" min="0" class="userInfo" name="challengeeScore" id="challengeeScore"></div>
            </form>
        <?php endif; ?>
        <hr>
        <?php if(in_array(1, $checkGames)) : ?>

            <?php if(in_array(2, $checkGames)) : ?>
                <?php
                $gameOneScores = "select winner, winner_score, loser, loser_score from game where played = '$dateScheduled' and number = 2 and winner = '$challenger' and loser ='$challengee' or played = '$dateScheduled' and number = 2 and loser = '$challenger' and winner = '$challengee'";
                $gameOneScores = pg_fetch_row(pg_query($dbconn, $gameOneScores));
                $winner = $gameOneScores[0];
                $winnerName = "select name from player where username = '$winner'";
                $winnerName = pg_fetch_row(pg_query($winnerName));
                $winnerName = $winnerName[0];

                ?>
                <div class="row">
                    <div class="col-md-3">
                        <?php if($challenger == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengerWins[] = $challenger;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Game 2 won by: <?php echo $winnerName?></h6>
                    </div>
                    <div class="col-md-3">
                        <?php if($challengee == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengeeWins[] = $challengee;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                </div>
            <?php else: ?>
                <form class="row" method="POST" action="../server/user.php" onsubmit="return scoreValidation(this);">
                    <div class="col-md-4 col-sm-5 col-xs-5" ><input type="number" min="0" class="userInfo" name="challengerScore" id="challengerScore"></div>
                    <input type="number" value="2" style="display: none;" id="gameNumber" name="gameNumber">
                    <input type="text" value="<?php echo $gameTime; ?>" style="display: none;" id="gameTime" name="gameTime">
                    <div class="col-md-4 col-sm-2 col-xs-2">
                        <button type="submit" class="gamePlayedButton" name="gamePlayed">Game 2 Submit</button>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-5"><input type="number" min="0" class="userInfo" name="challengeeScore" id="challengeeScore"></div>
                </form>
            <?php endif; ?>



            <hr>
        <?php endif; ?>


        <?php if(in_array(2, $checkGames)) : ?>

            <?php if(in_array(3, $checkGames)) : ?>
                <?php
                $gameOneScores = "select winner, winner_score, loser, loser_score from game where played = '$dateScheduled' and number = 3 and winner = '$challenger' and loser ='$challengee' or played = '$dateScheduled' and number = 3 and loser = '$challenger' and winner = '$challengee'";
                $gameOneScores = pg_fetch_row(pg_query($dbconn, $gameOneScores));
                $winner = $gameOneScores[0];
                $winnerName = "select name from player where username = '$winner'";
                $winnerName = pg_fetch_row(pg_query($winnerName));
                $winnerName = $winnerName[0];
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <?php if($challenger == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengerWins[] = $challenger;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Game 3 won by: <?php echo $winnerName?></h6>
                    </div>
                    <div class="col-md-3">
                        <?php if($challengee == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengeeWins[] = $challengee;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                </div>
            <?php else: ?>

                <form class="row" method="POST" action="../server/user.php" onsubmit="return scoreValidation(this);">
                    <div class="col-md-4 col-sm-5 col-xs-3" ><input type="number" min="0" class="userInfo" name="challengerScore" id="challengerScore"></div>
                    <input type="number" value="3" style="display: none;" id="gameNumber" name="gameNumber">
                    <input type="text" value="<?php echo $gameTime; ?>" style="display: none;" id="gameTime" name="gameTime">

                    <div class="col-md-4 col-sm-2 col-xs-6">
                        <button type="submit" class="gamePlayedButton" name="gamePlayed">Game 3 Submit</button>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-3"><input type="number" min="0" class="userInfo" name="challengeeScore" id="challengeeScore"></div>
                </form>
            <?php endif; ?>



            <hr>
        <?php endif; ?>

        <?php if(in_array(3, $checkGames) && !((sizeof($challengeeWins)) == 3 || (sizeof($challengerWins) == 3))) : ?>

            <?php if(in_array(4, $checkGames)) : ?>
                <?php
                $gameOneScores = "select winner, winner_score, loser, loser_score from game where played = '$dateScheduled' and number = 4 and winner = '$challenger' and loser ='$challengee' or played = '$dateScheduled' and number = 4 and loser = '$challenger' and winner = '$challengee'";
                $gameOneScores = pg_fetch_row(pg_query($dbconn, $gameOneScores));
                $winner = $gameOneScores[0];
                $winnerName = "select name from player where username = '$winner'";
                $winnerName = pg_fetch_row(pg_query($winnerName));
                $winnerName = $winnerName[0];
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <?php if($challenger == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengerWins[] = $challenger;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Game 4 won by: <?php echo $winnerName?></h6>
                    </div>
                    <div class="col-md-3">
                        <?php if($challengee == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengeeWins[] = $challengee;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                </div>
            <?php else: ?>

                <form class="row" method="POST" action="../server/user.php" onsubmit="return scoreValidation(this);">
                    <div class="col-md-4 col-sm-5 col-xs-3" ><input type="number" min="0" class="userInfo" name="challengerScore" id="challengerScore"></div>
                    <input type="number" value="4" style="display: none;" id="gameNumber" name="gameNumber">
                    <input type="text" value="<?php echo $gameTime; ?>" style="display: none;" id="gameTime" name="gameTime">

                    <div class="col-md-4 col-sm-2 col-xs-6">
                        <button type="submit" class="gamePlayedButton" name="gamePlayed">Game 4 Submit</button>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-3"><input type="number" min="0" class="userInfo" name="challengeeScore" id="challengeeScore"></div>
                </form>


            <?php endif; ?>
            <hr>
        <?php endif; ?>



        <?php if(in_array(4, $checkGames) && !((sizeof($challengeeWins)) == 3 || (sizeof($challengerWins) == 3))) : ?>
            <?php if(in_array(5, $checkGames)) : ?>
                <?php
                $gameOneScores = "select winner, winner_score, loser, loser_score from game where played = '$dateScheduled' and number = 5 and winner = '$challenger' and loser ='$challengee' or played = '$dateScheduled' and number = 5 and loser = '$challenger' and winner = '$challengee'";
                $gameOneScores = pg_fetch_row(pg_query($dbconn, $gameOneScores));
                $winner = $gameOneScores[0];
                $winnerName = "select name from player where username = '$winner'";
                $winnerName = pg_fetch_row(pg_query($winnerName));
                $winnerName = $winnerName[0];
                ?>
                <div class="row">
                    <div class="col-md-3 col-sm-5 col-xs-3">
                        <?php if($challenger == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengerWins[] = $challenger;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-2 col-xs-6">
                        <h6>Game 4 won by: <?php echo $winnerName?></h6>
                    </div>
                    <div class="col-md-3 col-sm-5 col-xs-3">
                        <?php if($challengee == $gameOneScores[0]){
                            echo  $gameOneScores[1];
                            $challengeeWins[] = $challengee;
                        }

                        else
                        {
                            echo  $gameOneScores[3];
                        }
                        ?>
                    </div>
                </div>
            <?php else: ?>

                <form class="row" method="POST" action="../server/user.php" onsubmit="return scoreValidation(this);">
                    <div class="col-md-4 col-sm-5 col-xs-3" ><input type="number" min="0" class="userInfo" name="challengerScore" id="challengerScore"></div>
                    <input type="number" value="5" style="display: none;" id="gameNumber" name="gameNumber">
                    <input type="text" value="<?php echo $gameTime; ?>" style="display: none;" id="gameTime" name="gameTime">

                    <div class="col-md-4 col-sm-2 col-xs-6">
                        <button type="submit" class="gamePlayedButton" name="gamePlayed">Game 5 Submit</button>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-3"><input type="number" min="0" class="userInfo" name="challengeeScore" id="challengeeScore"></div>
                </form>


            <?php endif; ?>

            <hr>
        <?php endif; ?>



        <?php if((sizeof($challengeeWins)) == 3 || (sizeof($challengerWins) == 3) && in_array(3, $checkGames) || (sizeof($challengeeWins)) == 3 || (sizeof($challengerWins) == 3) && in_array(4, $checkGames) || (sizeof($challengeeWins)) == 3 || (sizeof($challengerWins) == 3) && in_array(5, $checkGames)): ?>

            <?php
            if (sizeof($challengeeWins) > sizeof($challengerWins)){
                $_SESSION['matchWinner'] = $challengee;
                $_SESSION['matchLoser'] = $challenger;
            }
            else{
                $_SESSION['matchWinner'] = $challenger;
                $_SESSION['matchLoser'] = $challengee;
            }
            ?>
            <form class="row" method="POST" action="../server/user.php">
                <div class="col-md-4 col-sm-5 col-xs-3" >Total Wins: <br> <?php echo count($challengerWins); ?></div>
                <div class="col-md-4 col-sm-2 col-xs-6">
                    <button type="submit" class="finalSubmit btn-lg btn-success" name="finalSubmit">Submit Score</button>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-3">Total Wins: <br> <?php echo count($challengeeWins); ?></div>
            </form>
        <?php endif; ?>







    <?php else: ?>
        <h1>Not Accepted any challenges or Challenges not available.</h1>
    <?php endif; ?>



<?php else: ?>

    <div class="ladderError">
        <button class="goToLogin" onclick="toLogin()">Login</button>
        <button class="goToRegister" onclick="toRegister()">Register</button>

        <h4>You are not logged in</h4>
    </div>

<?php endif; ?>
<button class="button btn btn-success backToLadder" onclick="toLogin()">Back to Ladder</button>
</body>
</html>