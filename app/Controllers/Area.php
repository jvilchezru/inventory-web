<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AreaModel;

class Area extends BaseController
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
        $areaModel = new AreaModel();
        $data['areas'] = $areaModel->orderBy('nombre_areas', 'ASC')->findAll();

        return view('area', $data);
    }

    public function registrar()
    {
        $areaModel = new AreaModel();

        // Validar los campos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_areas' => 'required',
            'descripcion' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si hay errores de validación, redirige a la página anterior mostrando los errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Insertar el área en la base de datos
        $data = [
            'nombre_areas' => $this->request->getPost('nombre_areas'),
            'descripcion' => $this->request->getPost('descripcion')
        ];
        $areaModel->insert($data);

        // Mostrar mensaje de éxito
        return redirect()->back()->with('success', 'Área registrada correctamente.');
    }

    public function eliminarArea($areaId)
    {
        $areaModel = new AreaModel();
        $areaModel->delete($areaId);

        // Mostrar Sweet Alert2 para confirmar la eliminación exitosa
        return redirect()->back()->with('success', 'El área se eliminó correctamente.');
    }

    public function editarArea($areaId)
    {
        $areaModel = new AreaModel();

        // Obtener los datos del área a editar
        $data['area'] = $areaModel->find($areaId);

        if (empty($data['area'])) {
            // El área no existe, redirigir o mostrar un mensaje de error
            return redirect()->back()->with('error', 'El área no existe.');
        }

        // Mostrar la vista de edición del área
        return view('editar_area', $data);
    }

    public function guardarCambios($areaId)
    {
        $areaModel = new AreaModel();

        // Validar los campos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_areas' => 'required',
            'descripcion' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Si hay errores de validación, redirige a la página anterior mostrando los errores
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Actualizar los datos del área en la base de datos
        $data = [
            'nombre_areas' => $this->request->getPost('nombre_areas'),
            'descripcion' => $this->request->getPost('descripcion')
        ];
        $areaModel->update($areaId, $data);

        // Mostrar mensaje de éxito
        return redirect()->back()->with('success', 'Cambios guardados correctamente.');
    }
}
