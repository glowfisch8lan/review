<?php


namespace App\Modules\Site\Services\Interfaces;


use App\Modules\Site\Models\Objects\FileInfoObject;
use App\Modules\Site\Models\Objects\ImagePreviewConfig;
use App\Modules\Site\Models\Objects\ImagePreviewObject;
use Intervention\Image\Image;

/**
 * Interface ImageServiceInterface
 * @package App\Modules\Site\Services\Interfaces
 */
interface ImageServiceInterface
{

    public function createPreview(ImagePreviewObject $image): string;

    public function createObject(FileInfoObject $fileInfoObject, ImagePreviewConfig $imagePreviewConfig): ImagePreviewObject;

    public function validate(FileInfoObject $fileInfoObject): bool;

}
