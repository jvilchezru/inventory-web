<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\TrabajadoresModel;
use App\Models\EquipoModel;
use App\Models\MantenimientoModel;

class OpcionesController extends BaseController
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

        $marcaModel = new MarcaModel();
        $modeloModel = new ModeloModel();
        $trabajadoresModel = new TrabajadoresModel();
        $equipoModel = new EquipoModel();

        $data = [
            'numMarcas' => $marcaModel->countAll(),
            'numModelos' => $modeloModel->countAll(),
            'numTrabajadores' => $trabajadoresModel->countAll(),
            'numEquipos' => $equipoModel->countAll(),
        ];

        $trabajadoresModel = new TrabajadoresModel();
        $areas = $trabajadoresModel->getAreas();

        $trabajadoresPorArea = [];
        foreach ($areas as $area) {
            $trabajadoresCount = $trabajadoresModel->where('area', $area->idareas_municipalidad)->countAllResults();
            $trabajadoresPorArea[] = [
                'nombre_areas' => $area->nombre_areas,
                'trabajadores_count' => $trabajadoresCount
            ];
        }

        $data['areas'] = $trabajadoresPorArea;

        $equiposPorTrabajador = $equipoModel->getEquiposPorTrabajador();

        $data['equiposPorTrabajador'] = $equiposPorTrabajador;

        return view('opciones', $data);
    }
}
