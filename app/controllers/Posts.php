<?php
/**
 * Created by PhpStorm.
 * User: Gregor
 * Date: 02.03.2019
 * Time: 10:53
 */

namespace app\controllers;


class Posts {
    public function indexAction(){
        echo 'Posts::index';
    }

    public function viewAction(){
        echo 'Posts::view';
    }
}