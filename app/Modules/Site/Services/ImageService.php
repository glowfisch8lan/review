<?php


namespace App\Modules\Site\Services;


use App\Modules\Site\Enums\ErrorImageEnum;
use App\Modules\Site\Factories\ImagePreviewMethodFactory;
use App\Modules\Site\Models\Objects\FileInfoObject;
use App\Modules\Site\Models\Objects\ImagePreviewConfig;
use App\Modules\Site\Models\Objects\ImagePreviewObject;
use App\Modules\Site\Models\Objects\ImageSizeObject;
use App\Modules\Site\Services\Interfaces\ImageServiceInterface;
use DomainException;
use Exception;
use Intervention\Image\Facades\Image;

/**
 * Class ImageService
 * @package App\Modules\Site\Services
 */
class ImageService implements ImageServiceInterface
{

    private const PREVIEW_EXTENSION = 'jpg';

    private const CACHE_PATH = 'app/public/cache/images/';

    /**
     * @see https://www.php.net/manual/function.exif-imagetype.php
     */
    public const AVAILABLE_TYPE_IMAGE = [
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
    ];

    /**
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->dirIsWritable();

    }

    public function dirIsWritable(): void
    {
        $path = storage_path(self::CACHE_PATH);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    /**
     * @param FileInfoObject $fileInfoObject
     * @return bool
     */
    public function validate(FileInfoObject $fileInfoObject): bool
    {
        $type = exif_imagetype($fileInfoObject->path);
        if ($type === false) {
            throw new DomainException(ErrorImageEnum::FILE_IS_NOT_IMAGE);
        }

        if (!in_array($type, self::AVAILABLE_TYPE_IMAGE)) {
            throw new DomainException(ErrorImageEnum::VALIDATION_FAILED);
        }

        return true;
    }

    /**
     * @param string $previewPath
     * @return bool
     */
    public function previewExist(string $previewPath): bool
    {
        return is_file($previewPath);
    }

    /**
     * @param ImagePreviewObject $imagePreviewObject
     * @return string|null
     */
    public function getPreviewPath(ImagePreviewObject $imagePreviewObject): ?string
    {
        $previewPath = $this->generatePath($imagePreviewObject);
        return ($this->previewExist($previewPath)) ? $previewPath : null;
    }

    /**
     * @param ImagePreviewObject $imagePreviewObject
     * @return string
     */
    protected function generatePath(ImagePreviewObject $imagePreviewObject): string
    {

        return storage_path(self::CACHE_PATH) . $imagePreviewObject->preview->method . '-' . $imagePreviewObject->preview->width . 'x' .
            $imagePreviewObject->preview->height . '_' .
            implode('.', [md5($imagePreviewObject->file->path), $imagePreviewObject->file->extension]);
    }

    /**
     * @param string $sizes
     * @return ImageSizeObject
     * @description Получить объект размеров превью изображения
     */
    public function getSize(string $sizes): ImageSizeObject
    {
        $sizes = explode('x', $sizes);
        if (count($sizes) !== 2) {
            throw new DomainException(ErrorImageEnum::SIZE_IS_NOT_VALID);
        }


        foreach ($sizes as $size) {
            if ((int)$size === 0) {
                throw new DomainException(ErrorImageEnum::SIZE_IS_NOT_VALID);
            }
        }

        return new ImageSizeObject([
            'width' => (int) $sizes[0],
            'height' => (int) $sizes[1],
        ]);
    }

    /**
     * @param FileInfoObject $fileInfoObject
     * @param ImagePreviewConfig $imagePreviewConfig
     * @return ImagePreviewObject
     * @description Создать объект превью изображения
     */
    public function createObject(FileInfoObject $fileInfoObject, ImagePreviewConfig $imagePreviewConfig): ImagePreviewObject
    {
        return new ImagePreviewObject([
            'preview' => $imagePreviewConfig,
            'file' => $fileInfoObject,
        ]);
    }

    /**
     * @param ImagePreviewObject $image
     * @return string
     * @throws Exception
     * @description Создать превью картинку
     */
    public function createPreview(ImagePreviewObject $image): string
    {
        $preview = null;

        switch ($image->preview->method) {
            case ImagePreviewMethodFactory::CROP:
                $preview = Image::make($image->file->path)->fit($image->preview->width, $image->preview->height);
                break;
            case ImagePreviewMethodFactory::RESIZE:
                $preview = Image::make($image->file->path)->resize($image->preview->width, $image->preview->height);
                break;
        }

        if ($preview === null) {
            throw new Exception(ErrorImageEnum::CANT_CREATE_PREVIEW_IMAGE);
        }

        $previewPath = $this->generatePath($image);
        $imagePreview = $preview->encode(self::PREVIEW_EXTENSION, 80)->save($previewPath);
        return $previewPath;
    }


}
