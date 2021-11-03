<?php

namespace App;

use Exception;

class PaginatedQuery {

    private $query;
    private $queryCount;
    private $ClassMapping;
    private $pdo;
    private $perPage;
    private $count;
    private $items;

    public function __construct(string $query, string $queryCount, string $ClassMapping,?\PDO $pdo = null, int $perPage = 8)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->ClassMapping = $ClassMapping;
        $this->pdo = $pdo ?: App::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(): array
    {
        if ($this->items === null) {
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if ($currentPage > $pages) {
                throw new Exception('Page invalid');
            }
            $offset = $this->perPage * ($currentPage - 1);
            $this->items = $this->pdo->query($this->query . " LIMIT {$this->perPage} OFFSET $offset")->fetchAll(\PDO::FETCH_CLASS, $this->ClassMapping);
        }
        return $this->items;
    }

    public function previousPage(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary">&laquo; Previous Page</a>
HTML;
    }

    public function nextPage(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary">Next Page &raquo;</a>
HTML;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages(): int
    {
        if ($this->count === null) {
            $this->count = (int)$this->pdo->query($this->queryCount)->fetch(\PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage);
    }
}

?>