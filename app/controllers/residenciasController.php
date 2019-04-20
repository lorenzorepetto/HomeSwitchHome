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
 * Controlador residencias/
*/
class residenciasController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);

        $r = new Model\Residencias;

        if (isset($_SESSION['id'])) { 

        switch ($router->getMethod()) {

        	case 'listar':
                $this->listarResidencias($r);
                break;
        	

            case 'detalle':
                $this->detalleResidencia($r, $router->getId(true));
                break;



        	default:
        		$this->template->display('home/home');
        		break;
        }

        }else{
            $this->template->display('home/home');
        }
   
    }


    public function detalleResidencia($r, $id){
        
        $resultado = $r->getResidencia($id);
        
        if ($resultado) {

                $residencia = array(
                'id' => $resultado['0']['id'],
                'nombre' => $resultado['0']['nombre'],
                'descripcion' => $resultado['0']['descripcion'],
                'foto' => $resultado['0']['foto'],
                'capacidad' => $resultado['0']['capacidad'],
                'estado_logico' => $resultado['0']['estado_logico'],
                'calle' => $resultado['0']['calle'],
                'altura' => $resultado['0']['altura'],
                'ciudad' => $resultado['0']['ciudad'],
                'provincia' => $resultado['0']['provincia']
                 );
            }


        $this->template->diplay('residencias/detalleResidencia',$residencia);
    }



    public function listarResidencias($r){

        $residencias = $r->getResidencias();


        if ($_SESSION['rol']== "ADMINISTRADOR") {
            $this->template->display('residencias/editarResidencias',array('residencias' => $residencias));
        }
        else{
            $this->template->display('residencias/listarResidencias',array('residencias' => $residencias));
        }
    }


}