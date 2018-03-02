/**
 * Created by gohar on 9/27/17.
 */
function toRegister() {
    window.location.href = '/userAuth/pages/register.php';
}

function goBack() {
    window.history.back();
}

function toLogin() {
    window.location.href = '/userAuth/pages/login.php';
}

function toHomePage() {
    window.location.href = '/index.php';
}

function logout() {
    window.location.href = '/index.php?logout=\'1\'';
}

function acceptedChallenge() {
    window.location.href = '/userAuth/pages/acceptedChallenge.php';
}

function toStats() {
    window.location.href = '/userAuth/pages/stats.php';
}

function toLadderDisplay(){
    window.location.href = '/userAuth/pages/ladderDisplay.php';
}