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
        	case 'login':
        			echo $this->template->render('usuarios/login');
        		break;
        	
        	case 'autenticar':
        			$this->autenticar($u);
         		break;

        	default:
        			echo $this->template->render('usuarios/usuarios');
        		break;
    	}
    }




    private function autenticar($u){

    	#Guardo los valores del formulario
    	$email= $_POST['email'];
        $pass= $_POST['password'];

        $ok = $u->autenticar($email,$pass);
      
        if ($ok) {
        	#Guardo los datos de la sesion en un arreglo
        	$usuario= array('nombre' => $_SESSION['nombre'] , 'apellido' => $_SESSION['apellido'] );


        	#Envia los datos del arreglo a la vista, junto con el valor TRUE en el index isLogged
        	echo $this->template->render('usuarios/usuarios', array('isLogged' => true,'data' => $usuario ));
        }
        else{
        	#Le envia a la vista solo un valor false en el index isLogged
        	echo $this->template->render('usuarios/usuarios' , array('isLogged' => false));
        }


    }


}