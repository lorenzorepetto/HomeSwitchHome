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


        switch ($router->getMethod()) {

            case 'token':
                $this->autenticar($a);
                break;


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
                    

                    case 'editarResidencia':
                        $id = $_GET['id_residencia'];
                        $resultado = $r->getResidencia($id);
                        $data = array('residencia' => $resultado['0']);
                        $this->template->display('residencias/modificarResidencia', $data);
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
                    
                    case 'editar':
                        $this->editarResidencia($r);
                        
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

        echo $this->template->display('residencias/agregarResidencia',$errores); 

    }



    public function insertarEstadia($e){
        /*aca hago la cuenta para obtener el numero de semana*/
        $data = array('sin_error' => 0, //esta en 1 cuando esta todo ok
                        'semana_ocupada' => 0,
                        'id_residencia'=> $_GET['id_residencia']);

        $fecha_inicio=$_POST['fecha_inicio'];
        $monto=$_POST['monto'];
        $id_residencia=$_GET['id_residencia'];

        /*pruebo con semana 1*/
        $semana=1;

        //Valido si ya existe una estadia para esa residencia y semana
        if ($e->existe($semana, $id_residencia)) {
            $data['semana_ocupada'] = 1;            
        }

        if (!$data['semana_ocupada']){
            $e->insertar($semana, $monto, $id_residencia);
            $data['sin_error'] = 1;

        }
        echo $this->template->display("estadias/agregarEstadia", $data); 

    }


    private function autenticar($a){

        #Guardo los valores del formulario
        $token= $_POST['valor_token'];

        $ok = $a->autenticar($token);

        if ($ok) {      
            Functions::redir("http://localhost/HomeSwitchHome/home");
        }
        else{
            //Login fallido
            //$errores = array('error_login' => 1);
            Functions::redir("http://localhost/HomeSwitchHome/home/error_login");
        }
    }



    private function editarResidencia($r){

        $data = array('id_residencia' => $_GET['id_residencia'],
                      'nombre_existente' => 0 ,
                       'sin_error' => 0);

        $nombre=$_POST['nombre'];

        //Valido el nombre
        if ($r->existe($nombre)) {
            $data['nombre_existente'] = 1;            
        }


        if (!$data['nombre_existente']) {
            //Editar
            $r->editar($r->getResidencia($data['id_residencia']));
            $data['sin_error'] = 1;
        }

        $this->template->display('home/homeBackend',$data);


    }



}