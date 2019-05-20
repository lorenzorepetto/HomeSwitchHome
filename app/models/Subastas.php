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
 * Modelo Subastas
 */
class Subastas extends Models implements IModels {
    use DBModel;


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }

     /*

    ------------------------  CREAR SUBASTA  ---------------------------------------------------------------------

    */

    
    public function insertar($id_estadia, $monto){
        $subasta = array('fecha_inicio' => date("m.d.y"),
                        'fecha_fin' => date("m.d.y"),
                        'estado' => 0,
                        'usuario_ganador' => ' ',
                        'id_estadia' => $id_estadia,
                        'monto' => $monto,
                        'monto_actual' => $monto);

        $this->db->insert('subastas',$subasta);

    }

    /*

    ------------------------  ELIMINAR SUBASTA  ---------------------------------------------------------------------

    */

    public function cerrar($subasta){
        $id= $subasta['0']['id'];
        $nuevosDatos = array('fecha_inicio' => $subasta['0']['id'],
                                'fecha_fin' => $subasta['0']['fecha_inicio'],
                                'estado' => 1,
                                'usuario_ganador' => $subasta['0']['usuario_ganador'],
                                'id_estadia' => $subasta['0']['id_estadia'],
                                'monto' => $subasta['0']['monto'],
                                'monto_actual' => $subasta['0']['monto'] );

        
        $this->db->update('subastas', $nuevosDatos, "id=$id");
    
    }

    /*

    ------------------------  CONSULTAS  ----------------------------------------------------------

    */

    public function existe($id_estadia){
        $resultado = $this->db->select('*', 'subastas', null, "estado = 0 and id_estadia = '$id_estadia'");
        return $resultado;
    }

    public function getSubastas(){

        $resultado = $this->db->select('*', 'subastas', null, "estado = 0");
        return $resultado;
    }

    public function getSubastasConEstadiaYResidencia(){

        $resultado = $this->db->select('e.id as id_estadia, 
                                        e.semana, 
                                        e.monto as monto_estadia, 
                                        r.id as id_residencia, 
                                        r.nombre,
                                        s.id as id_subasta,  
                                        s.monto as monto_subasta,
                                        s.monto_actual'
                                        , 'subastas s', 
                                        'INNER JOIN estadias e ON (s.id_estadia = e.id) INNER JOIN residencias r ON (e.id_residencia = r.id)');
        return $resultado;
    }

    public function getSubasta($id_subasta){
        
       
        $resultado = $this->db->select('e.id as id_estadia,
                                        e.semana,
                                        e.monto as monto_estadia,
                                        r.id as id_residencia, 
                                        r.nombre,
                                        s.id as id_subasta,  
                                        s.monto as monto_subasta, 
                                        s.monto_actual, 
                                        r.calle, 
                                        r.altura, 
                                        r.ciudad, 
                                        r.provincia,
                                        r.foto, 
                                        r.capacidad' , 
                                        'subastas s' , 
                                        'INNER JOIN estadias e ON (s.id_estadia = e.id) INNER JOIN residencias r ON (e.id_residencia = r.id)', 
                                        "s.id = '$id_subasta'");
        
        return $resultado;
        
    }

    public function getPujas($id){

        $resultado = $this->db->select('*', 'pujas', null, "id_subasta = $id");
        return $resultado;
    }



}