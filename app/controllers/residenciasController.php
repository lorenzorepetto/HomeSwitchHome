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

            case 'listarEstadias':
                $id=$router->getId(true);
                $this->listarMisEstadias($r, $id);
                break;
        	

            case 'detalle':

                $this->detalleResidencia($_SESSION['rol'],$r, $router->getId(true));
                break;



        	default:
        		$this->template->display('home/home');
        		break;
        }

        }else{
            $this->template->display('home/home');
        }
   
    }



    public function detalleResidencia($rol, $r, $id){
        
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

                $mis_estadias = $r->getEstadias($id);
                
            }

        switch ($rol) {
            case 'ADMINISTRADOR':
                $this->template->display('residencias/detalleAdmin', array('residencia' => $residencia, 'estadias' => $mis_estadias));
                break;

            case 'PREMIUM':
                $this->template->display('residencias/detalle', array('residencia' => $residencia, 'estadias' => $mis_estadias, 'premium' => 1));
            break;
            
            default:
                $this->template->display('residencias/detalle', array('residencia' => $residencia, 'estadias' => $mis_estadias, 'premium' => 0));
            break;
        } 
        
    }



    public function listarResidencias($r){

        $residencias = $r->getResidencias();

        $data = array('residencias' => $residencias,
                      'estadias_pendientes' => 0, 
                        'operacion'=> 0);
        
        if (isset($_GET['operacion'])){

            $data['operacion'] =1;
            if (isset($_GET['estadias_pendientes'])) {
                $data['estadias_pendientes'] = $_GET['estadias_pendientes'];
            }

        }
        
        if ($_SESSION['rol']== "ADMINISTRADOR") {
            $this->template->display('residencias/editarResidencias',$data);
        }
        else{
            $this->template->display('residencias/listarResidencias',array('residencias' => $residencias));
        }
    }

    public function listarMisEstadias($r, $id_residencia){

        $mis_estadias = $r->getEstadias($id_residencia);
        $residencia=$r->getResidencia($id_residencia)['0'];

        $data = array('estadias' => $mis_estadias, 
                        'residencia' => $residencia );


        $this->template->display('hotsales/listarEstadias',$data);
    }


}