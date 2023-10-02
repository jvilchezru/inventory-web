<!DOCTYPE html>
<html>

<head>
  <title>Sistema de inventario - MPS</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="resources/css/style.css">
  <link rel="icon" href="resources/img/logo-mps.png">
  <link rel="stylesheet" href="resources/css/Tarjetas.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="resources/js/jscerrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar">
    <div class="navbar-title">Sistema de Gestión de Inventario</div>
    <div class="dropdown ms-auto">
      <button class="btn dropdown-toggle" type="button" id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img class="img-profile rounded-circle" src="https://cdn.icon-icons.com/icons2/2030/PNG/512/user_icon_124042.png" alt="Foto de perfil" style="width: 40px; height: 40px;">
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
      <img src="resources/img/logo-mps.png" alt="Logo">
    </div>
    <ul>
      <a href="<?php echo base_url(); ?>/OpcionesController" class="active"><i class="fas fa-home"></i> Inicio</a>
      <a href="<?php echo base_url(); ?>/Equipos"><i class="fas fa-laptop"></i> Equipos</a>
      <a href="<?php echo base_url(); ?>/Mantenimiento"><i class="fas fa-tools"></i> Mantenimientos</a>
      <a href="<?php echo base_url(); ?>/Marcas"><i class="fas fa-trademark"></i> Marcas</a>
      <a href="<?php echo base_url(); ?>/Modelos"><i class="fas fa-barcode"></i> Modelos</a>
      <a href="<?php echo base_url(); ?>/Area"><i class="fas fa-building"></i> Area Municipal</a>
      <a href="<?php echo base_url(); ?>/Trabajadores"><i class="fas fa-users"></i> Trabajadores</a>
    </ul>
  </div>

  <div class="dashboard-container">
    <a href="<?php echo base_url('/Equipos'); ?>" class="dashboard-card blue">
      <i class="fas fa-laptop card-icon"></i>
      <h3>Equipos tecnológicos</h3>
      <br>
      <h2>
        <?php echo $numEquipos; ?>
      </h2>
    </a>

    <a href="<?php echo base_url('/Marcas'); ?>" class="dashboard-card blue">
      <i class="fas fa-trademark card-icon"></i>
      <h3>Marcas de equipos</h3>
      <br>
      <h2>
        <?php echo $numMarcas; ?>
      </h2>
    </a>

    <a href="<?php echo base_url('/Modelos'); ?>" class="dashboard-card green">
      <i class="fas fa-barcode card-icon"></i>
      <h3>Modelos de equipos</h3>
      <br>
      <h2>
        <?php echo $numModelos; ?>
      </h2>
    </a>

    <a href="<?php echo base_url('/Trabajadores'); ?>" class="dashboard-card red">
      <i class="fas fa-users card-icon" style="background-color: transparent;"></i>
      <h3>Trabajadores registrados</h3>
      <br>
      <h2>
        <?php echo $numTrabajadores; ?>
      </h2>
    </a>

    <select name="chartSelect" id="chartSelect" class="swal2-input">
      <option value="">Seleccione una grafica</option>
      <option value="trabajadores">Trabajadores por área</option>
      <option value="equipos">Equipos por trabajador</option>
    </select>

    <div class="chart-container">
      <canvas class="chartTrabajadoresPorArea" id="chartTrabajadoresPorArea" style="display: none;"></canvas>
      <canvas class="chartEquiposPorTrabajador" id="chartEquiposPorTrabajador" style="display: none;"></canvas>
    </div>


    <script>
      const chartData = <?php echo json_encode($areas); ?>;
      const areaLabels = chartData.map(area => area.nombre_areas);
      const trabajadoresCounts = chartData.map(area => area.trabajadores_count);

      new Chart(document.getElementById("chartTrabajadoresPorArea"), {
        type: 'bar',
        data: {
          labels: areaLabels,
          datasets: [{
            label: 'Trabajadores por área',
            data: trabajadoresCounts,
            backgroundColor: 'rgba(75, 192, 192, 0.4)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          animation: {
            duration: 6000,
            delay: 500
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                precision: 1
              }
            }
          }
        }
      });

      const equiposPorTrabajadorData = <?php echo json_encode($equiposPorTrabajador); ?>;
      const trabajadorLabels = equiposPorTrabajadorData.map(item => item.trabajador);
      const equiposCounts = equiposPorTrabajadorData.map(item => item.equipos_count);

      new Chart(document.getElementById("chartEquiposPorTrabajador"), {
        type: 'bar',
        data: {
          labels: trabajadorLabels,
          datasets: [{
            label: 'Equipos por trabajador',
            data: equiposCounts,
            backgroundColor: 'rgba(255, 99, 132, 0.4)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          animation: {
            duration: 6000,
            delay: 500
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                precision: 1
              }
            }
          }
        }
      });

      const chartSelect = document.getElementById("chartSelect");
      const chartTrabajadoresPorArea = document.getElementById("chartTrabajadoresPorArea");
      const chartEquiposPorTrabajador = document.getElementById("chartEquiposPorTrabajador");

      chartSelect.addEventListener("change", function() {
        const selectedValue = chartSelect.value;

        if (selectedValue === "trabajadores") {
          chartTrabajadoresPorArea.style.display = "block";
          chartEquiposPorTrabajador.style.display = "none";
        } else if (selectedValue === "equipos") {
          chartTrabajadoresPorArea.style.display = "none";
          chartEquiposPorTrabajador.style.display = "block";
        } else {
          chartTrabajadoresPorArea.style.display = 'none';
          chartEquiposPorTrabajador.style.display = 'none';
          location.reload();
        }

      });
    </script>
  </div>

</body>

</html>