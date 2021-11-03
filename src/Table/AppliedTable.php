<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Helpers\Applied;
use App\Table\Exception\NotFoundException;

final class AppliedTable extends Table {

    protected $table = "applied";
    protected $class = Applied::class;

    public function findByEmail(string $email)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $query->execute(['email' => $email]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException("{$this->table}", $email);
        }
        return $result;
    }

    public function findByID(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException("{$this->table}", $id);
        }
        return $result;
    }

    public function findPaginated() 
    {
        $paginatedQuery = new PaginatedQuery("SELECT * FROM {$this->table} ORDER BY id ASC", "SELECT COUNT(id) FROM {$this->table}", $this->class, $this->pdo);
        $ads = $paginatedQuery->getItems();
        return [$ads, $paginatedQuery];
    }

    public function create(Applied $ads): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET `motivation_people` = :motivation_people, `people_id` = :people_id, `advertissement_id` = :advertissement_id");
        $ok = $query->execute([
            'motivation_people' => $ads->getMotivationPeople(),
            'people_id' => $ads->getPeopleId(),
            'advertissement_id' => $ads->getAdvertissementId()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't create the record in the table {$this->table}"); 
        }
        $ads->setID($this->pdo->lastInsertId());
    }


    public function update(Applied $ads): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET `motivation_people` = :motivation WHERE id = :id");
        $ok = $query->execute([
            'motivation_people' => $ads->getMotivationPeople()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

    public function joinPeople(Applied $ads): void
    {
        $query = $this->pdo->prepare("SELECT * FROM people INNER JOIN {$this->table} ON people.id = applied.people_id");
        $ok = $query->execute();
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

    public function joinAds(Applied $ads): void
    {
        $query = $this->pdo->prepare("SELECT * FROM advertissements INNER JOIN {$this->table} ON advertissements.ads_id = applied.advertissement_id");
        $ok = $query->execute();
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

}

?>