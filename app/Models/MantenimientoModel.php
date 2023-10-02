<?php

namespace App\Models;

use CodeIgniter\Model;

class MantenimientoModel extends Model
{
    protected $table = 'mantenimientos';
    protected $primaryKey = 'id_mantenimiento';
    protected $allowedFields = ['codpatrimonial', 'descripcion_mantenimiento', 'fecha_mantenimiento', 'costo_mantenimiento'];

    public function getEquipos()
    {
        return $this->db->table('equipos')->get()->getResult();
    }
    
}