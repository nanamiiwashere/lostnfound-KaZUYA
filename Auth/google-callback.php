<?php

session_start();
require_once '../connect.php';
require_once '../Auth/auth3thparty.php';

$code = $_GET['code'] ?? '';
if (!$code) { 
    header('Location: login.php?error=oauth_failed'); 
    exit; 
    }

#exchange to access token
$tokenResponse = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded\r\n',
        'content' => http_build_query([
            'code' => $code,
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_url' => GOOGLE_REDIRECT_URL,
            'grant_type' => 'authorization_code',
        ]),
    ]
]));

$token = json_decode($tokenResponse, true);
if (empty($token['access_token'])){
    header('Location: login.php?error=exchange_failed');
    exit;
}

$userResponse = file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo', false, stream_context_create(['http' => [
    'header' => "Authorization: Bearer {$token['access_token']}\r\n"
    ]])
);

$googleUser = json_decode($userResponse, true);

if (empty($googleUser['email'])){
    header('Location: login.php?error=no_email');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt -> execute([$googleUser[$email]]);
$user = $stmt -> fetch();

if (!user){
    $stmt = $pdo -> prepare(
        "INSERT INTO users (nama, email, avatar, oauth_provider, oauth_uid)
        VALUES (?, ?, ?, 'google', ?)"
    );

    $stmt -> execute([$googleUser['email'], $googleUser['email'], $googleUser['picture'] ?? null, $googleUser['id']]);
    $stmt = $pdo -> prepare("SELECT * FROM users WHERE id_user = ?");
    $stmt -> execute([$pdo -> lastInsertId()]);
    $user = $stmt -> fetch();
} else {
    $pdo -> prepare("UPDATE users SET avatar = ?, oauth_provider = ?, WHERE id_user = ?")
         -> execute([$googleUser['picture'] ?? null, $googleUser['id'], $user['id_user']]);
}

loginUser($user);
header('Location: ../dashboard/index.php');
exit;
?>