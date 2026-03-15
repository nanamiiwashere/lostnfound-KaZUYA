<?php
require_once './connect.php';
require_once './Auth/auth3thparty.php';
require_once './Auth/auth-handler.php';

if (isLoggedIn()){
    header('Location: ' . APP_URL . '/dashboard/index.php');
    exit();
}

$googleUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' .http_build_query([
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid email profile',
]);

$discordUrl = 'https://discord.com/api/oauth2/authorize?' . http_build_query([
    'client_id' => DISCORD_CLIENT_ID,
    'redirect_uri' => DISCORD_REDIRECT_URL,
    'response_type' => 'code',
    'scope' => 'openid email profile',
]);

$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pw = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$nama || !$email || !$pw || !$confirm){
      $error = ' All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error = ' Invalid email format.';
    } elseif (strlen($pw) < 8){
      $error = 'Password must be at least 8 characters.';
    } elseif ($pw !== $confirm) {
      $error = '  Password do not match.';
    } else {
      $chk = $pdo -> prepare("SELECT id_user FROM users WHERE email = ?");
      $chk -> execute([$email]);
      if ($chk -> fetch()){
        $error = 'Email already registered. <a href="login.php" style="color:#f97316;">Sign in?</a>';
      } else {
        $pdo -> prepare("INSERT INTO users (nama, email, password, oauth_provider, role) VALUES (?, ?, ?, 'email', 'user')")
          -> execute([$nama, $email, password_hash($pw, PASSWORD_BCRYPT)]);
          $stmt = $pdo -> prepare("SELECT * FROM users WHERE email = ?");
          $user = $stmt -> fetch();
          if ($user){
            loginUser($user);
            header ('Location: ' . APP_URL . 'dashboard/index.php');
            exit();
          }

           $success = 'Account created! You can now login.';
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - LostnFound</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
 
<div class="login-wrapper">
<div class="login-card">
 
  <div class="text-center mb-4">
    <a href="../index.php" class="text-decoration-none">
      <div style="font-family:'Clash Display',sans-serif;font-weight:700;font-size:2rem;color:#fff;letter-spacing:-.02em;">
        Lostn<span style="color:#f97316;">Found</span>
      </div>
    </a>
    <p style="color:#64748b;font-size:.88rem;margin-top:6px;">Create your free account.</p>
  </div>
 
  <?php if ($error):   ?><div class="auth-alert-err mb-3"><i class="fas fa-exclamation-circle"></i><span><?= $error ?></span></div><?php endif; ?>
  <?php if ($success): ?><div class="auth-alert-ok  mb-3"><i class="fas fa-check-circle"></i><span><?= $success ?></span></div><?php endif; ?>
 
  <a href="<?= $googleUrl ?>" class="oauth-btn mb-3">
    <img src="https://developers.google.com/identity/images/g-logo.png" width="18" alt=""/>
    Sign up with Google
  </a>
  <a href="<?= $discordUrl ?>" class="oauth-btn discord mb-4">
    <i class="fab fa-discord" style="color:#5865f2;font-size:1.1rem;"></i>
    Sign up with Discord
  </a>
 
  <div class="divider mb-4">or register with email</div>
 
  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-lbl">Full Name</label>
      <input type="text" name="nama" class="form-inp" placeholder="John Doe"
             value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required/>
    </div>
    <div class="mb-3">
      <label class="form-lbl">Email</label>
      <input type="email" name="email" class="form-inp" placeholder="you@example.com"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required/>
    </div>
    <div class="mb-3">
      <label class="form-lbl">Password</label>
      <input type="password" name="password" id="pwInput" class="form-inp" placeholder="Min. 8 characters" required/>
      <div class="pw-track"><div class="pw-fill" id="pwFill"></div></div>
      <div id="pwLabel" style="font-size:.72rem;margin-top:4px;color:#64748b;min-height:16px;"></div>
    </div>
    <div class="mb-4">
      <label class="form-lbl">Confirm Password</label>
      <input type="password" name="confirm" id="confirmInput" class="form-inp" placeholder="Re-enter password" required/>
      <div id="matchHint" style="font-size:.72rem;margin-top:4px;min-height:16px;"></div>
    </div>
    <button type="submit" class="btn-login mb-3">
      <i class="fas fa-user-plus me-2"></i>Create Account
    </button>
  </form>
 
  <p class="text-center mb-0" style="color:#64748b;font-size:.85rem;">
    Already have an account?
    <a href="login.php" style="color:#f97316;font-weight:700;text-decoration:none;">Sign in</a>
  </p>
 
</div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const pwInput = document.getElementById('pwInput');
const pwFill  = document.getElementById('pwFill');
const pwLabel = document.getElementById('pwLabel');
const colors  = ['#ef4444','#ef4444','#f97316','#eab308','#22c55e'];
const labels  = ['','Weak','Fair','Good','Strong'];
 
pwInput.addEventListener('input', function() {
  const v = this.value; let s = 0;
  if (v.length >= 8)           s++;
  if (/[A-Z]/.test(v))         s++;
  if (/[0-9]/.test(v))         s++;
  if (/[^A-Za-z0-9]/.test(v))  s++;
  pwFill.style.width = (s*25)+'%'; pwFill.style.background = colors[s];
  pwLabel.textContent = labels[s]; pwLabel.style.color = colors[s];
  checkMatch();
});
 
const confirmInput = document.getElementById('confirmInput');
const matchHint    = document.getElementById('matchHint');
function checkMatch() {
  if (!confirmInput.value) { matchHint.textContent=''; return; }
  if (pwInput.value === confirmInput.value) {
    matchHint.textContent='✓ Passwords match'; matchHint.style.color='#22c55e';
  } else {
    matchHint.textContent='✗ Do not match'; matchHint.style.color='#ef4444';
  }
}
confirmInput.addEventListener('input', checkMatch);
</script>
</body>
</html>