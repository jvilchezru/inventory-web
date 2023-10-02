<!DOCTYPE html>
<html>
<head>
  <title>Sistema Web Municipalidad de Sullana</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="stylesheet" type="text/css" href="resources/css/equipos.css">
  <link rel="icon" href="resources/img/logo.png">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <link rel="icon" href="resources/img/logo.png">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>

<nav class="navbar">
  <div class="navbar-title">Sistema de Registro de Equipos</div>
  <div class="dropdown ms-auto">
    <button class="btn dropdown-toggle" type="button" id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <img class="img-profile rounded-circle" src="https://media.licdn.com/dms/image/D4E03AQHDmNR5lSaoEA/profile-displayphoto-shrink_400_400/0/1665241485740?e=1689811200&v=beta&t=8YsfqqYXxTylYfIdjgMQOTDyzV-HV31Qlss0DFsZLts" alt="Foto de perfil" style="width: 40px; height: 40px;">
      Administrador
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">
      
       <li>
  <a class="dropdown-item d-flex align-items-center" href="#" onclick="fntcerrar()">
    <i class="fas fa-power-off me-2"></i> Cerrar sesión
  </a>
</li>
    </ul>
  </div>
</nav>

  <div class="sidebar">
  <div class="logo">
    <img src="resources/img/logo.png" alt="Logo">
  </div>
  <ul>
    <a href="<?php echo base_url();?>/OpcionesController"><i class="fas fa-home"></i> Inicio</a>
    <a href="<?php echo base_url();?>/Equipos"class="active"><i class="fas fa-laptop"></i> Equipos</a>
    <a href="<?php echo base_url();?>/Mantenimiento"><i class="fas fa-tools"></i> Mantenimientos</a>
    <a href="<?php echo base_url();?>/Marcas"><i class="fas fa-trademark"></i> Marcas</a>
    <a href="<?php echo base_url();?>/Modelos"><i class="fas fa-barcode"></i> Modelos</a>
    <a href="<?php echo base_url();?>/Area"><i class="fas fa-building"></i> Area Municipal</a>
    <a href="<?php echo base_url();?>/Trabajadores"><i class="fas fa-users"></i> Trabajadores</a>
  </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <br>
            <h1>Registro de Equipos</h1>
            <div>
               <button class="registrar-btn" id="registrar-btn">
  <i class="fas fa-laptop"></i> Registrar Equipos
</button>
            </div>
     
           
              <div class="reporte-btn-container">
                    <a href="<?php echo base_url('Equipos/generarReportePDF'); ?>" class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="<?php echo base_url('Equipos/generateReportExcel'); ?>" class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>
<br>


           <div class="search-bar">

        <input type="text" id="search-input" placeholder="Buscar...">
    </div>
            <table class="table">
                <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Num.serie</th>
                        <th>Fec.Adqui</th>
                        <th>Tipo</th>
                        <th>Fech.Baja</th>
                        <th>Estado</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Trabajador</th>
                        <th>Área</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
          <tbody>


                  

            <?php

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

foreach ($equipos as $equipo) : ?>
    <?php
    // Obtener los nombres correspondientes según los IDs
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

    foreach ($areas as $area) {
        if ($area->idareas_municipalidad == $equipo['Areae']) {
            $areaNombre = $area->nombre_areas;
            break;
        }
    }
    ?>
    <tr>
        <td hidden><?= $equipo['id_equipos'] ?></td>
        <td><?= $equipo['codigo_patrimonial'] ?></td>
        <td><?= $equipo['descripcion_equipo'] ?></td>
        <td><?= $equipo['numero_serie'] ?></td>
        <td><?= date('d-m-Y', strtotime($equipo['fecha_adqusicion'])) ?></td>
        <td><?= $equipo['tipo_equipo'] ?></td>
        <?php
    $fechaBaja = date('d-m-Y', strtotime($equipo['fecha_baja']));
    if ($fechaBaja == "30-11--0001") {
        $fechaBaja = "-";
    }
