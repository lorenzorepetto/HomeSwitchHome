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
        $e = new Model\Estadias;


        if (isset($_SESSION['id'])) {
            if ($_SESSION['rol'] != 'ADMINISTRADOR') {
                $this->template->display('home/home');
            }
        }
        else{
            $this->template->display('home/home');
        }


        switch ($router->getMethod()) {


            case 'operaciones':
                
                switch ($router->getId()) {
                    
                    case 'editarResidencias':
                        Functions::redir("http://localhost/HomeSwitchHome/residencias/listar");
                        break;

                    case 'agregarResidencia':
                        echo $this->template->display('residencias/agregarResidencia');
                        break;

                    case 'agregarEstadia':

                        $data = array('id_residencia' => $_GET['id_residencia'] );
                        echo $this->template->display('estadias/agregarEstadia', $data);
                        break;
                    
                    default:
                        $this->template->display('home/home');
                        break;
                }


                break;



            case 'residencias':
                
                switch ($router->getId()) {
                    
                    case 'insertar':
                        $this->insertarResidencia($r);
                        break;
                    
                    default:
                        $this->template->display('home/home');
                        break;
                }

            break;

            case 'estadias':
                
                switch ($router->getId()) {
                    
                    case 'insertar':
                        $this->insertarEstadia($e);
                        break;
                    
                    default:
                        $this->template->display('home/home');
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
                        $this->template->display('home/home');
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



    public function insertarEstadia($e){
        /*aca hago la cuenta para obtener el numero de semana*/
        $data = array('sin_error' => 1,
                        'semana_ocupada' => 0,
                        'id_residencia'=> $_GET['id_residencia']);

        $fecha_inicio=$_POST['fecha_inicio'];
        $monto=$_POST['monto'];
        $id_residencia=$_GET['id_residencia'];
        /*pruebo con semana 1*/
        $semana=1;

        $e->insertar($semana, $monto, $id_residencia);

        echo $this->template->display("estadias/agregarEstadia", $data); 

    }





}