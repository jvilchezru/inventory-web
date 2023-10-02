<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Equipos extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
         if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }

        $equipoModel = new EquipoModel();
        $data['equipos'] = $equipoModel->getAllEquipos();
        $data['marcas'] = $equipoModel->getMarcas();
        $data['modelos'] = $equipoModel->getModelos();
        $data['trabajadores'] = $equipoModel->getTrabajadores();
        $data['areas'] = $equipoModel->getAreas();

        return view('equipos', $data);
    }

    public function registrarEquipos()
    {
        // Validar campos vacíos
        $validationRules = [
            'codigo_patrimonial' => 'required',
            'descripcion_equipo' => 'required',
            'numero_serie' => 'required',
            'fecha_adqusicion' => 'required',
            'tipo_equipo' => 'required',
            'estado_equipo' => 'required',
            'marcae' => 'required',
            'modeloe' => 'required',
            'trabajadore' => 'required',
            'Areae' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            // Si hay campos vacíos, redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Por favor, completa todos los campos.');
        }

        // Procesar los datos y guardar el equipo en la base de datos
        $equipoModel = new EquipoModel();
        $equipoData = [
            'codigo_patrimonial' => $this->request->getPost('codigo_patrimonial'),
            'descripcion_equipo' => $this->request->getPost('descripcion_equipo'),
            'numero_serie' => $this->request->getPost('numero_serie'),
            'fecha_adqusicion' => $this->request->getPost('fecha_adqusicion'),
            'tipo_equipo' => $this->request->getPost('tipo_equipo'),
            'fecha_baja' => $this->request->getPost('fecha_baja'),
            'estado_equipo' => $this->request->getPost('estado_equipo'),
            'marcae' => $this->request->getPost('marcae'),
            'modeloe' => $this->request->getPost('modeloe'),
            'trabajadore' => $this->request->getPost('trabajadore'),
            'Areae' => $this->request->getPost('Areae')
        ];
        $equipoModel->insert($equipoData);

        // Mostrar Sweet Alert2 para confirmar el registro exitoso
        return redirect()->back()->with('success', 'El equipo se registró correctamente.');
    }

    public function edit($equipoId)
{
    $validationRules = [
        'codigo_patrimonial' => 'required',
        'descripcion_equipo' => 'required',
        'numero_serie' => 'required',
        'fecha_adqusicion' => 'required',
        'estado_equipo' => 'required',
        'trabajadore' => 'required',
        'Areae' => 'required'
    ];

    if ($this->validate($validationRules)) {
        $equipoData = [
            'codigo_patrimonial' => $this->request->getPost('codigo_patrimonial'),
            'descripcion_equipo' => $this->request->getPost('descripcion_equipo'),
            'numero_serie' => $this->request->getPost('numero_serie'),
            'fecha_adqusicion' => $this->request->getPost('fecha_adqusicion'), 
            'fecha_baja' => $this->request->getPost('fecha_baja'),
            'estado_equipo' => $this->request->getPost('estado_equipo'),
            'trabajadore' => $this->request->getPost('trabajadore'),
            'Areae' => $this->request->getPost('Areae')
        ];

        $equipoModel = new EquipoModel();
        $equipoModel->update($equipoId, $equipoData);

        // Mostrar mensaje de éxito
        session()->setFlashdata('success', 'Equipo actualizado exitosamente.');

        return redirect()->to(base_url('/Equipos'));
    } else {
        return redirect()->to(base_url('/Equipos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}



 public function eliminarEquipo($equipoId)
    {
        $equipoModel = new EquipoModel();
        $equipoModel->delete($equipoId);

        // Mostrar Sweet Alert2 para confirmar la eliminación exitosa
        return redirect()->back()->with('success', 'El equipo se eliminó correctamente.');
    }

     public function generarReportePDF()
    {
        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->getAllEquipos();
        $marcas = $equipoModel->getMarcas();
        $modelos = $equipoModel->getModelos();
        $trabajadores = $equipoModel->getTrabajadores();
        $areas = $equipoModel->getAreas();

        

        // Ordenar el array de equipos en orden alfabético por el campo 'tipo_equipo'
        usort($equipos, function ($a, $b) {
            return strcmp($a['Areae'], $b['Areae']);
        });

        // Crear el contenido HTML del reporte
        $html = view('reporte_equipos', compact('equipos', 'marcas', 'modelos', 'trabajadores', 'areas'));

        // Generar el PDF con Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        // Descargar el PDF
        $dompdf->stream('reporte_equipos.pdf', ['Attachment' => true]);
    }

public function generateReportExcel()
{
    $equipoModel = new EquipoModel();
    $equipos = $equipoModel->getAllEquipos();
    $marcas = $equipoModel->getMarcas();
    $modelos = $equipoModel->getModelos();
    $trabajadores = $equipoModel->getTrabajadores();
    $areas = $equipoModel->getAreas();

 usort($equipos, function ($a, $b) use ($areas) {
    $areaIdA = $a['Areae'];
    $areaIdB = $b['Areae'];

    $areaNombreA = '';
    $areaNombreB = '';

    foreach ($areas as $area) {
        if ($area->idareas_municipalidad == $areaIdA) {
            $areaNombreA = $area->nombre_areas;
            break;
        }
    }

    foreach ($areas as $area) {
        if ($area->idareas_municipalidad == $areaIdB) {
            $areaNombreB = $area->nombre_areas;
            break;
        }
    }

    return strcmp($areaNombreA, $areaNombreB);
});

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Equipos");

    // Establecer estilo para los encabezados
    $headerStyle = [
        'font' => [
            'bold' => true,
        ],
    ];

    // Establecer estilo para el texto "MUNICIPALIDAD PROVINCIAL DE SULLANA"
   $sheet->mergeCells('A1:C2');
$sheet->setCellValue('A1', 'MUNICIPALIDAD PROVINCIAL DE SULLANA');
$sheet->getStyle('A1')->getFont()->setName('Arial')->setSize(8)->setBold(true);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


    // Insertar el logo en la celda A1
    $logoPath = 'resources/img/logo.png'; // Reemplaza con la ruta correcta de tu logo
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath($logoPath);
    $drawing->setCoordinates('A1');
    $drawing->setHeight(40);
    $drawing->setWorksheet($sheet);

    // Establecer estilo para la celda K1
$sheet->getStyle('K1')->getFont()->setName('Arial')->setSize(10)->setBold(true);
$sheet->getStyle('K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT); // Alineación a la derecha

// Agregar texto "Fec.Imp.:" en la celda K1
$sheet->setCellValue('K1', 'Fec.Imp.:');
// Combinar y centrar celdas L1 y M1 para la fecha y hora actual
$sheet->mergeCells('L1:M1');
$sheet->setCellValue('L1', date('d-m-Y H:i:s'));
$sheet->getStyle('L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Alineación a la izquierda

    // Combinar y centrar celdas E3, F3 y G3 para "FICHA DE INVENTARIO"
    $sheet->mergeCells('E3:G3');
    $sheet->setCellValue('E3', 'FICHA DE INVENTARIO');
    $sheet->getStyle('E3:G3')->getFont()->setName('Arial')->setSize(9)->setBold(true);
    $sheet->getStyle('E3:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Agregar encabezados de columnas
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->setCellValue('B5', 'Codigo patrimonial');
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->setCellValue('C5', 'Description');
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->setCellValue('D5', 'Num.serie');
    $sheet->getColumnDimension('E')->setWidth(15);
    $sheet->setCellValue('E5', 'Fecha adqusicion');
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->setCellValue('F5', 'Tipo');
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->setCellValue('G5', 'Fecha baja');
    $sheet->getColumnDimension('H')->setWidth(15);
    $sheet->setCellValue('H5', 'Estado');
    $sheet->getColumnDimension('I')->setWidth(15);
    $sheet->setCellValue('I5', 'Marca');
    $sheet->getColumnDimension('J')->setWidth(15);
    $sheet->setCellValue('J5', 'Modelo');
    $sheet->getColumnDimension('K')->setWidth(15);
    $sheet->setCellValue('K5', 'Trabajador');
    $sheet->getColumnDimension('L')->setWidth(20);
    $sheet->setCellValue('L5', 'Area');
    $sheet->getStyle('B5:L5')->applyFromArray($headerStyle);

    $row = 6;
    foreach ($equipos as $equipo) {
        $marcaNombre = '';
        $modeloNombre = '';
        $trabajadorNombre = '';
        $trabajadorApellido = '';
        $areaNombre = '';

        foreach ($marcas as $marca) {
            if ($marca->id_marca == $equipo['marcae']) {
                $marcaNombre = $marca->nombre_marca;
                break;
            }
        }

        foreach ($modelos as $modelo) {
            if ($modelo->id_modelo == $equipo['modeloe']) {
                $modeloNombre = $modelo->nombre_modelo;
                break;
            }
        }

        foreach ($trabajadores as $trabajador) {
            if ($trabajador->id_trabajador == $equipo['trabajadore']) {
                $trabajadorNombre = $trabajador->nombre_t;
                break;
            }
        }

        foreach ($areas as $areaObj) {
            if ($areaObj->idareas_municipalidad == $equipo['Areae']) {
                $areaNombre = $areaObj->nombre_areas;
                break;
            }
        }

        $fechaBaja = date('d-m-Y', strtotime($equipo['fecha_baja']));
if ($fechaBaja == "30-11--0001") {
    $fechaBaja = "-";
}

       $sheet->setCellValueExplicit('B' . $row, $equipo['codigo_patrimonial'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('C' . $row, $equipo['descripcion_equipo']);
        $sheet->setCellValue('D' . $row, $equipo['numero_serie']);
        $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($equipo['fecha_adqusicion'])));
        $sheet->setCellValue('F' . $row, $equipo['tipo_equipo']);
        $sheet->setCellValue('G' . $row, $fechaBaja);
        $sheet->setCellValue('H' . $row, $equipo['estado_equipo']);
        $sheet->setCellValue('I' . $row, $marcaNombre);
        $sheet->setCellValue('J' . $row, $modeloNombre);
        $sheet->setCellValue('K' . $row, $trabajadorNombre . ' ' . $trabajadorApellido);
        $sheet->setCellValue('L' . $row, $areaNombre);

        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="reporte_equipos.xls"');
    header('Cache-Control: max-age=0');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save('php://output');
}





}






