<?php


namespace App\Modules\Site\Factories;


use App\Modules\Site\Enums\ErrorImageEnum;

class ImagePreviewMethodFactory
{

    public const CROP = 1;
    public const RESIZE = 2;
    public const UNKNOWN = 0;

    /**
     * @param string $type
     * @return int
     */
    public static function getMethod(string $type): int
    {
        switch ($type) {
            case 'c':
                return static::CROP;
            case 'r':
                return static::RESIZE;
            default:
                throw new \DomainException(ErrorImageEnum::UNKNOWN_METHOD_IMAGE_PROCESSING);
        }
    }

}
