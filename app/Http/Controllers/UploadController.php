<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg',
        ]);
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        return ResponseHelper::success("true", $file);

    }
}
