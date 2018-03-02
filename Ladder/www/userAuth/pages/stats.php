<?php
/**
 * Created by PhpStorm.
 * User: grobert14
 * Date: 11/25/2017
 * Time: 11:45 PM
 */
include('../server/server.php');

?>

<html>
<head>
    <title>
        Statistics
    </title>
    <?php
    //Include all css and js
    include('ladder/header.php');
    ?>
</head>
<body class="statsPage">
<?php if (isset($_SESSION['message']) && isset($_SESSION['username'])): ?>
    <?php
    //include all navigation items
    include('ladder/nav.php');

    $statsQuery = "select q5.name,
case when (q5.matches_won+q5.matches_lost) = 0 then 0 else ((q5.matches_won)/(cast(q5.matches_won+q5.matches_lost as float)))*100.00 end as match_winning_percentage,
case when (q5.matches_won+q5.matches_lost) = 0 then 0 else (q5.matches_lost/(cast(q5.matches_won+q5.matches_lost as float)))*100.00 end as match_losing_percentage,
q5.games_win_percentage, q5.games_lost_percentage,
case when (q5.total_games) = 0 then 0 when (q5.wins) = 0 then 0 else (q5.winner_score/q5.wins) end as game_winning_margin,
case when (q5.total_games) = 0 then 0 when q5.losses = 0 then 0 else (q5.loser_score/q5.losses) end as game_losing_margin
from
(select q1.name, q1.rank, q1.wins, q2.losses, (q1.wins+q2.losses) as total_games, q1.winner_score, q2.loser_score,
	case when (q1.wins+q2.losses) = 0 then 0 else q1.wins/(cast(q1.wins+q2.losses as float))*100.00 end as games_win_percentage,
	case when (q1.wins+q2.losses) = 0 then 0 else q2.losses/(cast(q1.wins+q2.losses as float))*100.00 end as games_lost_percentage,
	q3.matches_won, q4.matches_lost
	from
    (
        (select p1.name,p1.rank, p1.username, count(g1.winner) as wins, sum(g1.winner_score) as winner_score
			from player p1 left outer join game g1 on p1.username = g1.winner group by username) q1
		left outer join
(select p2.username, count(g2.loser) as losses, sum(g2.loser_score) as loser_score
			from player p2 left outer join game g2 on p2.username = g2.loser  group by p2.username) q2 on q1.username = q2.username
		left outer join
(select p3.username, count(m1.winner) as matches_won
			from player p3 left outer join match_view m1 on p3.username = m1.winner group by p3.username) q3 on q1.username = q3.username
		left outer join
(select p4.username, count(m2.loser) as matches_lost
			from player p4 left outer join match_view m2 on p4.username = m2.loser group by p4.username) q4 on q1.username = q4.username
		)
	) q5 order by q5.rank asc";

    $statsQuery = pg_query($dbconn, $statsQuery);
    ?>
    <br>
    <br>
    <h3>Games Statistics</h3>
    <table class="table ladderTable table-hover">
        <thead class='tableHead statsHead'>
        <tr>

            <th>Name</th>
            <th>Match Winning Percentage</th>
            <th>Match Losing Percentage</th>
            <th>Games Winning Percentage</th>
            <th>Games Losing Percentage</th>
            <th>Games Winning Margin</th>
            <th>Games Losing Margin</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = pg_fetch_row($statsQuery)) {
            $matchWinningPerc = round($row[1], 2);
            $matchLosingPerc = round($row[2], 2);
            $gameWinningPerc = round($row[3], 2);
            $gameLosingPerc = round($row[4], 2);
            $gameWinningMargin = round($row[5], 2);
            $gameLosingMargin = round($row[6], 2);
            echo "<tr class='tableRows'>
                    <td>$row[0]</td>

                    <td>$matchWinningPerc</td>
                    <td>$matchLosingPerc</td>

                    <td>$gameWinningPerc</td>
                    <td>$gameLosingPerc</td>

                    <td>$gameWinningMargin</td>
                    <td>$gameLosingMargin</td>";
        }

        ?>
        </tbody>
    </table>

    <button class="button btn btn-success backToLadder" onclick="toLogin()">Back to Ladder</button>

<?php else: ?>
    <div class="ladderError">
        <button class="goToLogin" onclick="toLogin()">Login</button>
        <button class="goToRegister" onclick="toRegister()">Register</button>

        <h4>You are not logged in</h4>
    </div>
<?php endif; ?>

</body>
</html>


