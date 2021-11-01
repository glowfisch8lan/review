<?php


namespace App\Modules\Site\Enums;


class ErrorImageEnum
{
    public const ORIGINAL_IMAGE_NOT_FOUND = 'Sorry, original image not found on the server! Nothing to process!';

    public const VALIDATION_FAILED = 'Sorry, file is not valid!';

    public const NOT_ALLOWED_EXTENSION = 'Sorry, this image extension is not allowed!';

    public const FILE_IS_NOT_IMAGE = 'Sorry, this is file is not image!';

    public const SIZE_IS_NOT_VALID = 'Sorry, wrong image size parameters!';

    public const UNKNOWN_METHOD_IMAGE_PROCESSING = 'Unknown image processing method!';

    public const CANT_CREATE_PREVIEW_IMAGE = 'Error when creating preview!';


}
