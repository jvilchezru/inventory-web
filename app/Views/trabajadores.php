<!DOCTYPE html>
<html>
<head>
  <title>Sistema Web Municipalidad de Sullana</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="icon"  href="resources/img/logo.png">
  <link rel="stylesheet" href="resources/css/Tarjetas.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="resources/css/trabajadores.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
      <a href="<?php echo base_url();?>/Equipos"><i class="fas fa-laptop"></i> Equipos</a>
      <a href="<?php echo base_url();?>/Mantenimiento"><i class="fas fa-tools"></i> Mantenimientos</a>
      <a href="<?php echo base_url();?>/Marcas"><i class="fas fa-trademark"></i> Marcas</a>
      <a href="<?php echo base_url();?>/Modelos"><i class="fas fa-barcode"></i> Modelos</a>
      <a href="<?php echo base_url();?>/Area"><i class="fas fa-building"></i> Area Municipal</a>
      <a href="<?php echo base_url();?>/Trabajadores"class="active"><i class="fas fa-users"></i> Trabajadores</a>
    </ul>
  </div>
  <br>

  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <h1>Registro de Trabajadores</h1>
        <div>
          
<button class="registrar-btn" id="registrar-btn" onclick="showRegistrarTrabajadorModal()">
  <i class="fas fa-user-plus"></i> Registrar Trabajador
</button>
          <br>
          <div class="search-bar">
            <input type="text" id="search-input" placeholder="Buscar...">
          </div>

           <?php
        // Ordenar el array de trabajadores por nombre
        usort($trabajadores, function ($a, $b) {
          return strcmp($a['nombre_t'], $b['nombre_t']);
        });
        ?>
          
          <table class="table" id="mi-tabla">
            <thead>
              <tr>
                <th hidden>ID</th>
                <th>Nombre</th>
               
                <th>Correo</th>
                <th>Condición</th>
                <th>Area</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($trabajadores as $trabajador): ?>
              <tr>
                <td hidden><?php echo $trabajador['id_trabajador']; ?></td>
                <td><?php echo $trabajador['nombre_t']; ?></td>
                
                <td><?php echo $trabajador['correo']; ?></td>
                <td><?php echo $trabajador['condicion']; ?></td>
                <?php
                  $area_id = $trabajador['area']; 
                  $nombre_area = ""; 

                  
                  foreach ($areas as $area) {
                    if ($area->idareas_municipalidad == $area_id) {
                      $nombre_area = $area->nombre_areas;
                      break;
                    }
                  }
                  ?>

                  <td><?php echo $nombre_area; ?></td>
                  <td><a href="#" class="btn-editar" data-id="<?php echo $trabajador['id_trabajador']; ?>"><i class="fas fa-edit"></i></a></td>
                <td><a href="#" class="btn-eliminar" data-id="<?php echo $trabajador['id_trabajador']; ?>"><i class="fas fa-trash"></i></a></td>
                                </tr>
                              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert2 registrar trabajador-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function showRegistrarTrabajadorModal() {
    Swal.fire({
      title: 'Registrar Trabajador',
      html:
        '<input id="nombre" class="swal2-input" placeholder="Nombre">' +
        
        '<input id="correo" class="swal2-input" placeholder="Correo">' +
        '<br>' +
        '<select id="condicion" class="swal2-select">' +
        '<option value="">Seleccione una condición</option>' +
        '<option value="CAS">CAS</option>' +
        '<option value="Locador de servicios">Locador de servicios</option>' +
        '<option value="Nombrado">Nombrado</option>' +
        '</select>' +
        '<br>' +
            '<select id="area" class="swal2-select" required>' +
            '<option value="">Seleccione un área</option>' +
            '<?php 
               $sortedAreas = array();
               foreach($areas as $area) {
                  $sortedAreas[$area->nombre_areas] = $area;
               }
               ksort($sortedAreas);
               foreach($sortedAreas as $area) {
            ?>' +
            '<option value="<?php echo $area->idareas_municipalidad; ?>"><?php echo $area->nombre_areas; ?></option>' +
            '<?php 
               }
            ?>' +
            '</select>',

          confirmButtonText:'Registrar',
        focusConfirm: false,
        preConfirm: () => {
          const nombre = Swal.getPopup().querySelector('#nombre').value;
          const correo = Swal.getPopup().querySelector('#correo').value;
          const condicion = Swal.getPopup().querySelector('#condicion').value;
          const area = Swal.getPopup().querySelector('#area').value;

          // Validar campos vacíos
          if (!nombre  || !correo || !condicion || !area) {
            Swal.showValidationMessage('Por favor, complete todos los campos.');
            return false;
          }

          // Realizar la petición AJAX para registrar al trabajador
          // Aquí puedes agregar tu lógica para enviar los datos al controlador
          const formData = new FormData();
          formData.append('nombre', nombre);
          formData.append('correo', correo);
          formData.append('condicion', condicion);
          formData.append('area', area);

          fetch('<?php echo base_url(); ?>/Trabajadores/registrar', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                location.reload(); 
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
              });
            }
          });
        }
      });
    }

