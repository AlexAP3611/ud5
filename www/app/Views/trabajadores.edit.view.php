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
<?php } else { ?>
<div class="alert alert-default-success">
    <p>El trabajador <?php echo $trabajador['username']?> ha sido actualizado con exito</p>
</div>
<?php } ?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
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
                                       value=<?php echo $trabajador['username']; ?>>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="rol">Rol:</label>
                                <option value=""><?php echo $trabajador['rol'] ?></option>
                                <?php foreach ($roles as $rol) {
                                    if ($rol['id_rol'] !== $trabajador['rol']) { ?>
                                        <option><?php echo $rol['nombre_rol'] ?></option>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="salario">Salario :</label>
                                <input type="text" class="form-control" name="salario" id="salario"
                                       value="<?php echo $trabajador['salarioBruto'] ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="irpf">IRPF:</label>
                                <input type="text" class="form-control" name="irpf" id="irpf"
                                       value="<?php echo $trabajador['retencionIRPF'] ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pais">Pais:</label>
                                <select name="country" id="country" class="form-control">
                                    <option value=""><?php echo $trabajador['pais'] ?></option>
                                    <?php foreach ($paises as $pais) {
                                        if ($pais['id'] !== $trabajador['pais']) { ?>
                                        <option><?php echo $pais['country_name']  ?></option>
                                   <?php }
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="estado">Estado:</label>
                                <select name="estado" id="estado" class="form-control">
                                    <?php if ($trabajador['estado'] == 1) { ?>
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Inactivo</option>
                                   <?php } else { ?>
                                    <option value="1">Activo</option>
                                    <option value="0" selected>Inactivo</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/trabajadores" value="" name="reiniciar" class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Aplicar" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Fin HTML -->