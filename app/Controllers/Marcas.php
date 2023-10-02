<?php

namespace App\Controllers;

use App\Models\MarcaModel;
use CodeIgniter\Controller;

class Marcas extends BaseController
{
    protected $marcaModel;

    public function __construct()
    {
        $this->marcaModel = new MarcaModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            // Si el usuario no ha iniciado sesión, redirigir al controlador de inicio de sesión
            return redirect()->to(base_url('Login'));
        }
        $data['marcas'] = $this->marcaModel->orderBy('nombre_marca', 'ASC')->findAll();
        return view('marca', $data);
    }

    public function create()
    {
        $validationRules = [
            'nombre' => 'required',
            'descripcion' => 'required'
        ];

        if ($this->validate($validationRules)) {
            $marcaData = [
                'nombre_marca' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion')
            ];

            $this->marcaModel->insert($marcaData);

            // Mostrar mensaje de éxito
            session()->setFlashdata('success', 'Marca registrada exitosamente.');

            return redirect()->to(base_url('/Marcas'));
        } else {
            return redirect()->to(base_url('/Marcas'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function edit($marcaId)
    {
        $validationRules = [
            'nombre' => 'required',
            'descripcion' => 'required'
        ];

        if ($this->validate($validationRules)) {
            $marcaData = [
                'nombre_marca' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion')
            ];

            $this->marcaModel->update($marcaId, $marcaData);

            // Mostrar mensaje de éxito
            session()->setFlashdata('success', 'Marca actualizada exitosamente.');

            return redirect()->to(base_url('/Marcas'));
        } else {
            return redirect()->to(base_url('/Marcas'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($marcaId)
    {
        $marca = $this->marcaModel->find($marcaId);

        if (!$marca) {
            return redirect()->back()->with('error', 'La marca no existe.');
        }

        try {
            $this->marcaModel->delete($marcaId);
            return redirect()->back()->with('success', 'La marca se eliminó correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar la marca debido a que se encuentra registrado en un modelo.');
        }
    }
}
