<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model
{
    protected $table = 'areas_municipalidad';
    protected $primaryKey = 'idareas_municipalidad';
    protected $allowedFields = ['nombre_areas', 'descripcion'];
}
