<?php

namespace App\Widgets\Menu;

use App\Widgets\Menu\Configs\ViewConfig;
use App\Widgets\Menu\Factories\ViewFactory;
use Arrilot\Widgets\AbstractWidget;

class Widget extends AbstractWidget
{
    public const HEADER_MENU_NON_MOBILE = 1;
    public const FOOTER_MENU = 2;
    public const MENU_MOBILE = 3;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type' => self::HEADER_MENU_NON_MOBILE
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return ViewFactory::build(ViewConfig::make($this->config));
    }
}
