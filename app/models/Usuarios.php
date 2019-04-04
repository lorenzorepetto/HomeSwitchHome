<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Models\Models;
use Ocrend\Kernel\Models\IModels;
use Ocrend\Kernel\Models\ModelsException;
use Ocrend\Kernel\Models\Traits\DBModel;
use Ocrend\Kernel\Router\IRouter;

/**
 * Modelo Usuarios
 */
class Usuarios extends Models implements IModels {
    use DBModel;

    /**
     * Respuesta generada por defecto para el endpoint
     * 
     * @return array
    */ 
    public function foo() : array {
        try {
            global $http;
                    
            return array('success' => 0, 'message' => 'Funcionando');
        } catch(ModelsException $e) {
            return array('success' => 0, 'message' => $e->getMessage());
        }
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

    
    private function generarSesion($usuario){  
        global $session;

        # Generar la sesión del usuario
        $_SESSION['id'] = $usuario['0']['id'];
        $_SESSION['nombre'] = $usuario['0']['nombre'];
        $_SESSION['apellido'] = $usuario['0']['apellido'];
        $_SESSION['rol'] = $usuario['0']['rol'];


    }


    
    public function insertar(){
        
        if (isset($_FILES["foto"]["tmp_name"])) {
            $foto= $_FILES["foto"]["tmp_name"];
            $nombrefoto = $_FILES["foto"]["name"];
            $foto  = $_FILES['foto']['tmp_name'];

            $foto= $this->db->scape($foto);
        }
        else{
            $foto=null;
        }
        

        $u = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'foto' => $foto,
            'telefono' => $_POST['telefono'],
            'creditos' => 2,
            'marca_tarjeta' => $_POST['marca_tarjeta'],
            'numero_tarjeta' => $_POST['numero_tarjeta'],
            'fecha_vencimiento_tarjeta' => $_POST['fecha_vencimiento_tarjeta'],
            'rol' => "ESTANDAR"
        );

        $this->db->insert('usuarios',$u);

    }

    


    public function autenticar($email,$pass){

        $usuario = $this->db->select('*', 'usuarios', null, "email = '$email' AND password = '$pass'");
        
        if ($usuario){

            $this->generarSesion($usuario);
            return true;
        }

        return false;
    }
    
    
    public function existe($email){

        $resultado= $this->db->select('*', 'usuarios', null, "email = '$email'");

        if ($resultado){
            return true;
        }

        return false;
    }
    

    
}