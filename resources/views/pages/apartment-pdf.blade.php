<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PDF</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="imagetoolbar" content="no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            font-family: 'circe', sans-serif;
        }

        .slide {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            page-break-inside: avoid;
            page-break-after: always;
            background-size: 100%;
        }

        .slide--last {
            page-break-after: avoid;
        }

        table {
            color: #c95520;
            font-size: 26px;
        }

        .td-top {
            width: 380px;
            height: 100px;
        }

        .td-first {
            padding-left: 70px;
            padding-right: 10px;
            width: 380px;
            height: 50px;
        }

        .td-bottom {
            width: 380px;
            height: 280px;
        }

        .plan {
            padding-top: 50px;
            padding-left: 50px;
            width: 600px;
        }
    </style>
</head>
<body>
@for ($i = 1; $i <= 7; $i++)
    @if ($i===6)
        <div class="slide"
             style="background-image:url({{$_SERVER['DOCUMENT_ROOT']}}/pdf/bg{{$i}}--{{$apartment->floor->block->number}}.jpg)">
            <table>
                <tr>
                    <td class="td-top">&nbsp;</td>
                    <td rowspan="7"><img class="plan" src="data:image/png;base64,{{ $apartment->imageBase64 }}"></td>

                </tr>
                <tr><td class="td-first"><span style="padding-bottom: 20px;">Корпус &mdash; {{ $apartment->floor->block->number }}</span></td></tr>
                <tr><td class="td-first"><span style="padding-bottom: 20px;">Этаж &mdash; {{ $apartment->floor->number }}</span></td></tr>
                <tr><td class="td-first"><span style="padding-bottom: 20px;">Квартира &mdash; {{ $apartment->number }}</span></td></tr>
                <tr><td class="td-first"><span style="padding-bottom: 20px;">Площадь &mdash; {{ $apartment->total_area }}  м²</span></td></tr>
                <tr><td class="td-first"><span style="padding-bottom: 20px;">Количество спален &mdash; {{ $apartment->rooms }}</span></td></tr>
                {{--<tr><td class="td-first"><span style="padding-bottom: 20px;">Цена &mdash; {{ number_format($apartment->price, 0, ',', ' ') }} руб.</span></td></tr>--}}
                <tr class="td-bottom"><td>&nbsp;</td></tr>
            </table>
        </div>
    @else
    <div class="slide
         @if($i===7) slide--last
@endif
            " style="background-image:url({{$_SERVER['DOCUMENT_ROOT']}}/pdf/bg{{$i}}.jpg)">
    </div>
        @endif
@endfor
</body>
</html>