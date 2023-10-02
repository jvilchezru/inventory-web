<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcaModel extends Model
{
    protected $table = 't_marcas';
    protected $primaryKey = 'id_marca';
    protected $allowedFields = ['nombre_marca', 'descripcion'];
}
