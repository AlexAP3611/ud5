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
                <input type="hidden" name="order" value="1"/>
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value=<?php echo (isset($input['username'])) ? $input['username'] : ''; ?>>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="rol">Rol:</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) {?>
                                            <option value="<?php echo $rol['id_rol']?>"
                                                    <?php if (isset($input['rol']) && ($input['rol'] == $rol['id_rol'])) {
                                                        echo 'selected';
                                                    }?>>
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
                                       value="<?php echo isset($input['salario']) ? $input['salario'] : ''?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="irpf">IRPF:</label>
                                <input type="text" class="form-control" name="irpf" id="irpf"
                                       value="<?php echo isset($input['irpf']) ? $input['irpf'] : ''?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pais">Pais:</label>
                                <select name="country" id="country" class="form-control">
                                    <option value=""></option>
                                    <?php if (!empty($paises)) {
                                        foreach ($paises as $pais) { ?>
                                            <option value="<?php echo $pais['id'] ?>"
                                                    <?php if (isset($input['country']) && ($input['country'] == $pais['id'])) {
                                                        echo 'selected';
                                                        }?>>
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
                                    <?php if ($input['estado'] == 1) { ?>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                    <?php } else { ?>
                                    <option value="1" >Activo</option>
                                    <option value="0" selected>Inactivo</option>
                                   <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Insertar" name="enviar" class="btn btn-primary ml-2"/>
                        <a href="/trabajadores" value="" name="volver" class="btn btn-primary ml-2">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Fin HTML -->