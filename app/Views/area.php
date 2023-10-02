<!DOCTYPE html>
<html>
<head>
  <title>Sistema Web Municipalidad de Sullana</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="icon"  href="resources/img/logo.png">
  <link rel="stylesheet" href="resources/css/Tarjetas.css">
  <link rel="stylesheet" type="text/css" href="resources/css/area.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
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
    <a href="<?php echo base_url();?>/Area"class="active"><i class="fas fa-building"></i> Area Municipal</a>
    <a href="<?php echo base_url();?>/Trabajadores"><i class="fas fa-users"></i> Trabajadores</a>
  </ul>
</div>
  <br>

  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <h1>Registro de Areas</h1>
          <?php if (session()->getFlashdata('success')) : ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: '<?php echo session()->getFlashdata('success'); ?>',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                </script>
            <?php endif; ?>
       <div>
  <button class="registrar-btn" id="registrar-btn">
    <i class="fas fa-building"></i> Registrar Área
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
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
            <tbody>
            <?php foreach ($areas as $area) : ?>
              <tr>
                <td hidden><?= $area['idareas_municipalidad'] ?></td>
                <td><?= $area['nombre_areas'] ?></td>
                <td><?= $area['descripcion'] ?></td>
                <td><a href="#" class="btn-editar" data-id="<?php echo $area['idareas_municipalidad']; ?>"><i class="fas fa-edit"></i></a></td>
              <td><a href="#" class="btn-eliminar" data-id="<?php echo $area['idareas_municipalidad']; ?>"><i class="fas fa-trash"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script>
    // SweetAlert2 para registrar un área
    document.getElementById('registrar-btn').addEventListener('click', function () {
      Swal.fire({
        title: 'Registrar Área',
        html:
          '<input id="nombre_areas" class="swal2-input" placeholder="Nombre">' +
          '<input id="descripcion" class="swal2-input" placeholder="Descripción">',
        focusConfirm: false,
        showCancelButton: false,
        confirmButtonText: 'Registrar',
        preConfirm: () => {
          const nombreAreas = Swal.getPopup().querySelector('#nombre_areas').value;
          const descripcion = Swal.getPopup().querySelector('#descripcion').value;

          if (!nombreAreas || !descripcion) {
            Swal.showValidationMessage('Por favor, ingresa todos los campos');
            return false;
          }

          // Enviar formulario de registro de área
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '<?php echo base_url(); ?>/Area/registrar';
          form.style.display = 'none';

          const inputNombreAreas = document.createElement('input');
          inputNombreAreas.name = 'nombre_areas';
          inputNombreAreas.value = nombreAreas;
          form.appendChild(inputNombreAreas);

          const inputDescripcion = document.createElement('input');
          inputDescripcion.name = 'descripcion';
          inputDescripcion.value = descripcion;
          form.appendChild(inputDescripcion);

          document.body.appendChild(form);
          form.submit();
          return true;
        }
      });
    });

    // SweetAlert2 para eliminar un área
    const eliminarButtons = document.querySelectorAll('.btn-eliminar');
    eliminarButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        const areaId = this.getAttribute('data-id');

        Swal.fire({
          title: '¿Estás seguro?',
          text: 'Esta acción no se puede deshacer',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Enviar formulario de eliminación de área
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo base_url(); ?>/Area/eliminarArea/' + areaId;
            form.style.display = 'none';

            document.body.appendChild(form);
            form.submit();
          }
        });
      });
    });

    // SweetAlert2 para editar un área
  const editarButtons = document.querySelectorAll('.btn-editar');
  editarButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const areaId = this.getAttribute('data-id');

      // Obtener el área correspondiente al áreaId seleccionado
      const area = <?php echo json_encode($areas); ?>.find(area => area.idareas_municipalidad === areaId);

      Swal.fire({
        title: 'Editar Área',
        html:
          '<input id="nombre_areas" class="swal2-input" placeholder="Nombre">' +
          '<input id="descripcion" class="swal2-input" placeholder="Descripción">',
        focusConfirm: false,
        showCancelButton: false,
        confirmButtonText: 'Guardar cambios',
        preConfirm: () => {
          const nombreAreas = Swal.getPopup().querySelector('#nombre_areas').value;
          const descripcion = Swal.getPopup().querySelector('#descripcion').value;

          if (!nombreAreas || !descripcion) {
            Swal.showValidationMessage('Por favor, ingresa todos los campos');
            return false;
          }

          // Enviar formulario de edición de área
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '<?php echo base_url(); ?>/Area/guardarCambios/' + areaId;
          form.style.display = 'none';

          const inputNombreAreas = document.createElement('input');
          inputNombreAreas.name = 'nombre_areas';
          inputNombreAreas.value = nombreAreas;
          form.appendChild(inputNombreAreas);

          const inputDescripcion = document.createElement('input');
          inputDescripcion.name = 'descripcion';
          inputDescripcion.value = descripcion;
          form.appendChild(inputDescripcion);

          document.body.appendChild(form);
          form.submit();
          return true;
        }
      });

      // Rellenar los campos con los datos del área seleccionada
      document.getElementById('nombre_areas').value = area.nombre_areas;
      document.getElementById('descripcion').value = area.descripcion;
    });
  });

    // Función para buscar áreas
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('keyup', function () {
      const value = this.value.toLowerCase().trim();
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const nombre = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
        const descripcion = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();

        if (nombre.includes(value) || descripcion.includes(value)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>
