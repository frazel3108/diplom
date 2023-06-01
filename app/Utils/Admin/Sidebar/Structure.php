<?php

namespace App\Utils\Admin\Sidebar;

class Structure
{
    private array $structure = [];
    private bool $active = false;

    public function add(array $item): void
    {
        $this->structure[] = $item;
    }

    public function active(bool $value): void
    {
        $this->active = $value;
    }

    public function getStructure(): array
    {
        return $this->structure;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function hasItems(): bool
    {
        return count($this->structure) > 0;
    }
}
