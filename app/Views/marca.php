<!DOCTYPE html>
<html>
<head>
    <title>Sistema Web Municipalidad de Sullana</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resources/css/style.css'); ?>">
    <link rel="icon" href="<?php echo base_url('resources/img/logo.png'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url('resources/js/jscerrar.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="resources/css/marca.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
</head>
<body>

<nav class="navbar">
    <div class="navbar-title">Sistema de Registro de Equipos</div>
    <div class="dropdown ms-auto">
        <button class="btn dropdown-toggle" type="button" id="user-dropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
            <img class="img-profile rounded-circle"
                 src="https://media.licdn.com/dms/image/D4E03AQHDmNR5lSaoEA/profile-displayphoto-shrink_400_400/0/1665241485740?e=1689811200&v=beta&t=8YsfqqYXxTylYfIdjgMQOTDyzV-HV31Qlss0DFsZLts"
                 alt="Foto de perfil" style="width: 40px; height: 40px;">
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
    <a href="<?php echo base_url();?>/Marcas"class="active"><i class="fas fa-trademark"></i> Marcas</a>
    <a href="<?php echo base_url();?>/Modelos"><i class="fas fa-barcode"></i> Modelos</a>
    <a href="<?php echo base_url();?>/Area"><i class="fas fa-building"></i> Area Municipal</a>
    <a href="<?php echo base_url();?>/Trabajadores"><i class="fas fa-users"></i> Trabajadores</a>
  </ul>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h1>Registro de Marcas</h1>

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
                <button class="registrar-btn" id="registrar-btn" onclick="showRegistrarMarcaModal()">
  <i class="fas fa-trademark"></i> Registrar Marca
</button>
                 <br>
                 <div class="search-bar">

        <input type="text" id="search-input" placeholder="Buscar...">
    </div>
    
                <table class="table" id="mi-tabla">
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
                    <?php foreach ($marcas as $marca) : ?>
                        <tr>
                            <td hidden><?php echo $marca['id_marca']; ?></td>
                            <td><?php echo $marca['nombre_marca']; ?></td>
                            <td><?php echo $marca['descripcion']; ?></td>
                            <td><a href="#" class="btn-editar" data-id="<?php echo $marca['id_marca']; ?>"><i class="fas fa-edit"></i></a></td>
                            <td><a href="#" class="btn-eliminar" data-id="<?php echo $marca['id_marca']; ?>"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function showRegistrarMarcaModal() {
        Swal.fire({
            title: 'Registrar Marca',
            html: `
            <br>
                <form id="marca-form" method="post" action="<?= base_url('/Marcas/create') ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre de la marca</label>
                        <br>
                        <br>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <br><br>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Registrar',

            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#nombre').value;
                const descripcion = Swal.getPopup().querySelector('#descripcion').value;
                if (!nombre || !descripcion) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('marca-form').submit();
            }
        });
    }

    const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function () {
            const marcaId = this.getAttribute('data-id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `<?= base_url('/Marcas/delete/') ?>/${marcaId}`;
                }
            });
        });
    }

    const editButtons = document.getElementsByClassName('btn-editar');
    for (let i = 0; i < editButtons.length; i++) {
        editButtons[i].addEventListener('click', function () {
            const marcaId = this.getAttribute('data-id');
            const nombre = this.parentNode.parentNode.children[1].textContent;
            const descripcion = this.parentNode.parentNode.children[2].textContent;
            Swal.fire({
                title: 'Editar Marca',
                html: `
                <br>
                <form id="edit-marca-form" method="post" action="<?= base_url('/Marcas/edit/') ?>/${marcaId}">
                    <div class="form-group">
                        <label for="edit-nombre">Nombre de la marca</label>
                        <br>
                        <br>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" required
                               value="${nombre}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="edit-descripcion">Descripción</label>
                        <br><br>
                        <textarea class="form-control" id="edit-descripcion" name="descripcion" required>${descripcion}</textarea>
                    </div>
                </form>`,
                showCancelButton: false,
                confirmButtonText: 'Guardar',

                preConfirm: () => {
                    const nombre = Swal.getPopup().querySelector('#edit-nombre').value;
                    const descripcion = Swal.getPopup().querySelector('#edit-descripcion').value;
                    if (!nombre || !descripcion) {
                        Swal.showValidationMessage('Por favor, completa todos los campos');
                        return false;
                    }
                    Swal.close();
                    document.getElementById('edit-marca-form').submit();
                }
            });
        });
    }

    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('keyup', function () {
        const value = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const marcaName = row.children[1].textContent.toLowerCase().trim();
            if (marcaName.includes(value)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<script type="text/javascript" src="resources/js/busqueda.js"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
