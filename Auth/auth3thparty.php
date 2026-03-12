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
    if (!isLoggedIn()) return null;
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'name' => $_SESSION['name'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'provider' => $_SESSION['provider'] ?? 'email',
        'avatar' => $_SESSION['avatar'] ?? null,
    ];
}

function loginUser(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id_user'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['provider'] = $user['oauth_provider'] ?? 'email';
    $_SESSION['avatar'] = $user[avatar] ?? null;
    $_SESSION['logged_at'] = time();
}

function logoutUser(): void{
    session_unset();
    session_destroy();
    header('Location: '. APP_URL . 'index.php');
    exit;
}


