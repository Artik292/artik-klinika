<?php

session_start();

if (!(isset($_SESSION['id']) && (($_SESSION['status'] == 'admin') || ($_SESSION['status'] == 'recorder')))) {
  header('location: index.php');
}

$app = new \atk4\ui\App('Artik-klinika');
$app->initLayout('Admin');

$layout = $app->layout;

$layout->leftMenu->addItem(['Records','icon'=>'list ul'],['trans','tar'=>'rec']);
$layout->leftMenu->addItem(['Patients','icon'=>'users'],['trans','tar'=>'pat']);
if ($_SESSION['status'] == "admin") {
    $layout->leftMenu->addItem(['Doctors','icon'=>'user md'],['trans','tar'=>'doc']);
    $layout->leftMenu->addItem(['Stuff','icon'=>'user circle'],['trans','tar'=>'stu']);
    $layout->leftMenu->addItem(['Spec','icon'=>'stethoscope'],['trans','tar'=>'spe']);
}
$layout->leftMenu->addItem(['Logout','icon'=>'sign out'],['logout']);
