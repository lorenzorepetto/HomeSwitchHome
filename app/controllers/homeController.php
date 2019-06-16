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

        $s = new Model\Subastas;



        if (isset($_SESSION['id'])) {
        	if ($_SESSION['rol']=='ADMINISTRADOR') {
        		$this->template->display('home/homeBackend');
        	}
        	else{
                //loggeado
        		$this->template->display('home/homeLogged');
        	}
        }
        elseif($router->getMethod() == 'error_login') {

            $email = $_GET['email'];

            $this->renderHome($s, 1, 0, 0, $email);
        }
        elseif ($router->getMethod() == 'error_token') {
            $this->renderHome($s,1,1);
        }
        elseif ($router->getMethod() == 'token') {
           $this->renderHome($s,0,0,1);
        }
        else{
            $this->renderHome($s);
        }
    }
    

    public function renderHome($s,$error_login = 0, $error_token = 0, $token = 0, $email=""){

        $resultado = $s->getSubastasConEstadiaYResidencia();
        if ($resultado) {
            $subasta = Arrays::array_random_element($resultado);
        }else{
            $subasta = null;
        }

        $datos = array('subasta' => $subasta,
                        'error_login' => $error_login,
                        'error_token' => $error_token,
                        'email' => $email);


        if ($error_token) {
            $this->template->display('home/homeToken', $datos);
        }
        elseif ($error_login) {
            $this->template->display('home/home', $datos);
        }
        elseif ($token) {
            $this->template->display('home/homeToken', $datos);
        }
        else{
            $this->template->display('home/home',$datos);
        }
        


    }



}