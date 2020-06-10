<?php

class App extends \atk4\ui\App {
    function __construct() {
        parent::__construct('Artik klinika');
            $this->initLayout('Centered');
            $this->layout->template->del('Header');
            //$logo = '../src/logo.png';
            $logo = "https://www.pngitem.com/pimgs/m/222-2228006_no-man-s-sky-logo-png-no-mans.png";
            $this->layout->add(['Image',$logo,'small centered'],'Header');
            $this->layout->add([
                'Header',
                'Artik klinika',
                'size'=>'huge',
                'aligned' => 'center',
            ], 'Header');
          }
}
