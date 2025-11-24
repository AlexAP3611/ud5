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
    public function getTrabajadores(): array
    {
        $sql = "SELECT t.username, t.salarioBruto, t.retencionIRPF, t.activo, art.nombre_rol, cou.country_name  
                FROM trabajadores t
                LEFT JOIN ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
                LEFT JOIN ud5.aux_countries cou on cou.id = t.id_country;";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getTrabajadoresSalary(): array
    {
        $sql = "SELECT t.username, t.salarioBruto, t.retencionIRPF, t.activo, art.nombre_rol, cou.country_name  
                FROM trabajadores t
                LEFT JOIN ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
                LEFT JOIN ud5.aux_countries cou on cou.id = t.id_country
                ORDER BY t.salarioBruto DESC;";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    public function getTrabajadoresStandard(): array
    {
        $sql = "SELECT t.username, t.salarioBruto, t.retencionIRPF, t.activo, art.nombre_rol, cou.country_name  
                FROM trabajadores t
                LEFT JOIN ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
                LEFT JOIN ud5.aux_countries cou on cou.id = t.id_country
                WHERE t.id_rol = 5;";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    public function getTrabajadoresCarlos(): array
    {
        $sql = "SELECT t.username, t.salarioBruto, t.retencionIRPF, t.activo, art.nombre_rol, cou.country_name  
                FROM trabajadores t
                LEFT JOIN ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
                LEFT JOIN ud5.aux_countries cou on cou.id = t.id_country
                WHERE t.username LIKE 'Carlos%';";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getTrabajadoresFilters(array $filters): array
    {
        $condiciones = [];
        $valores = [];
        $sql = "SELECT t.username, t.salarioBruto, t.retencionIRPF, t.activo, art.nombre_rol, cou.country_name  
                FROM trabajadores t
                LEFT JOIN ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
                LEFT JOIN ud5.aux_countries cou on cou.id = t.id_country";
        if (!empty($filters['username'])) {
            $condiciones[] = " t.username LIKE :username ";
            $valores['username'] = "%" . $filters['username'] . "%";
        }
        if (!empty($filters['rol'])) {
            $condiciones[] = "art.nombre_rol = :rol";
            $valores['rol'] = $filters['rol'];
        }
        if (!empty($filters['countries'])) {
            $i = 1;
            foreach ($filters['countries'] as $country) {
                $placeholders[] = ":country$i";
                $valores["country$i"] = $country;
                $i++;
            }
            $condiciones[] = "cou.id IN (" . implode(', ', $placeholders) . ")";
            $statement = $this->pdo->prepare($sql);
        }
        if (!empty($filters['salario-maximo']) && !empty($filters['salario-minimo'])) {
            $condiciones[] = " t.salarioBruto >= :salarioMinimo AND t.salarioBruto <= :salarioMaximo ";
            $valores['salarioMinimo'] = $filters['salario-minimo'];
            $valores['salarioMaximo'] = $filters['salario-maximo'];
        }
        if (!empty($filters['salario-minimo'])) {
            $condiciones[] = " t.salarioBruto >= :salarioMinimo ";
            $valores['salarioMinimo'] = $filters['salario-minimo'];
        }
        if (!empty($filters['salario-maximo'])) {
            $condiciones[] = "t.salarioBruto <= :salarioMaximo";
            $valores['salarioMaximo'] = $filters['salario-maximo'];
        }
        if (!empty($filters['irpf-maximo']) && !empty($filters['irpf-minimo'])) {
            $condiciones[] = " t.retencionIRPF >= :irpfMinimo AND t.retencionIRPF <= :irpfMaximo ";
            $valores['irpfMinimo'] = $filters['irpf-minimo'];
            $valores['irpfMaximo'] = $filters['irpf-maximo'];
        }
        if (!empty($filters['irpf-maximo'])) {
            $condiciones[] = " t.retencionIRPF <= :irpfMaximo ";
            $valores['irpfMaximo'] = $filters['irpf-maximo'];
        }
        if (!empty($filters['irpf-minimo'])) {
            $condiciones[] = " t.retencionIRPF >= :irpfMinimo ";
            $valores['irpfMinimo'] = $filters['irpf-minimo'];
        }
        if (count($condiciones) === 0) {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } else {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($valores);
            return $stmt->fetchAll();
        }
    }
    public function insertarTrabajador($datosTrabajador): ?array
    {
        $errores = $this->comprobarTrabajador($datosTrabajador);
        if (empty($errores)) {
            $sql = "INSERT INTO trabajadores VALUES(:username, :salario, :irpf, :estado, :rol, :country)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
            ':username' => $datosTrabajador['username'],
            ':salario' => $datosTrabajador['salario'],
            ':irpf' => $datosTrabajador['irpf'],
            ':estado' => $datosTrabajador['estado'],
            ':rol' => $datosTrabajador['rol'],
            ':country' => $datosTrabajador['country']
            ]);
        }
        return $errores;
    }
    private function comprobarTrabajador(array $datosTrabajador): array
    {
        $errores = [];
        if (empty($datosTrabajador['username'])) {
            $errores['usuario'] = "El nombre de usuario no puede estar vacio";
        } elseif ($this->find($datosTrabajador['username']) !== false) {
            $errores['usuario'] = "El nombre de usuario ya se encuentra registrado";
        } elseif (!preg_match('/^[A-Za-z_0-9]{4,50}$/', $datosTrabajador['username'])) {
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
        } elseif ($datosTrabajador['estado'] !== '1' && $datosTrabajador['estado'] !== '0') {
            $errores['estado'] = "El estado solo puede ser activo o inactivo";
        }
        if (empty($datosTrabajador['rol'])) {
            $errores['rol'] = "El rol no puede estar vacio";
        } elseif (filter_var($datosTrabajador['rol'], FILTER_SANITIZE_STRING) === false) {
            $errores['rol'] = "El rol es invalido";
        } elseif ($this->comprobarRol($datosTrabajador['rol']) === false) {
            $errores['rol'] = "El rol especificado no existe";
        }
        if (empty($datosTrabajador['country'])) {
            $errores['country'] = "El pais no puede estar vacio";
        } elseif ($this->comprobarPais($datosTrabajador['country']) === false) {
            $errores['country'] = "El pais es invalido";
        }
        return $errores;
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

    public function find(string $username): array|false {
        $sql  = self::SELECT_FROM . " WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $resultado = $stmt->fetch();
        if ($resultado === false) {
            return false;
        }
        return $resultado;
    }

    public function borrarTrabajador(string $username): bool
    {
            $sql = "DELETE FROM trabajadores WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute(['username' => $username])) {

            }

    }

    public function modificarTrabajador(array $trabajador): array
    {
        $errores = $this->comprobarTrabajador($trabajador);
        if (empty($errores)) {
            $sql = "UPDATE trabajadores t SET 
                    t.salarioBruto = :salario,
                    t.retencionIRPF = :irpf,
                    t.activo = :estado,
                    t.id_rol = :rol,
                    t.id_country = :pais
                    WHERE t.username = :username;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'salario' => $trabajador['salario'],
                'irpf' => $trabajador['irpf'],
                'estado' => $trabajador['estado'],
                'rol' => $trabajador['rol'],
                'pais' => $trabajador['pais'],
                'username' => $trabajador['username']
            ]);
        }
        return $errores;
    }
}
