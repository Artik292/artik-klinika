<?php
require '../connection.php';
require '../app.php';

$app = new App();

$pac = new Patient($db);

$reg = new \atk4\data\Model(new \atk4\data\Persistence_Array($a));
$reg->addField('name',['type'=>'string','caption'=>'Name']);
$reg->addField('surname',['type'=>'string','caption'=>'Surname']);
$reg->addField('phone_number',['type'=>'number','caption'=>'Phone number']);
$reg->addField('address',['type'=>'string','caption'=>'Address']);
$reg->addField('email',['type'=>'email','caption'=>'E-mail']);
$reg->addField('password1',['type'=>'password','caption'=>"Password"]);
$reg->addField('password2',['type'=>'password','caption'=>"Repeat password"]);

$app->add(['Header',"Registration","centered"]);

$form = $app->add(['Form']);
$form->setModel($reg);
$form->buttonSave->set('Sign up');
$form->onSubmit(function($form) use($pac) {
	if ($form->model['name'] == '') {
		return $form->error('name', "This field is required.");
	}
  if ($form->model['phone_number'] == '') {
		return $form->error('phone_number', "This field is required.");
	}
  if ($form->model['address'] == '') {
		return $form->error('address', "This field is required.");
	}
  if ($form->model['email'] == '') {
		return $form->error('email', "This field is required.");
	}
  if ($form->model['password1'] == '') {
		return $form->error('password1', "This field is required.");
	}
  if ($form->model['password2'] == '') {
		return $form->error('password2', "This field is required.");
	}

  $pac->tryLoadby('email',$form->model['email']);

  if(isset($pac->id)) {
      return $form->error('email', "This email is already in use.");
  }

	$pac->tryLoadby('phone_number',$form->model['phone_number']);

  	if(isset($pac->id)) {
      return $form->error('phone_number', "This phone number is already in use.");
  }

  switch ($form->model['password1']) {
    case 'password':
    case 'Password':
    case '12345678':
    case 'qwertyui':
      return $form->error('password1',"Password is too simple.");
  }

  if (strlen($form->model['password1']) < 8) {
      return $form->error('password1',"Password is too short.");
  }

  if ($form->model['password1'] != $form->model['password2']) {
      return $form->error('password2',"Password mismatch.");
  }

  $email = $form->model['email'];
  $pac['name'] = $form->model['name']." ".$form->model['surname'];
  $pac['phone_number'] = $form->model['phone_number'];
  $pac['address'] = $form->model['address'];
  $pac['email'] = $form->model['email'];
  $pac['password'] = hash('sha256',$form->model['password1']);
  $pac->save();
  $pac->tryLoadby('email',$email);
  session_start();
  $_SESSION['id'] = $pac->id;
	$_SESSION['status'] = 'patient';
	//return $form->success('You were successfully registered');
  return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
