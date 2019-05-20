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

     public function getEstadias(){

        $resultado = $this->db->select('*', 'estadias', null, "estado_logico = 0 and ocupada=0 and caducada=0 ORDER BY estadias.semana");
        return $resultado;
    }

    public function getEstadiasConResidencia(){

        $resultado = $this->db->select('e.id as id_estadia, e.semana, e.monto, r.id as id_residencia, r.nombre', 'estadias e', 'INNER JOIN residencias r ON (e.id_residencia = r.id)', "e.estado_logico = 0 and e.ocupada=0 and e.caducada=0");
        return $resultado;
    }

    public function getSemana($id){

        $resultado = $this->db->select('semana', 'estadias', null, "estado_logico = 0 and id = '$id'");
        return $resultado[0]['semana'];
    }


    public function existe($semana, $id_residencia){

        $resultado= $this->db->select('*', 'estadias', null, "id_residencia = '$id_residencia' AND estado_logico = 0 and semana = '$semana'");

        if ($resultado){
            return true;
        }

        return false;
    }

    /*
    ----------------------------------INSERTAR ESTADIA----------------------------------------
    */

    public function insertar($semana, $monto, $id_residencia){
        

        $e = array(
        	'caducada' => 0,
        	'id_residencia' => $id_residencia,
            'semana' => $semana,
            'ocupada'=> 0,
            'monto' => $monto,
            'estado_logico' => 0
        );


        $this->db->insert('estadias',$e);

    }
}