<?php

namespace App\Services;

use App\Models\Category;
use App\Utils\Tree;
use Illuminate\Support\Collection;

class CategoryService
{
    public static function getTree(): mixed
    {
        return (new Tree(Category::all()->toArray()))->getTree();
    }

    public static function treeFromCollection(Collection $categories): array
    {
        foreach ($categories as $category) {
            if ($category->parent_id != 0 && is_null($categories->find($category->parent_id))) {
                $findCategory = Category::find($category->parent_id);
                $findCategory->products_count = 0;
                $categories->add($findCategory);
            }
        }

        return (new Tree($categories->toArray()))->getTree();
    }

    public static function sortChild(array $tree): array
    {
        $filterTree = [];
        array_map(function ($category) use (&$filterTree) {
            if (count($category['child']) == 0) {
                $filterTree['withoutChild'][] = $category;
            } else {
                $filterTree['withChild'][] = $category;
            }
        }, $tree);
        return $filterTree;
    }
}