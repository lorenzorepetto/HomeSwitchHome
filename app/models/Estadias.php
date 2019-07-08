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
 * Modelo Estadias
 */
class Estadias extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

    /*--------------------------CONSULTAS--------------------------*/


    public function estaOcupada($id){
        $resultado = $this->db->select('*', 'estadias', null, "estado='OCUPADA' and id = '$id'");
        return $resultado;

    }

     public function getEstadias(){

        $resultado = $this->db->select('*', 'estadias', null, "estado='LIBRE' ORDER BY estadias.semana");
        return $resultado;
    }

    public function getEstadiasConResidencia(){

        $resultado = $this->db->select('e.id as id_estadia, e.semana, r.id as id_residencia, r.nombre, r.foto, r.calle, r.altura, r.ciudad, r.provincia', 'estadias e', 'INNER JOIN residencias r ON (e.id_residencia = r.id)', "e.estado='LIBRE'");
        return $resultado;
    }

    public function getEstadiaConResidencia($id){

        $resultado = $this->db->select('e.id as id_estadia, e.semana, e.fecha, r.id as id_residencia, r.capacidad, r.nombre, r.descripcion, r.foto, r.calle, r.altura, r.ciudad, r.provincia', 'estadias e', 'INNER JOIN residencias r ON (e.id_residencia = r.id)', "e.estado='LIBRE' and e.id = '$id'");
        return $resultado;
    }

    public function getSemana($id){

        $resultado = $this->db->select('semana', 'estadias', null, "estado='LIBRE' and id = '$id'");
        return $resultado[0]['semana'];
    }


    public function existe($semana, $id_residencia){

        $resultado= $this->db->select('*', 'estadias', null, "id_residencia = '$id_residencia' AND estado<> 'CANCELADA' and semana = '$semana'");

        return $resultado;
    }

    public function cambiarEstado($id, $estado){

        $estadia = array('estado' => $estado );
        $this->db->update('estadias', $estadia, "id='$id'");

    }


    public function getEstadiasParaSubastar(){
        //necesito saber como filtrar las fechas
        $fecha=date('Y-m-d', strtotime('+6 month'));

        $resultado = $this->db->select('e.id as id_estadia,
                                        e.semana,
                                        e.fecha,
                                        r.id as id_residencia,
                                        r.nombre,
                                        r.foto',
                                        'estadias e',
                                        'INNER JOIN residencias r ON (e.id_residencia = r.id)',
                                        "e.estado='LIBRE' AND e.fecha > '$fecha'");
        return $resultado;
    }

    /*
    ----------------------------------INSERTAR ESTADIA----------------------------------------
    */

    public function insertar($semana, $id_residencia, $fecha_inicio){


        $e = array(
        	'id_residencia' => $id_residencia,
            'semana' => $semana,
            'fecha' => $fecha_inicio
        );


        $this->db->insert('estadias',$e);

    }
}
