<?php


namespace App\Widgets\Menu\Objects;


use App\Modules\Site\Models\Page;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PageObject
 * @package App\Widgets\Menu\Objects
 *
 * @property string $url
 * @property string $name
 * @property string $module
 */
class PageObject extends Model
{

    public $fillable = [
        'name', 'url', 'module'
    ];

    public static function make(Page $model): PageObject
    {
        return new PageObject([
            'name' => $model->name,
            'url' => '/' . $model->module . '/' . $model->url,
        ]);
    }
}
