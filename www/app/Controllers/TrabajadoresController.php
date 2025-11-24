<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Models\Aux_paises;
use Com\Daw2\Models\Aux_roles;
use Com\Daw2\Models\TrabajadoresModel;
use Controller;

class TrabajadoresController extends \Com\Daw2\Core\BaseController
{
    public function trabajadores1(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getTrabajadores();
        $data = [
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'trabajadores' => $trabajadores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores1.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadores2(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getTrabajadoresSalary();
        $data = [
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'trabajadores' => $trabajadores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores2.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadores3(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getTrabajadoresStandard();
        $data = [
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'trabajadores' => $trabajadores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores3.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadores4(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getTrabajadoresCarlos($_GET);
        $aux_paises = new Aux_paises();
        $paises = $aux_paises->getPaises();
        $data = [
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'trabajadores' => $trabajadores,
            'paises' => $paises
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores4.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadores(): void
    {
        setrawcookie('tema', isset($_GET['tema']) ? $_GET['tema'] : 'claro');
        $model = new TrabajadoresModel();
        $trabajadores = $model->getTrabajadoresFilters($_GET);
        $aux_paises = new Aux_paises();
        $aux_rol = new Aux_roles();
        $roles = $aux_rol->getRoles();
        $paises = $aux_paises->getPaises();
        $data = [
            'titulo' => 'Filtro de búsqueda de trabajadores',
            'breadcrumb' => ['Trabajadores'],
            'seccion' => '/trabajadores',
            'trabajadores' => $trabajadores,
            'paises' => $paises,
            'roles' => $roles,
            'input' => filter_input_array(INPUT_GET)
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadoresNew(): void
    {
        $aux_paises = new Aux_paises();
        $aux_rol = new Aux_roles();
        $roles = $aux_rol->getRoles();
        $paises = $aux_paises->getPaises();
        $data = [
            'titulo' => 'Inserción de nuevo trabajador',
            'breadcrumb' => ['Trabajadores/new'],
            'seccion' => '/trabajadores/new',
            'paises' => $paises,
            'roles' => $roles,
            'input' => [],
            'errores' => []
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.new.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function doTrabajadoresNew(): void
    {
        $model = new TrabajadoresModel();
        $aux_paises = new Aux_paises();
        $aux_rol = new Aux_roles();
        $roles = $aux_rol->getRoles();
        $paises = $aux_paises->getPaises();
        $datos = $_POST;
        unset($datos['enviar']);
        unset($datos['order']);
        $errores = $model->insertarTrabajador($datos);
        $data = [
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'paises' => $paises,
            'roles' => $roles,
            'input' => $datos,
            'errores' => $errores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.new.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function trabajadoresEdit($username): void {
        $model = new TrabajadoresModel();
        $trabajador = $model->find($username);
        $roles = new Aux_roles();
        $aux_paises = new Aux_paises();
        $roles = $roles->getRoles();
        $paises = $aux_paises->getPaises();
        $data = [
            'titulo' => 'Edicion de trabajador',
            'breadcrumb' => ['Trabajadores/Edit'],
            'seccion' => 'trabajadores/edit',
            'roles' => $roles,
            'paises' => $paises,
            'trabajador' => $trabajador
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function doTrabajadoresEdit($username): void {
        $datos = $_POST;
        $model = new TrabajadoresModel();
        $model->modificarTrabajador($datos);
        $roles = new Aux_roles();
        $aux_paises = new Aux_paises();
        $roles = $roles->getRoles();
        $paises = $aux_paises->getPaises();
        $data = [
            'titulo' => 'Edicion de trabajador',
            'breadcrumb' => ['Trabajadores/Edit'],
            'seccion' => 'trabajadores/edit',
            'roles' => $roles,
            'paises' => $paises,
            'trabajador' => $trabajador,
            'errores' => $errores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function trabajadoresDelete($username): void {
        $model = new TrabajadoresModel();
        $model ->borrarTrabajador($username);
        header('location: /trabajadores');
    }
}
