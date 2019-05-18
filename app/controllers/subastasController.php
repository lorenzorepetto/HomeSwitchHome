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
 * Controlador subastas/
*/
class subastasController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);
        $s = new Model\Subastas;




		if (isset($_SESSION['id'])) { 

	        switch ($router->getMethod()) {

	            case 'detalle':

	                $this->detalleSubasta($_SESSION['rol'],$s, $router->getId(true));
	                break;

	        	default:
	        		$this->template->display('home/home');
	        		break;
	        }

	    }else{
	            $this->template->display('home/home');
    	}
    }

    public function detalleSubasta($rol, $s, $id){
        
        $resultado = $s->getSubasta($id);
        
        if ($resultado) {

                $subasta = array(
                'id' => $resultado['0']['id'],
                'fecha_inicio' => $resultado['0']['fecha_inicio'],
                'fecha_fin' => $resultado['0']['fecha_fin'],
                'estado' => $resultado['0']['estado'],
                'usuario_ganador' => $resultado['0']['usuario_ganador'],
                'id_estadia' => $resultado['0']['id_estadia'],
                'monto' => $resultado['0']['monto']
                 );

                $mis_pujas = $s->getPujas($id);
                
            }

        switch ($rol) {
            case 'ADMINISTRADOR':
                $this->template->display('subastas/detalleAdmin', array('subasta' => $subasta, 'pujas' => $mis_pujas));
                break;
            
            default:
                $this->template->display('subastas/detalle', array('subasta' => $subasta, 'pujas' => $mis_pujas));
                break;
        } 
        
    }

}