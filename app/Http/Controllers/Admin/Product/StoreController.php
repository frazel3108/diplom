<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Requests\Admin\Product\StoreRequest;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class StoreController
{
    public function __invoke(Product $product, StoreRequest $request)
    {
        $validated = $request->validated();

        $product = new Product();
        $product->category_id = $validated['category_id'];
        $product->name = $validated['name'];
        $product->url = $validated['url'] ?? 'new-' . Str::slug($validated['name']);
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->sale_price = $validated['sale_price'];
        $product->popular = isset($request->popular) && $validated['popular'] == 'on' ? 1 : 0;
        $product->order = $validated['order'] ?? 0;

        $product->images = $this->storeImages(
            $request->image ?? [],
            $request->_uploaded_['image'] ?? [],
            array_diff(
                json_decode($product->images) ?? [],
                $request->_uploaded_['image'] ?? []
            )
        );

        $product->save();

        $product->offers()->sync($validated['offers'] ?? []);
        foreach ($validated['characteristic']['id'] as $key => $char) {
            if (!is_null($char) && !is_null($validated['characteristic']['value'][$key])) {
                $synsCharacteristics[$char] = ['value' => $validated['characteristic']['value'][$key]];
            }
        }
        $product->characteristics()->sync($synsCharacteristics ?? []);
        \Cache::flush();

        return redirect()->route('admin.product')
            ->withStatus('Категория создана!');
    }

    private function storeImages(array $store, array $uploaded, array $diff,): string|null
    {
        $jsonImages = [];
        if (!empty($uploaded)) {
            $jsonImages = array_merge($jsonImages, $uploaded);
        }

        Storage::disk('images')->delete($diff);

        if (!empty($store)) {
            foreach ($store as $image) {
                $jsonImages[] = $image->store('products', 'images');
            }
        }

        return !empty($jsonImages) ? json_encode($jsonImages) : null;
    }
}