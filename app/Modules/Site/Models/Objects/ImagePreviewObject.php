<?php


namespace App\Modules\Site\Models\Objects;


use Illuminate\Database\Eloquent\Model;

/**
 * Class FileInfoObject
 * @package App\Modules\Site\Models\Objects
 *
 * @property ImagePreviewConfig $preview
 * @property FileInfoObject $file
 */
class ImagePreviewObject extends Model
{

    public $fillable = [
        'preview', 'file',
    ];
}
