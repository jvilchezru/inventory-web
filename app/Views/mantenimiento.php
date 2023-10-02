<!DOCTYPE html>
<html>
<head>
  <title>Sistema Web Municipalidad de Sullana</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/mantenimiento.css">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="icon"  href="resources/img/logo.png">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar">
      <div class="navbar-title">Sistema de Registro de Equipos</div>
      <div class="dropdown ms-auto">
        <button class="btn dropdown-toggle"type="button"id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false"><img class="img-profile rounded-circle" src="https://media.licdn.com/dms/image/D4E03AQHDmNR5lSaoEA/profile-displayphoto-shrink_400_400/0/1665241485740?e=1689811200&v=beta&t=8YsfqqYXxTylYfIdjgMQOTDyzV-HV31Qlss0DFsZLts" alt="Foto de perfil" style="width: 40px; height: 40px;">
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
    <a href="<?php echo base_url();?>/Equipos"><i class="fas fa-laptop"></i> Equipos</a>
    <a href="<?php echo base_url();?>/Mantenimiento"class="active"><i class="fas fa-tools"></i> Mantenimientos</a>
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
    <h1>Registro de Mantenimiento de equipos</h1>
   <div>
  <button class="registrar-btn" id="registrar-btn">
    <i class="fas fa-cog"></i> Registrar Mantenimiento
  </button>
</div>

         <div class="reporte-btn-container">
                    <a href="<?php echo base_url('Mantenimiento/generarPDF'); ?>" class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="<?php echo base_url('Mantenimiento/generarReportExcel'); ?>" class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>
<br>


           <div class="search-bar">
        <input type="text" id="search-input" placeholder="Buscar...">
    </div>
    <table class="table">
      <thead>
        <tr>
          <th hidden>ID</th>
          <th>Codigo Patrimonial</th>
          <th>Descripción</th>
          <th>Fecha</th>
          <th>Costo</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
              <tbody>
          <?php 
          foreach ($mantenimientos as $mantenimiento): ?>
            <tr>
              <td hidden><?php echo $mantenimiento['id_mantenimiento'] ?></td>
               <?php
                  $codigo_id = $mantenimiento['codpatrimonial']; 
                  $codigopatrimonial = ""; 

                  
                  foreach ($equipos as $equipo) {
                    if ($equipo->id_equipos == $codigo_id) {
                      $codigopatrimonial = $equipo->codigo_patrimonial;
                      break;
                    }
                  }
                  ?>

                  <td><?php echo $codigopatrimonial; ?></td>
              <td><?php echo $mantenimiento['descripcion_mantenimiento'] ?></td>
               <td><?php echo date('d-m-Y', strtotime($mantenimiento['fecha_mantenimiento'])) ?></td>
              <td>S/.<?php echo $mantenimiento['costo_mantenimiento'] ?></td>
              <td>
            <a href="#" class="btn-editar" data-id="<?php echo $mantenimiento['id_mantenimiento']; ?>"><i class="fas fa-edit"></i></a>
        </td>
        <td>
            <a href="#" class="btn-eliminar" data-id="<?php echo $mantenimiento['id_mantenimiento']; ?>"><i class="fas fa-trash"></i></a>
        </td>
            </tr>
          <?php endforeach; ?>
        </tbody>

    </table>
  </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="resources/js/busqueda.js"></script>
