<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Mantenimiento de Equipos</title>
    

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 15px;
            text-align: left;
        }

        .date-time {
            text-align: right;
            margin-bottom: 20px;
            font-size: 18px;
        }

      .footer {
            position: fixed;
            bottom: 0; 
            width: 100%; 
            padding: 20px; 
           
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            text-align: center;
            margin-right: -90px;
        }

        .signature-input {
            display: inline-block;
            width: 200px;
            height: 30px;
            border: none;
            border-bottom: 1px solid #000;
            padding: 0;
            margin: 0;
        }

        .signature-label {
            display: inline-block;
            text-align: center;
            margin-right: 140px; /* Separación mayor entre las firmas */
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="<?php echo base_url('resources/img/logo.png'); ?>" alt="Logo" width="100">
        <p>Municipalidad Provincial de Sullana</p>
    </div>

    <div class="date-time">
        <p>Fecha: <?php echo date('d-m-Y'); ?> | Hora: <?php echo date('H:i:s'); ?></p>
    </div>
    <h1>Reporte de Mantenimientos</h1>

    <table class="table">
        <thead>
            <tr> <th>N°</th>
                <th>Codigo Patrimonial</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
              <?php
            $numero = 1;

            foreach ($mantenimientos as $mantenimiento): ?>
            <tr>
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
                <td><?= $numero ?></td>
                <td><?php echo $codigopatrimonial; ?></td>
                <td><?php echo $mantenimiento['descripcion_mantenimiento'] ?></td>
                <td><?php echo date('d-m-Y', strtotime($mantenimiento['fecha_mantenimiento'])) ?></td>
                <td>S/.<?php echo $mantenimiento['costo_mantenimiento'] ?></td>
            </tr>
            <?php 
             $numero++;
        endforeach; ?>
        </tbody>
    </table>
<br>
    <div class="footer">
      

<br><br>
        <div class="signature">
            <div class="signature-label">
                
                <input type="text" id="signature1" name="signature1" class="signature-input">
                <p>VªB</p>
            </div>
            <div class="signature-label">
                
                <input type="text" id="signature2" name="signature2" class="signature-input">
                <p>Soporte Tecnico</p>
            </div>
        </div>
    </div>
</body>

</html>
