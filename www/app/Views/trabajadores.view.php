<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row  <?php echo (isset($_GET['tema']) && $_GET['tema'] == 'oscuro') ? "dark-mode" : ''?>">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" class="form-control" name="username" id="username" value=<?php echo (isset($input['username'])) ? $input['username'] : ''; ?>>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="rol">Rol:</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                            <option value="<?php $rol["id_rol"] ?>">
                                            <?php echo $rol['nombre_rol'] ?>
                                            </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="salario-maximo">Salario maximo:</label>
                                <input type="text" class="form-control" name="salario-maximo" id="salario-maximo"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="salario-minimo">Salario minimo:</label>
                                <input type="text" class="form-control" name="salario-minimo" id="salario-minimo"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="irpf-minimo">IRPF minimo:</label>
                                <input type="text" class="form-control" name="irpf-minimo" id="irpf-minimo" value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="irpf-maximo">IRPF maximo:</label>
                                <input type="text" class="form-control" name="irpf-maximo" id="irpf-maximo" value=""/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pais">Paises:</label>
                                <select name="countries[]" id="countries" class="form-control select2" multiple>
                                    <option value=""></option>
                                    <?php foreach ($paises as $pais) { ?>
                                            <option value="<?php echo $pais['id']; ?>">
                                                <?php echo $pais['country_name'];?>
                                            </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                        <a href="/trabajadores/new/" value="" name="insertar"
                           class="btn btn-primary ml-2">Insertar trabajador</a>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="mb-3">
                        <label for="tema">Rol:</label>
                        <select name="tema" id="tema" class="form-control">
                            <option value="claro"
                            <?php echo (isset($_GET['tema']) && $_GET['tema'] == 'claro') ?? 'selected' ?>>Claro</option>
                            <option value="oscuro"
                            <?php echo (isset($_GET['tema']) && $_GET['tema'] == 'oscuro') ?? 'selected' ?>>Oscuro</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($trabajadores) && (!empty($trabajadores))) { ?>
        <div class="col-12">
            <div class="card shadow mb-4">
                <table id="tabla" class="table table-hover dataTable">
                    <thead>
                    <tr>
                        <th>Nombre de usuario</th>
                        <th>Salario bruto</th>
                        <th>Retencion IRPF</th>
                        <th>Activo</th>
                        <th>Rol</th>
                        <th>Nacionalidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($trabajadores as $trabajador) {
                        ?>
                        <tr>
                            <?php foreach ($trabajador as $columna) { ?>
                                <td><?php echo $columna ?></td>
                            <?php } ?>
                            <td>
                                <a href="/trabajadores/edit/<?php echo $trabajador['username'] ?>"
                                   class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/trabajadores/delete/<?php echo $trabajador['username'] ?>"
                                   class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=1&order=1" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=2&order=1" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <li class="page-item active"><a class="page-link" href="#">3</a></li>
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
</div>
<!--Fin HTML -->