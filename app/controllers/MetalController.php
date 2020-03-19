<?php

namespace app\controllers;

use lib\App;

class MetalController extends AppController
{

    public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


    public function indexAction($model, $route)
    {

        $title = 'Металопрокат |'.$this->title;

        $this->meta($title,$title.' '.$this->configs['about']['description']);

        $products = \R::getAll('SELECT id,name,url FROM _metal WHERE active = 1');

        $this->render(compact('products'));
    }

    public function viewAction($model, $route){

        //pr3( in_array($route['url'],\R::getCol('SELECT url FROM _metal WHERE active = 1')) );

        if( in_array($route['url'],\R::getCol('SELECT url FROM _metal WHERE active = 1')) ){

            $logo = \R::getCol('SELECT `name` FROM `_metal` WHERE `active` = 1 AND `url` = ? LIMIT 1',[ $route['url'] ])[0];

            $title = $logo.' |'.$this->title;

            $this->meta($title,$title.' '.$this->configs['about']['description']);

            $product = \R::getAll('SELECT * FROM `_metal_'.$route['url'].'` WHERE active = 1');

            //pr1($product);

            $this->render(compact('product','logo'));


        }else{

            App::notFound();
        }

    }


    public function praisAction($model, $route){

        $logo = 'Прайс лист';

        $title = $logo.' |'.$this->title;

        $this->meta($title,$title.' '.$this->configs['about']['description']);


        $product[] = \R::getAll('SELECT * FROM `_metal_armature` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_channel` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_circle` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_corner` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_galvanized-products` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_mortar-grid` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_pipes-water-pipelines` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_profile-pipes` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_square` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_strip` WHERE active = 1');
        $product[] = \R::getAll('SELECT * FROM `_metal_wire` WHERE active = 1');



        //pr1($product);

        $this->render(compact('product','logo'));



    }

}