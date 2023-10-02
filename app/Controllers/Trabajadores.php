<?php

namespace App\Controllers;

use App\Models\TrabajadoresModel;
use CodeIgniter\Controller;

class Trabajadores extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
         if (!session()->get('isLoggedIn')) {
            // Si el usuario no ha iniciado sesión, redirigir al controlador de inicio de sesión
            return redirect()->to(base_url('Login'));
        }
        $trabajadoresModel = new TrabajadoresModel();
        $data['areas'] = $trabajadoresModel->getAreas();
        $data['trabajadores'] = $trabajadoresModel->findAll(); // Obtener todos los trabajadores

        return view('trabajadores', $data);
    }

    public function registrar()
    {
        // Validar campos vacíos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required',
           
            'correo' => 'required',
            'condicion' => 'required',
            'area' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Campos vacíos, mostrar mensaje de error
            $errors = $validation->getErrors();
            $data['success'] = false;
            $data['message'] = 'Por favor, complete todos los campos.';
            $data['errors'] = $errors;
        } else {
            // Todos los campos están completos, realizar el registro del trabajador

            // Obtener los datos del formulario
            $nombre = $this->request->getPost('nombre');
           
            $correo = $this->request->getPost('correo');
            $condicion = $this->request->getPost('condicion');
            $area = $this->request->getPost('area');

            // Crear un nuevo registro en la base de datos
            $trabajadoresModel = new TrabajadoresModel();
            $trabajadoresModel->insert([
                'nombre_t' => $nombre,
                
                'correo' => $correo,
                'condicion' => $condicion,
                'area' => $area
            ]);

            // Actualizar la lista de trabajadores
            $data['trabajadores'] = $trabajadoresModel->findAll();

            // Mostrar mensaje de éxito
            $data['success'] = true;
            $data['message'] = 'Trabajador registrado exitosamente.';
        }

        return $this->response->setJSON($data);
    }

    public function edit($trabajadorId)
{
    $validationRules = [
        
        'nombre' => 'required',
       
        'correo' => 'required',
        'condicion' => 'required',
        'area' => 'required'
        
    ];

    if ($this->validate($validationRules)) {
        $trabajadorData = [

            'nombre_t'=> $this->request->getPost('nombre'),
            
            'correo'=> $this->request->getPost('correo'),
            'condicion' => $this->request->getPost('condicion'),
            'area'=> $this->request->getPost('area')
            
        ];

        $model = new TrabajadoresModel();
        $model->update($trabajadorId, $trabajadorData);

        // Mostrar mensaje de éxito
        session()->setFlashdata('success', 'Trabajador actualizado exitosamente.');

        return redirect()->to(base_url('/Trabajadores'));
    } else {
        return redirect()->to(base_url('/Trabajadores'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


      public function Eliminartrabjador($trabajadorId)
    {
        $trabajadoresModel = new TrabajadoresModel();
        $trabajadoresModel->delete($trabajadorId);

        // Mostrar Sweet Alert2 para confirmar la eliminación exitosa
        return redirect()->back()->with('success', 'El trabajador se eliminó correctamente.');
    }
}
