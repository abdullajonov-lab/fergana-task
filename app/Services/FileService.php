<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function upload($file, $path): string
    {
        $fileName = Str::random(8) . "_" . time()  . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($path, $file, $fileName);
        return $fileName;
    }

    public function delete($path): void
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
