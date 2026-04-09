<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller,
    Validator;

class FormsController extends Controller
{
    public function addComagicUser()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'name' => 'required|string',
                'phone' => 'required|regex:/^\+\d \( \d{3} \) \d{3}-\d{2}-\d{2}$/',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'validation failed',
                    'success' => false,
                    'errors' => $validator->getMessageBag()
                ],
                422
            );

        }

        return response()->json(
            [
                'message' => 'Success request',
                'success' => true
            ],
            200
        );

        dump(request()->all());
        dump(request()->input('name'));
        dump(request()->input('phone'));

//        $requestParams = [
//            "jsonrpc" => "2.0",
//            "id" => "gafsvgdasdlkas2asdasd1oi32nwm",
//            "method" => "login.user",
//            'params' => [
//                'login' => 'ivv@kodix.rua',
//                'password' => '83PCDiNX'
//            ]
//        ];

    }
}
