<?php
include('../model/config.php');
include('../view/parte1.php');//parte 1 del index

// Obtener el id_usuario del usuario desde la URL
if (isset($_GET['id_usuario'])) {
    $user_id = $_GET['id_usuario'];

    // Obtener datos del usuario desde la base de datos
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Usuario no encontrado.</div>";
        exit;
    }
    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>ID de usuario no especificado.</div>";
    exit;
}

// Procesar el formulario de actualización al ser enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $rol = $_POST['rol'];

    if ($password === $confirm_password) {
        // Si se proporciona una nueva contraseña, hashearla
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

        // Actualizar el usuario en la base de datos
        $sql_update = "UPDATE usuarios SET nombre = ?, correo = ?, password = ?, rol = ? WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $nombre, $correo, $hashed_password, $rol, $user_id);

        if ($stmt_update->execute()) {
            echo "<div class='alert alert-success'>Usuario actualizado con éxito.</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index-users.php';
                    }, 2000); // Redirigir después de 2 segundos
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt_update->error . "</div>";
        }

        $stmt_update->close();
    } else {
        echo "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
    }
}

$conn->close();
?>
<br>
<div class="container-fluid">
    <h1>Editar un usuario</h1>
    <div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-success">
          <div class="card-header">
            <h3 class="card-title"><b>Datos del Usuario</b></h3>  
          </div>
          
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">  
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($user['correo']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm-password">Verificar Contraseña</label>
                            <input type="password" name="confirm-password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select name="rol" class="form-control" required>
                                <option value="administrador" <?php echo ($user['rol'] == 'administrador') ? 'selected' : ''; ?>>ADMINISTRADOR</option>
                                <option value="cliente" <?php echo ($user['rol'] == 'cliente') ? 'selected' : ''; ?>>CLIENTE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <a href="index-users.php" class="btn btn-secondary">Cancelar</a>
                        <input type="submit" class="btn btn-success" value="Actualizar usuario">
                    </div>
                </div>
                </form>
          </div>
    </div>
</div>

<?php include('../view/parte2.php');//parte 2 del index ?>
