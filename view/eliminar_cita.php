<?php
include('../model/config.php'); // Conexión a la base de datos

if (isset($_GET['id_cita'])) {
    $id_cita = filter_var($_GET['id_cita'], FILTER_SANITIZE_NUMBER_INT);

    try {
        // Eliminar la cita por ID
        $sql = "DELETE FROM citas WHERE id_cita = :id_cita";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_cita', $id_cita);

        if ($stmt->execute()) {
            echo "
            <script>
                alert('Cita eliminada exitosamente.');
                window.location.href = '../view/list-citas.php';
            </script>";
        } else {
            echo "
            <script>
                alert('Error al eliminar la cita.');
                window.history.back();
            </script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "
    <script>
        alert('ID de cita no proporcionado.');
        window.history.back();
    </script>";
}
?>
