<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\TrabajadoresModel;
use Com\Daw2\Models\AuxCountryModel;

class TrabajadoresController extends BaseController
{
    public function trabajadoresEdit(): void
    {
        $model = new TrabajadoresModel();
        $username = $_GET['username'];
        $usuario = $model->find($username);
        $aux_paises = new AuxCountryModel();
        $aux_rol = new AuxRolModel();
        $roles = $aux_rol->getAll();
        $paises = $aux_paises->getAll();
        $data = [
            'titulo' => 'Modificacion de trabajador',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'paises' => $paises,
            'roles' => $roles,
            'usuario' => $usuario,
            'url' => '/trabajadores/edit',
            'input' => [],
            'errores' => []
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function doTrabajadoresEdit(): void
    {
        $aux_paises = new AuxCountryModel();
        $aux_rol = new AuxRolModel();
        $roles = $aux_rol->getAll();
        $paises = $aux_paises->getAll();
        $data = [
            'titulo' => 'Modificacion de trabajador',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'paises' => $paises,
            'roles' => $roles,
            'url' => '/trabajadores/edit',
            'input' => [],
            'errores' => []
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function trabajadoresNew(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getAll();
        $aux_paises = new AuxCountryModel();
        $aux_rol = new AuxRolModel();
        $roles = $aux_rol->getAll();
        $paises = $aux_paises->getAll();
        $copiaGet = $_GET;
        $queryParams = http_build_query($copiaGet);
        $data = [
            'titulo' => 'Inserción de trabajador',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'paises' => $paises,
            'roles' => $roles,
            'url' => '/trabajadores/new' . $queryParams,
            'order' => $model->getOrderInt($_GET),
            'trabajadores' => $trabajadores,
            'input' => [],
            'errores' => []
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.new.view.php', 'templates/footer.view.php'),
            $data
        );
    }
    public function doTrabajadoresNew(): void {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getAll();
        $aux_paises = new AuxCountryModel();
        $aux_rol = new AuxRolModel();
        $roles = $aux_rol->getAll();
        $paises = $aux_paises->getAll();
        $datos = $_POST;
        $queryParams = http_build_query($datos);
        $errores = $model->insertarTrabajador($datos);
        $data = [
            'titulo' => 'Inserción de trabajador',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio',
            'paises' => $paises,
            'roles' => $roles,
            'input' => $datos,
            'url' => '/trabajadores/new' . $queryParams,
            'order' => $model->getOrderInt($_GET),
            'trabajadores' => $trabajadores,
            'errores' => $errores
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.new.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function getByFilters(): void
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getByFilters($_GET);
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $countryModel = new AuxCountryModel();
        $countries = $countryModel->getAll();
        $copiaGet = $_GET;
        unset($copiaGet['order']);
        unset($copiaGet['page']);
        unset($copiaGet['enviar']);
        $queryParams = http_build_query($copiaGet);
        $data = [
            'titulo' => 'Trabajadores Filtros',
            'breadcumb' => ['Inicio', 'Trabajadores'],
            'trabajadores' => $trabajadores,
            'input' => filter_input_array(INPUT_GET),
            'roles' => $roles,
            'countries' => $countries,
            'url' => '/trabajadores?' . $queryParams,
            'order' => $model->getOrderInt($_GET),
            'page' => $model->getPage($_GET),
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'trabajadores.view.php', 'templates/footer.view.php'),
            $data
        );
    }

    public function trabajadores1()
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getAll();

        $data = [
            'titulo' => 'Todos los trabajadores',
            'trabajadores' => $trabajadores
        ];

        $this->view->showViews(array('templates/header.view.php', 'trabajadores1.view.php', 'templates/footer.view.php'), $data);
    }

    public function trabajadores2()
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getByGrossSalary();

        $data = [
            'titulo' => 'Trabajadores ordenados por salario bruto',
            'trabajadores' => $trabajadores
        ];

        $this->view->showViews(array('templates/header.view.php', 'trabajadores2.view.php', 'templates/footer.view.php'), $data);
    }

    public function trabajadores3()
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getByRolStandard();

        $data = [
            'titulo' => 'Trabajadores que tienen el rol standard',
            'trabajadores' => $trabajadores
        ];

        $this->view->showViews(array('templates/header.view.php', 'trabajadores3.view.php', 'templates/footer.view.php'), $data);
    }

    public function trabajadores4()
    {
        $model = new TrabajadoresModel();
        $trabajadores = $model->getByCarlos();

        $data = [
            'titulo' => 'Trabajadores cuyo nombre de usuario empieza por Carlos',
            'trabajadores' => $trabajadores
        ];

        $this->view->showViews(array('templates/header.view.php', 'trabajadores4.view.php', 'templates/footer.view.php'), $data);
    }
}