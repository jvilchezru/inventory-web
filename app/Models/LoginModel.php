<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'usuario_administrador';
    protected $primaryKey = 'idusuario_administrador';
    protected $allowedFields = ['usuario_administradorcol', 'contraseña'];

    public function validateLogin($usuario, $password)
    {
        $query = $this->where('usuario_administradorcol', $usuario)
                      ->where('contraseña', $password)
                      ->first();

        return ($query !== null);
    }
}
