    <?php
        include('../model/config.php');
        include('../view/parte1.php');//parte 1 del index

        // Procesar el formulario de creación al ser enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];
            $rol = strtolower($_POST['rol']); // Guardar el rol en minúsculas en una variable

            // Verificar si las contraseñas coinciden
            if ($password === $confirm_password) {
                // Hashear la contraseña antes de almacenarla
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el usuario en la base de datos
                $sql_insert = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ssss", $nombre, $correo, $hashed_password, $rol);

                if ($stmt_insert->execute()) {
                    echo "<div class='alert alert-success'>Usuario creado con éxito.</div>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'index-users.php';
                            }, 2000); // Redirigir después de 2 segundos
                        </script>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt_insert->error . "</div>";
                }

                $stmt_insert->close();
            } else {
                echo "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
            }
        }

        $conn->close();
    ?>
    <br>
    <div class="container-fluid">
        <h1>Crear un usuario</h1>
        <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
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
                                <input type="text" name="nombre" class="form-control" placeholder="Ingresa el nombre completo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" class="form-control" placeholder="Crea una contraseña segura" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirm-password">Verificar Contraseña</label>
                                <input type="password" name="confirm-password" class="form-control" placeholder="Repite la contraseña" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select name="rol" class="form-control" required>
                                    <option value="administrador">ADMINISTRADOR</option>
                                    <option value="cliente">CLIENTE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="index-users.php" class="btn btn-secondary">Cancelar</a>
                            <input type="submit" class="btn btn-primary" value="Crear usuario">
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <?php include('../view/parte2.php');//parte 2 del index ?>
