<?php

namespace App\Utils;

class Breadcrumbs
{
    private array $links = [];
    private string|null $current = null;
    private array $home = ['Главная', '/'];

    public function setHome(string $name, string $url): self
    {
        $this->home = [$name, $url];
        return $this;
    }

    public function add(string $name, ?string $url = null): self
    {
        return is_null($url)
            ? $this->current($name)
            : $this->link($name, $url);
    }

    public function current(string $name): self
    {
        $this->current = $name;
        return $this;
    }

    public function link(string $name, string $url): self
    {
        $this->links[] = [$name, $url];
        return $this;
    }

    public function getLinks(): array
    {
        return array_merge([$this->home], $this->links);
    }

    public function getCurrent(): ?string
    {
        return $this->current;
    }

    public function isActive(): bool
    {
        return count($this->links) > 0 || is_string($this->current);
    }
}