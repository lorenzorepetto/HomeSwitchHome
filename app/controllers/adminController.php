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
use Ocrend\Kernel\Helpers\Functions;

/**
 * Controlador admin/
*/
class adminController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);
        
        $a = new Model\Admin;
        $r = new Model\Residencias;
        $u = new Model\Usuarios;


        if (isset($_SESSION['id'])) {
            if ($_SESSION['rol'] != 'ADMINISTRADOR') {
                $this->template->display('usuarios/iniciar');
            }
        }
        else{
            $this->template->display('usuarios/iniciar');
        }


        switch ($router->getMethod()) {


            case 'operaciones':
                
                switch ($router->getId()) {
                    
                    case 'editar_residencias':
                        Functions::redir("http://localhost/HomeSwitchHome/residencias/listar");
                        break;

                    case 'agregar_residencia':
                        echo $this->template->display('usuarios/agregar_residencia');
                        break;
                    
                    default:
                        $this->template->display('usuarios/iniciar');
                        break;
                }


                break;



            case 'residencias':
                
                switch ($router->getId()) {
                    
                    case 'insertar':
                        $this->insertarResidencia($r);
                        break;
                    
                    default:
                        $this->template->display('usuarios/iniciar');
                        break;
                }





                break;



        	case 'usuarios':

                switch ($router->getId()) {
                    
                    case 'cambiarRol':
                            //$a->cambiarRol($router->getId(true));
                            $this->template->display('home/homeBackend');
                        break;
                    
                    default:
                        $this->template->display('usuarios/iniciar');
                        break;
                }

        		
        	   break;
        	

        }



    }


    /*

    -------------------------------------------AGREGAR---------------------------------------------------

    */


    public function insertarResidencia($r){

        $errores= array('nombre_existente' => 0,
                         'sin_error' => 0);


        
        $nombre=$_POST['nombre'];

        //Valido el nombre
        if ($r->existe($nombre)) {
            $errores['nombre_existente'] = 1;            
        }


        if (!$errores['nombre_existente']) {
            //Registro exitoso
            $r->insertar();
            $errores['sin_error'] = 1;
        }

        echo $this->template->display('home/homeBackend',$errores); 

    }





}