const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const trabajadorId = this.getAttribute('data-id');
        const nombre = this.parentNode.parentNode.children[1].textContent;
        const correo = this.parentNode.parentNode.children[2].textContent;
        const condicion = this.parentNode.parentNode.children[3].textContent;
        const area = this.parentNode.parentNode.children[4].textContent;

        // Generar opciones del combobox de condición en JavaScript
        const condicionesOptions = ['CAS', 'Locador de servicios', 'Nombrado'];

        const condicionesSelectOptions = condicionesOptions.map(function (condicionOption) {
            const selected = (condicionOption === condicion) ? 'selected' : '';
            return `<option value="${condicionOption}" ${selected}>${condicionOption}</option>`;
        });

        // Generar opciones del combobox de área en JavaScript
        const areasOptions = <?php echo json_encode($areas); ?>;

        const areasSelectOptions = areasOptions.map(function (areaOption) {
            const selected = (areaOption.nombre_areas === area) ? 'selected' : '';
            return `<option value="${areaOption.idareas_municipalidad}" ${selected}>${areaOption.nombre_areas}</option>`;
        });

        Swal.fire({
            title: 'Editar Trabajadores',
            html: `
            <br>
            <form id="edit-trabajadores-form" method="post" action="<?= base_url('/Trabajadores/edit/') ?>/${trabajadorId}">
                <div class="form-group">
                    <label for="edit-nombre">Nombre</label>
                    <input type="text" class="swal2-input" id="edit-nombre" name="nombre" required value="${nombre}">
                    <br>
                    <label for="edit-correo">Correo</label>
                    <input type="text" id="edit-correo" class="swal2-input" placeholder="Correo" name="correo" value="${correo}">
                    <br>
                    <label for="edit-condicion">Condición</label>
                    <select id="edit-condicion" class="swal2-select" name="condicion" required>
                        ${condicionesSelectOptions.join('')}
                    </select>
                    <br>
                    <label for="edit-area">Área</label>
                    <select id="edit-area" class="swal2-select" name="area" required>
                        ${areasSelectOptions.join('')}
                    </select>
                </div>
            </form>`,
            showCancelButton: false,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#edit-nombre').value;
                const correo = Swal.getPopup().querySelector('#edit-correo').value;
                const condicion = Swal.getPopup().querySelector('#edit-condicion').value;
                const area = Swal.getPopup().querySelector('#edit-area').value;
                if (!nombre  || !correo || !condicion || !area) {
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
            const trabajadorId = this.getAttribute('data-id');
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
                    fetch('<?php echo base_url(); ?>/Trabajadores/Eliminartrabjador/' + trabajadorId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        // No es necesario convertir la respuesta a JSON
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El trabajador se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el trabajador debido a que se encuentra asociado a un equipo.',
                            'error'
                        );
                    });
                }
            });
        });
    }
  </script>
    <script src="resources/js/busqueda.js"></script>
</body>
</html>
