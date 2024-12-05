<?php
    
    include('../model/config.php');
    include('../view/parte1.php');
    include('../controller/listado_reservas.php');//parte 1 del index
    ?>
    

    <br>
    <div class="container-fluid">
    <h1>Listado de Citas</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Citas Registradas</b></h3>  
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <table class="table table-responsive table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Cita</th>
                                <th>ID Mascota</th>
                                <th>Mascota</th>
                                <th>Fecha Reserva</th>
                                <th>Hora</th>
                                <th>Dueño</th>
                                <th>Correo</th>
                                <th>Raza</th>
                                <th>Servicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $contador = 0;
                        foreach ($citas as $cita) {
                            $contador++;
                            echo "<tr>";
                            echo "<td>{$contador}</td>";
                            echo "<td>{$cita['id_cita']}</td>";
                            echo "<td>{$cita['id_mascota']}</td>";
                            echo "<td>{$cita['mascota']}</td>";
                            echo "<td>{$cita['fechaReserva']}</td>";
                            echo "<td>{$cita['horaReserva']}</td>";
                            echo "<td>{$cita['nombre']}</td>";
                            echo "<td>{$cita['correo']}</td>";
                            echo "<td>{$cita['raza']}</td>";
                            echo "<td>{$cita['servicio']}</td>";
                            echo "<td>";
                            echo "<a href='editar_cita.php?id_cita={$cita['id_cita']}' class='btn btn-warning btn-sm'>Editar</a> ";
                            echo "<a href='eliminar_cita.php?id_cita={$cita['id_cita']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar esta cita?\");'>Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php include('../view/parte2.php');//parte 2 del index
  
?>
