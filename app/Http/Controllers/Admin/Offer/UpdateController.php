<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Requests\Admin\Offer\UpdateRequest;
use App\Models\Offer;

class UpdateController
{
    public function __invoke(Offer $offer, UpdateRequest $request)
    {
        $validated = $request->validated();

        $offer->name = $validated['name'];
        $offer->percent = $validated['percent'];
        $offer->href = $validated['href'];
        $offer->start_at = $validated['start_at'];
        $offer->end_at = $validated['end_at'];

        $offer->banner = $request->banner
            ? $request->banner->store('offers', 'images')
            : ($request->_uploaded_['banner'] ?? null);

        $offer->save();
        \Cache::flush();
        return redirect()->route('admin.offer')
            ->withStatus('Категория создана!');
    }
}