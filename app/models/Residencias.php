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
 * Modelo Residencias
 */
class Residencias extends Models implements IModels {
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




    public function getResidencia($id){
        
        $resultado = $this->db->select('*', 'residencias', null, "id = '$id' AND estado_logico = 0");
        return $resultado;
    }


    public function getResidencias(){

        $resultado = $this->db->select('*', 'residencias', null, "estado_logico = 0 ORDER BY nombre");
        return $resultado;
    }

    public function getEstadias($id){

        $resultado = $this->db->select('*', 'estadias', null, "estado='LIBRE' and id_residencia = '$id' ORDER BY semana");
        return $resultado;
    }


    public function getEstadiasPendientes($id){

        $resultado = $this->db->select('*', 'estadias', null, "(estado = 'OCUPADA' or estado='SUBASTA' or estado='HOTSALE') and id_residencia = '$id'");
        return $resultado;
    }




    public function existe($nombre){

        $resultado= $this->db->select('*', 'residencias', null, "nombre = '$nombre' AND estado_logico = 0");

        if ($resultado){
            return true;
        }

        return false;
    }



    public function tienePendientes($id){

        //puede tener estadias reservadas, en subasta o hotsale
        $resultado = $this->db->select('e.id as id_estadia,  
                                        r.id as id_residencia', 
                                        'residencias r', 
                                        'INNER JOIN estadias e ON (e.id_residencia = r.id)', 
                                        "r.id = '$id' AND (e.estado = 'SUBASTA' OR e.estado = 'HOTSALE' OR e.estado = 'OCUPADA')");

        if ($resultado) {
            //tiene pendientes
            return true;
        }
        
        return false; //no tiene pendientes

    }


     /*

    ------------------------  CREAR RESIDENCIA  ---------------------------------------------------------------------

    */

   
    
    public function insertar(){
        



        if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {
            $nombrefoto = $_FILES["foto"]["name"];
            $foto = "app/img/residencias/" . $nombrefoto; 
            $foto = $this->db->scape($foto);
        }
        else{
            $foto=null;
        }
        

        $r = array(
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'foto' => $foto,
            'capacidad' => $_POST['capacidad'],
            'calle' => $_POST['calle'],
            'altura' => $_POST['altura'],
            'ciudad' => $_POST['ciudad'],
            'provincia' => $_POST['provincia']
        );


        $id= $this->db->insert('residencias',$r);
        return $id;

    }


    /*

    ------------------------  MODIFICACIONES  ---------------------------------------------------------------------

    */

    public function update($id, $datos){

        $resultado = $this->db->update('residencias', $datos, "id = '$id' AND estado_logico = 0");

        if ($resultado){
            return true;
        }

        return false;
    }



    public function delete($id){

        $residencia = $this->db->select('estado_logico', 'residencias', null, "id = '$id' AND estado_logico = 0");

        if (!$residencia['0']['estado_logico']) {
            $this->update($id, array('estado_logico' => 1 ));
        }

    }



    public function editar($r){


        if (is_uploaded_file($_FILES["fotoM"]["tmp_name"])) {
            $nombrefoto = $_FILES["fotoM"]["name"];
            $foto = "app/img/residencias/" . $nombrefoto; 
            $foto = $this->db->scape($foto);
        }
        else{
            $foto= $r['0']['foto'];
        }

        $nuevosDatos = array(
            'nombre' => !empty($_POST['nombreM']) ? $_POST['nombreM'] : $r['0']['nombre'],
            'descripcion' => !empty($_POST['descripcionM']) ? $_POST['descripcionM'] : $r['0']['descripcion'],
            'foto' => $foto,
            'capacidad' => !empty($_POST['capacidadM']) ? $_POST['capacidadM'] : $r['0']['capacidad'],
            'calle' => !empty($_POST['calleM']) ? $_POST['calleM'] : $r['0']['calle'],
            'altura' => !empty($_POST['alturaM']) ? $_POST['alturaM'] : $r['0']['altura'],
            'ciudad' => !empty($_POST['ciudadM']) ? $_POST['ciudadM'] : $r['0']['ciudad'],
            'provincia' => !empty($_POST['provinciaM']) ? $_POST['provinciaM'] : $r['0']['provincia']
        );


        $this->update($r['0']['id'],$nuevosDatos);
    }



}