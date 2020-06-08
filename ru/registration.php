<?php
require '../connection.php';
require '../app.php';

$app = new App();

$pac = new Patient($db);

$reg = new \atk4\data\Model(new \atk4\data\Persistence_Array($a));
$reg->addField('name',['type'=>'string','caption'=>'Имя']);
$reg->addField('surname',['type'=>'string','caption'=>'Фамилия']);
$reg->addField('phone_number',['type'=>'number','caption'=>'Номер телефона']);
$reg->addField('address',['type'=>'string','caption'=>'Адрес']);
$reg->addField('email',['type'=>'email','caption'=>'Электронный адресс']);
$reg->addField('password1',['type'=>'password','caption'=>"Пароль"]);
$reg->addField('password2',['type'=>'password','caption'=>"Повторите пороль"]);

$app->add(['Header',"Регистрация пациента","centered"]);

$form = $app->add(['Form']);
$form->setModel($reg);
$form->buttonSave->set('Зарегистрироваться');
$form->onSubmit(function($form) use($pac) {
	if ($form->model['name'] == '') {
		return $form->error('name', "Это поле обязательно для заполнения.");
	}
  if ($form->model['surname'] == '') {
		return $form->error('surname', "Это поле обязательно для заполнения.");
	}
  if ($form->model['phone_number'] == '') {
		return $form->error('phone_number', "Это поле обязательно для заполнения.");
	}
  if ($form->model['address'] == '') {
		return $form->error('address', "Это поле обязательно для заполнения.");
	}
  if ($form->model['email'] == '') {
		return $form->error('email', "Это поле обязательно для заполнения.");
	}
  if ($form->model['password1'] == '') {
		return $form->error('password1', "Это поле обязательно для заполнения.");
	}
  if ($form->model['password2'] == '') {
		return $form->error('password2', "Это поле обязательно для заполнения.");
	}

  $pac->tryLoadby('email',$form->model['email']);

  if(isset($pac->id)) {
      return $form->error('email', "Данная электронная почта уже используется.");
  }

  $pac->tryLoadby('phone_number',$form->model['phone_number']);

  if(isset($pac->id)) {
      return $form->error('phone_number', "Данный номер телефона уже используется.");
  }

  switch ($form->model['password1']) {
    case 'password':
    case 'Password':
    case '12345678':
    case 'qwertyui':
      return $form->error('password1',"Пароль слишком простой");
  }

  if (strlen($form->model['password1']) < 8) {
      return $form->error('password1',"Пароль слишком простой");
  }

  if ($form->model['password1'] != $form->model['password2']) {
      return $form->error('password2',"Пароли не смовпадают");
  }

  $email = $form->model['email'];
	//$form->model->save();
  $pac['name'] = $form->model['name'];
  $pac['surname'] = $form->model['surname'];
  $pac['phone_number'] = $form->model['phone_number'];
  $pac['address'] = $form->model['address'];
  $pac['email'] = $form->model['email'];
  $pac['password'] = hash('sha256',$form->model['password1']);
  $pac->save();
  $pac->tryLoadby('email',$email);
  session_start();
  $_SESSION['id'] = $pac->id;
	//return $form->success('You were successfully registered');
  return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
