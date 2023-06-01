<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(Category $category, UpdateRequest $request)
    {
        $validated = $request->validated();

        $category->parent_id = $validated['parent_id'] ?? 0;
        $category->name = $validated['name'];
        $category->url = $validated['url'] ?? 'new-' . Str::slug($validated['name']);;
        $category->order = $validated['order'] ?? 0;

        if ($category->image) {
            $category->image = $request->image
                ? $this->updateImage($request->image, $category->image)
                : ($request->_uploaded_['image'] ?? null);
        } elseif ($request->image) {
            $category->image = $request->image->store('categories', 'images');
        } else {
            $category->image = null;
        }

        $category->save();
        \Cache::flush();
        return redirect()->route('admin.category')
            ->withStatus('Данные обновлены!');
    }

    private function updateImage(UploadedFile $image, string $imagePath): string
    {
        Storage::disk('images')->delete($imagePath);
        return $image->store('categories', 'images');
    }
}