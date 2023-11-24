<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:5120', // Adjust the allowed file types and size as needed
        ]);
        $file = $request->file('file');
        $filename = Str::orderedUuid() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        if (file_exists(public_path('uploads/' . $filename)))
            return ResponseHelper::success(_("message.file-upload-success"), URL("uploads/" . $filename));
        else
            return ResponseHelper::error(_("message.file-upload-error"), null, 500);
    }
}
