<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\TrabajadoresModel;

class TrabajadoresController extends BaseController
{
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