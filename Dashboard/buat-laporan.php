<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../connect.php';
require_once '../Auth/auth3thparty.php';
requireLogin();
$u = currentUser();
$activePage = 'buat';
$error = $sucess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['nama_barang'] ?? '');
    $description = trim($_POST['deskripsi'] ?? '');
    $location = trim($_POST['lokasi_ditemukan'] ?? '');
    $date = trim($_POST['tanggal_ditemukan'] ?? '');
    $category = trim($_POST['category'] ?? 'Other');
}

    if (!$name || !$location || !$date){
        $error = 'Nama barang, lokasi dan tanggal wajib diisi.';
    } else {
        $imageName = null;
        if (!empty($_FILES['image']['name'])){
            $ext = strtolower(pathinfo($_FILES['image'] ['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($ext, $allowed)){
                $error = 'Format foto tidak di dukung. Gunakan format JPG, PNG atau WEBP!';
            } elseif ($_FILES['image'] ['name'] > 3*1024*1024){
                $error = 'File upload failed. Maximum allowed size is 3 MB';
            } else {
                $imageName = uniqid('laporan_') . '.' . $ext;
                $uplaodDir = '../uploads/';
                if (!is_dir($uplaodDir)) mkdir($uplaodDir, 0755, true);

                move_uploaded_file($_FILES['image'] ['name'], $uplaodDir . $imageName);
            }
        }


        if (!$error){
            $pdo -> prepare("INSERT INTO barang_temuan (user_id, nama_barang, deskripsi, lokasi_ditemukan, tanggal_ditemukan, category, image, type, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'lost', 'open')") -> execute([$u['id'], $name, $description, $location, $date, $category, $imageName]);

            $sucess = 'Laporan berhasil dibuat!';
        }
    }
?>