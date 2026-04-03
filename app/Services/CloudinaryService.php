<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(config('cloudinary.cloud_url'));
    }

    /**
     * Upload público (imágenes de perfil, menú, etc.)
     * @return array ['url' => string, 'public_id' => string]
     */
    public function upload($file, string $folder = 'metra'): array
    {
        $result = $this->cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder'        => $folder,
                'resource_type' => 'image',
                'type'          => 'upload', // público
            ]
        );

        return [
            'url'       => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    /**
     * Upload privado/autenticado (comprobantes de pago).
     * Solo accesibles via URL firmada.
     * @return array ['public_id' => string, 'resource_type' => string]
     */
    public function uploadPrivate($file, string $folder = 'metra/comprobantes'): array
    {
        // Detectar si es PDF u otro formato para decidir resource_type
        $extension = strtolower($file->getClientOriginalExtension());
        $resourceType = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'image' : 'raw';

        $result = $this->cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder'        => $folder,
                'resource_type' => $resourceType,
                'type'          => 'authenticated', // privado
            ]
        );

        return [
            'public_id'     => $result['public_id'],
            'resource_type' => $result['resource_type'],
            'format'        => $result['format'] ?? $extension,
        ];
    }

    /**
     * Genera una URL firmada temporal para un recurso autenticado.
     * @param string $publicId  Public ID del recurso en Cloudinary
     * @param string $resourceType  'image' o 'raw'
     * @param string $format  Extensión del archivo (jpg, png, pdf)
     * @param int $expiresInSeconds  Tiempo de vida de la URL (default 60s)
     * @return string URL firmada
     */
    public function signedUrl(string $publicId, string $resourceType = 'image', string $format = 'jpg', int $expiresInSeconds = 60): string
    {
        return $this->cloudinary->adminApi()->asset($publicId, [
            'resource_type' => $resourceType,
            'type'          => 'authenticated',
        ])['secure_url'] ?? '';
    }

    /**
     * Genera URL de descarga privada temporal.
     */
    public function privateDownloadUrl(string $publicId, string $format = 'jpg', string $resourceType = 'image', int $expiresAt = 0): string
    {
        if ($expiresAt === 0) {
            $expiresAt = time() + 60; // 60 segundos
        }

        return $this->cloudinary->uploadApi()->privateDownloadUrl(
            $publicId,
            $format,
            [
                'resource_type' => $resourceType,
                'type'          => 'authenticated',
                'expires_at'    => $expiresAt,
            ]
        );
    }

    /**
     * Elimina un recurso de Cloudinary por su public_id.
     */
    public function delete(?string $publicId, string $resourceType = 'image', string $type = 'upload'): void
    {
        if (!$publicId) {
            return;
        }

        try {
            $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
                'type'          => $type,
            ]);
        } catch (\Throwable $e) {
            \Log::warning("Cloudinary delete failed for {$publicId}: " . $e->getMessage());
        }
    }
}
