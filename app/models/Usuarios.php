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

    public function tieneCredito($id){
        $resultado = $this->db->select('*', 'usuarios', null, "estado_logico = 0 and creditos >= 1 and id='$id'");
        return $resultado[0];

    }


    public function restarCredito($id){
        $resultado = $this->db->select('creditos', 'usuarios', null, "estado_logico = 0 and id='$id'");
        $datos_nuevos = array('creditos' => $resultado[0]['creditos']-1 );
        $this->db->update('usuarios', $datos_nuevos, "id = '$id'");
    }



    public function getUsuario($id){

        $resultado = $this->db->select('*', 'usuarios', null, "id = '$id' AND estado_logico = 0");
        return $resultado;

    }


    public function existe($email){

        $resultado= $this->db->select('*', 'usuarios', null, "email = '$email' AND estado_logico = 0");

        if ($resultado){
            return true;
        }

        return false;
    }

    public function getUsuarios(){

        $resultado = $this->db->select('*', 'usuarios', null, "estado_logico = 0 and rol != 'ADMINISTRADOR' ORDER BY fecha_registro DESC");
        return $resultado;
    }



    /*

    ------------------------  SESIONES  ---------------------------------------------------------------------

    */

    public function autenticar($email,$pass){

        $usuario = $this->db->select('*', 'usuarios', null, "email = '$email' AND password = '$pass' AND estado_logico = 0");
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



    public function insertar($t){


        if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {
            $nombrefoto = $_FILES["foto"]["name"];
            $foto = "app/img/usuarios/" . $nombrefoto;
            $foto = $this->db->scape($foto);
        }
        else{
            $foto="app/img/usuarios/user.png";
        }

        $fecha_registro = Date("Y-m-d");


        $u = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'foto' => $foto,
            'telefono' => $_POST['telefono'],
            'creditos' => 2,
            'rol' => "ESTANDAR",
            'fecha_registro' => $fecha_registro
        );

        $id_usuario=$this->db->insert('usuarios',$u);

        $tarjeta = array ('marca' => $_POST['marca_tarjeta'],
                            'numero' => $_POST['numero_tarjeta'],
                            'vencimiento' => $_POST['fecha_vencimiento_tarjeta'],
                            'titular' => $_POST['titular_tarjeta'],
                            'id_usuario' => $id_usuario,
                            'principal' => true );

        $t->insertar($tarjeta);

    }


    /*

    ------------------------  MODIFICACIONES  ---------------------------------------------------------------------

    */

    public function update($id, $datos){

        if (is_uploaded_file($_FILES["fotoP"]["tmp_name"])) {
            $nombrefoto = $_FILES["fotoP"]["name"];
            $foto = "app/img/usuarios/" . $nombrefoto;
            $foto = $this->db->scape($foto);
            $datos['foto']=$foto;
        }
        

        $resultado = $this->db->update('usuarios', $datos, "id = '$id' AND estado_logico = 0");

        if ($resultado){
            return true;
        }

        return false;
    }



    public function delete($id){

        $usuario = $this->db->select('estado_logico', 'usuarios', null, "id = '$id' AND estado_logico = 0");

        if ($usuario['0']['estado_logico']) {
            $this->update($id, array('estado_logico' => 1 ));
        }

    }







    public function descontarCredito($id){

        $usuario = $this->db->select('creditos', 'usuarios', null, "id = '$id' AND estado_logico = 0");

        $creditos = $usuario['0']['creditos'];
        $creditos = $creditos - 1;

        $this->update($id, array('creditos' => $creditos ));

    }


    public function cambiarRol($id){

        $usuario = $this->db->select('rol', 'usuarios', null, "id = '$id' AND estado_logico = 0");

        if ($usuario['0']['rol'] == 'ESTANDAR'){
            $nuevo_rol = 'PREMIUM';
        }
        elseif ($usuario['0']['rol'] == 'PREMIUM') {
            $nuevo_rol = 'ESTANDAR';
        }

        $this->update($id, array('rol' => $nuevo_rol));
        return true;

    }









}
