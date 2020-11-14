<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}
require 'function.php';
// // koneksi database
// $conn = mysqli_connect('localhost', 'root', '', 'pw_20182205103') or die(mysqli_error());
// // query isi tabel mahasiswa
// $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
// // ubah data ke dalam array
// $rows = [];
// while ($row = mysqli_fetch_array($result)) {
//   $rows[] = $row;
// }
// tampung
$mahasiswa = query("SELECT * FROM mahasiswa");
// ketika tombol cari dklik
if (isset($_POST['cari'])) {
  $mahasiswa = cari($_POST['keyword']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <a href="logout.php">Logout</a>
  <h3>Daftar Mahasiswa</h3>
  <a href="tambah.php">Tambah Data Mahasiswa</a>
  <form action="" method="post">
    <input type="text" name="keyword" size="40" placeholder="Masukkan Keyword pencarian" autocomplete="off" autofocus>
    <button type="submit" name="cari">Cari!</button>
  </form>
  <br>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>#</th>
      <th>Gambar</th>
      <th>Nama</th>
      <th>Aksi</th>
    </tr>
    <!-- kondisi jika data kosong -->
    <?php
    if ($mahasiswa) {
    ?>

      <?php
      $i = 1;
      foreach ($mahasiswa as $m) : ?>
        <tr>
          <td><?= $i++; ?></td>
          <th><img src="img/<?= $m['gambar']; ?>" width="60"></th>
          <td><?= $m['nama']; ?></td>
          <td>
            <a href="detail.php?id=<?= $m['id']; ?>">Lihat Detail</a>
          </td>
        </tr>
      <?php endforeach; ?>

    <?php
    } else {
      echo "
        <tr>
          <td colspan='4'>Data Kosong / Tidak Ditemukan</td>  
        </tr>
      ";
    }
    ?>
  </table>
</body>

</html>