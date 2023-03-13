<?php

namespace App;

class Pagination
{
    private int $total;
    private int $page;
    private int $limit;
    private string $url;
    private int $maxPages = 5;
    private string $pageParam = 'page';

    public function setup($total, $page, $limit, $url)
    {
        $this->total = $total;
        $this->page = $page;
        $this->limit = $limit;
        $this->url = $url;
    }

    public function getPrevUrl(): ?string
    {
        $prevPage = $this->getCurrentPage() - 1;

        if ($prevPage < 1) {
            return null;
        }

        return $this->getUrl($prevPage);
    }

    public function hasNext(): bool
    {
        return $this->page < ceil($this->total / $this->limit);
    }

    public function getNextUrl(): ?string
    {
        if ($this->hasNext()) {
            return $this->url . '/tasks' . '?page=' . ($this->page + 1);
        }
        return null;
    }

    public function getCurrentPage(): int
    {
        $currentPage = $_GET['page'] ?? 1;
        if (!is_numeric($currentPage)) {
            $currentPage = 1;
        }
        return (int)$currentPage;
    }

    public function getPages(): array
    {
        $currentPage = $this->getCurrentPage();
        $lastPage = $this->getLastPage();
        $pages = [];

        // Выводим ссылку на первую страницу
        if ($currentPage > 1) {
            $pages[] = [
                'num' => 1,
                'url' => $this->getUrl(1),
                'isCurrent' => false,
            ];
        }

        for ($i = max(2, $currentPage - $this->maxPages); $i < $currentPage; $i++) {
            $pages[] = [
                'num' => $i,
                'url' => $this->getUrl($i),
                'isCurrent' => false,
            ];
        }

        $pages[] = [
            'num' => $currentPage,
            'url' => $this->getUrl($currentPage),
            'isCurrent' => true,
        ];

        for ($i = $currentPage + 1; $i < min($lastPage, $currentPage + $this->maxPages); $i++) {
            $pages[] = [
                'num' => $i,
                'url' => $this->getUrl($i),
                'isCurrent' => false,
            ];
        }

        if ($currentPage < $lastPage) {
            $pages[] = [
                'num' => $lastPage,
                'url' => $this->getUrl($lastPage),
                'isCurrent' => false,
            ];
        }

        return $pages;
    }

    public function getUrl($page): string
    {
        $url = $this->url;
        $url .= "/tasks";
        $query = [];

        if ($page > 1) {
            $query[$this->pageParam] = $page;
        }

        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                if ($key != $this->pageParam) {
                    $query[$key] = $value;
                }
            }
        }

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    public function getLastPage(): int
    {
        return (int)ceil($this->total / $this->limit);
    }
}