<?php


namespace App\Modules\Site\Models\Objects;


use Illuminate\Database\Eloquent\Model;

/**
 * Class FileInfoObject
 * @package App\Modules\Site\Models\Objects
 *
 * @property string $dirname
 * @property string $basename
 * @property string $extension
 * @property string $filename
 * @property string $path
 * @property @
 * @property bool fileExist
 */
class FileInfoObject extends Model
{

    protected $attributes = [
        'fileExist' => false,
    ];

    public $fillable = [
        'dirname', 'basename', 'extension', 'filename', 'fileExist', 'path',
    ];
}
