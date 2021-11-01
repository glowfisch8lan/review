<?php


namespace App\Widgets\Menu\Factories;


use App\Modules\Site\Repositories\Interfaces\PageRepositoryInterface;
use App\Modules\Site\Repositories\PageRepository;
use App\Widgets\Menu\Configs\ConfigInterface;
use App\Widgets\Menu\Objects\PageObject;
use App\Widgets\Menu\Widget;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class ViewFactory
 * @package App\Widgets\Menu\Factories
 * @property PageRepository $pageRepository
 */
class ViewFactory
{

    protected ConfigInterface $config;
    protected PageRepositoryInterface $pageRepository;


    public function __construct(ConfigInterface $config, PageRepositoryInterface $pageRepository)
    {
        $this->config = $config;
        $this->pageRepository = $pageRepository;
    }


    /**
     * @description Фабричный метод, создающая View для меню: меню в Хедере, меню в Футере, меню для Мобильных устройств
     * @param ConfigInterface $config
     * @return Application|Factory|View|null
     */
    public static function build(ConfigInterface $config)
    {
        $factory = new ViewFactory($config, new PageRepository());

        switch ($config->type) {
            case Widget::HEADER_MENU_NON_MOBILE:
                return $factory->buildHeaderDesktopMenu();
            case Widget::FOOTER_MENU:
                return $factory->buildFooterMenu();
            case Widget::MENU_MOBILE:
                return $factory->buildMobileMenu();
            default:
                return null;
        }
    }

    /**
     * @description Генерирует мобильное меню
     * @return Application|Factory|View
     */
    private function buildMobileMenu()
    {
        $pages = $this->pageRepository->menuTop()->all();
        $pageObjects = $pages->map(fn($page) => PageObject::make($page));

        return view('widgets.menu.mobile-menu', ['pages' => $pageObjects]);
    }

    /**
     * @description Генерирует меню в хедере
     * @return Application|Factory|View
     */
    private function buildHeaderDesktopMenu()
    {
        $pages = $this->pageRepository->menuTop()->all();
        $pageObjects = $pages->map(fn($page) => PageObject::make($page));

        return view('widgets.menu.header-menu-non-mobile', ['pages' => $pageObjects]);
    }

    /**
     * @description Генерирует ссылки меню в Футере
     * @return Application|Factory|View
     */
    private function buildFooterMenu()
    {
        $pages = $this->pageRepository->menuBottom()->all();
        $pageObjects = $pages->map(fn($page) => PageObject::make($page));

        return view('widgets.menu.footer-menu', ['pages' => $pageObjects]);
    }
}
