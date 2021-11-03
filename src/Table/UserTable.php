<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Helpers\User;
use App\Table\Exception\NotFoundException;

final class UserTable extends Table {

    protected $table = "people";
    protected $class = User::class;

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

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $id in the table {$this->table}"); 
        }
    }

    public function findPaginated() 
    {
        $paginatedQuery = new PaginatedQuery("SELECT * FROM {$this->table} ORDER BY id ASC", "SELECT COUNT(id) FROM {$this->table}", $this->class, $this->pdo);
        $ads = $paginatedQuery->getItems();
        return [$ads, $paginatedQuery];
    }

    public function create(User $ads): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET `name` = :name, `first_name` = :first_name, `email` = :email, `address` = :address,
        postal_code = :postal_code, city = :city, phone = :phone, birthdate = :birthdate, cv = :cv, website = :website, `password` = :password, `description` = :description");
        $ok = $query->execute([
            'name' => $ads->getName(),
            'first_name' => $ads->getFirstname(),
            'birthdate' => $ads->getBirthdate()->format('Y-m-d'),
            'email' => $ads->getEmail(),
            'address' => $ads->getAddress(),
            'postal_code' => $ads->getPostalCode(),
            'city' => $ads->getCity(),
            'phone' => $ads->getPhone(),
            'cv' => $ads->getCv(),
            'website' => $ads->getWebsite(),
            'password' => password_hash($ads->getPassword(), PASSWORD_DEFAULT),
            'description' => $ads->getDescription()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't create the record in the table {$this->table}"); 
        }
        $ads->setID($this->pdo->lastInsertId());
    }


    public function update(User $ads): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET `name` = :name, `first_name` = :first_name, `email` = :email, `address` = :address,
                                    `postal_code` = :postal_code, `city` = :city, `phone` = :phone, `birthdate` = :birthdate, `CV` = :cv, `website` = :website, `description` = :description
                                    WHERE id = :id");
        $ok = $query->execute([
            'id' => $ads->getID(), 
            'name' => $ads->getName(),
            'first_name' => $ads->getFirstname(),
            'birthdate' => $ads->getBirthdate()->format('Y-m-d'),
            'email' => $ads->getEmail(),
            'address' => $ads->getAddress(),
            'postal_code' => $ads->getPostalCode(),
            'city' => $ads->getCity(),
            'phone' => $ads->getPhone(),
            'cv' => $ads->getCv(),
            'website' => $ads->getWebsite(),
            'description' => $ads->getDescription()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

}

?>