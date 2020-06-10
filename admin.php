<?php

require 'connection.php';
require 'admin_visual.php';

$target = $_SESSION['tar'];

if(($_SESSION['status'] != 'admin') && (($target == 'stu') || ($target == 'spe'))) {
  header('location: logout.php');
}

$email = FALSE;

if ($target == 'rec') {
  $model = new Record($db);
  $email = TRUE;
} elseif ($target == 'doc') {
  $model = new Doctor($db);
  $email = TRUE;
} elseif ($target == 'pat') {
  $model = new Patient($db);
  $email = TRUE;
} elseif ($target == 'stu') {
  $model = new Stuff($db);
  $email = TRUE;
} elseif ($target == 'spe') {
  $model = new Spec($db);
} else {
  header('location: logout.php');
}

$CRUD = $app->add(['CRUD']);
$CRUD->setModel($model);
if ($email) {
    $CRUD->addQuickSearch(['name','email']);
} else {
    $CRUD->addQuickSearch(['title']);
}