?>
<td><?= $fechaBaja ?></td>

        <td><?= $equipo['estado_equipo'] ?></td>
        <td><?= $marcaNombre ?></td>
        <td><?= $modeloNombre ?></td>
        <td><?= $trabajadorNombre ?></td>
        <td><?= $areaNombre ?></td>
        <td>
            <a href="#" class="btn-editar" data-id="<?php echo $equipo['id_equipos']; ?>"><i class="fas fa-edit"></i></a>
        </td>
        <td>
            <a href="#" class="btn-eliminar" data-id="<?php echo $equipo['id_equipos']; ?>"><i class="fas fa-trash"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Agregar evento click al botón "Registrar Equipos"
    document.getElementById('registrar-btn').addEventListener('click', function() {
        // Mostrar Sweet Alert2 para registrar un equipo
        Swal.fire({
            title: 'Registrar Equipo',
            html:`
                 <form id="equipo-form">
                        <div class="form-group">
                            <label for="codigo_patrimonial">Código Patrimonial:</label>
                            <input type="number" id="codigo_patrimonial" name="codigo_patrimonial" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_equipo">Descripción Equipo:</label>
                            <input type="text" id="descripcion_equipo" name="descripcion_equipo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="numero_serie">Número de Serie:</label>
                            <input type="text" id="numero_serie" name="numero_serie" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_adqusicion">Fecha de Adquisición:</label>
                            <input type="date" id="fecha_adqusicion" name="fecha_adqusicion" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_equipo">Tipo de Equipo:</label>
                            <input type="text" id="tipo_equipo" name="tipo_equipo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_baja">Fecha de Baja:</label>
                            <input type="date" id="fecha_baja" name="fecha_baja" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="estado_equipo">Estado de Equipo:</label>
                            <select id="estado_equipo" name="estado_equipo" class="form-control" required>
                                <option value="">Seleccione un estado</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="marcae">Marca:</label>
                        <select id="marcae" name="marcae" class="form-control" required>
                            <option value="">Seleccione una marca</option>
                            <?php 
                                $sortedMarcas = array();
                                foreach($marcas as $marca) {
                                    $sortedMarcas[$marca->nombre_marca] = $marca;
                                }
                                ksort($sortedMarcas);
                                foreach($sortedMarcas as $marca) {
                            ?>
                                <option value="<?php echo $marca->id_marca; ?>"><?php echo $marca->nombre_marca; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modeloe">Modelo:</label>
                        <select id="modeloe" name="modeloe" class="form-control" required>
                            <option value="">Seleccione un modelo</option>
                            <?php 
                                $sortedModelos = array();
                                foreach($modelos as $modelo) {
                                    $sortedModelos[$modelo->nombre_modelo] = $modelo;
                                }
                                ksort($sortedModelos);
                                foreach($sortedModelos as $modelo) {
                            ?>
                                <option value="<?php echo $modelo->id_modelo; ?>"><?php echo $modelo->nombre_modelo; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trabajadore">Trabajador:</label>
                        <select id="trabajadore" name="trabajadore" class="form-control" required>
                            <option value="">Seleccione un trabajador</option>
                            <?php 
                                $sortedTrabajadores = array();
                                foreach($trabajadores as $trabajador) {
                                    $sortedTrabajadores[$trabajador->nombre_t] = $trabajador;
                                }
                                ksort($sortedTrabajadores);
                                foreach($sortedTrabajadores as $trabajador) {
                            ?>
                                <option value="<?php echo $trabajador->id_trabajador; ?>"><?php echo $trabajador->nombre_t; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Areae">Área:</label>
                        <select id="Areae" name="Areae" class="form-control" required>
                            <option value="">Seleccione un área</option>
                            <?php 
                                $sortedAreas = array();
                                foreach($areas as $area) {
                                    $sortedAreas[$area->nombre_areas] = $area;
                                }
                                ksort($sortedAreas);
                                foreach($sortedAreas as $area) {
                            ?>
                                <option value="<?php echo $area->idareas_municipalidad; ?>"><?php echo $area->nombre_areas; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>

                    </form>
                `,
         
            confirmButtonText: 'Registrar',

            preConfirm: function() {
                const codigo_patrimonial = Swal.getPopup().querySelector('#codigo_patrimonial').value;
                const descripcion_equipo = Swal.getPopup().querySelector('#descripcion_equipo').value;
                const numero_serie = Swal.getPopup().querySelector('#numero_serie').value;
                const fecha_adqusicion = Swal.getPopup().querySelector('#fecha_adqusicion').value;
                const tipo_equipo = Swal.getPopup().querySelector('#tipo_equipo').value;
                const fecha_baja = Swal.getPopup().querySelector('#fecha_baja').value;
                const estado_equipo = Swal.getPopup().querySelector('#estado_equipo').value;
                const marcae = Swal.getPopup().querySelector('#marcae').value;
                const modeloe = Swal.getPopup().querySelector('#modeloe').value;
                const trabajadore = Swal.getPopup().querySelector('#trabajadore').value;
                const Areae = Swal.getPopup().querySelector('#Areae').value;

                // Validar campos vacíos
                if (!codigo_patrimonial || !descripcion_equipo || !numero_serie || !fecha_adqusicion || !tipo_equipo  || !estado_equipo || !marcae || !modeloe || !trabajadore || !Areae) {
                    Swal.showValidationMessage('Por favor, completa todos los campos.');
                    return false;
                }

                // Enviar formulario
                const formData = new FormData();
                formData.append('codigo_patrimonial', codigo_patrimonial);
                formData.append('descripcion_equipo', descripcion_equipo);
                formData.append('numero_serie', numero_serie);
                formData.append('fecha_adqusicion', fecha_adqusicion);
                formData.append('tipo_equipo', tipo_equipo);
                formData.append('fecha_baja', fecha_baja);
                formData.append('estado_equipo', estado_equipo);
                formData.append('marcae', marcae);
                formData.append('modeloe', modeloe);
                formData.append('trabajadore', trabajadore);
                formData.append('Areae', Areae);

                fetch('<?php echo base_url(); ?>/Equipos/registrarEquipos', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
            }
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Registrado!',
                    'El equipo se registró correctamente.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }

        });

    });




const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const equipoId = this.getAttribute('data-id');
        const codigo_patrimonial = this.parentNode.parentNode.children[1].textContent;
        const descripcion_equipo = this.parentNode.parentNode.children[2].textContent;
        const numero_serie = this.parentNode.parentNode.children[3].textContent;
        const fecha_adqusicion = convertirFecha(this.parentNode.parentNode.children[4].textContent);
        const fecha_baja = convertirFecha(this.parentNode.parentNode.children[6].textContent);
        const estado_equipo = this.parentNode.parentNode.children[7].textContent;
        const trabajadore = this.parentNode.parentNode.children[10].textContent;
        const Areae = this.parentNode.parentNode.children[11].textContent;
        
        // Generar opciones del combobox de estado en JavaScript
        const estadosSelectOptions = `
            <option value="">Seleccione un nuevo estado</option>
            <option value="Activo" ${estado_equipo === 'Activo' ? 'selected' : ''}>Activo</option>
            <option value="Inactivo" ${estado_equipo === 'Inactivo' ? 'selected' : ''}>Inactivo</option>
        `;

        // Generar opciones del combobox de trabajador en JavaScript
        const trabajadoresSelectOptions = <?php echo json_encode($trabajadores); ?>.map(function (trabajadorOption) {
            const selected = (trabajadorOption.nombre_t === trabajadore) ? 'selected' : '';
            return `<option value="${trabajadorOption.id_trabajador}" ${selected}>${trabajadorOption.nombre_t}</option>`;
        });

        // Generar opciones del combobox de área en JavaScript
        const areasSelectOptions = <?php echo json_encode($areas); ?>.map(function (areaOption) {
            const selected = (areaOption.nombre_areas === Areae) ? 'selected' : '';
            return `<option value="${areaOption.idareas_municipalidad}" ${selected}>${areaOption.nombre_areas}</option>`;
        });

        // Función para convertir la fecha al formato "día-mes-año"
        function convertirFecha(fecha) {
            const parts = fecha.split('-');
            const fechaFormatted = parts[2] + '-' + parts[1] + '-' + parts[0];
            return fechaFormatted;
        }

        Swal.fire({
            title: 'Editar Equipos',
            html: `
                <form id="edit-trabajadores-form" method="post" action="<?= base_url('/Equipos/edit/') ?>/${equipoId}">
                    <div class="form-group">
                        <label for="edit-codigo_patrimonial">Código Patrimonial</label>
                        <input type="number" class="form-control" id="edit-codigo_patrimonial" name="codigo_patrimonial" required value="${codigo_patrimonial}">
                        <br>
                        <label for="edit-descripcion_equipo">Descripción</label>
                        <input type="text" class="form-control" id="edit-descripcion_equipo" name="descripcion_equipo" required value="${descripcion_equipo}">
                        <br>
                        <label for="edit-numero_serie">Número de Serie</label>
                        <input type="text" class="form-control" id="edit-numero_serie" name="numero_serie" required value="${numero_serie}">
                        <br>
                        <label for="edit-fecha_adqusicion">Fecha de Adquisición</label>
                        <input type="date" class="form-control" id="edit-fecha_adqusicion" name="fecha_adqusicion" required value="${fecha_adqusicion}">
                        <br>
                        <label for="edit-fecha_baja">Fecha de Baja</label>
                        <input type="date" class="form-control" id="edit-fecha_baja" name="fecha_baja" required value="${fecha_baja}">
                        <br>
                        <label for="edit-estado_equipo">Estado de Equipo:</label>
                        <select id="edit-estado_equipo" name="estado_equipo" class="form-control" required>
                            ${estadosSelectOptions}
                        </select>
                        <br>
                        <label for="edit-trabajadore">Trabajador:</label>
                        <select id="edit-trabajadore" name="trabajadore" class="form-control" required>
                            <option value="">Seleccione un nuevo trabajador</option>
                            ${trabajadoresSelectOptions.join('')}
                        </select>
                        <br>
                        <label for="edit-Areae">Área:</label>
                        <select id="edit-Areae" name="Areae" class="form-control" required>
                            <option value="">Seleccione un área</option>
                            ${areasSelectOptions.join('')}
                        </select>
                    </div>
                </form>`,
            showCancelButton: false,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                const codigo_patrimonial = Swal.getPopup().querySelector('#edit-codigo_patrimonial').value;
                const descripcion_equipo = Swal.getPopup().querySelector('#edit-descripcion_equipo').value;
                const numero_serie = Swal.getPopup().querySelector('#edit-numero_serie').value;
                const fecha_adqusicion = Swal.getPopup().querySelector('#edit-fecha_adqusicion').value;
                const fecha_baja = Swal.getPopup().querySelector('#edit-fecha_baja').value;
                const estado_equipo = Swal.getPopup().querySelector('#edit-estado_equipo').value;
                const trabajadore = Swal.getPopup().querySelector('#edit-trabajadore').value;
                const Areae = Swal.getPopup().querySelector('#edit-Areae').value;
                if (!codigo_patrimonial || !descripcion_equipo || !numero_serie || !fecha_adqusicion || !estado_equipo || !trabajadore || !Areae) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-trabajadores-form').submit();
            }
        });
    });
}
<?php if (session()->getFlashdata('success')) : ?>
    Swal.fire({
        title: 'Éxito',
        text: '<?= session()->getFlashdata('success') ?>',
        icon: 'success'
    });
<?php endif; ?>





const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            const equipoId = this.getAttribute('data-id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    // Enviar solicitud para eliminar el equipo con AJAX o fetch

                    // Ejemplo con fetch
                    fetch('<?php echo base_url(); ?>/Equipos/eliminarEquipo/' + equipoId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        // No es necesario convertir la respuesta a JSON
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El equipo se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el equipo debido a que se encuentra en mantenimiento.',
                            'error'
                        );
                    });
                }
            });
        });
    }

    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="resources/js/busqueda.js"></script>

</body>
</html>