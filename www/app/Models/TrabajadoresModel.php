<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class TrabajadoresModel extends BaseDbModel
{

    private const SELECT_FROM = 'SELECT trabajadores.*, aux_countries.country_name, aux_rol_trabajador.nombre_rol
                FROM trabajadores
                LEFT JOIN aux_countries ON aux_countries.id = trabajadores.id_country
                LEFT JOIN aux_rol_trabajador ON aux_rol_trabajador.id_rol = trabajadores.id_rol';

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

    public function getByFilters(array $filters, $order = ""): array
    {
        $condiciones = [];
        $valores = [];
        $sql = self::SELECT_FROM;
        if (!empty($filters['username'])) {
            $condiciones[] = " username LIKE :username ";
            $valores['username'] = "%{$filters['username']}%";
        }
        if (!empty($filters['id_rol'])) {
            $condiciones[] = " trabajadores.id_rol = :id_rol";
            $valores['id_rol'] = $filters['id_rol'];
        }
        if (!empty($filters['min_salario'])) {
            $condiciones[] = "trabajadores.salarioBruto >= :min_salario";
            $valores['min_salario'] = $filters['min_salario'];
        }
        if (!empty($filters['max_salario'])) {
            $condiciones[] = "trabajadores.salarioBruto <= :max_salario";
            $valores['max_salario'] = $filters['max_salario'];
        }
        if (!empty($filters['min_irpf'])) {
            $condiciones[] = "trabajadores.retencionIRPF >= :min_irpf";
            $valores['min_irpf'] = $filters['min_irpf'];
        }
        if (!empty($filters['max_irpf'])) {
            $condiciones[] = "trabajadores.retencionIRPF <= :max_irpf";
            $valores['max_irpf'] = $filters['max_irpf'];
        }
        if (!empty($filters['countries'])) {
            $i = 1;
            foreach ($filters['countries'] as $country) {
                $placeholders[] = ":country$i";
                $valores["country$i"] = $country;
                $i++;
            }
            $condiciones[] = "id_country IN (" . implode(', ', $placeholders) . ")";
            $statement = $this->pdo->prepare($sql);
        }
        if ($condiciones === []) {
            $statement = $this->pdo->query($sql);
        } else {
            $sql .= " WHERE " . implode(' AND ', $condiciones);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($valores);
        }
        return $statement->fetchAll();
    }

    public function orderByUsername() {

    }
}