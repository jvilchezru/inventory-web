<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LoginModel;

class Login extends Controller
{
    public function index()
    {
        $data['error'] = session()->getFlashdata('error');
        return view('login', $data);
    }

    public function validateLogin()
    {
        $usuario = $this->request->getPost('user');
        $password = $this->request->getPost('password');

        $model = new LoginModel();
        $result = $model->validateLogin($usuario, $password);

        if ($result) {
            session()->set('isLoggedIn', true);
            return redirect()->to(base_url('OpcionesController'));
        } else {
            // Almacenar mensaje de error en la sesión
            session()->setFlashdata('error', 'Usuario o Contraseña incorrecta');
            return redirect()->to(base_url('Login'));
        }
    }

public function logout()
{
    session()->destroy();
    return redirect()->to(base_url('Login'));
}

}