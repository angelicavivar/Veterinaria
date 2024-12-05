<?php
    include('../model/config.php');
    include('../view/parte1.php');//parte 1 del index

    // Obtener el ID del usuario desde la URL
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

    // Procesar la solicitud de eliminación
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql_delete = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $user_id);

        if ($stmt_delete->execute()) {
            echo "<div class='alert alert-success'>Usuario eliminado con éxito.</div>";
            echo "<a href='index-users.php' class='btn btn-primary'>Volver a la lista de usuarios</a>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt_delete->error . "</div>";
        }

        $stmt_delete->close();
    }

    $conn->close();
?>
<br>
<div class="container-fluid">
    <h1>Datos del usuario</h1>
    <div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title"><b>¿Estás seguro de eliminar este usuario?</b></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre Completo</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['correo']); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['rol']); ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="index-users.php" class="btn btn-secondary">Cancelar</a>
                            <input type="submit" class="btn btn-danger" value="Eliminar usuario">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../view/parte2.php');//parte 2 del index ?>
