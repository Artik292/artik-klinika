<?php

require '../connection.php';
require '../hash.php';

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Artik-klinika</title>
    <link rel="icon" href="../src/logo.png">
    <link rel = "stylesheet" href = "../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>

  <body>

   <h2>Войти в систему</h2>
   <div class = "container form-signin">

      <?php
         $msg = '';

         if (isset($_POST['email']) && !empty($_POST['email'] && !empty($_POST['email']))) {
           $doctor = new Doctor($db);
           $doctor->tryLoadby("email",$_POST['email']);

           $user = new User($db);
           $user->tryLoadby("email",$_POST['email']);

           if (isset($doctor->id)) {
                if ($doctor['password'] == $OpensslEncryption->encrypt($_POST['password'], ENCRYPTION_KEY)) {
                  $_SESSION['id'] = $doctor->id;
                } else {
                  $msg = 'Wrong e-mail or password';
                }
           } elseif (isset($user->id)) {
                if ($user['password'] == $OpensslEncryption->encrypt($_POST['password'], ENCRYPTION_KEY)) {
                  $_SESSION['īd'] = $user->id;
                } else {
                  $msg = 'Wrong e-mail or password';
                }
           } else {
               $msg = 'Wrong e-mail or password';
           }
         }
      ?>
   </div>
   <div class = "container">

      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
         <input type = "text" class = "form-control" name = "email" placeholder = "Э. почта" required autofocus></br>
         <input type = "password" class = "form-control" name = "password" placeholder = "Пароль" required>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>
         <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
      </form>

      <a href = "registration.php" tite = "Logout">Зарегистрироваться как пациент</a>

   </div>
  </body>
</html>

<!-- $OpensslEncryption = new Openssl_EncryptDecrypt;
$encrypted = $OpensslEncryption->encrypt($string, ENCRYPTION_KEY);
$decrypted = $OpensslEncryption->decrypt($encrypted, ENCRYPTION_KEY); -->
