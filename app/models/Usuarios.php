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

    
   



    /*

    ------------------------  CONSULTAS  ---------------------------------------------------------------------

    */




    public function getUsuario($id){
        
        $resultado = $this->db->select('*', 'usuarios', null, "id = '$id'");
        return $resultado;

    }


    public function existe($email){

        $resultado= $this->db->select('*', 'usuarios', null, "email = '$email'");

        if ($resultado){
            return true;
        }

        return false;
    }



    /*

    ------------------------  SESIONES  ---------------------------------------------------------------------

    */

    public function autenticar($email,$pass){

        $usuario = $this->db->select('*', 'usuarios', null, "email = '$email' AND password = '$pass'");
        if ($usuario){

            $this->generarSesion($usuario);
            return true;
        }

        return false;
    }
    
    
     private function generarSesion($usuario){  
        global $session;

        # Generar la sesión del usuario
        $_SESSION['id'] = $usuario['0']['id'];
        $_SESSION['nombre'] = $usuario['0']['nombre'];
        $_SESSION['apellido'] = $usuario['0']['apellido'];
        $_SESSION['rol'] = $usuario['0']['rol'];


    }



    /*

    ------------------------  CREAR USUARIO  ---------------------------------------------------------------------

    */

   
    
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


    /*

    ------------------------  MODIFICACIONES  ---------------------------------------------------------------------

    */

    public function update($id, $datos){

        $resultado = $this->db->update('usuarios', $datos, "id = '$id'");

        if ($resultado){
            return true;
        }

        return false;
    }


    public function descontarCredito($id){

        $usuario = $this->db->select('creditos', 'usuarios', null, "id = '$id'");

        $creditos = $usuario['0']['creditos'];
        $creditos = $creditos - 1;

        $this->update($id, array('creditos' => $creditos ));

    }


    public function cambiarRol($id){

        $usuario = $this->db->select('rol', 'usuarios', null, "id = '$id'");

        if ($usuario['0']['rol'] == 'ESTANDAR'){
            $nuevo_rol = 'PREMIUM';
        }
        elseif ($usuario['0']['rol'] == 'PREMIUM') {
            $nuevo_rol = 'ESTANDAR';
        }

        $this->update($id, array('rol' => $nuevo_rol)); 

    }
    


    


    

    
}