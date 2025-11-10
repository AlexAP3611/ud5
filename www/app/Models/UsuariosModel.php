<?php

declare(strict_types=1);

namespace Com\Daw2\Models;
use Com\Daw2\Core\BaseDbModel;
class UsuariosModel extends BaseDbModel
{

    private const SELECT_FROM = 'SELECT trabajadores.*, aux_countries.country_name, aux_rol_trabajador.nombre_rol
                FROM trabajadores
                LEFT JOIN aux_countries ON aux_countries.id = trabajadores.id_country
                LEFT JOIN aux_rol_trabajador ON aux_rol_trabajador.id_rol = trabajadores.id_rol';
    public function getUsuarios(){
        $sql = self::SELECT_FROM;
        if (!empty($filters['username'])) {
            $sql .= " WHERE username LIKE :username";
            $statement = $this->pdo->prepare($sql);
            $statement->execute(['username' => '%' . $filters['username'] . '%']);
        } elseif(!empty($filters['id_rol'])){
            $sql .= " WHERE trabajador.id_rol = :id_rol";
            $statement = $this->pdo->prepare($sql);
            $statement->execute(['username' => '%' . $filters['username'] . '%']);
        } elseif (!empty) {
            $statement = $this->pdo->query($sql);
        }
        return $statement->fetchAll();
    }
}