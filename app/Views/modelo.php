<!DOCTYPE html>
<html>
<head>
  <title>Sistema Web Municipalidad de Sullana</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="icon" href="resources/img/logo.png">
  <link rel="stylesheet" href="resources/css/Tarjetas.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" type="text/css" href="resources/css/modelo.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
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
    <a href="<?php echo base_url();?>/Modelos"class="active"><i class="fas fa-barcode"></i> Modelos</a>
    <a href="<?php echo base_url();?>/Area"><i class="fas fa-building"></i> Area Municipal</a>
    <a href="<?php echo base_url();?>/Trabajadores"><i class="fas fa-users"></i> Trabajadores</a>
  </ul>
</div>
<br>
  <div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
    <h1>Registro de Modelos</h1>
<div>
  <button class="registrar-btn" id="registrar-btn">
    <i class="fas fa-microchip"></i> Registrar Modelo
  </button>
</div>

           <div class="search-bar">

        <input type="text" id="search-input" placeholder="Buscar...">
    </div>
    <table class="table">
      <thead>
        <tr>
          <th hidden>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Marca</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
<tbody>
    <?php foreach ($modelos as $modelo) : ?>
        <tr>
            <td hidden><?php echo $modelo['id_modelo']; ?></td>
            <td><?php echo $modelo['nombre_modelo']; ?></td>
            <td><?php echo $modelo['descripcion_modelo']; ?></td>
            <td><?php echo $modelo['marca']; ?></td>
            <td>
                <a href="#" class="btn-editar" data-id="<?php echo $modelo['id_modelo']; ?>"><i class="fas fa-edit"></i></a>
            </td>
            <td>
                <a href="#" class="btn-eliminar" data-id="<?php echo $modelo['id_modelo']; ?>"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>


    </table>
  </div>
</div>
</div>


<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Botón "Registrar Modelo" click event
    $('#registrar-btn').click(function() {
      Swal.fire({
        title: 'Registrar Modelo',
        html:
             '<input type="text" id="nombre-modelo" class="swal2-input" placeholder="Nombre del Modelo" required>' +
          '<input type="text" id="descripcion-modelo" class="swal2-input" placeholder="Descripción del Modelo" required>' +
          '<select id="marca-modelo" class="swal2-input" required>' +
            '<option value="">Seleccione una marca</option>' +
            '<?php 
               $sortedMarcas = array();
               foreach($marcas as $marca) {
                  $sortedMarcas[$marca->nombre_marca] = $marca;
               }
               ksort($sortedMarcas);
               foreach($sortedMarcas as $marca) {
            ?>' +
            '<option value="<?php echo $marca->id_marca; ?>"><?php echo $marca->nombre_marca; ?></option>' +
            '<?php 
               }
            ?>' +
            '</select>',


        showCancelButton: false,
        confirmButtonText: 'Registrar',
        preConfirm: function() {
          var nombreModelo = $('#nombre-modelo').val();
          var descripcionModelo = $('#descripcion-modelo').val();
          var marcaModelo = $('#marca-modelo').val();

          if (nombreModelo === '' || descripcionModelo === '' || marcaModelo === '') {
            Swal.showValidationMessage('Por favor, complete todos los campos');
            return false;
          }

          return {
            nombre_modelo: nombreModelo,
            descripcion_modelo: descripcionModelo,
            marca: marcaModelo
          };
        },
        didOpen: function() {
          $('#nombre-modelo').focus();
        }
      }).then(function(result) {
        if (!result.dismiss) {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?php echo base_url();?>/Modelos/registrar',
              method: 'POST',
              data: result.value,
              dataType: 'json',
              success: function(response) {
                Swal.fire({
                  title: 'Éxito',
                  text: response.message,
                  showCancelButton:false,
                  icon: 'success'
                }).then(function() {
                  location.reload();
                });
              },
              error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON.message;
                Swal.fire({
                  title: 'Error',
                  text: errorMessage,
                  icon: 'error'
                });
              }
            });
          }
        }
      });
    });
  });


  const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const modeloId = this.getAttribute('data-id');
        const nombremodelo = this.parentNode.parentNode.children[1].textContent;
        const descripcionmodelo = this.parentNode.parentNode.children[2].textContent;
        const marca = this.parentNode.parentNode.children[3].textContent;

        // Generar opciones del combobox de marca en JavaScript
        const marcasOptions = <?php echo json_encode($marcas); ?>;

        const marcasSelectOptions = marcasOptions.map(function (marcaOption) {
            const selected = (marcaOption.nombre_marca === marca) ? 'selected' : '';
            return `<option value="${marcaOption.id_marca}" ${selected}>${marcaOption.nombre_marca}</option>`;
        });

        Swal.fire({
            title: 'Editar Modelos',
            html: `
            <form id="edit-trabajadores-form" method="post" action="<?= base_url('/Modelos/edit/') ?>/${modeloId}">
                <div class="form-group">
                    <label for="edit-nombremodelo">Modelo</label>
                    <input type="text" class="swal2-input" id="edit-nombremodelo" name="nombre_modelo" required value="${nombremodelo}">
                    <br>
                    <label for="edit-descripcionmodelo">Descripción</label>
                    <input type="text" class="swal2-input" id="edit-descripcionmodelo" name="descripcion_modelo" required value="${descripcionmodelo}">
                    <br>
                    <label for="edit-marca">Marca</label>
                    <select id="edit-marca" class="swal2-select" name="marca" required>
                        ${marcasSelectOptions.join('')}
                    </select>
                </div>
            </form>`,
            showCancelButton: false,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                const nombremodelo = Swal.getPopup().querySelector('#edit-nombremodelo').value;
                const descripcionmodelo = Swal.getPopup().querySelector('#edit-descripcionmodelo').value;
                const marca = Swal.getPopup().querySelector('#edit-marca').value;
                if (!nombremodelo || !descripcionmodelo || !marca) {
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
            const modeloId = this.getAttribute('data-id');
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
                    fetch('<?php echo base_url(); ?>/Modelos/Eliminarmodelo/' + modeloId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        // No es necesario convertir la respuesta a JSON
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El modelo se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el modelo debido a que se encuentra registrado en un equipo.',
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
