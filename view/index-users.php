<?php
    include('../model/config.php');
    include('../view/parte1.php');//parte 1 del index
?>
<br>
<div class="container-fluid">
    <h1>Listado de Usuarios</h1>

    <div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Usuarios Registrados</b></h3>  
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <table class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consultar los usuarios de la base de datos
                    $sql = "SELECT id_usuario, nombre, correo, telefono, direccion, rol, fecha_registro FROM usuarios";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Mostrar cada usuario
                        $counter = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>";
                            echo "<td>
                                    <div class='btn-group' role='group' aria-label='Basic example'>
                                        <a href='ver-users.php?id_usuario=" . $row['id_usuario'] . "' class='btn btn-info'><i class='bi bi-eye-fill'></i> Ver</a>
                                        <a href='actualizar-users.php?id_usuario=" . $row['id_usuario'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i> Editar</a>
                                        <a href='delete-users.php?id_usuario=" . $row['id_usuario'] . "' class='btn btn-danger'><i class='bi bi-trash'></i> Eliminar</a>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                        
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay usuarios registrados.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
          </div>
    </div>

    
</div>

<?php include('../view/parte2.php');//parte 2 del index ?>
