<?php

include('server.php');

if (isset($_POST['registerSubmit']))
{

    $name = pg_escape_string($dbconn, $_POST['name']);
    $username = pg_escape_string($dbconn, $_POST['username']);
    $phone = pg_escape_string($dbconn, $_POST['phone']);
    $email = pg_escape_string($dbconn, $_POST['email']);
    $password = pg_escape_string($dbconn, $_POST['password']);
    $password = md5($password);

    $sqlEmail = "select email from player where email = '$email'";
    $sqlUsername = "select username from player where username = '$username'";
    $sqlPhone = "select phone from player where phone = '$phone'";

    $resultEmail = pg_query($dbconn, $sqlEmail);
    $resultUsername = pg_query($dbconn, $sqlUsername);
    $resultPhone = pg_query($dbconn, $sqlPhone);

    $checkEmail = pg_fetch_row($resultEmail);
    $checkUsername = pg_fetch_row($resultUsername);
    $checkPhone = pg_fetch_row($resultPhone);

    if ($checkEmail > 0)
    {
        $_SESSION['errorMessage'] = "Email Already Taken";
        include('../error/error.php');
        session_unset();
        session_destroy();
        pg_close($dbconn);
        exit();
    }

	elseif ($checkUsername > 0)
    {
        $_SESSION['errorMessage'] = "Username Already Taken";
        include('../error/error.php');
        session_unset();
        session_destroy();
        pg_close($dbconn);
        exit();
    }

	elseif ($checkPhone > 0)
    {
        $_SESSION['errorMessage'] = "Phone Number Already Taken";
        include('../error/error.php');
        session_unset();
        session_destroy();
        pg_close($dbconn);
        exit();
    }

    else
    {
        $getMaxRank = pg_fetch_row(pg_query($dbconn, "select max(rank) from player"));
        $getMaxRank = $getMaxRank[0];
        $newRank =$getMaxRank + 1;
//			$sqlInsert = "insert into player (name, email, rank, phone, username, password) values ('$name', '$email', '$newRank', '$phone', '$username', '$password')";
        $sqlInsert = "insert into player (name, email, rank, phone, username, password) values ($1, $2, $3, $4, $5, $6)";

        $newPlayer = pg_prepare($dbconn, "newPlayer", $sqlInsert);
        $newPlayer = pg_execute($dbconn, "newPlayer", array($name, $email, $newRank, $phone, $username, $password));

        //pg_query($dbconn, $sqlInsert);

        $_SESSION['message'] = "User Registered!";
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['rank'] = $newRank;


        $_SESSION['timeout'] = time();
        header("Location: /userAuth/pages/ladderDisplay.php");
    }

}

//Log user in
elseif (isset($_POST['loginSubmit']))
{
    $username = pg_escape_string($dbconn, $_POST['username']);
    $password = pg_escape_string($dbconn, $_POST['password']);

    $password = md5($password);

//		$sqlLogin = "select * from player where username = '$username' and password = '$password'";
    $sqlName = "select name, username, email, rank from player where username = $1 and password = $2";

//		$login = pg_query($dbconn, $sqlLogin);
    $login = pg_prepare($dbconn, "login", $sqlName);
    $login = pg_execute($dbconn, "login", array($username, $password));

//		$checkLogin = pg_fetch_row($login);
    $checkUser = pg_fetch_row($login);
    $name = $checkUser[0];
    $username = $checkUser[1];
    $email = $checkUser[2];
    $rank = $checkUser[3];

    $getChallengePlayers = "select challenger, challengee from challenge where challenger = '$username' and accepted is not null or challengee = '$username' and accepted is not null";
    $getChallengePlayersQuery = pg_query($dbconn, $getChallengePlayers);
    $getChallenges = pg_fetch_row($getChallengePlayersQuery);

    if ($checkUser < 1 ) {

        $_SESSION['errorMessage'] = "Wrong Username or Password";
        include('../error/error.php');
        session_destroy();
        session_unset();
        pg_close($dbconn);
        exit();
    }

    else{

        $_SESSION['message'] = "You are now logged in";
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['rank'] = $rank;

        if($getChallenges > 0)
        {
            $_SESSION['challenger'] = $getChallenges[0];
            $_SESSION['challengee'] = $getChallenges[1];
            header("Location: /index.php");
        }
        $_SESSION['timeout'] = time();
        header("Location: /userAuth/pages/ladderDisplay.php");
    }

}

