<?php

namespace App\Controllers;

use App\Models\MantenimientoModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mantenimiento extends BaseController
{
    protected $mantenimientoModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->mantenimientoModel = new MantenimientoModel();
    }

    public function index()
    {
         if (!session()->get('isLoggedIn')) {
            // Si el usuario no ha iniciado sesión, redirigir al controlador de inicio de sesión
            return redirect()->to(base_url('Login'));
        }
        $data['equipos'] = $this->mantenimientoModel->getEquipos();
        $data['mantenimientos'] = $this->mantenimientoModel->findAll(); // Obtener todos los registros de mantenimientos
        return view('mantenimiento', $data);
    }

    public function registrar()
    {
        // Validar campos vacíos
        $rules = [
            'codpatrimonial' => 'required',
            'descripcion_mantenimiento' => 'required',
            'fecha_mantenimiento' => 'required',
            'costo_mantenimiento' => 'required'
        ];

        $errors = [
            'required' => 'El campo {field} es obligatorio.'
        ];

        if (!$this->validate($rules, $errors)) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Obtener los datos del formulario
        $data = [
            'codpatrimonial' => $this->request->getPost('codpatrimonial'),
            'descripcion_mantenimiento' => $this->request->getPost('descripcion_mantenimiento'),
            'fecha_mantenimiento' => $this->request->getPost('fecha_mantenimiento'),
            'costo_mantenimiento' => $this->request->getPost('costo_mantenimiento')
        ];

        // Insertar los datos en la base de datos
        $this->mantenimientoModel->insert($data);

        // Mostrar SweetAlert2 de éxito
        \session()->setFlashdata('success', 'Mantenimiento registrado exitosamente.');

        return redirect()->to('/Mantenimiento');
    }


      public function edit($mantenimientoId)
{
    $validationRules = [
        
        'descripcion_mantenimiento' => 'required',
        'fecha_mantenimiento' => 'required',
        'costo_mantenimiento' => 'required'

    ];

    if ($this->validate($validationRules)) {
        $mantenimientoData = [

            'descripcion_mantenimiento'=> $this->request->getPost('descripcion_mantenimiento'),
            'fecha_mantenimiento' => $this->request->getPost('fecha_mantenimiento'),
            'costo_mantenimiento'=> $this->request->getPost('costo_mantenimiento')

            
        ];

        $model = new MantenimientoModel();
        $model->update($mantenimientoId, $mantenimientoData);

        // Mostrar mensaje de éxito
        session()->setFlashdata('success', 'Mantenimiento actualizado exitosamente.');

        return redirect()->to(base_url('/Mantenimiento'));
    } else {
        return redirect()->to(base_url('/Mantenimiento'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

     public function eliminarmantenimiento($mantenimientoId)
    {
        $mantenimientoModel = new MantenimientoModel();
        $mantenimientoModel->delete($mantenimientoId);

        // Mostrar Sweet Alert2 para confirmar la eliminación exitosa
        return redirect()->back()->with('success', 'El mantenimiento se eliminó correctamente.');
    }

     public function generarPDF()
    {   $mantenimientoModel = new MantenimientoModel();
        $data['mantenimientos'] = $this->mantenimientoModel->findAll();
         $data['equipos'] = $this->mantenimientoModel->getEquipos();

        $html = view('reporte_mantenimientos', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
         $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        $dompdf->stream('reporte_mantenimientos.pdf', ['Attachment' => true]);
    }

    public function generarReportExcel()
{
       $mantenimientoModel = new MantenimientoModel();
        $data['mantenimientos'] = $this->mantenimientoModel->findAll();
         $data['equipos'] = $this->mantenimientoModel->getEquipos();

    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Mantenimiento");

    // Establecer estilo para los encabezados
    $headerStyle = [
        'font' => [
            'bold' => true,
        ],
    ];

    // Combinar y centrar celdas A1:C2, y establecer negrita
$sheet->mergeCells('A1:C2');
$sheet->setCellValue('A1', 'MUNICIPALIDAD PROVINCIAL DE SULLANA');
$sheet->getStyle('A1:C2')->getFont()->setName('Arial')->setSize(8)->setBold(true);
$sheet->getStyle('A1:C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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

    // Agregar texto "Fec.Imp.:" en la celda K1
    $sheet->setCellValue('K1', 'Fec.Imp.:');
    // Combinar y centrar celdas L1 y M1 para la fecha y hora actual
    $sheet->mergeCells('L1:M1');
    $sheet->setCellValue('L1', date('d-m-Y H:i:s'));
    $sheet->getStyle('L1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

 
    $sheet->mergeCells('E3:G3');
    $sheet->setCellValue('E3', 'FICHA DE MANTENIMINETO');
    $sheet->getStyle('E3:G3')->getFont()->setName('Arial')->setSize(9)->setBold(true);
    $sheet->getStyle('E3:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Agregar encabezados de columnas
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->setCellValue('B5', 'Codigo patrimonial');
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->setCellValue('C5', 'Description');
    $sheet->getColumnDimension('D')->setWidth(10);
    $sheet->setCellValue('D5', 'Fecha');
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->setCellValue('E5', 'costo');
    $sheet->getStyle('B5:E5')->applyFromArray($headerStyle);

    $row = 6;
     foreach ($data['mantenimientos'] as $mantenimiento) {
       $codigo_id = $mantenimiento['codpatrimonial'];
                  $codigopatrimonial = "";

    foreach ($data['equipos'] as $equipo) {
                    if ($equipo->id_equipos == $codigo_id) {
                      $codigopatrimonial = $equipo->codigo_patrimonial;
                      break;
                    }
                  }

        $sheet->setCellValue('B' . $row,  $codigopatrimonial);
        $sheet->setCellValue('C' . $row, $mantenimiento['descripcion_mantenimiento']);
        $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($mantenimiento['fecha_mantenimiento'])));
        $sheet->setCellValue('E' . $row, $mantenimiento['costo_mantenimiento']);
       
        $row++;
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="reporte_mantenimientos.xls"');
    header('Cache-Control: max-age=0');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save('php://output');
}

}
