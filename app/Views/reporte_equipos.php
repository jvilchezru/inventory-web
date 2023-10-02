<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Equipos Informaticos</title>
    


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
            font-size: 12px;
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

    <h1>Reporte de Equipos</h1>

    <table>
        <thead>
            <tr>
                <th>N°</th>
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
            </tr>
        </thead>
        <tbody>
            <?php
            $numero = 1;

            // Ordenar los equipos por área
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

            foreach ($equipos as $equipo) :
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

                foreach ($areas as $areaObj) {
                    if ($areaObj->idareas_municipalidad == $equipo['Areae']) {
                        $areaNombre = $areaObj->nombre_areas;
                        break;
                    }
                }
            ?>
                <tr>
                    <td><?= $numero ?></td>
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
                    <td><?= $trabajadorNombre . ' ' . $trabajadorApellido ?></td>
                    <td><?= $areaNombre ?></td>
                </tr>
            <?php
                $numero++; // Incrementar la variable de conteo
            endforeach;
            ?>
        </tbody>
    </table>

    <div class="footer">
        

        <div class="signature">
            <div class="signature-label">
                <input type="text" id="signature1" name="signature1" class="signature-input">
                <p>VªB</p>
            </div>
            <div class="signature-label">
                <input type="text" id="signature2" name="signature2" class="signature-input">
                <p>Soporte Técnico</p>
            </div>
        </div>
    </div>
</body>

</html>
