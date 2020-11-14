<?php
require 'function.php';

if (isset($_POST['registrasi'])) {
  if (registrasi($_POST) > 0) {
    echo "
    <script>
     alert('User berhasil ditambah!'); 
     document.location.href = 'login.php';
     </script>
  ";
  } else {
    echo "User gagal ditambah";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi</title>
</head>

<body>
  <h3>Registrasi</h3>
  <form action="" method="POST">
    <ul>
      <li><label>
          Username:
          <input type="text" name="username" autocomplete="off" required autofocus>
        </label></li>
      <li><label>
          Password :
          <input type="password" name="password1" required>
        </label></li>
      <li><label>
          Konfirmasi Password :
          <input type="password" name="password2" required>
        </label></li>
      <li><button type="submit" name="registrasi">Registrasi</button></li>
    </ul>
  </form>
</body>

</html>