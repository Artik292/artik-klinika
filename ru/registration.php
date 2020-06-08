<?php
require '../connection.php';
require '../app.php';

$app = new App();

$reg = new \atk4\data\Model(new \atk4\data\Persistence_Array($a));
$reg->addField('name',['type'=>'string',/*'required'=>TRUE,*/'caption'=>'Имя']);
$reg->addField('surname',['type'=>'string',/*'required'=>TRUE,*/'caption'=>'Фамилия']);
$reg->addField('phone_number',['type'=>'number',/*'required'=>TRUE,*/'caption'=>'Номер телефона']);
$reg->addField('address',['type'=>'string',/*'required'=>TRUE,*/'caption'=>'Адрес']);
$reg->addField('email',['type'=>'email',/*'required'=>TRUE,*/'caption'=>'Электронный адресс']);
$reg->addField('password1',['type'=>'password',/*'required'=>TRUE,*/'caption'=>"Пароль"]);
$reg->addField('password2',['type'=>'password',/*'required'=>TRUE,*/'caption'=>"Повторите пороль"]);

$app->add(['Header',"Регистрация пациента","centered"]);

$form = $app->add(['Form']);
$form->setModel($reg);
$form->buttonSave->set('Зарегистрироваться');
$form->onSubmit(function($form) {
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

  switch ($form->model['password']) {
    case 'password':
    case 'Password':
    case '12345678':
    case 'qwertyui':
      return $form->error('password1',"Пароль слишком простой");
  }

  if (strlen($form->model['password'])) {
      return $form->error('password1',"Пароль слишком простой");
  }

  session_start();
  $_SESSION['user_name'] = $form->model['name'] . ' ' . $form->model['surname'];
	$form->model->save();
	//return $form->success('You were successfully registered');
  return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
