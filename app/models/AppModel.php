<?php

namespace app\models;
use mvc\Model;
use lib\App;

class AppModel extends Model
{

    public $modules;


    public function __construct($route)
    {
        parent::__construct($route);

        $this->modules = 12;

    }

}