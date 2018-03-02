<?php
/**
 * Created by PhpStorm.
 * User: grobert14
 * Date: 11/7/2017
 * Time: 9:28 AM
 */

//Check for session timeout
if (time() - ($_SESSION['timeout'] ) >= 300)
{
    session_unset('username');
    $_SESSION['errorMessage'] = "Session Timed Out";
    header("Location: /userAuth/error/error.php");
}
else
{
    $_SESSION['timeout'] = time();
}
?>

<div class="ladderNav">
    <form action="/userAuth/server/user.php" method="POST">

        <button type="button" class="btn btn-primary accountModalButton" data-toggle="modal" data-target="#accountModal">
            <i class="fa fa-user fa-fw" aria-hidden="true"></i>
            Account
        </button>

        <button type="submit" class="btn btn-primary logout logoutBigWindow" onclick="logout()" name="logout">Logout</button>
    </form>

</div>

<!-- Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $_SESSION['name']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Account Information
                <br>
                <br>
                <b>Email: </b>
                <?php
                echo $_SESSION['email'];
                ?>
                <br>
                <b>Username: </b>
                <?php
                echo $_SESSION['username'];
                ?>
                <br>
                <b>Rank: </b>
                <?php
                echo $_SESSION['rank'];
                ?>
            </div>
            <div class="modal-footer">

                <form action="/userAuth/server/user.php" method="POST">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteUserModal">
                        <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                        Delete User
                    </button>
                    <button type="submit" class="btn btn-primary logout" onclick="logout()" name="logout">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/userAuth/server/user.php" onsubmit="return passwordValidation(this);" method="POST">
                <div class="modal-body">
                    Are you sure you want to delete your profile?

                    <br>

                    This will delete the user from the players list and you will not be able to login again.
                    <br>
                    <h5>Re-enter Password: </h5>
                    <input class="userInfo" id="password" name="password" type="password" />
                </div>
                <div class="modal-footer">


                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary logout" name="deleteUser">Yes, I'm Sure.</button>

                </div>
            </form>
        </div>
    </div>
</div>
