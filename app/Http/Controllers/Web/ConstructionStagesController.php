<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConstructionStage;
use App\FormatDate;
use Carbon\Carbon;

/**
 * Class ConstructionStagesController
 *
 * @package App\Http\Controllers
 */
class ConstructionStagesController extends Controller
{
    public function getStagesList()
    {
        $stages = ConstructionStage::where('active', true)
            ->orderBy('id', 'desc')
            ->get();

        $grouped = $stages->groupBy(
            function ($item, $key) {
                return FormatDate::formatDate($item['created_at']->format("F Y"));
            }
        );

        $description ='Ход строительства домов нового жилого комплекса Медный 3.14 на ул. Донская, 14, рядом с м Шаболовская. Узнать больше о строительстве ЖК в отделе продаж: +7 (495) 023-78-37';
        $keywords = 'строительство дома, ход строительства, жк медный, медный 3.14, донская';
        return view(
            'pages.construction-stages',
            [
                'stages' => $grouped,
                'pageTitle' => 'Ход строительства ЖК Медный 3.14 на Донской, 14',
                'pageKeywords' =>$keywords,
                'pageDescription' => $description,
            ]
        );
    }

    public function detail($date)
    {
        $stages = ConstructionStage::where('active', true)
            ->whereMonth('created_at', '=', FormatDate::getMonth($date))
            ->whereYear('created_at', '=', FormatDate::getYear($date))
            ->orderBy('id', 'desc')
            ->get();

        if ($stages->isEmpty()) {
            abort('404');
        }
        $h1 = FormatDate::formatDate($stages->first()->created_at->format("F Y"));
        $title = $h1 . ' - Этапы строительства жилого комплекса Медный 3.14';
        $description = $h1 . ' - этапы строительство нового жилого комплекса Медный 3.14 на ул. Донской, 14. Отдел продаж: +7 (495) 023-78-37';
        $keywords = 'ход строительства, этапы, жк медный 3.14, донская 14, москва, шаболовка, шаболовская, донской район';

        return view(
            'pages.construction-stage-detail',
            [
                'stages' => $stages,
                'pageTitle' => $title,
                'pageKeywords' =>$keywords,
                'pageDescription' => $description,
            ]
        );
    }
}