<script>
document.getElementById('registrar-btn').addEventListener('click', function() {
  Swal.fire({
    title: 'Registrar Mantenimiento',
    html: `
      <form id="mantenimiento-form">
        <select class="swal2-input" name="codpatrimonial" required>
          <option value="">Seleccione un código patrimonial</option>
          <?php foreach ($equipos as $equipo): ?>
            <option value="<?php echo $equipo->id_equipos; ?>"><?php echo $equipo->codigo_patrimonial; ?></option>
          <?php endforeach; ?>
        </select><br>
        <input type="text" class="swal2-input" name="descripcion_mantenimiento" placeholder="Descripción" required><br>
        <input type="date" class="swal2-input" name="fecha_mantenimiento" placeholder="Fecha" required><br>
        <input type="number" class="swal2-input" name="costo_mantenimiento" placeholder="Costo" required><br>
      </form>`,
    showCancelButton: false,
    confirmButtonText: 'Registrar',
    preConfirm: () => {
      const form = document.getElementById('mantenimiento-form');
      const codpatrimonial = form.elements['codpatrimonial'].value;
      const descripcion_mantenimiento = form.elements['descripcion_mantenimiento'].value;
      const fecha_mantenimiento = form.elements['fecha_mantenimiento'].value;
      const costo_mantenimiento = form.elements['costo_mantenimiento'].value;

      // Validar campos vacíos
      if (codpatrimonial === '' || descripcion_mantenimiento === '' || fecha_mantenimiento === '' || costo_mantenimiento === '') {
        Swal.showValidationMessage('Por favor, complete todos los campos.');
        return false;
      }
// Enviar formulario
                const formData = new FormData();
                formData.append('codpatrimonial', codpatrimonial);
                formData.append('descripcion_mantenimiento', descripcion_mantenimiento);
                formData.append('fecha_mantenimiento', fecha_mantenimiento);
                formData.append('costo_mantenimiento', costo_mantenimiento);

                fetch('<?php echo base_url(); ?>/Mantenimiento/registrar', {
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
        const mantenimientoId = this.getAttribute('data-id');
        const descripcion_mantenimiento = this.parentNode.parentNode.children[2].textContent;
        const fecha_mantenimiento = convertirFecha(this.parentNode.parentNode.children[3].textContent);
        const costo_mantenimiento = this.parentNode.parentNode.children[4].textContent.replace('S/.', '');

        // Función para convertir la fecha al formato "día-mes-año"
        function convertirFecha(fecha) {
            const parts = fecha.split('-');
            const fechaFormatted = parts[2] + '-' + parts[1] + '-' + parts[0];
            return fechaFormatted;
        }

        Swal.fire({
            title: 'Editar Mantenimientos',
            html: `
                <form id="edit-mantenimiento-form" method="post" action="<?= base_url('/Mantenimiento/edit/') ?>/${mantenimientoId}">
                    <div class="form-group">
                        <label for="edit-descripcion_mantenimiento">Descripción</label>
                        <input type="text" class="swal2-input" id="edit-descripcion_mantenimiento" name="descripcion_mantenimiento" required value="${descripcion_mantenimiento}">
                        <br>
                        <label for="edit-fecha_mantenimiento">Fecha</label>
                        <input type="date" class="swal2-input" id="edit-fecha_mantenimiento" name="fecha_mantenimiento" required value="${fecha_mantenimiento}">
                        <br>
                        <label for="edit-costo_mantenimiento">Costo</label>
                        <input type="number" class="swal2-input" id="edit-costo_mantenimiento" name="costo_mantenimiento" required value="${costo_mantenimiento}">
                    </div>
                </form>`,
            showCancelButton: false,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                const descripcion_mantenimiento = Swal.getPopup().querySelector('#edit-descripcion_mantenimiento').value;
                const fecha_mantenimiento = Swal.getPopup().querySelector('#edit-fecha_mantenimiento').value;
                const costo_mantenimiento = Swal.getPopup().querySelector('#edit-costo_mantenimiento').value;
                if (!descripcion_mantenimiento || !fecha_mantenimiento || !costo_mantenimiento) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-mantenimiento-form').submit();
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
            const mantenimientoId = this.getAttribute('data-id');
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
                    fetch('<?php echo base_url(); ?>/Mantenimiento/eliminarmantenimiento/' + mantenimientoId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        // No es necesario convertir la respuesta a JSON
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El mantenimiento se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el mantenimiento.',
                            'error'
                        );
                    });
                }
            });
        });
    }
</script>



</body>
</html>