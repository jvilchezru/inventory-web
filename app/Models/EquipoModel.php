<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id_equipos';
    protected $allowedFields = ['codigo_patrimonial', 'descripcion_equipo', 'numero_serie', 'fecha_adqusicion', 'tipo_equipo', 'fecha_baja', 'estado_equipo', 'marcae', 'modeloe', 'trabajadore', 'Areae'];


    public function getMarcas()
    {
        return $this->db->table('t_marcas')->get()->getResult();
    }

    public function getModelos()
    {
        return $this->db->table('t_modelos')->get()->getResult();
    }

    public function getTrabajadores()
    {
        return $this->db->table('trabajadores')->get()->getResult();
    }

    public function getAreas()
    {
        return $this->db->table('areas_municipalidad')->get()->getResult();
    }

    public function getAllEquipos()
    {
        return $this->findAll();
    }
    public function getEquiposPorTrabajador()
{
    return $this->select('trabajadores.nombre_t AS trabajador, COUNT(equipos.id_equipos) AS equipos_count')
        ->join('trabajadores', 'equipos.trabajadore = trabajadores.id_trabajador')
        ->groupBy('trabajadores.id_trabajador')
        ->get()
        ->getResult();
}




}
