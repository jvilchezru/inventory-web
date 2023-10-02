<?php

namespace App\Models;

use CodeIgniter\Model;

class TrabajadoresModel extends Model
{
    protected $table = 'trabajadores';
    protected $primaryKey = 'id_trabajador';
    protected $allowedFields = ['nombre_t', 'correo', 'condicion', 'area'];

    public function getAreas()
    {
        return $this->db->table('areas_municipalidad')->get()->getResult();
    }
}