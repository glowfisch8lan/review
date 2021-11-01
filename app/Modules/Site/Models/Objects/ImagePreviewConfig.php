<?php


namespace App\Modules\Site\Models\Objects;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ImagePreviewConfig
 * @package App\Modules\Site\Models\Objects
 *
 * @property int $width
 * @property int $height
 * @property int $method
 */
class ImagePreviewConfig extends Model
{

    public $fillable = [
        'width', 'height', 'method'
    ];
}
