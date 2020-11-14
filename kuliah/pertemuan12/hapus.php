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

//ambil id dari url
$id = $_GET['id'];
if (hapus($id) > 0) {
  echo "
    <script>
     alert('Data berhasil Dihapus!'); 
     document.location.href = 'index.php';
     </script>
  ";
} else {
  echo "Data gagal Dihapus";
}
