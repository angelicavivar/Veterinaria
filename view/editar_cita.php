<?php
include('../model/config.php'); // Conexión a la base de datos
include('../view/parte1.php');

// Verificar si se ha recibido el ID de la cita
if (isset($_GET['id_cita'])) {
    $id_cita = filter_var($_GET['id_cita'], FILTER_SANITIZE_NUMBER_INT);

    try {
        // Obtener los datos de la cita por ID
        $sql = "SELECT * FROM citas WHERE id_cita = :id_cita";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_cita', $id_cita);
        $stmt->execute();
        $cita = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cita) {
            echo "
            <script>
                alert('Cita no encontrada.');
                window.history.back();
            </script>";
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "
    <script>
        alert('ID de cita no proporcionado.');
        window.history.back();
    </script>";
    exit();
}

// Actualizar los datos de la cita
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mascota = filter_var($_POST['mascota'], FILTER_SANITIZE_STRING);
    $fechaReserva = filter_var($_POST['fecha_reserva'], FILTER_SANITIZE_STRING);
    $horaReserva = filter_var($_POST['hora_reserva'], FILTER_SANITIZE_STRING);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $raza = filter_var($_POST['raza'], FILTER_SANITIZE_STRING);
    $servicio = filter_var($_POST['servicio'], FILTER_SANITIZE_STRING);

    try {
        $sql_update = "UPDATE citas 
                       SET mascota = :mascota, fechaReserva = :fechaReserva, horaReserva = :horaReserva, 
                           nombre = :nombre, correo = :correo, raza = :raza, servicio = :servicio 
                       WHERE id_cita = :id_cita";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':mascota', $mascota);
        $stmt_update->bindParam(':fechaReserva', $fechaReserva);
        $stmt_update->bindParam(':horaReserva', $horaReserva);
        $stmt_update->bindParam(':nombre', $nombre);
        $stmt_update->bindParam(':correo', $correo);
        $stmt_update->bindParam(':raza', $raza);
        $stmt_update->bindParam(':servicio', $servicio);
        $stmt_update->bindParam(':id_cita', $id_cita);

        if ($stmt_update->execute()) {
            echo "
            <script>
                alert('Cita actualizada exitosamente.');
                window.location.href = '../view/list-citas.php';
            </script>";
        } else {
            echo "
            <script>
                alert('Error al actualizar la cita.');
                window.history.back();
            </script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Editar Cita</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="mascota" class="form-label">Nombre de la Mascota</label>
            <input type="text" class="form-control" id="mascota" name="mascota" value="<?php echo $cita['mascota']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fecha_reserva" class="form-label">Fecha de Reserva</label>
            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" value="<?php echo $cita['fechaReserva']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="hora_reserva" class="form-label">Hora de Reserva</label>
            <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" value="<?php echo $cita['horaReserva']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Dueño</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $cita['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $cita['correo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="raza" class="form-label">Raza</label>
            <input type="text" class="form-control" id="raza" name="raza" value="<?php echo $cita['raza']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="servicio" class="form-label">Servicio</label>
            <select class="form-select" id="servicio" name="servicio" required>
                <option value="Consulta" <?php echo $cita['servicio'] == 'Consulta' ? 'selected' : ''; ?>>Consulta</option>
                <option value="Baño" <?php echo $cita['servicio'] == 'Baño' ? 'selected' : ''; ?>>Baño</option>
                <option value="Corte" <?php echo $cita['servicio'] == 'Corte' ? 'selected' : ''; ?>>Corte</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="../view/list-citas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
