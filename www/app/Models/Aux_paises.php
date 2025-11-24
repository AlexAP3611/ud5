<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class Aux_paises extends BaseDbModel {
    public function getPaises(): array {
        $sql = "SELECT cou.id, cou.country_name FROM aux_countries cou";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}