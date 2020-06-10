<?php

require '../connection.php';

session_start();

if (!(isset($_SESSION['id']))) {
  header('location: ../index.php');
}

require '../app.php';
$app = new App();
$to_record = $app->add(['Label','View my doctor notes.','blue left ribbon'])->link(['records']);

$app->add(['ui'=>'hidden divider']);

$logout = $app->add(['Label','Log out ','red right ribbon','iconRight'=>'sign out'])->link(['../logout']);


$app->add(['ui'=>'hidden divider']);

$col = $app->add('Columns');
$col->addClass('stackable');
$subject= new Subject($db);
$c1 = $col->addColumn();
$c2 = $col->addColumn();
$c3 = $col->addColumn();
$c4 = $col->addColumn();
$mes = $c4->add(['Message','Instruction manual','massive info']);
$mes->text->addParagraph('Choose a direction, then a doctor and time. After click "confirm".');

$table_s = $c1->add(['Table','very basic selectable'])->addStyle('cursor', 'pointer');
$table_s->setModel($subject, [$subject->title_field]);
$table_s->on('click', 'tr', $c2->jsReload(['pr'=>$table_s->jsRow()->data('id')]));
$pr = $app->stickyGet('pr');
if ($pr) {
  $subject->load($pr);
  $doctor = $subject->ref('Teacher');
  //$doctor->setOrder('name');
  $table_t = $c2->add(['Table','very basic selectable'])->addStyle('cursor', 'pointer');
  $table_t->setModel($doctor,[$doctor->title_field]);
  $table_t->on('click', 'tr', $c3->jsReload(['t'=>$table_t->jsRow()->data('id')]));
}
$t = $app->stickyGet('t');
if($t) {
  $doctor= new Teacher($db);
  $doctor = $doctor->load($t);
  if ($doctor['available']) {
    $parents=$doctor->ref('Vecaki');
    $doctor_id = $doctor->id;
    $parentss = new Vecaki($db);

    $menu = $c3->add('Menu');
    $menu->addClass('vertical fluid');
    $menu->addHeader('Time ('.$doctor['name'].')');

    $vir = $app->add('VirtualPage');
    $vir->set(function($vir) use($parentss,$db,$app,$doctor_id,$t) {
      $mes = $vir->add(['Message','Confirm selection.','massive info']);
      $doctor = new Doctor($db);
      $doctor->load($doctor_id);
      $doctor_name = $doctor['name'];
      $room = $doctor['room'];
      $time = $app->stickyGet('time');
      $specifik_id = $app->stickyGet('pr');
      $specifik = new Spec($db);
      $specifik->load($specifik_id);
      $specifik = $specifik['name'];
      $mes->text->addParagraph('Doctor: '.$doctor_name);
      $mes->text->addParagraph('Direction: '.$specifik);
      $mes->text->addParagraph('Date: '.$time);
      $form = $vir->add('Form');
      $form->buttonSave->set('Confirm');
      $form->onSubmit(function($form) use($app,$t,$db,$time,$room,$doctor_id) {
        $record= new Record($db);
        //$record->load($t);
        $user = new Patient($db);
        $user->load($_SESSION['id']);

        $record['time'] = $time;
        $record['room'] = $room;
        $record['available'] = FALSE;
        $record['doctor_id'] = $doctor_id;
        $record['patient_id'] = $_SESSION['id'];
        $record['patient_name'] = $user['name'];
        $record->save();
        return [$form->success('Recording was successful.') , new \atk4\ui\jsExpression('document.location="main.php"')];

      });
    });

    $min=0;
    for ($hour=9;$hour<18;$hour++) {
      for ($i=1;$i<=2;$i++) {
        if ($min>=60) {
          $min=0;
        }
        if($min<10) {
          $time = $hour.':0'.$min;
        }else {
          $time = $hour.':'.$min;
        }
        $s=1;

        if($parents->tryLoadAny()->loaded()) {
          foreach($parents as $rowss) {
            if ($rowss['time']==$time) {
              $array=[$s=>$time];
              $s=$s+1;
            }
          }
          unset($rowss);
          $check=FALSE;
          for($n=0;$n<=$s;$n++){
            if (isset($array[$n]) && $array[$n]==$time) {
              $menu->addItem([$time,'disabled']);
              $check=TRUE;
            }
          }
          if($check==FALSE){
            $menu->addItem($time)->on('click', new \atk4\ui\jsModal('Ieraksts',$vir,['time'=>$time]));
          }
          }else {
            $menu->addItem($time)->on('click', new \atk4\ui\jsModal('Ieraksts',$vir,['time'=>$time]));
          }
        $min=$min+30;
      }
    }
  } else {
    $menu = $c3->add('Menu');
    $menu->addClass('vertical fluid');
    $menu->addHeader('Ceturtdien, vecāku dienas laikā, šīs skolotājas nebūs.');
    //$menu->addItem('Šo skolotaja nebus.');
  }
}

$app->add(['ui'=>'divider']);

$app->add(['Label','With love ❤︎ from artik292 ','green right ribbon'])->link('https://github.com/Artik292');
