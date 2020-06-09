<?php

require 'vendor/autoload.php';

$db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=ak19192;charset=utf8', 'root', '');

class Stuff extends \atk4\data\Model {
    public $table = 'stuff';
    function init() {
        parent::init();
        $this->addField('name');
        $this->addField('surname');
        $this->addField('email');
        $this->addField('password',['type'=>'password']);
        $this->addField('status',['enum'=>['admin','recorder']]);
    }
}

class Spec extends \atk4\data\Model {
    public $table = 'spec';
    function init() {
        parent::init();
        $this->addField('name',['caption'=>'title']);
        $this->addField('lang');
        $this->hasMany('doctor');
    }
}

class Doctor extends \atk4\data\Model {
    public $table = 'doctor';
    function init() {
        parent::init();
        $this->addField('name');
        $this->addField('surname');
        $this->addField('hospital',['type'=>'text']);
        $this->addField('email');
        $this->addField('password',['type'=>'password']);
        $this->hasMany('record');
        $this->hasMany('research');
        $this->hasOne('spec_id',new Spec());
    }
}

class Patient extends \atk4\data\Model {
    public $table = 'patient';
    function init() {
        parent::init();
        $this->addField('name');
        $this->addField('surname');
        $this->addField('email',['type'=>'email']);
        $this->addField('password',['type'=>'password']);
        $this->addField('phone_number');
        $this->addField('address');
        $this->hasMany('record');
        $this->hasMany('research');
    }
}

class Record extends \atk4\data\Model {
    public $table = 'record';
    function init() {
        parent::init();
        $this->addField('time',['type'=>'datetime']);
        $this->addField('room');
        $this->hasOne('doctor_id',new Doctor())->addTitle();
        $this->hasOne('patient_id',new Patient())->addTitle();
    }
}

class Research extends \atk4\data\Model {
    public $table = 'research';
    function init() {
        parent::init();
        $this->addField('date',['type'=>'datetime']);
        $this->addField('result',['type'=>'text']);
        $this->hasOne('doctor_id',new Doctor());
        $this->hasOne('patient_id',new Patient());
    }
}
