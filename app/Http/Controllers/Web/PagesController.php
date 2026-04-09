<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;

/**
 * Class PagesController
 * @package App\Http\Controllers
 */
class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts()
    {
        return view(
            'pages.contacts',
            [
                'pageTitle' => 'Офис продаж Медный 3.14 в Москве, контакты',
                'pageDescription' => 'Адрес, телефон и часы работы офиса продаж ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'контакты, офис продаж, жк медный 3.14, донская 14, шаболовка, москва',
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function documents()
    {
        return view(
            'pages.docs',
            [
                'pageTitle' => 'Документы - ЖК Медный 3.14',
                'pageDescription' => 'Документы ЖК Медный 3.14. Новостройки рядом с м Шаболовская, Донской район. Отдел продаж: +7 (495) 023-78-37',
                'pageKeywords' => 'документы, жилой комплекс, жк медный 3.14, новостройка, донской район, шаболовка, москва',
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function politics()
    {
        return view(
            'pages.politics',
            [
                'pageTitle' => 'Политика в отношении обработки персональных данных - ЖК Медный 3.14',
                'pageDescription' => 'Политика в отношении обработки персональных данных',
                'pageKeywords' => 'персональные данные, обработка, политика',
            ]
        );
    }

    public function news()
    {
        $news = News::query()->where('active', 1)
            ->where('active_from', '<=', (new Carbon()))
            ->orderByDesc('active_from')
            ->get();

        return view(
            'pages.news',
            [
                'news' => $news,
                'pageTitle' => 'Новости ЖК Медный 3.14',
                'pageDescription' => 'Новости жилого комплекса Медный 3.14 и компании Capital Group',
                'pageKeywords' => 'новости, жк медный 3.14',
            ]
        );
    }

    public function interiors()
    {
        return view(
            'pages.interiors',
            [
                'pageTitle' => 'Интерьеры ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }

    public function lobby()
    {
        return view(
            'pages.lobby',
            [
                'pageTitle' => 'Лобби ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }

    public function design()
    {
        return view(
            'pages.stylistic-decisions',
            [
                'pageTitle' => 'Стилевые решения ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }

    public function whitemoon()
    {
        return view(
            'pages.whitemoon',
            [
                'pageTitle' => 'Whitemoon ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }

    public function easy()
    {
        return view(
            'pages.easy',
            [
                'pageTitle' => 'Easy ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }

    public function colorwater()
    {
        return view(
            'pages.colorwater',
            [
                'pageTitle' => 'Colorwater ЖК Медный 3.14',
                'pageDescription' => 'Представленные интерьеры в ЖК Медный 3.14 в Москве',
                'pageKeywords' => 'интерьеры, жк медный 3.14',
            ]
        );
    }
}
