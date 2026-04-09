<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * Class GalleryController
 * @package App\Http\Controllers\Web
 */
class GalleryController extends Controller
{
    public function __invoke()
    {
        return view(
            'pages.gallery',
            [
                'pageTitle' => 'Галерея - ЖК Медный 3.14',
                'pageDescription' => 'Фотогалерея жилого комплекса Медный 3.14, Донская 14. Телефон отдела продаж: +7 (495) 023-78-37',
                'pageKeywords' => 'фото, галерея, жк медный 3.14, донская 14',
            ]
        );
    }

    public function facades()
    {
        return view(
            'pages.facades',
            [
                'pageTitle' => 'Фасады ЖК Медный 3.14',
                'pageDescription' => 'Представленные фасады в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'фасады, жк медный 3.14',
            ]
        );
    }

    public function views()
    {
        return view(
            'pages.views',
            [
                'pageTitle' => 'Виды ЖК Медный 3.14',
                'pageDescription' => 'Представленные виды в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'виды, жк медный 3.14',
            ]
        );
    }
}
