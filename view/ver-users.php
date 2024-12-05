<?php
include('../model/config.php');
include('../view/parte1.php'); // Parte 1 del index

// Verificar si se ha pasado un id de usuario
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Consultar los datos del usuario
    $sql = "SELECT nombre, correo, rol FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-warning'>Usuario no encontrado.</div>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error al preparar la consulta.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No se ha proporcionado un ID de usuario.</div>";
    exit;
}

$conn->close();
?>

<br>
<div class="container-fluid">
    <h1>Datos del usuario</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nombre Completo</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['nombre']); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Correo Electrónico</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['correo']); ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Cargo</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars(strtoupper($user['rol'])); ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="index-users.php" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../view/parte2.php'); // Parte 2 del index ?>
