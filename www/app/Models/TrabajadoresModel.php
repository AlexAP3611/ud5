<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class TrabajadoresModel extends BaseDbModel
{
    //Obtener todos los trabajadores
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM trabajadores t;";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    //Obtener los trabajadores ordenados por salarioBruto de mayor salario a menor
    public function getByGrossSalary(): array
    {
        $sql = "SELECT *
               FROM trabajadores t
               ORDER BY salarioBruto DESC;";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    //Obtener todos los trabajadores que sean standard
    public function getByRolStandard(): array
    {
        $sql = "SELECT *
                FROM trabajadores t
                INNER JOIN aux_rol_trabajador art ON t.id_rol = art.id_rol
                WHERE art.nombre_rol = 'standard';";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    //Obtener todos los trabajadores cuyo username comience por Carlos
    public function getByCarlos(): array
    {
        $sql = "SELECT * 
                FROM trabajadores t
                WHERE t.username LIKE 'Carlos%';";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    public function getConFiltros(){

    }


}
