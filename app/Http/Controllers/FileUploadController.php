<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $fileName = null;
        if ($request->hasFile('images')) {
            // put image in the public storage
            $filePath = Storage::disk('public')->put('images', request()->file('images'));
        }
        return $this->sendResponse(url('') . '' . Storage::url($filePath), 'file berhasil upload');
    }
}
