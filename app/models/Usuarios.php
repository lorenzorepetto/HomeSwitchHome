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
        # Generar la sesión del usuario
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['rol'] = $usuario['rol'];
    }


    private function insertar(){
        #FALTA VALIDAR

        $u = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'foto' => addslashes(file_get_contents($_FILES['foto']['tmp_name'])),
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

        $resultado= $this->db->query("SELECT id,nombre,apellido,rol
                                      FROM usuarios
                                      WHERE email='$email' and password='$pass'");

        if (mysqli_num_rows($resultado)){
            $usuario= mysqli_fetch_array($resultado);
            $this->generarSesion($usuario);
            return true;
        }

        return false;

    }
    

    public function existe($email){

        $resultado= $this->db->query("SELECT id,nombre,apellido,rol
                                      FROM usuarios
                                      WHERE email='$email'");

        if (mysqli_fetch_array($resultado)){
            return true;
        }

        return false;
    }


    
}