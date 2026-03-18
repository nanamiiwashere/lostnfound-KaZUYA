<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../connect.php';
require_once '../Auth/auth3thparty.php';

requireLogin();
if(($_SESSION['role']??'')!=='staff'){header('Location: index.php');exit();}

$u = currentUser();
$activePage = 's-laporan';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_laporan'])) {
    $id     = (int)$_POST['id_laporan'];
    $status = $_POST['status'];
    $type   = $_POST['type'];
    $validStatus = ['open','resolved','closed'];
    $validType   = ['lost','found'];
    if (in_array($status, $validStatus) && in_array($type, $validType)) {
        $pdo->prepare("UPDATE laporan_kehilangan SET status=?, type=? WHERE id_laporan=?")
            ->execute([$status, $type, $id]);
    }
    header("Location: staff-laporan.php?updated=1");
    exit();
}

$filterStatus = $_GET['status'] ?? '';
$filterType   = $_GET['type']   ?? '';
$search       = trim($_GET['q'] ?? '');

$where  = ["1=1"];
$params = [];
if ($filterStatus) { $where[] = "l.status=?";      $params[] = $filterStatus; }
if ($filterType)   { $where[] = "l.type=?";         $params[] = $filterType; }
if ($search)       { $where[] = "(l.nama_barang LIKE ? OR l.lokasi_kehilangan LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }
$whereSQL = implode(' AND ', $where);

$statTotal = (int)$pdo -> query("SELECT COUNT(*) FROM laporan_kehilangan") -> fetchColumn();
$statOpen = (int)$pdo -> query("SELECT COUNT(*) FROM laporan_kehilangan WHERE status='open'") -> fetchColumn();
$statResolved = (int)$pdo ->query("SELECT COUNT(*) FROM laporan_kehilangan WHERE status='resolved' OR status='closed'") -> fetchColumn();

$laporan = $pdo->prepare("SELECT l.*, u.nama AS nama_pelapor FROM laporan_kehilangan l LEFT JOIN users u ON l.id_pelapor=u.id_user WHERE $whereSQL ORDER BY l.created_at DESC");
$laporan->execute($params);
$items = $laporan->fetchAll();

$updated = isset($_GET['updated']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Laporan Kehilangan — Staff</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="partials/style.css">
</head>
<body>
<?php require_once 'partials/sidebar.php'; ?>
<div class="main-wrap">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
    <div>
        <span style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;">Laporan Kehilangan</span>
        <span style="color:#64748b;font-size:.82rem;margin-left:8px;">Halo, <?= htmlspecialchars(strtok($u['name']??'User',' ')) ?>!</span>
      </div>
      <button onclick="document.getElementById('sidebar').classList.toggle('open')" class="d-lg-none" style="background:none;border:none;color:#e2e8f0;font-size:1.1rem;padding:0;cursor:pointer;"><i class="fas fa-bars"></i></button>
    </div>
  </div>

  <div class="page-content">
    <!--stats-->
        <div class="row g-3 mb-4">
      <div class="col-6 col-xl-4">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(249,115,22,.12);"><i class="fas fa-file-alt" style="color:#f97316;"></i></div>
          <div>
            <div class="stat-num" style="color:#f97316;"><?= $statTotal ?></div>
            <div class="stat-lbl">Total Laporan</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-4">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(129,140,248,.12);"><i class="fas fa-clock" style="color:#818cf8;"></i></div>
          <div>
            <div class="stat-num" style="color:#818cf8;"><?= $statOpen ?></div>
            <div class="stat-lbl">Masih Open</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-4">
        <div class="stat-card">
          <div class="stat-icon" style="background:rgba(34,197,94,.12);"><i class="fas fa-check-circle" style="color:#22c55e;"></i></div>
          <div>
            <div class="stat-num" style="color:#22c55e;"><?= $statResolved ?></div>
            <div class="stat-lbl">Selesai</div>
          </div>
        </div>
      </div>
    </div>
 

    <?php if ($updated): ?>
      <div class="alert-success mb-4"><i class="fas fa-check-circle me-2"></i>Laporan berhasil diupdate.</div>
    <?php endif; ?>
    <form method="GET" class="dash-card p-3 mb-4">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="form-input" placeholder="Cari nama barang / lokasi…" style="padding:9px 14px;"/>
        </div>
        <div class="col-auto">
          <select name="status" class="form-input" style="padding:9px 14px;width:auto;">
            <option value="">Semua Status</option>
            <option value="open"     <?= $filterStatus==='open'?'selected':'' ?>>Open</option>
            <option value="resolved" <?= $filterStatus==='resolved'?'selected':'' ?>>Resolved</option>
            <option value="closed"   <?= $filterStatus==='closed'?'selected':'' ?>>Closed</option>
          </select>
        </div>
        <div class="col-auto">
          <select name="type" class="form-input" style="padding:9px 14px;width:auto;">
            <option value="">Semua Tipe</option>
            <option value="lost"  <?= $filterType==='lost'?'selected':'' ?>>Lost</option>
            <option value="found" <?= $filterType==='found'?'selected':'' ?>>Found</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn-accent" style="padding:9px 18px;"><i class="fas fa-search"></i>Filter</button>
        </div>
        <?php if ($filterStatus||$filterType||$search): ?>
        <div class="col-auto">
          <a href="staff-laporan.php" class="btn-ghost-sm">Reset</a>
        </div>
        <?php endif; ?>
      </div>
    </form>

    <div class="dash-card">
      <div class="dash-card-header">
        <span class="dash-card-title"><i class="fas fa-file-alt me-2" style="color:#f87171;"></i>Semua Laporan <span style="color:#64748b;font-size:.8rem;font-weight:400;">(<?= count($items) ?> entri)</span></span>
      </div>
      <?php if (empty($items)): ?>
        <div class="empty-state"><i class="fas fa-file-alt"></i>Tidak ada laporan ditemukan.</div>
      <?php else: ?>
      <div style="overflow-x:auto;">
        <table class="dash-table">
          <thead><tr>
            <th>#</th><th>Barang</th><th>Pelapor</th><th>Lokasi</th><th>Tanggal</th><th>Tipe</th><th>Status</th><th>Aksi</th>
          </tr></thead>
          <tbody>
            <?php foreach($items as $item): ?>
            <tr>
              <td style="color:#64748b;"><?= $item['id_laporan'] ?></td>
              <td>
                <div style="color:#fff;font-weight:600;"><?= htmlspecialchars($item['nama_barang']) ?></div>
                <div style="color:#64748b;font-size:.75rem;"><?= htmlspecialchars($item['category']??'Other') ?></div>
              </td>
              <td style="color:#94a3b8;"><?= htmlspecialchars($item['nama_pelapor']??'—') ?></td>
              <td style="color:#94a3b8;font-size:.82rem;"><?= htmlspecialchars($item['lokasi_kehilangan']) ?></td>
              <td style="color:#94a3b8;font-size:.8rem;"><?= date('d M Y', strtotime($item['tanggal_kehilangan'])) ?></td>
              <td><span class="bdg bdg-<?= $item['type'] ?>"><?= strtoupper($item['type']) ?></span></td>
              <td><span class="bdg bdg-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></td>
              <td>
                <button class="btn-ghost-sm" onclick="openEditModal(<?= $item['id_laporan'] ?>,'<?= $item['status'] ?>','<?= $item['type'] ?>')">
                  <i class="fas fa-edit"></i>Edit
                </button>
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

<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:999;align-items:center;justify-content:center;">
  <div class="dash-card p-4" style="width:100%;max-width:380px;margin:1rem;">
    <div style="font-family:'Clash Display',sans-serif;font-weight:700;color:#fff;margin-bottom:1.2rem;font-size:1.1rem;">
      <i class="fas fa-edit me-2" style="color:#818cf8;"></i>Update Laporan
    </div>
    <form method="POST">
      <input type="hidden" name="id_laporan" id="modal_id"/>
      <input type="hidden" name="update_laporan" value="1"/>
      <div class="form-group">
        <label>Tipe</label>
        <select name="type" id="modal_type" class="form-input">
          <option value="lost">Lost</option>
          <option value="found">Found</option>
        </select>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" id="modal_status" class="form-input">
          <option value="open">Open</option>
          <option value="resolved">Resolved</option>
          <option value="closed">Closed</option>
        </select>
      </div>
      <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn-accent flex-fill" style="justify-content:center;"><i class="fas fa-save"></i>Simpan</button>
        <button type="button" class="btn-ghost-sm" onclick="closeModal()">Batal</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditModal(id, status, type) {
  document.getElementById('modal_id').value = id;
  document.getElementById('modal_status').value = status;
  document.getElementById('modal_type').value = type;
  const m = document.getElementById('editModal');
  m.style.display = 'flex';
}
function closeModal() { document.getElementById('editModal').style.display = 'none'; }
document.getElementById('editModal').addEventListener('click', function(e){ if(e.target===this) closeModal(); });
</script>
</body>
</html>