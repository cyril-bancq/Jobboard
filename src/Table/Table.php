<?php

namespace App\Table;

use App\Table\Exception\NotFoundException;
use Exception;

abstract class Table {

    protected $pdo;

    protected $table = null;

    protected $class = null;

    public function __construct(\PDO $pdo)
    {
        if ($this->table === null) {
            throw new Exception("Any propriety table for" . get_class($this));
        }
        if ($this->class === null) {
            throw new Exception("Any propriety class for" . get_class($this));
        }
        $this->pdo = $pdo;
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE ads_id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException("{$this->table}", $id);
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe dans la table
     * @param string $field Champs à rechercher
     * @param mixed $value Valeur associée au champs
     */
    public function existsads(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(ads_id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null ) {
            $sql .= " AND ads_id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(\PDO::FETCH_NUM)[0] > 0;
    }

    public function exists(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null ) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(\PDO::FETCH_NUM)[0] > 0;
    }
}

?>