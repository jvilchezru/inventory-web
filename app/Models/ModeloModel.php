<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloModel extends Model
{
    protected $table = 't_modelos';
    protected $primaryKey = 'id_modelo';
    protected $allowedFields = ['nombre_modelo', 'descripcion_modelo', 'marca'];

    public function getMarcas()
    {
        return $this->db->table('t_marcas')->get()->getResult();
    }
}
