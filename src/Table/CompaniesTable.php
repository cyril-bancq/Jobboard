<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Helpers\Companies;
use App\Table\Exception\NotFoundException;

final class CompaniesTable extends Table {

    protected $table = "companies";
    protected $class = Companies::class;

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

    public function create(Companies $ads): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET `name` = :name, `activities` = :activities, `address` = :address, `postal_code` = :postal_code,
        `city` = :city, `siret` = :siret, `password` = :password, `number_employes` = :number_employes, `website` = :website, `phone` = :phone, `email` = :email, `contact_name` = :contact_name");
        $ok = $query->execute([
            'name' => $ads->getName(),
            'activities' => $ads->getActivities(),
            'address' => $ads->getAddress(),
            'postal_code' => $ads->getPostalCode(),
            'city' => $ads->getCity(),
            'siret' => $ads->getSiret(),
            'password' => password_hash($ads->getPassword(), PASSWORD_DEFAULT),
            'number_employes' => $ads->getNumberEmployes(),
            'website' => $ads->getWebsite(),
            'phone' => $ads->getPhone(),
            'email' => $ads->getEmail(),
            'contact_name' => $ads->getContactName()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't create the record in the table {$this->table}"); 
        }
        $ads->setID($this->pdo->lastInsertId());
    }


    public function update(Companies $ads): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET `name` = :name, `activities` = :activities, `address` = :address, `postal_code` = :postal_code,
                                    `city` = :city, `siret` = :siret, `password` = :password, `number_employes` = :number_employes, `website` = :website,
                                    `phone` = :phone, `email` = :email, `contact_name` = :contact_name WHERE id = :id");
        $ok = $query->execute([
            'name' => $ads->getName(),
            'activities' => $ads->getActivities(),
            'address' => $ads->getAddress(),
            'postal_code' => $ads->getPostalCode(),
            'city' => $ads->getCity(),
            'siret' => $ads->getSiret(),
            'password' => password_hash($ads->getPassword(), PASSWORD_DEFAULT),
            'number_employes' => $ads->getNumberEmployes(),
            'website' => $ads->getWebsite(),
            'phone' => $ads->getPhone(),
            'email' => $ads->getEmail(),
            'contact_name' => $ads->getContactName()
        ]);
        if ($ok === false) {
            throw new \Exception("Can't delete the record $ads in the table {$this->table}"); 
        }
    }

}

?>