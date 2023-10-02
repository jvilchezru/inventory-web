<?php

namespace App\Controllers;

use App\Models\ModeloModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

class Modelos extends BaseController
{
    protected $modeloModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->modeloModel = new ModeloModel();
    }

public function index()
{
     if (!session()->get('isLoggedIn')) {
            // Si el usuario no ha iniciado sesión, redirigir al controlador de inicio de sesión
            return redirect()->to(base_url('Login'));
        }
    $data['marcas'] = $this->modeloModel->getMarcas();

    // Obtener los modelos y sus marcas correspondientes
    $modelos = $this->modeloModel
        ->select('t_modelos.id_modelo, t_modelos.nombre_modelo, t_modelos.descripcion_modelo, t_marcas.nombre_marca as marca')
        ->join('t_marcas', 't_marcas.id_marca = t_modelos.marca')
        ->orderBy('t_modelos.nombre_modelo', 'ASC')
        ->findAll();

    $data['modelos'] = $modelos;

    return view('modelo', $data);
}


    public function registrar()
    {
        $data = [
            'nombre_modelo' => $this->request->getPost('nombre_modelo'),
            'descripcion_modelo' => $this->request->getPost('descripcion_modelo'),
            'marca' => $this->request->getPost('marca')
        ];

        // Validar campos vacíos
        if (empty($data['nombre_modelo']) || empty($data['descripcion_modelo']) || empty($data['marca'])) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Todos los campos son requeridos']);
        }

        // Realizar el registro del modelo
        $inserted = $this->modeloModel->insert($data);

        if (!$inserted) {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Error al registrar el modelo']);
        }

        return $this->response->setJSON(['message' => 'Modelo registrado exitosamente']);
    }

        public function edit($modeloId)
{
    $validationRules = [
        
        'nombre_modelo' => 'required',
        'descripcion_modelo' => 'required',
        'marca' => 'required'

    ];

    if ($this->validate($validationRules)) {
        $modeloData = [

            'nombre_modelo'=> $this->request->getPost('nombre_modelo'),
            'descripcion_modelo' => $this->request->getPost('descripcion_modelo'),
            'marca'=> $this->request->getPost('marca')

            
        ];

        $model = new ModeloModel();
        $model->update($modeloId, $modeloData);

        // Mostrar mensaje de éxito
        session()->setFlashdata('success', 'Modelo actualizado exitosamente.');

        return redirect()->to(base_url('/Modelos'));
    } else {
        return redirect()->to(base_url('/Modelos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}



    public function Eliminarmodelo($modeloId)
    {
        $modeloModel = new ModeloModel();
        $modeloModel->delete($modeloId);

        // Mostrar Sweet Alert2 para confirmar la eliminación exitosa
        return redirect()->back()->with('success', 'El modelo se eliminó correctamente.');
    }
}
