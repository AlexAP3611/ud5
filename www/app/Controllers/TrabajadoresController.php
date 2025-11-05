<?php

declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class TrabajadoresController extends BaseController
{
    public function getAll(): void
    {
        //$trabajadores = $model->getTrabajadores();
    }

    public function ejercicio71()
    {
        $data = array(
            'titulo' => 'Ejercicio 7.1',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );
        $this->view->showViews(array('templates/header.view.php', 'ejercicio7.1.view.php', 'templates/footer.view.php'), $data);
    }
}