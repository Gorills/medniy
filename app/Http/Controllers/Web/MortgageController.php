<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * Class MortgageController
 * @package App\Http\Controllers\Web
 */
class MortgageController extends Controller
{
    public function calc()
    {
        return view(
            'pages.mortgage-calc',
            [
                'pageTitle' => 'Условия ипотеки для покупки квартиры в жилом комплексе Медный 3.14',
                'pageDescription' => 'Условия покупки квартиры в жилом комплексе Медный 3.14. в ипотеку у банков-партнеров. Ипотечный калькулятор',
                'pageKeywords' => 'ипотека, условия, купить квартиру, ипотечный калькулятор, жк медный 3.14',
            ]
        );
    }
}
