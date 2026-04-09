<?php

namespace Admin\Providers;

use Illuminate\Routing\Router;
use Illuminate\{
    Support\Facades\Route
};
use SleepingOwl\Admin\{
    Admin,
    Contracts\Navigation\NavigationInterface,
    Contracts\Widgets\WidgetsRegistryInterface,
    Providers\AdminSectionsServiceProvider as ServiceProvider
};
use Admin\Http\Sections\{
    Access\Users,
    Access\Roles,
    Access\Permissions,
    Apartments,
    GalleryPhotos,
    MainStageSlides,
    MapCategories,
    MapSubcategories,
    MapMarkers,
    ObjectSlides,
    Stocks,
    System\Settings,
    Blocks,
    Schemes,
    Decorations,
    Floors,
    ConstructionStages,
    News
};
use Admin\Widgets\{
    NavigationUserBlock
};
use App\Models\{
    Access\User,
    Access\Role,
    Access\Permission,
    GalleryPhoto,
    MainStageSlide,
    MapCategory,
    MapSubcategory,
    ObjectSlide,
    Scheme,
    Decoration,
    Stock,
    System\Setting,
    MapMarker,
    Block,
    Floor,
    Apartment,
    ConstructionStage};

/**
 * Class AdminSectionsServiceProvider
 * @package Admin\Providers
 */
class AdminSectionsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $sections = [
        User::class => Users::class,
        Role::class => Roles::class,
        Permission::class => Permissions::class,
        Setting::class => Settings::class,
        MainStageSlide::class => MainStageSlides::class,
        MapCategory::class => MapCategories::class,
        MapSubcategory::class => MapSubcategories::class,
        MapMarker::class => MapMarkers::class,
        ObjectSlide::class => ObjectSlides::class,
        Block::class => Blocks::class,
        Scheme::class => Schemes::class,
        Decoration::class => Decorations::class,
        Floor::class => Floors::class,
        Apartment::class => Apartments::class,
        GalleryPhoto::class => GalleryPhotos::class,
        ConstructionStage::class => ConstructionStages::class,
        \App\Models\News::class => \Admin\Http\Sections\News::class,
//        Stock::class => Stocks::class,
    ];

    /**
     * @var array
     */
    protected $widgets = [
        NavigationUserBlock::class,
    ];

    /**
     * @param Admin $admin
     */
    public function boot(Admin $admin)
    {
        $this->loadViewsFrom(base_path('admin/resources/views'), 'admin');
        $this->registerPolicies('Admin\\Policies\\');

        $this->app->call([$this, 'registerRoutes']);
        $this->app->call([$this, 'registerNavigation']);

        parent::boot($admin);

        $this->app->call([$this, 'registerViews']);
    }

    /**
     * @param Router $router
     */
    public function registerRoutes()
    {
        ['middleware' => $middleware, 'url_prefix' => $prefix] = config('sleeping_owl');

        Route::middleware($middleware)
            ->prefix($prefix)
            ->namespace('Admin\Http\Controllers')
            ->group(function () {
                require_once __DIR__ . '/../Http/routes.php';
            });
    }

    /**
     * @param NavigationInterface $navigation
     */
    public function registerNavigation(NavigationInterface $navigation)
    {
        require base_path('admin/navigation.php');
    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
