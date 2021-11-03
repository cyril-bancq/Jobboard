<?php

namespace App\Helpers;

class Applied {

    public $id;
    private $people_id;
    private $advertissement_id;
    private $motivation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPeopleId(): ?int
    {
        return $this->people_id;
    }

    public function setPeopleId(int $people_id): self
    {
        $this->people_id = $people_id;

        return $this;
    }

    public function getAdvertissementId(): ?int
    {
        return $this->advertissement_id;
    }

    public function setAdvertissementId(int $advertissement_id): self
    {
        $this->advertissement_id = $advertissement_id;

        return $this;
    }

    public function getMotivationPeople(): ?string
    {
        return $this->motivation;
    }

    public function setMotivationPeople(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }
}
?>