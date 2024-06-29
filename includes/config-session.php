<?php

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

session_set_cookie_params([
    'lifetime' => 1800, // 30 minute
    'path' => '/',
    'domain' => "localhost",
    'secure' => true, // false means HTTP only
    'httponly' => true, // true means client-side script can't access the session cookie
]);

session_start();

if (!isset($_SESSION["last_regeneration_time"])) {
    regenerate_session_id();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION["last_regeneration_time"] >= $interval) {
        regenerate_session_id();
    }
};

function regenerate_session_id()
{
    session_regenerate_id();
    $_SESSION["last_regeneration_time"] = time();
}
