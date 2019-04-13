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
 * Controlador residencias/
*/
class residenciasController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $r = new Model\Residencias;

        switch ($router->getMethod()) {
        	case 'insertar':
        		if (isset($_SESSION['rol'])) {
        			if ($_SESSION['rol'] == 'ADMINISTRADOR') {
        				$r->insertar();
        			}
        		}
        		break;
        	
        	default:
        		$this->template->display('home/home');
        		break;
        }


        
    }
}