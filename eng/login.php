<?php

require '../connection.php';
session_start();
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

   <h2>Log in</h2>
   <div class = "container form-signin">

      <?php
         $msg = '';

         if (isset($_POST['email']) && !empty($_POST['email'] && !empty($_POST['email']))) {

           $stuff = new Stuff($db);
           $stuff->tryLoadby("email",$_POST['email']);

           $doctor = new Doctor($db);
           $doctor->tryLoadby("email",$_POST['email']);

           $user = new Patient($db);
           $user->tryLoadby("email",$_POST['email']);

           if (isset($stuff->id)) {
                 if ($stuff['password'] == hash('sha256',$_POST['password'])) {
                   $_SESSION['id'] = $stuff->id;
                   $_SESSION['status'] = $stuff['status'];
                   header('location: ../trans.php?tar=rec');
                 } else {
                   $msg = 'Wrong e-mail or password';
                 }
          } elseif (isset($doctor->id)) {
                if ($doctor['password'] == hash('sha256',$_POST['password'])) {
                  $_SESSION['id'] = $doctor->id;
                  $_SESSION['status'] = 'doctor';
                  header('location: records.php');
                } else {
                  $msg = 'Wrong e-mail or password';
                }
           } elseif (isset($user->id)) {
                if ($user['password'] == hash('sha256',$_POST['password'])) {
                  $_SESSION['id'] = $user->id;
                  $_SESSION['status'] = 'patient';
                  header('location: main.php');
                } else {
                  $msg = 'Wrong e-mail or password';
                }
           } else {
               $msg = 'Wrong e-mail or password';
           }
           unset($_POST['email']);
         }//*/
      ?>
   </div>
   <div class = "container">

      <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
         <input type = "text" class = "form-control" name = "email" placeholder = "E-mail" required autofocus></br>
         <input type = "password" class = "form-control" name = "password" placeholder = "Password" required>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>
         <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
      </form>

      <a href = "registration.php" tite = "Logout">Sign up</a>

   </div>
  </body>
</html>
