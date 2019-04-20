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

        $resultado = $this->db->select('*', 'residencias', null, "estado_logico = 0");
        return $resultado;
    }




    public function existe($nombre){

        $resultado= $this->db->select('*', 'residencias', null, "nombre = '$nombre' AND estado_logico = 0");

        if ($resultado){
            return true;
        }

        return false;
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


        $this->db->insert('residencias',$r);

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

        if ($residencias['0']['estado_logico']) {
            $this->update($id, array('estado_logico' => 1 ));
        }

    }




}