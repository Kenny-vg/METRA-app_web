<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    /**
     * Sube un archivo a Cloudinary aplicando transformaciones estándar.
     * 
     * @param UploadedFile $file
     * @param string $folder Carpeta destino (metra/menus, metra/perfiles, metra/comprobantes)
     * @param array $transformations Opcional: transformaciones adicionales.
     * @return array|null [url, public_id] o null si falla.
     */
    public static function upload(UploadedFile $file, string $folder, array $transformations = [])
    {
        try {
            $isPdf = $file->getClientOriginalExtension() === 'pdf';
            
            // Transformaciones por defecto para imágenes
            $defaultTransformations = $isPdf ? [] : [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ];

            $options = array_merge([
                'folder' => $folder,
            ], $defaultTransformations, $transformations);

            $result = Cloudinary::upload($file->getRealPath(), $options);

            return [
                'url' => $result->getSecurePath(),
                'public_id' => $result->getPublicId(),
            ];
        } catch (\Exception $e) {
            Log::error("Error subiendo a Cloudinary ({$folder}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Reemplaza una imagen existente por una nueva.
     * 
     * @param UploadedFile $file
     * @param string|null $oldPublicId ID del archivo anterior para borrarlo.
     * @param string $folder
     * @return array|null Nueva URL y Public ID.
     */
    public static function replace(UploadedFile $file, ?string $oldPublicId, string $folder, array $transformations = [])
    {
        // Subir la nueva primero
        $newFile = self::upload($file, $folder, $transformations);

        if ($newFile && $oldPublicId) {
            // Si la subida fue exitosa, borramos la vieja
            self::delete($oldPublicId);
        }

        return $newFile;
    }

    /**
     * Elimina un archivo de Cloudinary.
     * 
     * @param string|null $publicId
     * @return bool
     */
    public static function delete(?string $publicId)
    {
        if (!$publicId) {
            return false;
        }

        try {
            Cloudinary::destroy($publicId);
            return true;
        } catch (\Exception $e) {
            Log::error("Error eliminando de Cloudinary ({$publicId}): " . $e->getMessage());
            return false;
        }
    }
}