//Logging out
elseif (isset($_POST['logout'])){
    session_unset();
    session_destroy();
    pg_close($dbconn);
    header("Location: /index.php");
}

//delete the user
elseif (isset($_POST['deleteUser'])){

    $username = $_SESSION['username'];
    $email = $_SESSION['email'];

    $password = pg_escape_string($_POST['password']);
    $password = md5($password);

    $sqlPassword = "select password from player where email = '$email' and username = '$username'";
    $resultPassword = pg_query($dbconn, $sqlPassword);
    $checkPassword = pg_fetch_row($resultPassword);

    if ($checkPassword[0] = $password){
        $deleteChallenge = "delete from challenge where challenger = '$username' or challengee = '$username'";
        pg_query($dbconn, $deleteChallenge);
        $deleteGames = "delete from game where winner = '$username' or loser = '$username'";
        pg_query($dbconn, $deleteGames);
        $deletePlayer = "delete from player where username = '$username' and password = '$password'";
        pg_query($dbconn, $deletePlayer);

        session_unset();
        session_destroy();
        pg_close($dbconn);
        header("Location: /userAuth/index.php");
    }

    else
    {
        header("Location: /userAuth/pages/ladderDisplay.php");
    }
}

// Send a challenge request
elseif (isset($_POST['challenge']))
{
    $personChallengedusername = $_POST['personChallengedusername'];
    $personChallengedname = $_POST['personChallengedname'];
    $personChallengeTimeSchedule = pg_escape_string($_POST['personChallengeTimeSchedule']);
    $_SESSION['challengeeName'] = $personChallengedname;
    $_SESSION['challengeeUserName'] = $personChallengedusername;
    $_SESSION['challengeScheduled'] = $personChallengeTimeSchedule;

    $_SESSION['timeout'] = time();
    header("Location: /userAuth/pages/challenge.php");
}

//accepting a challenge
elseif (isset($_POST['acceptChallenge']))
{
    $challengerName = $_POST['challengerName'];
    $challengerUsername = $_POST['challengerUsername'];

    $_SESSION['challengerName'] = $challengerName;
    $_SESSION['challenger'] = $challengerUsername;
    $challengee = $_SESSION['username'];
    $_SESSION['challengee'] = $challengee;

    $timeStampAccepted = date("Y-m-d");
    $challengeAccepted = "update challenge set accepted = '$timeStampAccepted' where challenger = '$challengerUsername' and challengee = '$challengee'";
    pg_query($dbconn, $challengeAccepted);

    $challengesDelete = "delete from challenge where challenger = '$challengerUsername' and accepted is null";
    pg_query($dbconn, $challengesDelete);
    $challengesDelete = "delete from challenge where challengee = '$challengerUsername' and accepted is null";
    pg_query($dbconn, $challengesDelete);
    $challengesDelete = "delete from challenge where challenger = '$challengee' and accepted is null";
    pg_query($dbconn, $challengesDelete);
    $challengesDelete = "delete from challenge where challengee = '$challengee' and accepted is null";
    pg_query($dbconn, $challengesDelete);

    $_SESSION['timeout'] = time();
    header("Location: /userAuth/pages/acceptedChallenge.php");
}

//rejecting a challenge
elseif (isset($_POST['rejectChallenge']))
{
    $challengerName = $_POST['challengerName'];
    $challengerUsername = $_POST['challengerUsername'];
    $challengee = $_SESSION['username'];

    $challengesDelete = "delete from challenge where challenger = '$challengerUsername' and challengee = '$challengee' and accepted is null";
    pg_query($dbconn, $challengesDelete);

    $_SESSION['timeout'] = time();
    header("Location: /userAuth/pages/ladderDisplay.php");
}

