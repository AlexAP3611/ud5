<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="<?php echo $order; ?>" ?>
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
                                <input type="text" class="form-control" name="username" id="username"
                                       placeholder="Nombre de usuario" value="<?php echo $input['username'] ?? '' ?>" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control select" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($roles as $rol) {
                                        ?>
                                        <option value="<?php echo $rol['id_rol'] ?>"
                                            <?php echo isset($_GET['id_rol']) && $_GET['id_rol'] == $rol['id_rol'] ? 'selected' : ''; ?>>
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
                                        <input type="text" class="form-control" name="min_salario" id="min_salario"
                                               placeholder="Mínimo" value="<?php echo $input['min_salario'] ?? '' ?>" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salario" id="max_salario"
                                               placeholder="Máximo" value="<?php echo $input['max_salario'] ?? '' ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="min_irpf">IRPF:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_irpf" id="min_irpf"
                                               value="<?php echo $input['min_irpf'] ?? '' ?>" placeholder="Mínimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_irpf" id="max_irpf"
                                               value="<?php echo $input['max_irpf'] ?? '' ?>" placeholder="Máximo" />
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
                                        <option value="<?php echo $country['id'] ?>"
                                            <?php echo isset($_GET['countries']) && in_array($country['id'], $_GET['countries']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($country['country_name']); ?></option>
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
                        <a href="/trabajadores/new" value="" class="btn btn-default ml-2">Insertar trabajador</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
            </div>
            <!-- Card Body -->
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
                            <td><?php echo number_format($trabajador['salarioBruto'], 2, ',', '.'); ?></td>
                            <td><?php echo $trabajador['retencionIRPF'] ?></td>
                            <td><?php echo $trabajador['country_name'] ?></td>
                            <td><?php echo $trabajador['nombre_rol'] ?></td>
                            <td>
                                <a href="/trabajadores/edit?username=<?php echo $trabajador['username'];?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="/trabajadores/delete/" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <nav aria-label="Navegacion por paginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item" hidden=<?php echo ($page === 1) ? 'true' : ''; ?>>
                        <a class="page-link" href="/proveedores?page=1&order=1" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">First</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="/proveedores?page=2&order=1" aria-label="Previous"
                           hidden=<?php echo ($page === 1) ? 'true' : '' ?>>
                            <span aria-hidden="true">&lt;</span>
                            <span class="sr-only"></span>
                        </a>
                    </li>

                    <li class="page-item active"><a class="page-link" href="#"><?php echo $page ?></a></li>
                    <li class="page-item">
                        <a class="page-link" href="/proveedores?page=4&order=1" aria-label="Next">
                            <span aria-hidden="true">&gt;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="/proveedores?page=8&order=1" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Last</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!--Fin HTML -->