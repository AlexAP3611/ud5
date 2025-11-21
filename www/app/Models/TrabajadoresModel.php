<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class TrabajadoresModel extends BaseDbModel
{

    private const ORDER_BY = ['username', 'salarioBruto', 'retencionIRPF', 'country_name', 'nombre_rol'];
    private const DEFAULT_ORDER = 1;
    private const DEFAULT_PAGE = 1;
    private const ELEMENTS_PER_PAGE = 25;
    private const LIMIT = 25;
    private const SELECT_FROM = 'SELECT trabajadores.*, aux_countries.country_name, aux_rol_trabajador.nombre_rol
                FROM trabajadores
                LEFT JOIN aux_countries ON aux_countries.id = trabajadores.id_country
                LEFT JOIN aux_rol_trabajador ON aux_rol_trabajador.id_rol = trabajadores.id_rol';

    //Obtener todos los trabajadores
    public function getAll(): array
    {
        $sql = "SELECT t.*, cou.country_name, rol.nombre_rol FROM trabajadores t
                LEFT JOIN aux_countries cou ON t.id_country = cou.id
                LEFT JOIN aux_rol_trabajador rol ON t.id_rol = rol.id_rol;";
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

    public function getByFilters(array $filters): array
    {
        $condiciones = [];
        $valores = [];
        $sql = self::SELECT_FROM;
        $page = $this->getPage($filters);
        $offset = ($page - 1) * (self::ELEMENTS_PER_PAGE);
        //if (!isset($filters['username']) && $filters['username'] !== '') {
        if (!empty($filters['username'])) {
            $condiciones[] = "username LIKE :username";
            $valores['username'] = "%{$filters['username']}%";
        }
        if (!empty($filters['id_rol'])) {
            $condiciones[] = "trabajadores.id_rol = :id_rol";
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
        $orderInt = $this->getOrderInt($filters);
        $orderField = self::ORDER_BY[abs($orderInt) - 1] . ($orderInt < 0 ? ' DESC' : '');
        if ($condiciones === []) {
            $sql .= " ORDER BY $orderField LIMIT " . self::LIMIT;
            $statement = $this->pdo->query($sql);
        } else {
            $sql .= " WHERE " . implode(' AND ', $condiciones) . " ORDER BY $orderField LIMIT " . self::LIMIT . " OFFSET " . $offset;
            $statement = $this->pdo->prepare($sql);
            $statement->execute($valores);
        }

        return $statement->fetchAll();
    }

    public function getOrderInt(array $filters): int
    {
        if (
            empty($filters['order']) || filter_var($filters['order'], FILTER_VALIDATE_INT) === false
        ) {
            return self::DEFAULT_ORDER;
        } else {
            if (abs((int)$filters['order']) < 1 || abs((int)$filters['order']) > count(self::ORDER_BY)) {
                return self::DEFAULT_ORDER;
            } else {
                return (int)$filters['order'];
            }
        }
    }

    public function getPage(array $filters):int {
        if (empty($filters['page']) || filter_var($filters['page'], FILTER_VALIDATE_INT) === false) {
            return self::DEFAULT_PAGE;
        } else {
            if ((int)$filters['page'] < 1 || (int)$filters['page'] ) {
                return self::DEFAULT_PAGE;
            } else {
                return (int)$filters['page'];
            }
        }
    }

    public function getTotalPages(array $filters):int {
        $sql = "SELECT COUNT(*) FROM trabajadores";
        return 0;
    }

    public function insertarTrabajador($datosTrabajador): ?array
    {
        $errores = $this->comprobarTrabajador($datosTrabajador);
        if (empty($errores)) {
            $sql = "INSERT INTO trabajadores (username, salarioBruto, retencionIRPF, activo, id_rol, id_country) 
                    VALUES(:username, :salario, :irpf, :estado, :rol, :pais)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $datosTrabajador['username'],
                ':salario'  => $datosTrabajador['salario'],
                ':irpf'     => $datosTrabajador['irpf'],
                ':estado'   => $datosTrabajador['estado'],
                ':rol'      => $datosTrabajador['rol'],
                ':pais'     => $datosTrabajador['pais']
            ]);
        }
            return $errores;
    }
    private function comprobarTrabajador($datosTrabajador): array
    {
        $errores = [];
        if (empty($datosTrabajador['username'])) {
            $errores['usuario'] = "El nombre de usuario no puede estar vacio";
        } elseif ($this->comprobarNombre($datosTrabajador['username']) === true) {
            $errores['usuario'] = "El nombre de usuario ya se encuentra registrado";
        } elseif (!preg_match('/^[A-Za-z_0-9]+$/', $datosTrabajador['username'])) {
            $errores['usuario'] = 'El nombre de usuario solo puede contener letras, numeros y barrabajas';
        } elseif (strlen($datosTrabajador['username']) < 4) {
            $errores['usuario'] = 'El nombre de usuario debe tener al menos 4 caracteres';
        } elseif (strlen($datosTrabajador['username']) > 50) {
            $errores['usuario'] = "El nombre de usuario no puede contener mas de 50 caracteres";
        }
        if (empty($datosTrabajador['salario'])) {
            $errores['salario'] = "El salario no puede estar vacio";
        } elseif (filter_var($datosTrabajador['salario'], FILTER_SANITIZE_NUMBER_FLOAT) === false) {
            $errores['salario'] = "El salario es invalido";
        } elseif ($datosTrabajador['salario'] < 500) {
            $errores['salario'] = "El salario tien que ser por lo menos de 500";
        }
        if (empty($datosTrabajador['irpf'])) {
            $errores['irpf'] = "El IRPF no puede estar vacio";
        } elseif (filter_var($datosTrabajador['irpf'], FILTER_SANITIZE_NUMBER_INT) === false) {
            $errores['irpf'] = "El IRPF es invalido";
        } elseif ($datosTrabajador['irpf'] < 0) {
            $errores['irpf'] = "El IRPF no puede ser negativo";
        } elseif ($datosTrabajador['irpf'] > 100) {
            $errores['irpf'] = "El IRPF no puede ser mayor que 100";
        }
        if ($datosTrabajador['estado'] === '') {
            $errores['estado'] = "El estado no puede estar vacio";
        } elseif ($datosTrabajador['estado'] !== '0' && $datosTrabajador['estado'] !== '1') {
            $errores['estado'] = "El estado solo puede ser activo o inactivo";
        }
        if (empty($datosTrabajador['rol'])) {
            $errores['rol'] = "El rol no puede estar vacio";
        } elseif (filter_var($datosTrabajador['rol'], FILTER_SANITIZE_STRING) === false) {
            $errores['rol'] = "El rol es invalido";
        } elseif ($this->comprobarRol($datosTrabajador['rol']) === false) {
            $errores['rol'] = "El rol especificado no existe";
        }
        if ($datosTrabajador['pais'] === '') {
            $errores['pais'] = "El pais no puede estar vacio";
        } elseif ($this->comprobarPais($datosTrabajador['pais']) === false) {
            $errores['pais'] = "El pais es invalido";
        }
        return $errores;
    }

    private function comprobarNombre($nombreUsuario): bool
    {
        $sql = "SELECT t.username FROM trabajadores t WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $nombreUsuario]);
        if ($stmt->fetch() === false) {
            return false;
        } else {
            return true;
        }
    }

    private function comprobarRol($rol): bool
    {
        $sql = "SELECT aux.id_rol FROM aux_rol_trabajador aux WHERE aux.id_rol = :rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['rol' => $rol]);
        if ($stmt->fetch() === false) {
            return false;
        } else {
            return true;
        }
    }
    private function comprobarPais($pais): bool
    {
        $sql = "SELECT aux.id FROM aux_countries aux WHERE aux.id = :pais";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pais' => $pais]);
        if ($stmt->fetch() === false) {
            return false;
        } else {
            return true;
        }
    }

    public function find(string $username): false|array
    {
        if ($this->comprobarNombre($username) === false) {
            return false;
        } else {
            $sql = $this::SELECT_FROM . " WHERE t.username = :username";
            $stmt = $this->pdo->execute(['username' => $username]);
            return $this->pdo->prepare($stmt);
        }
    }
}