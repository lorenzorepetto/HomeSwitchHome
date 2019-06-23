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
 * Controlador usuarios/
*/
class usuariosController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);
        
        #Instancio un objeto Usuario
        $u = new Model\Usuarios;
        $s = new Model\Subastas;
        $e = new Model\Estadias;
        $r = new Model\Residencias;
        $t = new Model\Tarjeta;
               
        switch ($router->getMethod()) {

            case 'cuenta':
                
                    switch ($router->getId()) {

                        case 'iniciar':
                            echo $this->template->display('home/home');
                            break;
                        
                        case 'logout':
                            $this->logout();    
                            break;  

                        case 'autenticar':
                            $this->autenticar($u);
                            break;

                        
                        default:
                            echo $this->template->display('home/home');
                            break;
                        
                    }

            break;


        	
            case 'registro':
                
                    switch ($router->getId()) {

                        case 'registrar':
                            echo $this->template->display('usuarios/registrar');
                            break;
            
                        case 'insertar':
                            $this->insertar($u, $t);
                            break;


                        default:
                            echo $this->template->display('home/home');
                            break;
                        
                    }


                break;


        	
            case 'operaciones':
                
                switch ($router->getId()) {

                    case 'perfil':
                        $this->perfil($u, $t);
                        break;

                    case 'modificar_perfil':
                        $id_usuario = $_GET['id'];
                        $this->modificar_perfil($u, $id_usuario);
                        break;

                    case 'ver_estadias':
                        $this->verEstadias($e);
                        break;

                    case 'descontarCredito':
                        $this->descontarCredito($u);
                        break; 

                    default:
                        echo $this->template->display('home/home');
                        break;
                }


                   

            break;

            case 'subastas':

                switch ($router->getId()) {

                    case 'verSubastas':
                        $subastas= $s->getSubastasConEstadiaYResidencia();
                        $this->template->display('subastas/verSubastasLogged', array('subastas' => $subastas));

                    break;
                    
                    default:
                        echo $this->template->display('home/home');
                    break;
                }
            break;

            

            case 'cambiarRol':
                    $this->cambiarRol($u);
                break;


            case 'verDetalleResidencia':
                $id= $router->getId();

                $this->verDetalleResidencia($r,$id);
                break;

            case 'perfil':
                switch ($router->getId()) {

                    case 'modificar':

                    break;
                    
                    default:
                        echo $this->template->display('home/home');
                    break;
                }
                break;

             
             default:
                $this->template->display('home/home');
                break; 

    	}

    }



    /*

    -------------------------------------CUENTA----------------------------------------------

    */


    private function autenticar($u){

        #Guardo los valores del formulario
        $email= $_POST['email'];
        $pass= $_POST['password'];

        $ok = $u->autenticar($email,$pass);

        if ($ok) {      

            if ($_SESSION['rol']=='ADMINISTRADOR') {
                $this->template->display('home/homeBackend');
            }
            else{
                $this->template->display('home/homeLogged');
            }
        }
        else{
            //Login fallido
            //$errores = array('error_login' => 1);

            Functions::redir("http://localhost/HomeSwitchHome/home/error_login?email=$email");
        }
    }



    private function logout(){

        if (isset($_SESSION['id'])) {
           
            #Destruir la sesión
            session_destroy();
           
        }
        Functions::redir("http://localhost/HomeSwitchHome/home");
    }



    /*

    -------------------------------------------REGISTRO-------------------------------

    */    


    public function insertar($u, $t){

        $email=$_POST['email'];
        $password=$_POST['password'];
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $telefono=$_POST['telefono'];
        $marca_tarjeta=$_POST['marca_tarjeta'];
        $numero_tarjeta=$_POST['numero_tarjeta'];
        $titular_tarjeta=$_POST['titular_tarjeta'];
        $vencimiento_tarjeta=$_POST['fecha_vencimiento_tarjeta'];

        $originalDate = $_POST['fecha_nacimiento'];
        $newDate = date("d/m/Y", strtotime($originalDate));
        $edad = Strings::calculate_age($newDate);

        $errores= array('email_existente' => 0,
                        'edad_invalida' => 0,
                        'sin_error' => 0, 
                        'email' => $email,
                        'password' => $password,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'fecha_nacimiento' => $originalDate,
                        'telefono' => $telefono,
                        'marca_tarjeta' => $marca_tarjeta,
                        'numero_tarjeta' => $numero_tarjeta,
                        'titular_tarjeta' => $titular_tarjeta,
                        'vencimiento_tarjeta' => $vencimiento_tarjeta);

        //Valido el email
        if ($u->existe($email)) {
            $errores['email_existente'] = 1;            
        }

        //Valido la edad
        if ($edad < 18) {
            $errores['edad_invalida'] = 1;
        }


        if (!$errores['email_existente'] && !$errores['edad_invalida']) {
            //Registro exitoso
            $u->insertar($t);
            $errores['sin_error'] = 1;
        }

        echo $this->template->display('usuarios/registrar',$errores);

    }






    /*

    ----------------------------OPERACIONES--------------------------------------------
    
    */

    public function perfil($u, $t){
                
        if (isset($_SESSION['id'])) {
            
            $id=$_SESSION['id'];

            $resultado = $u->getUsuario($id);

            if ($resultado) {

                $usuario = array(
                'id' => $resultado['0']['id'],
                'email' => $resultado['0']['email'],
                'nombre' => $resultado['0']['nombre'],
                'apellido' => $resultado['0']['apellido'],
                'foto' => $resultado['0']['foto'],
                'creditos' => $resultado['0']['creditos'],
                'rol' => $resultado['0']['rol'],
                'telefono' => $resultado['0']['telefono'],
                'fecha_nacimiento' => $resultado['0']['fecha_nacimiento'], 
                'fecha_registro' => $resultado['0']['fecha_registro']
                 );

                $tarjetas= $t->getTarjetas($id);
            }

            $data = array('usuario' => $usuario, 'tarjetas' => $tarjetas );
            $this->template->display('usuarios/perfil', $data);
        }
        else{
            $this->template->display('home/home');    
        }
        
    }


    public function descontarCredito($u){

        $u->descontarCredito($_SESSION['id']);
        $this->perfil($u);
    }


    public function cambiarRol($u){

        #ESTE METODO TENDRIA QUE IR EN ADMIN CONTROLLER Y LE LLEGARIA UN ID DEL USUARIO A MODIFICAR

        if(isset($_SESSION)){
            if ($_SESSION['rol'] == 'ADMINISTRADOR') {
                $u->cambiarRol($_SESSION['id']);
            }
        }
        
        $this->perfil($u);
    }

    public function modificar_perfil($u, $id_usuario){


        if ($_SESSION['id']==$id_usuario) {

            $resultado = $u->getUsuario($id_usuario);

            if ($resultado) {

                $usuario = array(
                'id' => $resultado['0']['id'],
                'password' => $resultado['0']['password'],
                'nombre' => $resultado['0']['nombre'],
                'apellido' => $resultado['0']['apellido'],
                'foto' => $resultado['0']['foto'],
                'creditos' => $resultado['0']['creditos'],
                'rol' => $resultado['0']['rol'],
                'telefono' => $resultado['0']['telefono'],
                'fecha_nacimiento' => $resultado['0']['fecha_nacimiento'],
                'marca_tarjeta' => $resultado['0']['marca_tarjeta'],
                'numero_tarjeta' => $resultado['0']['numero_tarjeta'],
                'titular_tarjeta' => $resultado['0']['titular_tarjeta'],
                'fecha_vencimiento_tarjeta' => $resultado['0']['fecha_vencimiento_tarjeta']
                 );
            }

            $this->template->display('usuarios/modificar_perfil', $usuario);
        }
        else{
            $this->template->display('home/home');    
        }
    }

    public function verDetalleResidencia($r, $id){
        $residencia = $r->getResidencia($id)[0];
        $estadias = $r->getEstadias($id);
        $premium=false;

        
        if (isset($_SESSION['id']) && $_SESSION['rol'] != 'ADMINISTRADOR'){
            if ($_SESSION['rol'] == 'PREMIUM'){
                $premium=true;
            }
        }else{
            $this->template->display('home/home');  
        }
        $data = array('residencia' => $residencia, 'estadias' => $estadias, 'premium' => $premium);
        $this->template->display('filtros/verDetalleResidencia', $data);

    }


}