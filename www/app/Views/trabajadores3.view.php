<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <input type="hidden" name="order" value="1"/>
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Trabajadores</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <table id="tabla" class="table table-hover dataTable">
                                <thead>
                                <th>Nombre de usuario</th>
                                <th>Salario bruto</th>
                                <th>Retencion IRPF</th>
                                <th>Estado</th>
                                <th>Codigo rol</th>
                                <th>Codigo pais</th>
                                <th>Rol</th>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($trabajadores as $trabajador) {
                                    ?>
                                    <tr>
                                        <?php
                                        foreach ($trabajador as $columna) {
                                            ?>
                                            <td><?php echo $columna; ?></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<!--Fin HTML -->