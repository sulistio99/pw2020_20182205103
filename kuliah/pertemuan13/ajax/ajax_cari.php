<?php
require '../function.php';
$mahasiswa = cari($_GET['keyword']);
?>
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