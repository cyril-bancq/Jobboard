<?php

namespace App\Helpers;

use App\Helpers\Text;

class Post {

    private $ads_id;
    private $title;
    private $description;
    private $date;
    private $duration;
    private $salary;
    private $hour;
    private $contract_type;
    private $published_id;

    public function getID(): ?int 
    {
        return $this->ads_id;
    }

    public function setID(int $ads_id): self
    {
        $this->ads_id = $ads_id;
        return $this;
    }

    public function getPublished(): ?int 
    {
        return $this->published_id;
    }

    public function setPublished(int $published_id): self
    {
        $this->published_id = $published_id;
        return $this;
    }

    public function getTitle(): ?string 
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return nl2br(htmlentities($this->description));
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getExcerpt(): ?string
    {
        if ($this->description === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->description, 60)));
    }

    public function getDate(): \DateTime
    {
        return new \DateTime($this->date);
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;
        return $this;
    }

    public function getHour(): ?string
    {
        return $this->hour;
    }

    public function setHour(string $hour): self
    {
        $this->hour = $hour;
        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract_type;
    }

    public function setContract(string $contract_type): self
    {
        $this->contract_type = $contract_type;
        return $this;
    }
}

?>