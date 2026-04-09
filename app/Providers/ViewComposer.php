<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\{
    System\Setting,
    MainStageSlide,
    MapCategory,
    ObjectSlide,
    Block,
    ConstructionStage
};
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ViewComposer
 * @package App\Providers
 */
class ViewComposer extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function () {
            view()->share('companyEmail', Setting::get('companyEmail'));
            view()->share('companyPhone', Setting::get('companyPhone'));
            view()->share('companyPhoneTag', preg_replace('/\s*/', '', Setting::get('companyPhone')));
            view()->share('comagicSiteID', Setting::get('comagicSiteID'));
            view()->share('comagicPersonalDataLink', '/private-politics');
            view()->share('currentRoute', function () {
                $route = Route::current();
                if ($route) {
                    return $route->uri();
                }
                return '';
            });
            view()->share('presentationLink', '/storage/files/Medny_leaflet.pdf');
            view()->share('documentsLink', route('documents'));
            view()->share('glidePrefix', '/' . config('glide.url_prefix') . '/');

            view()->share('menuItems', [
                [
                    'name' => 'Галерея',
                    'link' => route('gallery', [], false),
                ],
                [
                    'name' => 'Интерьеры',
                    'link' => route('interiors', [], false),
                ],
                [
                    'name' => 'Подбор квартир',
                    'link' => route('blocks-list', [], false),
                ],
               /* [
                    'name' => 'Условия покупки',
                    'link' => route('mortgage-calc', [], false),
                ],*/
                [
                    'name' => 'Ход строительства',
                    'link' => route('construction-stages', [], false),
                ],
                [
                    'name' => 'Новости',
                    'link' => route('news', [], false),
                ],
                [
                    'name' => 'Контакты',
                    'link' => route('contacts', [], false),
                ],
            ]);
        });

        view()->composer('components.mainstage', function () {
            view()->share('mainStageItems', MainStageSlide::where('active', true)
                ->orderBy('order', 'asc')
                ->get());
        });

        view()->composer('components.object', function () {
            view()->share('objectSlides', ObjectSlide::where('active', true)
                ->orderBy('order', 'asc')
                ->get());
        });

        view()->composer('components.map', function () {
            $mapMarkersConditions = function ($query) {
                /** @var Builder $query */
                $query->where('active', true);
                $query->whereNull('map_subcategory_id');
            };

            $mapSubcategoriesConditions = function ($query) {
                /** @var Builder $query */
                $query->where('active', true);
                $mapSubcategoryMarkersConditions = function ($query) {
                    /** @var Builder $query */
                    $query->where('active', true);
                };
                $query->with(['mapMarkers' => $mapSubcategoryMarkersConditions]);
                $query->whereHas('mapMarkers', $mapSubcategoryMarkersConditions);
            };

            view()->share('mapCategories', MapCategory::where('active', true)
                ->whereHas('mapMarkers', $mapMarkersConditions)
                ->orWhereHas('mapSubcategories', $mapSubcategoriesConditions)
                ->with(['mapMarkers' => $mapMarkersConditions])
                ->with(['mapSubcategories' => $mapSubcategoriesConditions])
                ->orderBy('order', 'asc')
                ->get());
        });

        view()->composer('pages.gallery', function () {
            view()->share(
                'blocks',
                Block::where('active', true)
                    ->with([
                        'galleryPhotos' => function ($query) {
                            /** @var Builder $query */
                            $query->where('active', true);
                        }
                    ])
                    ->get()
            );
        });

        view()->composer('components.construction_stages', function () {
            view()->share(
                'constructionStages',
                ConstructionStage::where('active', true)->get()
            );
        });

//        view()->composer('pages.stocks', function () {
//            view()->share('stocks', Stock::where('active', true)->paginate(4));
//        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
