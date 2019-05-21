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

    
    public function insertar($e, $id_estadia, $monto){
        $subasta = array('fecha_inicio' => date("m.d.y"),
                        'fecha_fin' => date("m.d.y"),
                        'estado' => 0,
                        'usuario_ganador' => ' ',
                        'id_estadia' => $id_estadia,
                        'monto' => $monto,
                        'monto_actual' => $monto);

        $this->db->insert('subastas',$subasta);

        $e->cambiarEstado($id_estadia, 'SUBASTA');


    }

    /*

    ------------------------  ELIMINAR SUBASTA  ---------------------------------------------------------------------

    */

    public function cerrar($e, $u, $subasta){
        $id= $subasta['0']['id_subasta'];

        $data = array('sin error' => 0,
                        'usuario_ganador'=> 0, 
                        'id_subasta' => $id );
        
        $ganador= null;
        $hay_puja= $this->getPuja($id);

        if ($hay_puja) {
            $ganador= $this->getGanador($u, $id);
            if ($ganador) { //se cierra la subasta y se informa el ganador
                $data['sin_error']=1;
                $data['usuario_ganador']=$ganador;
                //la estadia pasa a estar ocupada
                $e->cambiarEstado($subasta['0']['id_estadia'], "OCUPADA");
            }else{
                $data['sin_error'] = 1; //no hay ganador pero la subasta se cierra igual
                $e->cambiarEstado($subasta['0']['id_estadia'], "LIBRE");
            }
        }else{ //no hay pujas
            $data['sin_error']=1;
            $e->cambiarEstado($subasta['0']['id_estadia'], "LIBRE");
        }

        //setear el estado
        if ($data['sin_error']) {
            $this->actualizarEstado($id,$ganador);
        }

        return $data;
    
    }

    /*

    ------------------------  CONSULTAS  ----------------------------------------------------------

    */

    public function getGanador($u, $id){

        $pujas= $this->getPujas($id);

        foreach ($pujas as $p) {

            if ($u->tieneCredito($p['id_usuario'])) {

                $u->restarCredito($p['id_usuario']);
                return $p['id_usuario'];
            }
        }

        //no hay ganador con creditos
        return false;

    }

    public function actualizarEstado($id, $ganador){
        $datos_nuevos = array('estado' => 1, 'usuario_ganador' => $ganador );
        $this->db->update('subastas', $datos_nuevos, "id = '$id'");
    }

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
                                        r.ciudad,
                                        r.provincia, 
                                        r.nombre,
                                        s.id as id_subasta,  
                                        s.monto as monto_subasta,
                                        s.monto_actual, 
                                        s.estado'
                                        , 'subastas s', 
                                        'INNER JOIN estadias e ON (s.id_estadia = e.id) INNER JOIN residencias r ON (e.id_residencia = r.id) ORDER BY s.estado, e.semana');
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
                                        s.usuario_ganador,
                                        s.estado,
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

        $resultado = $this->db->select('*', 'pujas', null, "id_subasta = $id ORDER BY monto_apostado");
        return $resultado;
    }


    public function getPuja($id){

        $resultado = $this->db->select('MAX(monto_apostado) as monto_apostado, 
                                        u.id as usuario_id,
                                        u.nombre,
                                        u.apellido,
                                        u.creditos,
                                        u.foto', 
                                        'pujas p', 
                                        'INNER JOIN usuarios u ON (u.id = p.id_usuario)', 
                                        "id_subasta = $id");

        if ($resultado['0']['monto_apostado'] == null) {
            return false;
        }
        return $resultado;
    }


    /*

    ------------------------  PUJAS  ----------------------------------------------------------

    */


    public function pujar($id_subasta, $id_usuario, $monto){

        $puja = array('id_subasta' => $id_subasta,
                       'id_usuario' => $id_usuario,
                       'monto_apostado' => $monto );

        $this->db->insert('pujas',$puja);

    }


}