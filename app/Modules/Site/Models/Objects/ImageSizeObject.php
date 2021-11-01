<?php


namespace App\Modules\Site\Models\Objects;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ImageSizeObject
 * @package App\Modules\Site\Models\Objects
 * @property int $width
 * @property int $height
 */
class ImageSizeObject extends Model
{
    public $fillable = [
        'width', 'height',
    ];
}
