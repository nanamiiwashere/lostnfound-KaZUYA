<?php
require_once './connect.php';
require_once './auth3thparty.php';
require_once './core/envPrivilege.php';

$stmt = $pdo->query("SELECT * FROM barang_temuan WHERE status='open' ORDER BY created_at DESC LIMIT 8");
$items = $stmt->fetchAll();

// Fetch news
$news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 3")->fetchAll();

// Stats
$totalLost  = $pdo->query("SELECT COUNT(*) FROM barang_temuan WHERE type='lost'")->fetchColumn();
$totalFound = $pdo->query("SELECT COUNT(*) FROM barang_temuan WHERE type='found'")->fetchColumn();
$resolved   = $pdo->query("SELECT COUNT(*) FROM barang_temuan WHERE status='resolved'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FindIt — Lost & Found Community</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="./style.css">
</head>
<body>

<!-- ══ NAVBAR ══ -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="<?= APP_URL ?>index.php">Find<span class="accent">It</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <i class="fas fa-bars" style="color:#e2e8f0;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="items.php">Browse Items</a></li>
        <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <?php if (isLoggedIn()):
              $u = currentUser(); ?>
          <!-- ✅ Logged in nav -->
          <a href="post-item.php" class="btn-nav-accent"><i class="fas fa-plus me-1"></i>Post Item</a>
          <div class="dropdown">
            <button class="btn-avatar dropdown-toggle" data-bs-toggle="dropdown">
              <?php if (!empty($u['avatar'])): ?>
                <img src="<?= htmlspecialchars($u['avatar']) ?>" class="avatar-img" alt=""/>
              <?php else: ?>
                <div class="avatar-initial"><?= strtoupper(substr($u['name'],0,1)) ?></div>
              <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-dark-custom">
              <li class="dropdown-header">
                <div class="fw-600 text-white small"><?= htmlspecialchars($u['name']) ?></div>
                <div style="font-size:.7rem;color:var(--muted);">
                  <?php $icons=['google'=>'fab fa-google','discord'=>'fab fa-discord','email'=>'fas fa-envelope']; ?>
                  <i class="<?= $icons[$u['provider']]??'fas fa-user' ?> me-1"></i><?= ucfirst($u['provider']) ?>
                </div>
              </li>
              <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,.08);"/></li>
              <li><a class="dropdown-item" href="dashboard/index.php"><i class="fas fa-th-large me-2"></i>Dashboard</a></li>
              <li><a class="dropdown-item" href="dashboard/my-items.php"><i class="fas fa-list me-2"></i>My Items</a></li>
              <li><a class="dropdown-item" href="dashboard/messages.php"><i class="fas fa-envelope me-2"></i>Messages</a></li>
              <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,.08);"/></li>
              <li><a class="dropdown-item text-danger-soft" href="auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
          </div>

        <?php else: ?>
          <!-- 🔒 Guest nav -->
          <a href="auth/login.php"    class="btn-nav-ghost">Login</a>
          <a href="auth/register.php" class="btn-nav-accent">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- ══ HERO ══ -->
<section class="hero">
  <div class="container position-relative">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="hero-tag mb-4">
          <span style="width:6px;height:6px;background:var(--accent);border-radius:50%;display:inline-block;"></span>
          Community Lost &amp; Found Platform
        </div>
        <h1 class="hero-title mb-4">
          Lost something?<br/><span class="accent">We'll find it.</span>
        </h1>
        <p class="hero-sub mb-5">
          Browse lost and found items from your community.
          <?php if (!isLoggedIn()): ?>
            Register free to report items or contact our staff.
          <?php else: ?>
            Post an item or contact staff from your dashboard.
          <?php endif; ?>
        </p>

        <!-- Search — PUBLIC, everyone can use -->
        <div class="search-bar mb-4">
          <input type="text" id="heroSearch" placeholder="Search lost keys, wallets, pets..."/>
          <button onclick="location.href='items.php?q='+document.getElementById('heroSearch').value">
            <i class="fas fa-search"></i>
          </button>
        </div>

        <!-- CTA — changes based on login state -->
        <div class="d-flex flex-wrap gap-3">
          <?php if (isLoggedIn()): ?>
            <!-- ✅ Logged in: can post -->
            <a href="post-item.php"         class="btn-primary-custom"><i class="fas fa-plus-circle"></i> Report Item</a>
            <a href="items.php?type=found"  class="btn-ghost-custom"><i class="fas fa-hand-holding"></i> Found Items</a>
          <?php else: ?>
            <!-- 🔒 Guest: explore only, nudge to register -->
            <a href="items.php"             class="btn-primary-custom"><i class="fas fa-search"></i> Explore Items</a>
            <a href="auth/register.php"     class="btn-ghost-custom"><i class="fas fa-user-plus"></i> Register to Post</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Stats -->
      <div class="col-lg-6">
        <div class="row g-3">
          <?php foreach([
            ['num'=>$totalLost,  'lbl'=>'Lost Items',    'icon'=>'fa-exclamation-circle','color'=>'#ef4444'],
            ['num'=>$totalFound, 'lbl'=>'Found Items',   'icon'=>'fa-hand-holding',      'color'=>'#22c55e'],
            ['num'=>$resolved,   'lbl'=>'Reunited',      'icon'=>'fa-handshake',         'color'=>'#f97316'],
            ['num'=>'24/7',      'lbl'=>'Staff Support', 'icon'=>'fa-headset',           'color'=>'#818cf8'],
          ] as $s): ?>
          <div class="col-6">
            <div class="p-4 rounded-3" style="background:var(--card);border:1px solid var(--border);">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width:40px;height:40px;background:<?= $s['color'] ?>18;flex-shrink:0;">
                  <i class="fas <?= $s['icon'] ?>" style="color:<?= $s['color'] ?>;"></i>
                </div>
                <div style="font-family:'Clash Display',sans-serif;font-size:1.8rem;font-weight:700;color:<?= $s['color'] ?>;">
                  <?= $s['num'] ?>
                </div>
              </div>
              <div style="font-size:.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;">
                <?= $s['lbl'] ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ RECENT ITEMS — PUBLIC ══ -->
