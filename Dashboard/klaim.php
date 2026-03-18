<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../connect.php';
require_once '../Auth/auth3thparty.php';
requireLogin();
$u = currentUser();
$activePage = 'klaim';

$stmt = $pdo -> prepare("SELECT bt. * FROM barang_temuan bt 
    WHERE bt.type='found' AND bt.status='open'
    ORDER BY bt.created_at DESC
    LIMIT 20");

$stmt -> execute();
$items = $stmt -> fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Klaim — LostnFound</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={corePlugins:{preflight:false}}</script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../dashboard/partials/style.css"/>
</head>
<body>
<?php require_once 'partials/sidebar.php'; ?>
 
<div class="main-wrap">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button onclick="document.getElementById('sidebar').classList.toggle('open')" class="d-lg-none" style="background:none;border:none;color:#e2e8f0;font-size:1.1rem;padding:0;cursor:pointer;"><i class="fas fa-bars"></i></button>
      <span style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;">Riwayat Klaim</span>
    </div>
    <a href="barang-temuan.php" class="btn-accent"><i class="fas fa-search"></i>Cari Barang</a>
  </div>
 
  <div class="page-content">
    <div class="p-4 rounded-3 mb-4" style="background:rgba(129,140,248,.06);border:1px solid rgba(129,140,248,.15);">
      <div style="color:#818cf8;font-weight:700;font-size:.88rem;margin-bottom:4px;"><i class="fas fa-info-circle me-2"></i>Cara Klaim Barang</div>
      <div style="color:#64748b;font-size:.82rem;">Temukan barang yang cocok di halaman Barang Temuan, klik "Lihat Detail & Klaim", lalu hubungi petugas untuk proses verifikasi kepemilikan.</div>
    </div>
 
    <div class="dash-card">
      <div class="dash-card-header">
        <div class="dash-card-title">Barang Temuan Tersedia untuk Diklaim</div>
      </div>
      <?php if (empty($items)): ?>
        <div class="empty-state">
          <i class="fas fa-hand-holding"></i>
          Belum ada barang temuan yang tersedia.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="dash-table">
            <thead>
              <tr><th>Nama Barang</th><th>Kategori</th><th>Lokasi Ditemukan</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
              <?php foreach($items as $item): ?>
              <tr>
                <td style="color:#fff;font-weight:600;"><?= htmlspecialchars($item['nama_barang']) ?></td>
                <td><span class="bdg" style="background:rgba(255,255,255,.06);color:#94a3b8;border:1px solid rgba(255,255,255,.08);"><?= htmlspecialchars($item['category']??'Other') ?></span></td>
                <td style="color:#64748b;font-size:.82rem;"><?= htmlspecialchars($item['lokasi_ditemukan']) ?></td>
                <td style="color:#64748b;font-size:.8rem;"><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                <td>
                  <a href="../item-detail.php?id=<?= $item['id_barang'] ?>" class="btn-accent" style="font-size:.78rem;padding:5px 12px;"><i class="fas fa-eye"></i>Klaim</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>