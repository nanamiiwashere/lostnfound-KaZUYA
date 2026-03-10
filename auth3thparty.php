<?php
session_start();
require 'connect.php';

define('GOOGLE_CLIENT_ID', '');
define('GOOGLE_CLIENT_SECRET', '');
define('GOOGLE_REDIRECT_URI', 'http://localhost/lost_found/google_callback.php');

define('DISCORD_CLIENT_ID', '');
define('DISCORD_CLIENT_SECRET', '');
define('DISCORD_REDIRECT_URL', 'http://localhost/lost_found/discord_callback.php');

define('APP_URL', 'localhost/lost_found/');

function isLoggedIn():bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin():void {
    if (!isLoggedIn()) {
        header('Location: '. APP_URL . 'login.php');
        exit();
    }
}

function currentUser(): ?array{
    return $_SESSION['user_id'] ?? null;
}

function loginUser(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['logged_at'] = time();
}

function logoutUser(): void{
    session_unset();
    session_destroy();
    header('Location: '. APP_URL . 'index.php');
    exit;
}


