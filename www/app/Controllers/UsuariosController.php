<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Models\UsuariosModel;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolModel;
class UsuariosController extends BaseController
{
    public function usuarios1(){
        $model = new UsuariosModel();
        $usuarios = $model->getUsuarios($_GET);
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $data = [
            'titulo' => 'Usuarios con filtros',
            'usuarios' => $usuarios,
            'input' => filter_input_array(INPUT_GET),
            'roles' => $roles
        ];
        $this->view->showViews(array('templates/header.view.php', 'usuarios1.view.php', 'templates/footer.view.php'),
            $data);
    }
}