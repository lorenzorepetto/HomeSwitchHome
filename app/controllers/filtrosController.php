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
use Ocrend\Kernel\Helpers\Functions;

/**
 * Controlador filtros/
*/
class filtrosController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $router->setRoute('/fecha_desde');
        $router->setRoute('/fecha_hasta');
        $router->setRoute('/ciudad');



        $f = new Model\Filtros;
        $r = new Model\Residencias;
        $u = new Model\Usuarios;
        $e = new Model\Estadias;


        switch ($router->getMethod()) {

        	case 'filtrarEstadias':

        		$this->filtrarEstadias($f);
        		break;

            case 'detalleResidencia':
                $this->detalleResidencia($r,$f,$router->getId(),$router->getRoute('/fecha_desde'),$router->getRoute('/fecha_hasta'),$router->getRoute('/ciudad'));
                break;

        	default:
        		# code...
        		break;
        }

    }



    public function detalleResidencia($r,$f,$id,$desde,$hasta,$ciudad){


        $residencia = $r->getResidencia($id)[0];
        $estadias = $f->getEstadias($id,$desde,$hasta);
        $subastas = $f->getSubastas($id,$desde,$hasta);
        $premium=false;


        if (isset($_SESSION['id']) && $_SESSION['rol'] != 'ADMINISTRADOR'){
            if ($_SESSION['rol'] == 'PREMIUM'){
                $premium=true;
            }
        }else{
            $this->template->display('home/home');
        }

        $data = array('residencia' => $residencia,
                      'estadias' => $estadias,
                      'subastas' => $subastas,
                      'premium' => $premium,
                      'fecha_desde' => $desde,
                      'fecha_hasta' => $hasta,
                      'ciudad' => $ciudad);



        $this->template->display('filtros/verDetalleResidencia', $data);
    }



    public function filtrarEstadias($f){

    	$ciudad = $_GET['ubicacion'];
    	$fecha_desde = $_GET['fecha_desde'];
    	$fecha_hasta = $_GET['fecha_hasta'];

        $data = array('residencias' => null,
                      'fecha_desde' => $fecha_desde,
                      'fecha_hasta' => $fecha_hasta,
                      'ciudad' => $ciudad);

        $desde = date_create($fecha_desde);
        $hasta = date_create($fecha_hasta);

        //valido fecha inicio y rango
        $fecha_inicio = $this->validarFechaInicio($desde);
        $rango_valido = $this->validarRango($desde,$hasta);

        if ($fecha_inicio && $rango_valido) {

            $residencias = $f->filtrarEstadias($ciudad,$fecha_desde,$fecha_hasta);
            $data['residencias'] = $residencias;

            $this->template->display('filtros/resultadosFiltro', $data);

        }else{
            $data['error'] = 1;
            Functions::redir("http://localhost/HomeSwitchHome?ciudad=$ciudad&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta&error=1");
            //$this->template->display('home/homeLogged?ciudad=$ciudad&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta', $data); // para guardar los valores en el form
        }

    }



    public function validarRango($desde, $hasta){

        $interval = date_diff($desde, $hasta);

        if ($interval->days >= 7 && $interval->days <= 62 ) {
            return true;
        }

        return false;
    }


    public function validarFechaInicio($desde){

        $hoy = date_create();

        $fecha_minima=date('Y-m-d', strtotime('+6 month'));
        $fecha_minima = date_create($fecha_minima);

        return $desde >= $fecha_minima;

    }


}
