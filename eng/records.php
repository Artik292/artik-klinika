<?php

require '../connection.php';

session_start();

if (!(isset($_SESSION['id']))) {
  header('location: ../index.php');
}


require '../app.php';
$app = new App();

$back = $app->add(['Label','Back ','green left ribbon','iconRight'=>'arrow left'])->link(['main']);

$app->add(['ui'=>'hidden divider']);

$back = $app->add(['Label','Sign out ','red right ribbon','iconRight'=>'sign out'])->link(['../logout']);

$app->add(['ui'=>'hidden divider']);

if ($_SESSION['status'] == 'doctor') {
  $doctor = new Teacher($db);
  $doctor->load($_SESSION['id']);
  $records= $doctor->ref('Vecaki');
  $grid = $app->add('Grid');
  $grid->setModel($records,['time','patient_name']);
} elseif ($_SESSION['status'] == 'patient') {
  $records = new Record($db);
  if($records->tryLoadAny()->loaded()) {
    $doctor = new Doctor($db);
    foreach($records as $rowss) {
      if ($rowss['patient_id'] == $_SESSION['id']) {
        $doctor->load($rowss['doctor_id']);
        $app->add(['Header',"Time: ".$rowss['time']." ,cabinet: ".$rowss['room']." ,doctor: ".$doctor['name'],'green']);
      }
    }
  } else {
    $app->add(['Header',"You have no notes yet.",'green']);
  }
} else {
  header('location: ../logout.php');
}
