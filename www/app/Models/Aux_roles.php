<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class Aux_roles extends BaseDbModel
{
    public function getRoles() {
        $sql = "SELECT id_rol, rol.nombre_rol FROM aux_rol_trabajador rol";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}