<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->upload->store('uploads');

        return response()->json([
            'uploaded' => 1,
            'fileName' => $request->upload->getClientOriginalName(),
            'url' => Storage::url($file),
        ]);
    }
}
