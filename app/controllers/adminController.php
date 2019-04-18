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
 * Controlador admin/
*/
class adminController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);
        
        $a = new Model\Admin;
        $r = new Model\Residencias;
        $u = new Model\Usuarios;


        switch ($router->getMethod()) {


            case 'registrarResidencia':
                # code...
                break;



        	case 'cambiarRol':

        		$a->cambiarRol($router->getId(true));
        		$this->template->display('home/homeBackend');
        	   break;
        	
        	default:
        		$this->template->display('home/homeBackend');
        	   break;
        }



    }


    /*

    -------------------------------------------AGREGAR---------------------------------------------------

    */


    public function insertar($r){

        $errores= array('nombre_existente' => 0);


        $nombre=$_POST['nombre'];

        //Valido el nombre
        if ($r->existe($nombre)) {
            $errores['nombre_existente'] = 1;            
        }


        if (!$errores['nombre_existente']) {
            //Registro exitoso
            $r->insertar();
        }

        echo $this->template->display('home/homeBackend',$errores); 

    }





}