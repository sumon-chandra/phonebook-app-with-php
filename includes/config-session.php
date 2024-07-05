<?php

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);



session_set_cookie_params([
    'lifetime' => 1800 * 30, // 30 minute
    'path' => '/',
    'domain' => "localhost",
    'secure' => true, // false means HTTP only
    'httponly' => true, // true means client-side script can't access the session cookie
]);

session_start();

$url = basename($_SERVER['PHP_SELF']);
$query = $_SERVER['QUERY_STRING'];
if ($query) {
    $url .= "?" . $query;
}
$_SESSION['current_page'] = $url;

if (isset($_SESSION["user_id"])) {
    if (!isset($_SESSION["last_regeneration_time"])) {
        regenerate_session_id_loggedIn();
    } else {
        $interval = 60 * 30 * 24;
        if (time() - $_SESSION["last_regeneration_time"] >= $interval) {
            regenerate_session_id();
        }
    };
} else {
    if (!isset($_SESSION["last_regeneration_time"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30 * 24;
        if (time() - $_SESSION["last_regeneration_time"] >= $interval) {
            regenerate_session_id();
        }
    };
}

function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION["last_regeneration_time"] = time();
}
function regenerate_session_id_loggedIn()
{
    session_regenerate_id(true);
    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);

    $_SESSION["last_regeneration_time"] = time();
}
