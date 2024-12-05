<?php
include('../model/config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT id_usuario, nombre, correo, password, rol FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashed_password_db = $user['password'];

            if (password_verify($password, $hashed_password_db)) {
                // Guardar datos en la sesión
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['email'] = $user['correo'];
                $_SESSION['rol'] = $user['rol'];
              
                // Redirigir según el rol del usuario
                if ($user['rol'] == 'administrador') {
                    header("Location: index.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $error = "Credenciales incorrectas. Verifica tu correo y contraseña.";
            }
        } else {
            $error = "Credenciales incorrectas. Verifica tu correo y contraseña.";
        }
        $stmt->close();
    } else {
        $error = "Error interno del sistema. Por favor, inténtalo más tarde.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APP_NAME;?></title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL;?>/public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo $URL;?>./public/templeates/AdminLTE-3.2.0/index2.html"><b>Sistema de </b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <center>
            <img class="logo-login-i" src="<?php echo $URL;?>/assets/img/fondoContacto.jpg"  width="100%" alt="">
        </center>
      <p class="login-box-msg">Ingresa tus datos para iniciar sesión</p>

      <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

      <form action="" method="post">
        <label for="">Correo Electrónico</label>
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label for="">Contraseña</label>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary" style="width: 100%">Ingresar</button>
        <br><br>
        <a href="<?php echo $URL; ?>/index.php" class="btn btn-secondary" style="width: 100%">Cancelar</a>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo $URL;?>./public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $URL;?>./public/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $URL;?>./public/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
