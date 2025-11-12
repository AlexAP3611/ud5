<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" value="<?php echo $input['username'] ?? '' ?>" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control select2" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($roles as $rol) {
                                        ?>
                                        <option
                                                value="<?php echo $rol['id_rol'] ?>" <?php echo isset($_GET['id_rol']) && $_GET['id_rol'] == $rol['id_rol'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($rol['nombre_rol']) ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_salario">Salario:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_salario" id="min_salario" value="" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salario" id="max_salario" value="" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_irpf">IRPF:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_irpf" id="min_irpf" value="" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_irpf" id="max_irpf" value="" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="countries">Países:</label>
                                <select name="countries[]" id="countries" class="form-control select2" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($countries as $country) {
                                        ?>
                                        <option value="<?php echo $country['id'] ?>"><?php echo ucfirst($country['country_name']); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-error small"><?php echo $errors['countries'] ?? ''; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>" value="" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                                   -->
                <table id="tabladatos" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th><a href="#">Nombre de usuario</a></th>
                        <th><a href="#" onclick=TrabajadoresModel>Salario</a></th>
                        <th><a href="#">IRPF</a></th>
                        <th><a href="#">Nacionalidad</a></th>
                        <th><a href="#">Rol</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($trabajadores as $trabajador) {
                        ?>
                        <tr class="<?php echo !$trabajador['activo'] ? 'bg-danger' : ''; ?>">
                            <td><?php echo $trabajador['username'] ?></td>
                            <td><?php echo number_format($trabajador['salarioBruto'], 2, ',', '.'); ?></td>
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