// Recording scores from each game played
elseif (isset($_POST['gamePlayed']))
{

    $challenger = $_SESSION['challenger'];
    $challengee = $_SESSION['challengee'];
    $challengerScore = pg_escape_string($_POST['challengerScore']);
    $challengeeScore = pg_escape_string($_POST['challengeeScore']);
    $gameNumber = pg_escape_string($_POST['gameNumber']);
    $gameTime = pg_escape_string($_POST['gameTime']);

    $winner = "";
    $loser = "";
    $winnerScore = 0;
    $loserScore = 0;

    //Choosing the winner and losers
    if($challengerScore > $challengeeScore){
        $winner = $challenger;
        $winnerScore = $challengerScore;
        $loser = $challengee;
        $loserScore = $challengeeScore;
    }

    else{
        $winner = $challengee;
        $winnerScore = $challengeeScore;
        $loser = $challenger;
        $loserScore = $challengerScore;
    }

    //$insertScores = "insert into game values('$winner', '$loser', '$gameTime', $gameNumber, $winnerScore, $loserScore)";
    $insertScores = "insert into game values($1, $2, $3, $4, $5, $6)";
    $insertScores = pg_prepare($dbconn, "insertScore", $insertScores);
    pg_execute($dbconn, "insertScore", array($winner, $loser, $gameTime, $gameNumber, $winnerScore, $loserScore));

    $_SESSION['timeout'] = time();
    header('Location: /userAuth/pages/acceptedChallenge.php');
}

//Ending a challenge after final game has been playeds
elseif (isset($_POST['finalSubmit']))
{

    $challenger = $_SESSION['challenger'];
    $challengee = $_SESSION['challengee'];
    $matchWinner = $_SESSION['matchWinner'];
    $matchLoser = $_SESSION['matchLoser'];

    $challengesDelete = "delete from challenge where challenger = '$challenger' and challengee = '$challengee'";
    pg_query($dbconn, $challengesDelete);


    $matchWinnerRank = pg_fetch_row(pg_query($dbconn, "select rank from player where username = '$matchWinner'"));
    $matchWinnerRank = $matchWinnerRank[0];

    $matchLoserRank = pg_fetch_row(pg_query($dbconn, "select rank from player where username = '$matchLoser'"));
    $matchLoserRank = $matchLoserRank[0];


    if($matchWinnerRank > $matchLoserRank) {
        $getMaxRank = pg_fetch_row(pg_query($dbconn, "select max(rank) from player"));
        $getMaxRank = $getMaxRank[0];
        $newMaxRank = $getMaxRank + 100;

        $differenceBetweenRanks = $matchWinnerRank - $matchLoserRank;

        if($differenceBetweenRanks == 1)
        {
            $tempRank = "update player set rank = $newMaxRank where username = '$matchLoser'";
            pg_query($dbconn, $tempRank);
            $updateWinnerRank = "update player set rank = $matchLoserRank where username = '$matchWinner'";
            pg_query($dbconn, $updateWinnerRank);
            $updateLoserRank = "update player set rank = $matchWinnerRank where username = '$matchLoser'";
            pg_query($dbconn, $updateLoserRank);
        }

		elseif ($differenceBetweenRanks == 2)
        {
            $tempRank = "update player set rank = $newMaxRank where rank = ($matchLoserRank+1)";
            pg_query($dbconn, $tempRank);
            $updateLoserRank = "update player set rank = ($matchWinnerRank-1) where username = '$matchLoser'";
            pg_query($dbconn, $updateLoserRank);
            $updateWinnerRank = "update player set rank = $matchLoserRank where username = '$matchWinner'";
            pg_query($dbconn, $updateWinnerRank);

            //Bring the middle player back into the table
            $tempRank = "update player set rank = $matchWinnerRank where rank = $newMaxRank";
            pg_query($dbconn, $tempRank);
        }

        else
        {
            $tempRank = "update player set rank = $newMaxRank where username = '$matchLoser'";
            pg_query($dbconn, $tempRank);
            $updateWinnerRank = "update player set rank = $matchLoserRank where username = '$matchWinner'";
            pg_query($dbconn, $updateWinnerRank);
            $updateRanks = "update player set rank = $matchWinnerRank where rank = $matchWinnerRank-1";
            pg_query($dbconn, $updateRanks);
            $updateRanks = "update player set rank = rank+1 where rank = $matchLoserRank+1";
            pg_query($dbconn, $updateRanks);
            $updateLoserRank = "update player set rank = $matchLoserRank+1 where username = '$matchLoser'";
            pg_query($dbconn, $updateLoserRank);
        }

    }

    $_SESSION['gameOverMsg'] = "Thank you for playing! Your match is now finished and scores have been submitted.";
    unset($_SESSION['challenger']);
    unset($_SESSION['challengee']);

    $_SESSION['timeout'] = time();
    header("Location: /userAuth/pages/ladderDisplay.php");

}

else
{
    header("Location: ../../index.php");
    session_unset();
    session_destroy();
    pg_close($dbconn);
    exit();
}

?>
