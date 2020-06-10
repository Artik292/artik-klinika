<?php

require 'connection.php';
require 'app.php';

$app = new App();

$app->add(['Button',"По русски",'green fluid'])->link('ru/login.php');
$app->add(['ui'=>'hidden divider']);
$app->add(['Button',"English",'green fluid'])->link('eng/login.php');

?>
