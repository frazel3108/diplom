<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Content\UpdateRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product\Content;
use Illuminate\Http\UploadedFile;

class UpdateController extends Controller
{
    public function __invoke(Content $content, UpdateRequest $request)
    {
        $validated = $request->validated();

        $content->product_id = $validated['product_id'];
        $content->type = $validated['type'];
        if($content->type == 'text') {
            $content->file = null;
            $content->content = $validated['content'] ?? null;
        } else {
            $content->content = null;

            if ($content->file) {
                $content->file = $request->file
                    ? $this->updateFile($request->file, $content->file)
                    : ($request->_uploaded_['file'] ?? null);
            } elseif ($request->file) {
                $content->file = $request->file->store('product/content', 'public');
            } else {
                $content->file = null;
            }
        }

        $content->save();
        \Cache::flush();
        return redirect()->route('admin.products.content')
            ->withStatus('Данные товара обновлены!');
    }

    private function updateFile(UploadedFile $image, string $filePath): string
    {
        Storage::disk('public')->delete($filePath);
        return $image->store('categories', 'images');
    }
}