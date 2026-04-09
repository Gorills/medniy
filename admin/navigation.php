<?php

/**
 * @var \SleepingOwl\Admin\Contracts\Navigation\NavigationInterface $navigation
 * @see http://sleepingowladmin.ru/docs/menu_configuration
 */

use SleepingOwl\Admin\Navigation\Page;
use App\Models\{
    Access\User,
    Access\Role,
    Access\Permission,
    System\Setting,
    MainStageSlide,
    MapCategory,
    MapSubcategory,
    MapMarker,
    ObjectSlide,
    Stock,
    GalleryPhoto,
    Block,
    Floor,
    Scheme,
    Apartment,
    Decoration,
    ConstructionStage,
    News
};

$navigation->setFromArray([
    (new Page())
        ->setTitle('Настройки доступа')
        ->setIcon('fa fa-group')
        ->setPriority(1)
        ->setPages(function ($page) {
            /**
             * @var Page $page
             */
            $page->addPage(
                (new Page(User::class))
                    ->setIcon('fa fa-user')
                    ->setPriority(1)
            );

            $page->addPage(
                (new Page(Role::class))
                    ->setIcon('fa fa-user-secret')
                    ->setPriority(2)
            );

            $page->addPage(
                (new Page(Permission::class))
                    ->setIcon('fa fa-shield')
                    ->setPriority(3)
            );
        }),
    (new Page(Setting::class))
        ->setIcon('fa fa-cogs')
        ->setPriority(2),
    (new Page())
        ->setTitle('Главная страница')
        ->setIcon('fa fa-file')
        ->setPriority(3)
        ->setPages(function ($page) {
            /**
             * @var Page $page
             */
            $page->addPage(
                (new Page(MainStageSlide::class))
                    ->setIcon('fa fa-image')
                    ->setPriority(1)
            );

            $page->addPage(
                (new Page(MapCategory::class))
                    ->setIcon('fa fa-filter')
                    ->setPriority(2)
            );
            $page->addPage(
                (new Page(MapSubcategory::class))
                    ->setIcon('fa fa-filter')
                    ->setPriority(2)
            );

            $page->addPage(
                (new Page(MapMarker::class))
                    ->setIcon('fa fa-map-marker')
                    ->setPriority(3)
            );

            $page->addPage(
                (new Page(ObjectSlide::class))
                    ->setIcon('fa fa-image')
                    ->setPriority(4)
            );
        }),
    (new Page(News::class))
        ->setIcon('fa fa-newspaper-o')
        ->setPriority(4),
    (new Page())
        ->setTitle('Недвижимость')
        ->setIcon('fa fa-building')
        ->setPriority(5)
        ->setPages(function ($page) {
            /**
             * @var Page $page
             */
            $page->addPage(
                (new Page(Block::class))
                    ->setIcon('fa fa-building')
                    ->setPriority(1)
            );
            $page->addPage(
                (new Page(Floor::class))
                    ->setIcon('fa fa-bars')
                    ->setPriority(2)
            );
            $page->addPage(
                (new Page(Scheme::class))
                    ->setIcon('fa fa-th-large')
                    ->setPriority(3)
            );
            $page->addPage(
                (new Page(Apartment::class))
                    ->setIcon('fa fa-tag')
                    ->setPriority(4)
            );
            $page->addPage(
                (new Page(Decoration::class))
                    ->setIcon('fa fa-paint-brush')
                    ->setPriority(5)
            );
        }),
    (new Page(GalleryPhoto::class))
        ->setIcon('fa fa-image')
        ->setPriority(6),
    (new Page(ConstructionStage::class))
        ->setIcon('fa fa-cubes')
        ->setPriority(7),
]);
