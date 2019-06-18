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
 * Modelo Filtros
 */
class Filtros extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }



    public function filtrarEstadias($ciudad, $fecha_desde, $fecha_hasta){

    	$like = "%" . $ciudad . "%";
    	$desde=$this->db->scape($fecha_desde);
    	$hasta= $this->db->scape($fecha_hasta);
    	$like=$this->db->scape($like);
    	
    	$resultado = $this->db->select('e.id as id_estadia,
    									e.fecha,
    									e.semana,
                                        COUNT(r.id) AS cantidad_disponibles,  
                                        r.id as id_residencia,
                                        r.nombre,
                                        r.descripcion,
                                        r.foto,
                                        r.capacidad,
                                        r.calle,
                                        r.altura,
                                        r.ciudad,
                                        r.provincia',

                                        'residencias r',

                                        'INNER JOIN estadias e ON (e.id_residencia = r.id)', 

                                        "(e.estado = 'LIBRE' OR e.estado = 'SUBASTA') AND r.ciudad LIKE '$like' AND (e.fecha BETWEEN '$desde' and '$hasta') AND r.estado_logico = 0",

                                        null,

                                        "GROUP BY id_residencia");

       

    	return $resultado;

    }


    public function getEstadias($id, $fecha_desde, $fecha_hasta){

        $desde=$this->db->scape($fecha_desde);
        $hasta= $this->db->scape($fecha_hasta);
        
        $resultado = $this->db->select('*', 'estadias', null, "estado='LIBRE' and id_residencia = '$id' and (fecha BETWEEN '$desde' and '$hasta') ORDER BY semana");
        return $resultado;

    }


    public function getSubastas($id_residencia, $fecha_desde, $fecha_hasta){
        $desde=$this->db->scape($fecha_desde);
        $hasta= $this->db->scape($fecha_hasta);

        $resultado = $this->db->select('e.id as id_estadia, 
                                        e.semana,
                                        e.fecha,
                                        r.id as id_residencia,
                                        r.ciudad,
                                        r.provincia, 
                                        r.altura,
                                        r.nombre,
                                        r.foto,
                                        s.id as id_subasta,  
                                        s.monto as monto_subasta,
                                        s.monto_actual, 
                                        s.estado'
                                        , 'subastas s', 
                                        'INNER JOIN estadias e ON (s.id_estadia = e.id) INNER JOIN residencias r ON (e.id_residencia = r.id)',
                                        "r.id = '$id_residencia' and (fecha BETWEEN '$desde' and '$hasta')");

        return $resultado;

    }






}