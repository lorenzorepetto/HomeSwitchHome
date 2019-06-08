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
use Ocrend\Kernel\Helpers\Strings;

/**
 * Controlador filtros/
*/
class filtrosController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);


        $f = new Model\Filtros;
        $r = new Model\Residencias;
        $u = new Model\Usuarios;
        $e = new Model\Estadias;


        switch ($router->getMethod()) {
        	
        	case 'filtrarEstadias':
        		$this->filtrarEstadias($f);
        		break;
        	
        	default:
        		# code...
        		break;
        }
      
    }


    public function filtrarEstadias($f){

    	$ciudad = $_POST['ubicacion'];
    	$fecha_desde = $_POST['fecha_desde'];
    	$fecha_hasta = $_POST['fecha_hasta'];


        $fecha_limite = $_GET['fecha'];
        if ($fecha_desde >= $fecha_limite) {
            echo "pero claro";
        }

        //$cumpleMinimo = $this->validarFecha($fecha_desde);
        $rangoValido = $this->validarRango($fecha_desde, $fecha_hasta);
        dump($rangoValido); exit;


    	$f->filtrarEstadias($ciudad,$fecha_desde,$fecha_hasta);
    }



    public function validarRango($desde, $hasta){

        $rango= Strings::date_difference($desde,$hasta);
        dump($rango); exit;

        if ($rango >= 7 && $rango <= 62 ) {
            return true;
        }
        
        return false;
    }


}