<section class="py-5 mt-2">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <p style="color:var(--accent);font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Latest Activity</p>
        <h2 class="section-title mb-0">Recent Items</h2>
      </div>
      <a href="items.php" class="btn-ghost-custom py-2 px-4" style="font-size:.85rem;">View All <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <!-- Filter — PUBLIC -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
      <button class="filter-tab active" onclick="filterItems('all',this)">All Items</button>
      <button class="filter-tab" onclick="filterItems('lost',this)">
        <span style="background:#ef4444;width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:6px;"></span>Lost
      </button>
      <button class="filter-tab" onclick="filterItems('found',this)">
        <span style="background:#22c55e;width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:6px;"></span>Found
      </button>
    </div>

    <div class="row g-4" id="itemsGrid">
      <?php
      $demos = [
        ['title'=>'Black Leather Wallet', 'type'=>'lost',  'location'=>'Central Park',      'category'=>'Accessories', 'image'=>null,'id'=>1],
        ['title'=>'iPhone 15 Pro Max',    'type'=>'found', 'location'=>'Downtown Metro',    'category'=>'Electronics', 'image'=>null,'id'=>2],
        ['title'=>'Golden Retriever',     'type'=>'lost',  'location'=>'Riverside Park',    'category'=>'Pets',        'image'=>null,'id'=>3],
        ['title'=>'Blue Nike Backpack',   'type'=>'found', 'location'=>'City Library',      'category'=>'Bags',        'image'=>null,'id'=>4],
        ['title'=>'Toyota Car Keys',      'type'=>'lost',  'location'=>'Mall Parking B2',   'category'=>'Keys',        'image'=>null,'id'=>5],
        ['title'=>'Silver Bracelet',      'type'=>'found', 'location'=>'Beach Boardwalk',   'category'=>'Jewelry',     'image'=>null,'id'=>6],
        ['title'=>'Student ID Card',      'type'=>'found', 'location'=>'Campus Cafeteria',  'category'=>'Documents',   'image'=>null,'id'=>7],
        ['title'=>'Airpods Pro Case',     'type'=>'lost',  'location'=>'Coffee Shop',       'category'=>'Electronics', 'image'=>null,'id'=>8],
      ];
      $displayItems = empty($items) ? $demos : $items;
      $catIcons = ['Electronics'=>'fa-mobile-alt','Accessories'=>'fa-wallet','Pets'=>'fa-paw','Bags'=>'fa-shopping-bag','Keys'=>'fa-key','Jewelry'=>'fa-gem','Documents'=>'fa-id-card','Other'=>'fa-box'];

      foreach($displayItems as $item):
        $icon = $catIcons[$item['category']] ?? 'fa-box';
      ?>
      <div class="col-sm-6 col-lg-3 item-col" data-type="<?= $item['type'] ?>">
        <div class="item-card h-100" onclick="location.href='item-detail.php?id=<?= $item['id'] ?>'">
          <div class="item-card-img-wrap">
            <?php if (!empty($item['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($item['image']) ?>" class="item-card-img" alt=""/>
            <?php else: ?>
              <div class="img-placeholder">
                <i class="fas <?= $icon ?> fa-2x" style="color:rgba(255,255,255,.15);"></i>
              </div>
            <?php endif; ?>
            <span class="type-badge <?= $item['type'] ?>"><?= strtoupper($item['type']) ?></span>
          </div>

          <div class="item-card-body">
            <div class="item-cat"><?= htmlspecialchars($item['category']) ?></div>
            <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
            <div class="item-loc mb-3">
              <i class="fas fa-map-marker-alt"></i><?= htmlspecialchars($item['location']) ?>
            </div>

            <?php if (isLoggedIn()): ?>
              <!-- ✅ LOGGED IN: full action buttons -->
              <div class="d-flex gap-2">
                <a href="item-detail.php?id=<?= $item['id'] ?>"
                   class="btn btn-sm flex-grow-1 fw-600"
                   style="background:rgba(249,115,22,.15);color:var(--accent);border-radius:8px;border:1px solid rgba(249,115,22,.2);"
                   onclick="event.stopPropagation()">
                  View
                </a>
                <?php if ($item['type'] === 'found'): ?>
                  <a href="claim-item.php?id=<?= $item['id'] ?>"
                     class="btn btn-sm fw-600"
                     style="background:rgba(34,197,94,.12);color:#22c55e;border-radius:8px;border:1px solid rgba(34,197,94,.2);"
                     onclick="event.stopPropagation()">
                    Claim
                  </a>
                <?php else: ?>
                  <a href="contact-staff.php?ref=<?= $item['id'] ?>"
                     class="btn btn-sm fw-600"
                     style="background:rgba(129,140,248,.12);color:#818cf8;border-radius:8px;border:1px solid rgba(129,140,248,.2);"
                     onclick="event.stopPropagation()">
                    Help
                  </a>
                <?php endif; ?>
              </div>

            <?php else: ?>
              <!-- 🔒 GUEST: login gate — can still VIEW but can't act -->
              <div class="guest-gate">
                <a href="auth/login.php"    onclick="event.stopPropagation()">Login</a>
                or
                <a href="auth/register.php" onclick="event.stopPropagation()">Register</a>
                to claim or contact staff
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ NEWS — PUBLIC ══ -->
<section class="py-5" style="background:var(--surface);border-top:1px solid var(--border);">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
        <p style="color:var(--accent);font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Updates</p>
        <h2 class="section-title mb-0">Latest News</h2>
      </div>
      <a href="news.php" class="btn-ghost-custom py-2 px-4" style="font-size:.85rem;">All News <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-4">
      <?php
      $demoNews = [
        ['title'=>'New Drop-off Point at City Hall',   'body'=>'We have set up a new drop-off point for found items at City Hall, open weekdays 9am–5pm.',          'created_at'=>'2025-01-10'],
        ['title'=>'January: 47 Items Reunited!',        'body'=>'Thanks to our community, 47 lost items were successfully returned to their owners this month.',      'created_at'=>'2025-01-08'],
        ['title'=>'How to Improve Your Listing',        'body'=>'Adding a clear photo and exact location increases your chance of recovery by 3x. Read our guide.',   'created_at'=>'2025-01-05'],
      ];
      $displayNews = empty($news) ? $demoNews : $news;
      foreach($displayNews as $n): ?>
      <div class="col-md-4">
        <div class="news-card h-100">
          <div class="news-date mb-2"><i class="fas fa-calendar-alt me-1"></i><?= date('M j, Y', strtotime($n['created_at'])) ?></div>
          <div class="news-title"><?= htmlspecialchars($n['title']) ?></div>
          <div class="news-body"><?= htmlspecialchars(substr($n['body'],0,110)) ?>...</div>
          <a href="news.php" class="d-inline-flex align-items-center gap-1 mt-3"
             style="color:var(--accent);font-size:.82rem;font-weight:700;text-decoration:none;">
            Read more <i class="fas fa-arrow-right" style="font-size:.7rem;"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ CTA — only guests see this ══ -->
<?php if (!isLoggedIn()): ?>
<section class="py-5">
  <div class="container">
    <div class="cta-banner">
      <div class="mb-3" style="font-size:2.5rem;">🔍</div>
      <h2 class="section-title mb-3">Ready to report or claim an item?</h2>
      <p style="color:var(--muted);max-width:480px;margin:0 auto 1.5rem;">
        Create a free account to post lost items, claim found ones, and contact our staff directly.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="auth/register.php" class="btn-primary-custom"><i class="fas fa-user-plus"></i> Create Free Account</a>
        <a href="auth/login.php"    class="btn-ghost-custom"><i class="fas fa-sign-in-alt"></i> Already have one? Login</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ FOOTER ══ -->
<footer>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="navbar-brand mb-1">Find<span class="accent">It</span></div>
        <div style="color:var(--muted);font-size:.85rem;">Community Lost &amp; Found Platform</div>
      </div>
      <div class="col-md-4 text-center mb-3 mb-md-0">
        <div class="d-flex justify-content-center gap-3">
          <a href="items.php" style="color:var(--muted);font-size:.85rem;text-decoration:none;">Browse</a>
          <a href="news.php"  style="color:var(--muted);font-size:.85rem;text-decoration:none;">News</a>
          <a href="about.php" style="color:var(--muted);font-size:.85rem;text-decoration:none;">About</a>
          <?php if (!isLoggedIn()): ?>
          <a href="auth/login.php" style="color:var(--muted);font-size:.85rem;text-decoration:none;">Login</a>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4 text-md-end">
        <div style="color:var(--muted);font-size:.85rem;">© 2025 FindIt · PHP + Bootstrap + Tailwind</div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterItems(type, btn) {
  document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.item-col').forEach(col => {
    col.style.display = (type === 'all' || col.dataset.type === type) ? '' : 'none';
  });
}
</script>
</body>
</html>