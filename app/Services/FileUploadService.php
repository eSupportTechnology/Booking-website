<?php
namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    
    public function uploadAndSave(
        UploadedFile $file,
        string $fileType,
        string $propertyType,
        int $propertyId,
        ?string $directory = null
    ): ?File {
        try {
            $folder = $directory ?? 'uploads/files';
            $path = $file->store($folder, 'public');

            return File::create([
                'file_type'      => $fileType,
                'path'           => $path,
                'property_type'  => $propertyType,
                'property_id'    => $propertyId,
            ]);
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }
}
