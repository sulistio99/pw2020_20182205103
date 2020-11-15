<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'function.php';
$id = $_GET['id'];

$m = query("SELECT * FROM mahasiswa WHERE id = $id");

?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="img/<?= $m['gambar']; ?>" width="250"></li>
    <li>NRP : <?= $m['nrp']; ?></li>
    <li>Email : <?= $m['nama']; ?></li>
    <li>jurusan <?= $m['jurusan']; ?>:</li>
    <li><a href="hapus.php?id=<?= $m['id']; ?>" onclick="return confirm('Yakin Mau Hapus');">Hapus</a> | <a href="ubah.php?id=<?= $m['id']; ?>">Ubah</a></li>
    <li><a href="index.php">kembali Data Mahasiswa</a></li>
  </ul>
</body>

</html>