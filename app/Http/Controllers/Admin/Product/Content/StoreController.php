<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Http\Requests\Admin\Product\Content\StoreRequest;
use Illuminate\Support\Str;
use App\Models\Product\Content;

class StoreController
{
    public function __invoke(Content $content, StoreRequest $request)
    {
        $validated = $request->validated();

        $content = new Content();
        $content->product_id = $validated['product_id'];
        $content->type = $validated['type'];
        if($content->type == 'text') {
            $content->file = null;
            $content->content = $validated['content'] ?? null;
        } else {
            $content->content = null;
            $content->file = $request->file
                ? $request->file->store('product/content', 'public')
                : ($request->_uploaded_['file'] ?? null);
        }

        $content->save();
        \Cache::flush();
        return redirect()->route('admin.products.content')
            ->withStatus('Категория создана!');
    }
}