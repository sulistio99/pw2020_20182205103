<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'function.php';

// jika tdk ada id di url
if (!isset($_GET['id'])) {
  header("location: index.php");
  exit;
}

//ambil id di URL
$id = $_GET['id'];
$m = query("SELECT * FROM mahasiswa WHERE id = $id");
//cek apakah tombol tambah sudah ditekan
if (isset($_POST['ubah'])) {
  if (ubah($_POST) > 0) {
    echo "
      <script>
       alert('Data berhasil diubah!'); 
       document.location.href = 'index.php';
       </script>
    ";
  } else {
    echo "Data gagal diubah";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data Mahasiswa</title>
</head>

<body>
  <h3>Form Ubah Data Mahasiswa</h3>
  <form action="" method="post">
    <input type="hidden" name="id" value="<?= $m['id']; ?>">
    <ul>
      <li>
        <label> Nama :
          <input type="text" name="nama" autofocus required value="<?= $m['nama']; ?>"></label>
      </li>
      <li>
        <label>Nrp :
          <input type="text" name="nrp" required value="<?= $m['nrp']; ?>"></label>
      </li>
      <li>
        <label>Email : <input type="text" name="email" required value="<?= $m['email']; ?>">
        </label>
      </li>
      <li>
        <label>Jurusan :
          <input type="text" name="jurusan" required value="<?= $m['jurusan']; ?>"></label>
      </li>
      <li>
        <label>Gambar :
          <input type="text" name="gambar" required value="<?= $m['gambar']; ?>"></label>
      </li>
      <li>
        <button type="submit" name="ubah">Ubah</button>
      </li>
    </ul>
  </form>
</body>

</html>