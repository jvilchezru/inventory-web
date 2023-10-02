<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="resources/css/estilo.css">
  <link rel="icon" href="resources/img/logo-mps.png">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Municipalidad Provincial de Sechura</title>
</head>

<body>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="container px-5 my-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 rounded-3 shadow-lg">
          <div class="card-body p-4">
            <div class="text-center">
              <form action="<?php echo base_url('login/validateLogin'); ?>" method="post">
                <div class="h1 fw-light">INICIO DE SESION</div>
                <p class="mb-4 text-muted">Sistema de gestion de equipos informaticos</p>
            </div>

            <div class="form-floating mb-3">
              <input class="form-control" id="user" name="user" required="Ingrese un usuario" type="text" placeholder="Usuario" />
              <label for="user">Usuario</label>
            </div>

            <div class="form-floating mb-3">
              <input class="form-control" id="password" name="password" required="Ingrese una contraseña" type="password" placeholder="Contraseña" />
              <label for="password">Contraseña</label>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="showPasswordCheckbox">
              <label class="form-check-label" for="showPasswordCheckbox">Mostrar contraseña</label>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary btn-lg" id="submitButton" name="btningresar" type="submit">Iniciar Session</button>
            </div>
            </form>
            <?php if (isset($error)) : ?>
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                    title: 'Error',
                    text: "<?php echo $error; ?>",
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                });
              </script>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="resources/js/Mostrar.js"></script>

</body>

</html>