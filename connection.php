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
        $this->hasMany('Doctor');
        $this->setOrder('name');
    }
}

class Doctor extends \atk4\data\Model {
    public $table = 'doctor';
    public $title = 'Doctor';
    public $name = 'Doctor';
    function init() {
        parent::init();
        $this->addField('name');
        $this->addField('hospital',['type'=>'text']);
        $this->addField('room');
        $this->addField('email');
        $this->addField('password',['type'=>'password']);
        $this->hasMany('record');
        $this->hasMany('research');
        $this->addField('available',['type'=>'boolean']);
        $this->hasOne('spec_id',new Spec());
        //$this->hasOne('spec_id', [new Spec(),'caption'=>'Grupa'])->addTitle();
        //$this->getElement('spec_id')->ui['visible'] = false;
        $this->setOrder('name');
    }
}

class Patient extends \atk4\data\Model {
    public $table = 'patient';
    function init() {
        parent::init();
        $this->addField('name');
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
        $this->addField('time');
        $this->addField('patient_name');
        $this->addField('room');
        $this->addField('available',['type'=>'boolean']);
        $this->hasOne('doctor_id',new Doctor());
        $this->hasOne('patient_id',new Patient());
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








class Teacher extends \atk4\data\Model {
    public $table = 'doctor';
    public $title = 'Skolotājs';
    public $name = 'Skolotājs';

    function init() {
        parent::init();

        $this->addField('name',['caption'=>'Имя врача','required'=>TRUE]);
        $this->addField('available',['type'=>'boolean']);

        $this->addField('hospital',['type'=>'text']);
        $this->addField('email');
        $this->addField('password',['type'=>'password']);
        $this->hasMany('research');
        // $this->addField('cabinet',['caption'=>'Kabinets','required'=>TRUE]);
        // $this->addField('available',['caption'=>'Būs','type'=>'boolean','required'=>TRUE]);
        //
        $this->hasOne('spec_id', [new Subject(),'caption'=>'Направление'])->addTitle();
        //
        // $this->getElement('subject_id')->ui['visible'] = false;
        //
        $this->hasMany('Vecaki', new Vecaki);
        // $this->setOrder('name');

    }
}

class Subject extends \atk4\data\Model {
    public $table = 'spec';
    public $title = 'Stunda';

    function init() {
        parent::init();

        $this->addField('name',['caption'=>'Направление','required'=>TRUE]);

        $this->hasMany('Teacher', new Teacher);
        // $this->setOrder('name');
    }
}


class Vecaki extends \atk4\data\Model {
    public $table = 'record';
    public $title = 'Vecāki';
    public $name = 'parent_name';
    public $title_field = 'parent_name';

    function init() {
        parent::init();

        //$this->addField('student_name',['caption'=>'Skolnieka vārds un uzvārds','required'=>TRUE]);
        //$this->addField('grade',['caption'=>'Klase','required'=>TRUE]);
        //$this->addField('parent_name',['caption'=>'Vecāku vārds un uzvārds','required'=>TRUE]);
        //$this->addField('contact_phone',['caption'=>'Kontaktnumurs','required'=>TRUE]);
        $this->addField('patient_name');
        $this->addField('room');
        $this->hasOne('patient_id',new Patient());

        $this->addField('available',['type'=>'boolean']);
        $this->addField('time',['caption'=>'Время']);
        $this->hasOne('doctor_id', new Teacher)->addTitle();
        $this->setOrder('time');

    }
}

// class Subject extends \atk4\data\Model {
//     public $table = 'subject';
//     public $title = 'Stunda';
//
//     function init() {
//         parent::init();
//
//         $this->addField('name',['caption'=>'Grupa','required'=>TRUE]);
//
//         $this->hasMany('Teacher', new Teacher);
//         $this->setOrder('name');
//     }
// }
//
// class Teacher extends \atk4\data\Model {
//     public $table = 'teacher';
//     public $title = 'Skolotājs';
//     public $name = 'Skolotājs';
//
//     function init() {
//         parent::init();
//
//         $this->addField('name',['caption'=>'Uzvārds, vārds','required'=>TRUE]);
//         $this->addField('cabinet',['caption'=>'Kabinets','required'=>TRUE]);
//         $this->addField('available',['caption'=>'Būs','type'=>'boolean','required'=>TRUE]);
//
//         $this->hasOne('subject_id', [new Subject(),'caption'=>'Grupa'])
//             ->addTitle();
//
//         $this->getElement('subject_id')->ui['visible'] = false;
//
//         $this->hasMany('Vecaki', new Vecaki);
//         $this->setOrder('name');
//
//     }
// }
// class Vecaki extends \atk4\data\Model {
//     public $table = 'vecaki';
//     public $title = 'Vecāki';
//     public $name = 'parent_name';
//     public $title_field = 'parent_name';
//
//     function init() {
//         parent::init();
//
//         $this->addField('student_name',['caption'=>'Skolnieka vārds un uzvārds','required'=>TRUE]);
//         $this->addField('grade',['caption'=>'Klase','required'=>TRUE]);
//         $this->addField('parent_name',['caption'=>'Vecāku vārds un uzvārds','required'=>TRUE]);
//         $this->addField('contact_phone',['caption'=>'Kontaktnumurs','required'=>TRUE]);
//         $this->addField('time',['caption'=>'Laiks']);
//         $this->hasOne('teacher_id', new Teacher)->addTitle();
//         $this->setOrder('time');
//
//     }
// }
