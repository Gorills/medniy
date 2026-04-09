<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;

Auth::routes();

Route::namespace('Web')->group(function (Router $router) {
    $router->get('/')->uses('PagesController@index')->name('home');

    // todo rename route, controller & method
    $router->post('request')->uses('FormsController@addComagicUser')->name('addComagicUser');

    $router->get('gallery')->uses('GalleryController')->name('gallery');
    $router->get('gallery/facades')->uses('GalleryController@facades')->name('facades');
    $router->get('gallery/views')->uses('GalleryController@views')->name('views');

    $router->get('construction-stages')->uses('ConstructionStagesController@getStagesList')->name('construction-stages');
    $router->get('construction-stage/{date}/')->uses('ConstructionStagesController@detail')->name('construction-stage-detail');

    $router->get('mortgage-calc')->uses('MortgageController@calc')->name('mortgage-calc');

    $router->get('contacts')->uses('PagesController@contacts')->name('contacts');

    $router->get('genplan')->uses('ApartmentController@getBuildingsList')->name('blocks-list');
    $router->get('genplan/{block}/')->uses('ApartmentController@getBuilding')->name('building-block');
    $router->get('genplan/{block}/{floor}/')->uses('ApartmentController@getFloor')->name('block-floor');
    $router->get('genplan/{block}/{floor}/{apartment}/')->uses('ApartmentController@getApartment')->name('apartment');

    $router->get('apartment/{apartment}/')->uses('ApartmentController@detailApartment')->name('apartment-detail');
    $router->get('apartment/{apartment}/pdf')->uses('ApartmentController@detailApartmentPdf')->name('apartment-detail-pdf');
    $router->any('apartments')->uses('ApartmentController@apatrmentSelection')->name('apartment-selection');

    $router->get('interiors')->uses('PagesController@interiors')->name('interiors');
    $router->get('interiors/lobby')->uses('PagesController@lobby')->name('lobby');
    $router->get('interiors/stylistic-decisions')->uses('PagesController@design')->name('stylistic-decisions');
    $router->get('interiors/stylistic-decisions/whitemoon')->uses('PagesController@whitemoon')->name('whitemoon');
    $router->get('interiors/stylistic-decisions/easy')->uses('PagesController@easy')->name('easy');
    $router->get('interiors/stylistic-decisions/colorwater')->uses('PagesController@colorwater')->name('colorwater');


    $router->get('documents')->uses('PagesController@documents')->name('documents');
    $router->get('private-politics')->uses('PagesController@politics')->name('politics');
    $router->get('news')->uses('PagesController@news')->name('news');

    $router->get('sitemap.xml')->uses('SitemapController@index')->name('sitemap');
    // Images via glide
    Route::get('/' . config('glide.url_prefix') . '/{path}', 'ImagesController@index')->where('path', '.*');
});
