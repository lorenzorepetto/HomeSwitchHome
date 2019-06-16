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
        $u = new Model\Usuarios;



		if (isset($_SESSION['id'])) { 

	        switch ($router->getMethod()) {

	            case 'detalle':

	                $this->detalleSubasta($_SESSION['rol'],$s, $router->getId(true), 0, $u);
	                break;

                case 'pujar':
                    
                    $s->pujar($router->getId(true), $_SESSION['id'] ,$_POST['puja']);
                    $this->detalleSubasta($_SESSION['rol'],$s, $router->getId(true), true,$u);


                    break;


	        	default:
	        		$this->template->display('home/home');
	        		break;
	        }

	    }else{
	            $this->template->display('home/home');
    	}
    }



    public function detalleSubasta($rol, $s, $id, $operacion = 0, $u){
        
        $resultado = $s->getSubasta($id);
        $usuario = null;
        if ($resultado) {

            $subasta = $resultado['0'];
            $puja = $s->getPuja($id);

            
            if ($subasta['usuario_ganador'] != null) {
               $query = $u->getUsuario($subasta['usuario_ganador']);
              
               $usuario = $query['0'];
            }

                               
        }
        
        switch ($rol) {

            case 'ADMINISTRADOR':       
                $this->template->display('subastas/detalleAdmin', array('subasta' => $subasta, 'puja' => $puja['0'], 'operacion' => $operacion, 'usuario' => $usuario));
                break;
            
            default:
                $this->template->display('subastas/detalleLogged', array('subasta' => $subasta, 'puja' => $puja['0']));
                break;
        } 
        
    }


}