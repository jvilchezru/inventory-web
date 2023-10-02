<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];


public $datapersona = [
            'dni' => [
            'rules'  => 'required|exact_length[8]',
            'errors' => [
                'required' => 'No debe el DNI ser vacio',
                'exact_length' => 'El DNI debe ser de 8 digitos'
              ]
            ],

            'nombre' => [
            'rules'  => 'required|min_length[5]|max_length[50]',
            'errors' => [
                'required' => 'No debe el Nombre ser vacio',
                'min_length' => 'El Nombre debe ser mayor de 5 letras',
                'max_length' => 'El Nombre no debe exceder de 50 caracteres'
              ]
            ],
            
            'apellidos' => 'required|min_length[5]|max_length[90]',
            'dir' => 'required|min_length[5]|max_length[50]',
            'tel' => 'required|min_length[5]|max_length[12]',
            'correo' => 'required|min_length[5]|max_length[30]|valid_email',
            'fecha' => 'required',
            'estado' => 'required|numeric',
              'foto' => [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,1024]',
                'errors' => [
                'uploaded' => 'No se envio una imagen',
                'mime_in' => 'No se envio un formato aceptado(jpg,jpeg,png)',
                 'max_size' => 'La imagen no debe exceder de 1Mb'                
              ]
            ] 

        ];
	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
