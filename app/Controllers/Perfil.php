<?php

namespace App\Controllers;
use CodeIgniter\Controller;
class Perfil extends BaseController
{
	public function __construct() {
     	  helper(['form', 'url']);
       	    	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
            // Si el usuario no ha iniciado sesión, redirigir al controlador de inicio de sesión
            return redirect()->to(base_url('Login'));
        }
		return view('perfil');
	}

}