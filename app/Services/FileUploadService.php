<?php
namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileUploadService
{
    
    public function uploadAndSave(
        UploadedFile $file,
        string $fileType,
        string $propertyType,
        int $propertyId=null,
        ?string $directory = null
    ): ?File {
        try {
            Log::info('FileUploadService: Starting file upload', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'fileType' => $fileType,
                'propertyType' => $propertyType,
                'propertyId' => $propertyId,
                'directory' => $directory
            ]);

            $folder = $directory ?? 'uploads/files';
            $path = $file->store($folder, 'public');

            Log::info('FileUploadService: File stored successfully', ['path' => $path]);

            $fileRecord = File::create([
                'file_type'      => $fileType,
                'path'           => $path,
                'property_type'  => $propertyType,
                'property_id'    => $propertyId,
            ]);

            Log::info('FileUploadService: File record created', ['file_id' => $fileRecord->id]);

            return $fileRecord;
        } catch (\Exception $e) {
            Log::error('FileUploadService: Error uploading file', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'filename' => $file->getClientOriginalName()
            ]);
            report($e);
            return null;
        }
    }
}
