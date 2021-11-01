<?php


namespace App\Widgets\Menu\Configs;


/**
 * Class ViewConfig
 * @package App\Widgets\Menu\Configs
 * @property int $type Тип меню: Мобильное верхнее, декстопное нижнее и т.д.
 */
class ViewConfig implements ConfigInterface
{

    public int $type = 1;

    public static function make(array $config): ViewConfig
    {
        $object = new static();
        $object->type = $config['type'];

        return $object;
    }
}
