<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../connect.php';
require_once '../Auth/auth3thparty.php';
requireLogin();

$u = currentUser();
$activePage = 'laporan';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: laporan.php');
    exit();
}

$stmt = $pdo -> prepare("SELECT * FROM laporan_kehilangan WHERE id_laporan=? AND id_pelapor=?");
$stmt -> execute([$id, $u['id']]);
$item = $stmt -> fetch();
if (!$item){
    header('Location: laporan.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['konfirmasi'])){
    $pdo -> prepare("UPDATE laporan_kehilangan SET status='resolved' WHERE id_laporan=? AND id_pelapor=?") -> execute([$id, $u['id']]);
    header("Location: detail-laporan.php?id=$id&confirmed=1");
    exit();
}

$confirmed = isset($_GET['confirmed']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Laporan — LostnFound</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={corePlugins:{preflight:false}}</script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../dashboard/partials/style.css">
</head>
<body>
<?php require_once 'partials/sidebar.php'; ?>
 
<div class="main-wrap">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button onclick="document.getElementById('sidebar').classList.toggle('open')" class="d-lg-none" style="background:none;border:none;color:#e2e8f0;font-size:1.1rem;padding:0;cursor:pointer;"><i class="fas fa-bars"></i></button>
      <div>
        <a href="laporan.php" style="color:#64748b;font-size:.82rem;text-decoration:none;"><i class="fas fa-arrow-left me-1"></i>Laporan Saya</a>
        <span style="color:#334155;margin:0 6px;">/</span>
        <span style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;">Detail Laporan</span>
      </div>
    </div>
    <?php if ($item['status']==='open'): ?>
      <a href="edit-laporan.php?id=<?= $id ?>" class="btn-accent" style="background:rgba(129,140,248,.15);color:#818cf8;border:1px solid rgba(129,140,248,.2);"><i class="fas fa-edit"></i>Edit</a>
    <?php endif; ?>
  </div>
 
  <div class="page-content">
    <?php if ($confirmed): ?>
      <div class="alert-success mb-4"><i class="fas fa-check-circle me-2"></i>Kepemilikan dikonfirmasi! Status laporan diupdate menjadi Resolved.</div>
    <?php endif; ?>
 
    <div class="row g-4">
      <!-- Info utama -->
      <div class="col-lg-8">
        <div class="dash-card p-4 mb-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <h4 style="font-family:'Clash Display',sans-serif;color:#fff;margin:0;"><?= htmlspecialchars($item['nama_barang']) ?></h4>
              <div class="mt-2 d-flex gap-2 flex-wrap">
                <span class="bdg bdg-<?= $item['type'] ?>"><?= strtoupper($item['type']) ?></span>
                <span class="bdg bdg-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span>
                <span class="bdg" style="background:rgba(255,255,255,.06);color:#94a3b8;border:1px solid rgba(255,255,255,.08);"><?= htmlspecialchars($item['category']??'Other') ?></span>
              </div>
            </div>
          </div>
 
          <?php if (!empty($item['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" class="w-100 rounded-3 mb-3" style="max-height:280px;object-fit:cover;" alt="foto barang"/>
          <?php endif; ?>
 
          <div class="row g-3">
            <div class="col-sm-6">
              <div style="color:#64748b;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Deskripsi</div>
              <div style="color:#e2e8f0;font-size:.9rem;"><?= nl2br(htmlspecialchars($item['deskripsi']??'Tidak ada deskripsi')) ?></div>
            </div>
            <div class="col-sm-6">
              <div style="color:#64748b;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Lokasi</div>
              <div style="color:#e2e8f0;font-size:.9rem;"><i class="fas fa-map-marker-alt me-1" style="color:#f97316;"></i><?= htmlspecialchars($item['lokasi_kehilangan']) ?></div>
            </div>
            <div class="col-sm-6">
              <div style="color:#64748b;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Tanggal Kejadian</div>
              <div style="color:#e2e8f0;font-size:.9rem;"><i class="fas fa-calendar me-1" style="color:#f97316;"></i><?= date('d F Y', strtotime($item['tanggal_kehilangan'])) ?></div>
            </div>
            <div class="col-sm-6">
              <div style="color:#64748b;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">Dilaporkan</div>
              <div style="color:#e2e8f0;font-size:.9rem;"><i class="fas fa-clock me-1" style="color:#f97316;"></i><?= date('d F Y, H:i', strtotime($item['created_at'])) ?></div>
            </div>
          </div>
        </div>
      </div>
 
      <!-- Status & aksi -->
      <div class="col-lg-4">
        <!-- Status tracker -->
        <div class="dash-card p-4 mb-4">
          <div style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;margin-bottom:1rem;">Status Perkembangan</div>
          <?php
          $isFound     = $item['type'] === 'found';
          $isResolved  = in_array($item['status'], ['resolved', 'closed']);
          $isProcessed = $item['status'] !== 'open';
          $itemFound   = $isFound || $isResolved; // found by type OR sudah resolved/closed
 
          $steps = [
            ['label'=>'Laporan Dibuat',           'done'=> true,         'icon'=>'fa-file-alt'],
            ['label'=>'Diproses Petugas',          'done'=> $isProcessed, 'icon'=>'fa-user-tie'],
            ['label'=>'Barang Ditemukan',          'done'=> $itemFound,   'icon'=>'fa-box-open'],
            ['label'=>'Kepemilikan Dikonfirmasi',  'done'=> $isResolved,  'icon'=>'fa-check-double'],
          ];
          foreach($steps as $i => $step): ?>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:34px;height:34px;background:<?= $step['done']?'rgba(34,197,94,.15)':'rgba(255,255,255,.06)' ?>;border:1px solid <?= $step['done']?'rgba(34,197,94,.3)':'rgba(255,255,255,.08)' ?>;">
              <i class="fas <?= $step['icon'] ?>" style="font-size:.75rem;color:<?= $step['done']?'#22c55e':'#475569' ?>;"></i>
            </div>
            <div style="color:<?= $step['done']?'#e2e8f0':'#475569' ?>;font-size:.85rem;font-weight:<?= $step['done']?'600':'400' ?>;">
              <?= $step['label'] ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
 
        <!-- Konfirmasi kepemilikan -->
        <?php if ($item['status']==='open'): ?>
        <div class="dash-card p-4" style="border-color:rgba(34,197,94,.2);">
          <div style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;margin-bottom:.8rem;">Barang Sudah Ditemukan?</div>
          <div style="color:#64748b;font-size:.82rem;margin-bottom:1rem;">Jika barang kamu sudah ditemukan dan dikembalikan, konfirmasi kepemilikan untuk menutup laporan ini.</div>
          <form method="POST">
            <input type="hidden" name="konfirmasi" value="1"/>
            <button type="submit" class="btn-accent w-100" style="background:rgba(34,197,94,.15);color:#22c55e;border:1px solid rgba(34,197,94,.3);justify-content:center;" onclick="return confirm('Konfirmasi barang sudah diterima?')">
              <i class="fas fa-check-circle"></i>Konfirmasi Kepemilikan
            </button>
          </form>
        </div>
        <?php elseif (in_array($item['status'], ['resolved','closed'])): ?>
        <div class="dash-card p-4" style="background:rgba(34,197,94,.05);border-color:rgba(34,197,94,.2);">
          <div class="text-center">
            <i class="fas fa-check-circle fa-2x mb-2" style="color:#22c55e;display:block;"></i>
            <div style="color:#22c55e;font-weight:700;">Laporan Selesai</div>
            <div style="color:#64748b;font-size:.82rem;margin-top:4px;">Kepemilikan sudah dikonfirmasi</div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>