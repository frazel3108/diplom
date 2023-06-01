<?php

namespace App\Utils;

class Tree
{
    private array $items;
    private array $links;

    public function __construct($items)
    {
        [$this->items, $this->links] = $this->buildTree($items);
    }

    private function buildTree(
        array $items,
        int $parentId = 0
    ) {
        $result = [];
        $links = [];
        $branchIds = [];
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                [
                    $children,
                    $newLinks,
                    $childBranchIds,
                ] = $this->buildTree($items, $item['id']);

                $childBranchIds[] = $item['id'];
                $branchIds = array_merge($branchIds, $childBranchIds);

                $branch = [
                    'item' => $item,
                    'child' => $children,
                    'branchIds' => $childBranchIds,
                ];

                $links['_' . $item['id'] . '_'] = $branch;
                $links = array_merge($links, $newLinks);

                $result[] = $branch;
            }
        }


        return [$result, $links, $branchIds];
    }

    public function getBranchIds(int $id): array
    {
        return $this->links['_' . $id . '_']['branchIds'] ?? [];
    }

    public function getTree()
    {
        return $this->items;
    }
}