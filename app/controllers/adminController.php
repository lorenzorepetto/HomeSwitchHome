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
        $s = new Model\Subastas;


        if($router->getMethod() and !isset($_SESSION['id'])){
            switch ($router->getMethod()) {
                case 'token':
                    $this->autenticar($a);
                    break;
                
                default:
                    $this->template->display('home/home');
                    break;
            }
        }
        else{

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

                    case 'agregarSubasta':
                        $estadias = $e->getEstadiasConResidencia();
                        $this->template->display('subastas/agregarSubasta',array('estadias' => $estadias ));
                        break;

                    case 'verSubastas':
                        $subastas= $s->getSubastasConEstadiaYResidencia();
                        $this->template->display('subastas/verSubastas',array('subastas' => $subastas));
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
                        $id = $_GET['id_residencia'];
                        $resultado = $r->getResidencia($id);
                        $data = array('residencia' => $resultado['0'], 
                                        'nombre_existente' => 0, 
                                        'sin_error' => 0);
                        $this->editarResidencia($r, $data);
                        
                        break;

                    case 'eliminar':
                        $this->eliminarResidencia($r);
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

            case 'subastas':
                switch ($router->getId()) {
                    
                    case 'insertar':
                        $id_estadia= $_GET['id_estadia'];
                        $this->insertarSubasta($s, $id_estadia, $e);
                        break;

                    case 'cerrar':
                        $id_subasta= $_GET['id_subasta'];

                        $this->cerrarSubasta($u, $s, $id_subasta, $e);
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

    } //end else

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
        
        $data = array('sin_error' => 0, //esta en 1 cuando esta todo ok
                        'semana_ocupada' => 0,
                        'id_residencia'=> $_GET['id_residencia']);

        $monto=$_POST['monto'];
        $fecha_inicio= $_POST['fecha_inicio'];
        $id_residencia = $_GET['id_residencia'];

        $semana = $this->calcularSemana($fecha_inicio);
        

        //Valido si ya existe una estadia para esa residencia y semana
        if ($e->existe($semana, $id_residencia)) {
            $data['semana_ocupada'] = 1;            
        }
        else{
            //puedo crear la estadia  
            $e->insertar($semana, $monto, $id_residencia);
            $data['sin_error'] = 1;
        }

        echo $this->template->display("estadias/agregarEstadia", $data); 

    }




    private function insertarSubasta($s, $id_estadia, $e){
        $data = array('sin_error' => 0, //está en 1 cuando esta todo ok
                        'estadia_ocupada' => 0, 
                      'subasta_existente'=> 0, 
                        'falta_monto' =>0);

        $monto= $_POST['monto'.$id_estadia];

        if ($monto == ' ' or $monto<= 0) {
            $data['falta_monto'] =1;
        }

        /*debe crearse con al menos 6 meses de anticipacion (es igual a 52/2=26 semanas)
        $semana_estadia = $e->getSemana($id_estadia);

        $hoy= date("Y-m-d");        
        $semana_hoy = $this->calcularSemana($hoy);
        
        if ($semana_hoy > ($semana_estadia - 26)) {
            $data['error_anticipacion'] = 1;
        }
        */

        if($s->existe($id_estadia)){
            $data['subasta_existente'] = 1;
        }
        
        
        if($e->estaOcupada($id_estadia)){
            $data['estadia_ocupada']=1;
        }
        
        $subasta=null;
        if (!$data['estadia_ocupada'] && !$data['subasta_existente'] && !$data['falta_monto']){
            $s->insertar($e, $id_estadia, $monto);
            $subasta= $s->existe($id_estadia);
            $data['sin_error'] = 1;
        }

        $estadias= $e->getEstadiasConResidencia();
        $this->template->display("subastas/agregarSubasta", array('estadias' => $estadias,'data' => $data, 'subasta' => $subasta['0'])); 
        

    }


    private function calcularSemana($fecha){
        $f = explode("-", $fecha);
        $a = $f[0];
        $m = $f[1];
        $d = $f[2]; 

        $semana = ( ($m * 4 * 7 ) - (28.5 - $d ) ) / 7;
        $semana = ceil($semana);
        return intval($semana);
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



    private function editarResidencia($r, $data){

        $nombre=$_POST['nombreM'];
        $id_residencia=$data['residencia']['id'];

        $residenciaActual= $r->getResidencia($id_residencia); 
        //Valido el nombre
        if ($nombre != $residenciaActual[0]['nombre']) {
            if ($r->existe($nombre)) {
                $data['nombre_existente'] = 1;            
            }
        }


        if (!$data['nombre_existente']) {
            //Editar
            $r->editar($r->getResidencia($id_residencia));
            $data['sin_error'] = 1;
            $resultado = $r->getResidencia($id_residencia);
            $data['residencia'] = $resultado['0'];
        }

        $this->template->display('residencias/modificarResidencia',$data);


    }



    private function eliminarResidencia($r){

        $data = array('id_residencia' => $_GET['id_residencia'],
                      'estadias_pendientes' => 0 ,
                       'sin_error' => 0);

        //me fijo si hay estadias pendientes
        $resultado = $r->getEstadiasPendientes($_GET['id_residencia']);


        if ($resultado) {
            $data['estadias_pendientes'] = 1;
        }
        else{
            //no se encontraron estadias, se puede eliminar

            $r->delete($_GET['id_residencia']);
            $data['sin_error'] = 1;
        }

        $estadias_pendientes = $data['estadias_pendientes'];

        Functions::redir("http://localhost/HomeSwitchHome/residencias/listar?operacion=1&estadias_pendientes=$estadias_pendientes");

    }

    private function cerrarSubasta($u, $s, $id_subasta, $e){

        $data = array('id_subasta' => $id_subasta,
                      'sin_error' =>0, 
                      'usuario_ganador' => 0);

        $subasta= $s->getSubasta($id_subasta);
        $usuario= null;

        if ($subasta) {

            $data=$s->cerrar($e, $u, $subasta);

            if ($data['usuario_ganador']) {
                $usuario=$u->getUsuario($data['usuario_ganador']);
            }
            
        }
        $subasta= $s->getSubasta($id_subasta);
        $puja = $s->getPuja($id_subasta);

        $subastas= $s->getSubastasConEstadiaYResidencia();
        $this->template->display('subastas/detalleAdmin',array('subasta' => $subasta['0'], 'puja' => $puja['0'], 'data'=> $data, 'usuario' => $usuario['0'], 'operacion' => 0 ));
    }

}