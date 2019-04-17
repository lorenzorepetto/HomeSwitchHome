<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace app\controllers;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Controllers\Controllers;
use Ocrend\Kernel\Controllers\IControllers;
use Ocrend\Kernel\Router\IRouter;

/**
 * Controlador prueba/
*/
class pruebaController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);


        $_SESSION['error_login'] = 1;

        $datos = array('error' => $_SESSION['error_login']);

        unset($_SESSION['error_login']);
        
        $this->template->display('prueba/prueba',$datos);

        
    }
}