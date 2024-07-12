<?php 
$isLoggedIn = (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']);
$isAdmin = (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin']);
// $_SESSION["CookiesAccepted"] = null;

if (isset($_POST["CookieAccept"])) {
    // They accepted the cookies
    $_SESSION["CookiesAccepted"] = true;
    // Remember accepted cookies for one year
    setcookie("CookiesAccepted", true, expires_or_options:time()+60*60*24*365, httponly: true); // HTTP-only cookies to avoid having cookies stolen in JavaScript
    header('Refresh: 0');
} else if (isset($_POST["CookieReject"])) {
    $_SESSION["CookiesAccepted"] = false;
}

$showCookiesPopup = true;
if (isset($_COOKIE['CookiesAccepted']) && $_COOKIE['CookiesAccepted']) {
    if ($_COOKIE["CookiesAccepted"]) {
        $showCookiesPopup = false;
    }
} elseif (isset($_SESSION["CookiesAccepted"])) {
    if ($_SESSION["CookiesAccepted"]) {
        $showCookiesPopup = false;
    } elseif ($currentPage == 'Account') {
        $showCookiesPopup = true;
    } else {
        $showCookiesPopup = false;
    }
}

include('templates/Layout.html.php');
?>