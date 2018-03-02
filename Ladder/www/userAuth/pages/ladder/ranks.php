<?php
/**
 * Created by PhpStorm.
 * User: grobert14
 * Date: 11/2/2017
 * Time: 10:27 PM
 */
?>

<script src="../javascript/date.js"></script>

<table class="table ladderTable table-hover">
    <thead class='tableHead'>
    <tr>
        <th class="rankTD">Rank</th>
        <th>Name</th>
        <th>Challenge</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sqlChallenges = "select p1.username as challenger,  p2.username as challengee1,  p3.username as challengee2, p4.username as challenge3 
                              from player p1 
                              left outer join 
                              (select username, rank from player as t1 left outer join challenge as c1 on t1.username = c1.challenger or t1.username = c1.challengee where accepted is null) p2 on p2.rank = (p1.rank-1) 
                              left outer join 
                              (select username, rank from player as t2 left outer join challenge as c2 on t2.username = c2.challenger or t2.username = c2.challengee where accepted is null) p3 on p3.rank = (p1.rank-2) 
                              left outer join 
                              (select username, rank from player as t3 left outer join challenge as c3 on t3.username = c3.challenger or t3.username = c3.challengee where accepted is null) p4 on p4.rank = (p1.rank-3) 
                              where p1.username = '$username' and p1.username not in (select username from player left outer join challenge on username = challenger or username = challengee where accepted is not null) 
                              order by p1.rank asc";
    $resultChallenge = pg_query($dbconn, $sqlChallenges);
    $checkChallenges = pg_fetch_row($resultChallenge);

    $players = "select name, rank, username from player order by rank asc";
    $ranking = pg_query($dbconn, $players);

    $checkChallengeSent = "select challengee from challenge where challenger = '$username' and accepted is null";
    $checkChallengeSentQuery = pg_query($dbconn, $checkChallengeSent);
    $challengesSent = pg_fetch_all_columns($checkChallengeSentQuery);

    $checkChallengeReceived = "select challenger from challenge where challengee = '$username' and accepted is null";
    $checkChallengeReceivedQuery = pg_query($dbconn, $checkChallengeReceived);
    $challengesReceived = pg_fetch_all_columns($checkChallengeReceivedQuery);

    if ($ranking > 0) {
        $counter=1;
        while ($row = pg_fetch_row($ranking)) {
            echo "<tr class='tableRows'>
                            <td class='rankTD'>$row[1]</td>
                            
                            <td>$row[0]</td>";



            if(in_array($row[2], $challengesSent) && $row[2] != $username)
            {
                echo "<td><button class=\"btn btn-secondary acceptancePending\" >Waiting Acceptance</button></td>";
            }

            elseif(in_array($row[2], $challengesReceived) && $row[2] != $username)
            {
                echo "<td><button title = \"You have a challenge!\" type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#challengeReceivedModal".$row[2]."\">
                                  <i class=\"fa fa-telegram fa-fw\" aria-hidden=\"true\"></i>
                                </button>
                                <div id=\"challengeReceivedModal".$row[2]."\" class=\"modal fade\" role=\"dialog\">
                                  <div class=\"modal-dialog\">
                                
                                    <!-- Modal content-->
                                    <div class=\"modal-content\">
                                      <div class=\"modal-header\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                      </div>
                                      <div class=\"modal-body\">";
                echo "<p><b>Challenge Sent By: </b>" . $row[0];
                echo "</p>";
                echo "<p><b>Rank: </b>". $row[1];
                echo"</p>";
                echo"<form action=\"/userAuth/server/user.php\" method=\"POST\">";
                echo "<b>Challenge Scheduled:</b> <br>";
                $scheduleTime = "select scheduled from challenge where challengee = '$username' and challenger='$row[2]' and accepted is null;";
                $time = pg_fetch_all_columns(pg_query($dbconn, $scheduleTime));
                echo"$time[0]";
                echo"<input name=\"challengerUsername\" value='$row[2]' style='display:none;'>";
                echo"<input name=\"challengerName\" value='$row[0]' style='display:none;'><br><br>";
                echo"<button type=\"submit\" class=\"btn btn-primary\" name=\"acceptChallenge\">Accept Challenge</button>
                                        <button type=\"submit\" class=\"btn btn-danger\" name=\"rejectChallenge\">Reject Challenge</button>
                                        </form>";
                echo"</div> <div class=\"modal-footer\">";
                echo"<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button> 
                                      </div>
                                    </div>
                                
                                  </div>
                                </div></td>";
            }

            elseif(in_array($row[2], $checkChallenges) && $counter != 4 && $row[2] != $username)
            {
                echo "<td>
                                <button type=\"button\" title = \"Challenge this player!\" class=\"btn btn-primary challengeModalButton\" data-toggle=\"modal\" data-target=\"#challengeModal".$row[2]."\">
                                  <i class=\"fa fa-superpowers fa-fw\" aria-hidden=\"true\"></i>
                                </button>
                                <div id=\"challengeModal".$row[2]."\" class=\"modal fade\" role=\"dialog\">
                                  <div class=\"modal-dialog\">
                                
                                    <!-- Modal content-->
                                    <div class=\"modal-content\">
                                      <div class=\"modal-header\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                      </div>
                                      <div class=\"modal-body\">";
                echo "<p><b>Challenge: </b>" . $row[0];
                echo "</p>";
                echo "<p><b>Rank: </b>". $row[1];
                echo"</p>";
                echo"<form action=\"/userAuth/server/user.php\" method=\"POST\" onsubmit=\"return dateValidation(this);\">";
                $time = date('Y-m-d H:i:s', strtotime("+7 day"));
                echo "Challenge Scheduled: <br>";
                echo"<input name=\"personChallengeTimeSchedule\" value='$time' class='userInfo' id='challengeDateTime'>";
                echo"<input name=\"personChallengedusername\" value='$row[2]' style='display:none;'>";
                echo"<input name=\"personChallengedname\" value='$row[0]' style='display:none;'><br><br>";
                echo"<button type=\"submit\" class=\"btn btn-primary sendChallenge\" name=\"challenge\">Send Challenge</button>
                                        </form>";
                echo"</div>
                                      <div class=\"modal-footer\">";
                echo"<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>        
                                      </div>
                                    </div>
                                
                                  </div>
                                </div>
                              </td>";
            }

            elseif((isset($_SESSION['challenger']) && isset($_SESSION['challengee'])) && $_SESSION['challenger'] == $row[2] || ((isset($_SESSION['challenger']) && isset($_SESSION['challengee']))) && $_SESSION['challengee'] == $row[2]) {
                if ($row[2] != $username) {
                    echo "<td><button class=\"btn btn-info\" onclick=\"acceptedChallenge()\"><i class=\"fa fa-bell-o fa-fw\" aria-hidden=\"true\"></i>Challenge Pending</button></td>";
                    echo "<script>
                                function acceptedChallenge() {
                                           window.location.href = '/userAuth/pages/acceptedChallenge.php';
                                            }</script>";
                } else {
                    echo "<td></td>";
                }
            }

            else {

                echo "<td></td>";
            }
            echo "</tr>";
            $counter++;
        }
    }

    else
    {
        echo "No Results";
    }
    ?>
    </tbody>
</table>

