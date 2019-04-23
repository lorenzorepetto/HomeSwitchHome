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
use Ocrend\Kernel\Helpers\Arrays;

/**
 * Controlador home/
 *
 * @author Ocrend Software C.A <bnarvaez@ocrend.com>
*/
class homeController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $r = new Model\Residencias;


        


        if (isset($_SESSION['id'])) {
        	if ($_SESSION['rol']=='ADMINISTRADOR') {
        		$this->template->display('home/homeBackend');
        	}
        	else{
        		$this->template->display('home/homeLogged');
        	}
        }
        elseif($router->getMethod() == 'error_login') {
            $error_login=1;
            $this->renderHome($r, $error_login);
        }
        else{
            $this->renderHome($r);
        }
    }
    

    public function renderHome($r,$error_login = 0){



        $resultado = $r->getResidencias();

        $residencia = Arrays::array_random_element($resultado);

        $datos = array('residencia' => $residencia,
                        'error_login' => $error_login);

        $this->template->display('home/home', $datos);

    }



}