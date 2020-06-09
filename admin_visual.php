<?php

session_start();

if (!(isset($_SESSION['id']) && (($_SESSION['status'] == 'admin') || ($_SESSION['status'] == 'recorder')))) {
  header('location: index.php');
}

$app = new \atk4\ui\App('Artik-klinika');
$app->initLayout('Admin');

$layout = $app->layout;

$layout->leftMenu->addItem(['Records','icon'=>'building'],['trans','tar'=>'rec']);
$layout->leftMenu->addItem(['Doctors','icon'=>'building'],['trans','tar'=>'doc']);
$layout->leftMenu->addItem(['Patients','icon'=>'building'],['trans','tar'=>'pat']);
if ($_SESSION['status'] == "admin") {
    $layout->leftMenu->addItem(['Stuff','icon'=>'building'],['trans','tar'=>'stu']);
}
$layout->leftMenu->addItem(['Logout','icon'=>'sign out'],['logout']);