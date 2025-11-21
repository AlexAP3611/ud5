<?php

declare(strict_types=1);

?>
<?php if (!empty($errores)) { ?>
<div class="alert alert-danger">
    <ul>
    <?php foreach ($errores as $error) {?>
        <li><?php echo $error; ?></li>
  <?php }?>
    </ul>
</div>
<?php } ?>
<?php if (empty($errores) && isset($input) && (!empty($input))) { ?>
    <div class="alert alert-success">
        <p>El usuario con el nombre <?php echo $input['username'] ?> ha sido insertado con éxito</p>
    </div>
<?php } ?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="/trabajadores/new">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulario de inserción de trabajadores</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" value=<?php echo (isset($input['username'])) ? $input['username'] : ''; ?>>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="rol">Rol:</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) {?>
                                            <option value=<?php echo $rol['id_rol'] ?>>
                                                <?php echo $rol['nombre_rol']; ?>
                                            </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="salario">Salario :</label>
                                <input type="text" class="form-control" name="salario" id="salario"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="irpf">IRPF:</label>
                                <input type="text" class="form-control" name="irpf" id="irpf" value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pais">Pais:</label>
                                <select name="pais" id="pais" class="form-control">
                                    <option value=""></option>
                                    <?php if (!empty($paises)) {
                                        foreach ($paises as $pais) { ?>
                                            <option value=<?php echo $pais['id'] ?>>
                                                <?php echo $pais['country_name'];?>
                                            </option>
                                        <?php }
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="estado">Estado:</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="0" selected>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Insertar" name="enviar" class="btn btn-primary ml-2"/>
                        <a href="/trabajadores" value="Volver" name="volver" class="btn btn-primary ml-2">Volver</a>
                    </div>
                </div>
        </div>
            </form>
            <div class="col-12">
                <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
            </div>

            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                                   -->
                <table id="tabladatos" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 1 ? '-' : '';?>1">Nombre de usuario
                                <?php echo abs($order) === 1 ? '<i class="fas fa-sort-amount-'.(($order < 0) ? 'up' : 'down').'-alt"></i>' : ''; ?></a></th>
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 2 ? '-' : '';?>2">Salario
                                <?php echo abs($order) === 2 ? '<i class="fas fa-sort-amount-'.(($order < 0) ? 'up' : 'down').'-alt"></i>' : ''; ?></a></th>
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 3 ? '-' : '';?>3">IRPF
                                <?php echo abs($order) === 3 ? '<i class="fas fa-sort-amount-'.(($order < 0) ? 'up' : 'down').'-alt"></i>' : ''; ?></a></th>
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 4 ? '-' : '';?>4">Nacionalidad
                                <?php echo abs($order) === 4 ? '<i class="fas fa-sort-amount-'.(($order < 0) ? 'up' : 'down').'-alt"></i>' : ''; ?></a></th>
                        <th><a href="<?php echo $url ?>&order=<?php echo $order === 5 ? '-' : '';?>5">Rol
                                <?php echo abs($order) === 5 ? '<i class="fas fa-sort-amount-'.(($order < 0) ? 'up' : 'down').'-alt"></i>' : ''; ?></a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($trabajadores as $trabajador) {
                        ?>
                        <tr class="<?php echo !$trabajador['activo'] ? 'bg-danger' : ''; ?>">
                            <td><?php echo $trabajador['username'] ?></td>
                            <td><?php echo number_format((int)$trabajador['salarioBruto'], 2, ',', '.'); ?></td>
                            <td><?php echo $trabajador['retencionIRPF'] ?></td>
                            <td><?php echo $trabajador['country_name'] ?></td>
                            <td><?php echo $trabajador['nombre_rol'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->