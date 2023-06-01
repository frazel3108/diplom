<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Requests\Admin\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class StoreController
{
    public function __invoke(Category $category, StoreRequest $request)
    {
        $validated = $request->validated();

        $category = new Category();
        $category->parent_id = $validated['parent_id'] ?? 0;
        $category->name = $validated['name'];
        $category->url = $validated['url'] ?? 'new-' . Str::slug($validated['name']);
        $category->order = $validated['order'] ?? 0;

        $category->image = $request->image
            ? $request->image->store('categories', 'images')
            : ($request->_uploaded_['image'] ?? null);

        $category->save();
        \Cache::flush();
        return redirect()->route('admin.category')
            ->withStatus('Категория создана!');
    }
}