<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Helpers\Post;

final class PostTable extends Table {

    protected $table = "advertissements";
    protected $class = Post::class;

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE ads_id = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $id in the table {$this->table}"); 
        }
    }

    public function findPaginated() 
    {
        $paginatedQuery = new PaginatedQuery("SELECT * FROM {$this->table} ORDER BY ads_id ASC", "SELECT COUNT(ads_id) FROM {$this->table}", $this->class, $this->pdo);
        $ads = $paginatedQuery->getItems();
        return [$ads, $paginatedQuery];
    }

    public function update(Post $ads): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET `title` = :title, `description` = :description, `date` = :date, `salary` = :salary, duration = :duration, hour = :hour, contract_type = :contract WHERE ads_id = :id");
        $ok = $query->execute([
            'id' => $ads->getID(), 
            'title' => $ads->getTitle(),
            'description' => $ads->getDescription(),
            'date' => $ads->getDate()->format('Y-m-d'),
            'duration' => $ads->getDuration(),
            'hour' => $ads->getHour(),
            'contract' => $ads->getContract(),
            'salary' => $ads->getSalary()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

    public function create(Post $ads): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET `title` = :title, `description` = :description, `date` = :date, `salary` = :salary, duration = :duration, hour = :hour, contract_type = :contract");
        $ok = $query->execute([
            'title' => $ads->getTitle(),
            'description' => $ads->getDescription(),
            'date' => $ads->getDate()->format('Y-m-d'),
            'duration' => $ads->getDuration(),
            'hour' => $ads->getHour(),
            'contract' => $ads->getContract(),
            'salary' => $ads->getSalary()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't create the record in the table {$this->table}"); 
        }
        $ads->setID($this->pdo->lastInsertId());
    }
}

?>