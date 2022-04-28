<?php
namespace App\Controllers;
use Respect\Validation\Validator as V;

class ValidateMisoso
{
public function isReqSearchHouseValid( $request,$validator){
    return $validator->validate($request, [
        'addCode' => [
            'rules' => V::notBlank()->noWhitespace(),
            'messages' => [
                'notBlank' => 'address code is required'
            ]
        ],
        'prodCode' => [
            'rules' => V::notBlank()->noWhitespace(),
            'messages' => [
                'notBlank' => 'product code is required'
            ]
        ]

    ]);
}
}