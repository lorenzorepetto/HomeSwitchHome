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
 * Controlador usuarios/
*/
class usuariosController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router);
        
        #Instancio un objeto Usuario
        $u = new Model\Usuarios;

        switch ($this->method) {
        	case 'iniciar':
        			echo $this->template->display('usuarios/iniciar');
        		break;
        	case 'autenticar':
        			$this->autenticar($u);
         		break;
            case 'registrar':
                    echo $this->template->display('usuarios/registrar');
                break;
            
            case 'insertar':
                    $this->insertar($u);
                break;


            case 'perfil':
                    $this->perfil($u);
                break;

            case 'logout':
                    $this->logout();    
                break;    

        	default:
        			echo $this->template->display('home/home');
        		break;
    	}
    }



    public function insertar($u){
        $email=$_POST['email'];
        if (!$u->existe($email)) {
            $u->insertar();
        }

        echo $this->template->display('home/home');
    }


    private function logout(){

        if (isset($_SESSION['id'])) {
           
            #Destruir la sesión
            session_destroy();
           
        }
        echo $this->template->display('home/home');
    }



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
        	#Le envia a la vista solo un valor false en el index isLogged
        	echo $this->template->display('usuarios/login');
        }
    }



    public function perfil($u){
        
        $id = $_SESSION['id'];
        
        if ($id) {
               
            $resultado = $u->perfil($id);

            if ($resultado) {
                
                $usuario = array(
                'id' => $resultado['0']['id'],
                'email' => $resultado['0']['email'],
                'nombre' => $resultado['0']['nombre'],
                'apellido' => $resultado['0']['apellido'],
                'foto' => $resultado['0']['foto'],
                'creditos' => $resultado['0']['creditos'],
                'rol' => $resultado['0']['rol'],
                 );
            }
            

            #ACA IMPRIMO EL USUARIO PARA QUE VEAS COMO ESTA LA FOTO EN LA BASE
            dump($usuario);

            $this->template->display('usuarios/perfil', $usuario);
        }
        
    }


    


}