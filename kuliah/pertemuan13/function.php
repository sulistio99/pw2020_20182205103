<?php
function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'pw_20182205103');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // jika hasil hanya 1 data
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  // $gambar = htmlspecialchars($data['gambar']);

  // upload gambar
  $gambar = upload();
  if (!$gambar) {
    return false;
  }


  $query = "INSERT INTO
             mahasiswa 
            VALUES
            (null,'$nama' ,'$nrp', '$email', '$jurusan', '$gambar');
            ";
  mysqli_query($conn, $query);
  mysqli_error($conn);
  // khs tau mysli klu ada baris yg berubah
  return mysqli_affected_rows($conn);
}

function upload()
{
  $nama_file = $_FILES['gambar']['name'];
  $tipe_file = $_FILES['gambar']['type'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_file = $_FILES['gambar']['tmp_name'];


  // ketika tdk ada gambar dipilih
  if ($error == 4) {
    // echo "<script>
    //     alert('Pilih gambar terlebih dahulu');
    // </script>";
    return 'nophoto.png';
  }

  // ketika yg dplih bukan gambar
  // cek ekstensi file
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));
  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "<script>
            alert('Yang anda pilih bukan gambar');
          </script>";
    return false;
  }

  // cek type file
  if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
    echo "<script>
            alert('Yang anda pilih bukan gambar');
          </script>";
    return false;
  }

  // cek ukuran file
  // maksimal 5mb
  if ($ukuran_file > 5000000) {
    echo '<script>
            alert("Yang anda pilih bukan gambar");
          </script>';
    return false;
  }

  // lolos pengecekan
  // siap upload file
  // generate nama file baru
  $nama_file_baru = uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file;
  move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

  return $nama_file_baru;
}

function hapus($id)
{
  $conn = koneksi();

  // mengahpuas gambar difolder
  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id");
  if ($mhs['gambar'] != 'nophoto.png') {
    unlink('img/' . $mhs['gambar']);
  }
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  $conn = koneksi();

  $id = htmlspecialchars($data['id']);
  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar_lama = htmlspecialchars($data['gambar_lama']);

  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  if ($gambar == 'nophoto.png') {
    $gambar  = $gambar_lama;
  }

  $query = "UPDATE mahasiswa SET
            nama = '$nama',
            nrp = '$nrp',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar' 
            WHERE id =  $id";
  mysqli_query($conn, $query);
  mysqli_error($conn);
  // khs tau mysli klu ada baris yg berubah
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();
  $query = "SELECT * FROM mahasiswa
            WHERE nama LIKE '%$keyword%' OR 
            nrp LIKE '%$keyword%'";
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // cek username

  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    // cek password
    if (password_verify($password, $user['password'])) {
      // set session
      $_SESSION['login'] = true;

      header("location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Usernama / password salah'
  ];
}

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika usernmae dan pass kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
        alert('username / password tidak boleh kosong');
        documen.location.href = 'registrasi.php';
    </script>";
    return false;
  }

  // jika usernmae sudah ada
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script>
            alert('username sudah terdaftar');
            documen.location.href = 'registrasi.php';
           </script>";
    return false;
  }

  // cek kesamaan password
  if ($password1 !== $password2) {
    echo "<script>
    alert('Konfirmasi password tidak sesuai');
    documen.location.href = 'registrasi.php';
   </script>";
    return false;
  }

  // jika password < 5 figit
  if (strlen($password1) < 5) {
    echo "<script>
    alert('password terlalu pendek');
    documen.location.href = 'registrasi.php';
   </script>";
    return false;
  }

  // jika usernmae dan pass sesuai
  // eksripsi
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);
  // insert ke tabel user
  $query = "INSERT INTO user VALUES(null,'$username','$password_baru')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
