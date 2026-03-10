<?php

session_start();
require_once '../connect.php';
require_once '../auth3thparty.php';

$code  = $_GET['code'] ?? '';
if (!$code) {
    header('Location: login.php?error=oauth_failed');
    exit;
}

#exchange token
$tokenResponse = file_get_contents('https://discord.com/api/oauth2/token', false, stream_context_create(['http' => [
    'method' => 'POST',
    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
    'content' => http_build_query([
        'client_id' => DISCORD_CLIENT_ID,
        'client_secret' => DISCORD_CLIENT_SECRET,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => DISCORD_REDIRECT_URL
        ]),
    ]])
);

$token = json_decode($tokenResponse, true);
if (empty($token['access_token'])){
    header('Location: login.php?error=exchange_failed');
    exit;
}

$userResponse = file_get_contents('https://discord.com/api/users/@me', false, stream_context_create(['http' => [
    'method' => 'GET',
    'header' => "Authorization: Bearer {$token['access_token']}\r\n",
    ]])
);

$discordUser = json_decode($userResponse, true);

if (empty($discordUser['email'])){
    header('Location: login.php?error=no_email');
    exit;
}

$avatar = $discordUser['avatar']
    ? "https://cdn.discordapp.com/avatars/{$discordUser['id']}/{$discordUser['avatar']}.png"
    : "https://cdn.discordapp.com/embed/avatars/0.png";

$name  = $discordUser['global_name'] ?? $discordUser['username'];

$stmt = $pdo

?>