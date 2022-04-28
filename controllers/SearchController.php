<?php

namespace App\Controllers;

use Awurth\SlimValidation\Validator;
use Illuminate\Database\Query\Builder;
use PDO;
use Slim\Http\UploadedFile;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as V;

require __DIR__ . "/../config/GlobalResponse.php";
require __DIR__ . "/../validationerrors/ValidateMisoso.php";

class SearchController
{

    private $house;
    private $villages;
    private $validator;

    public function __construct(Builder $house, Builder $villages, $validate)
    {
        $this->house = $house;
        $this->validator = $validate;
        $this->villages = $villages;
    }


    public function searchHouseByLocation(Request $request, Response $response)
    {
        $validateError = new ValidateMisoso();
        $responsebean = new GlobalResponse();
        $validate = $validateError->isReqSearchHouseValid($request, $this->validator);
        $isValid = $validate->isValid();
        $parsedBody = $request->getParsedBody();
        if ($isValid) {
                $houses = $this->house
                    ->where('DistrictCode', $parsedBody['addCode'],)
                    ->where('businessType', $parsedBody['prodCode'])->get();
            if (sizeof($houses) > 0) {
                $responsebean->status = 200;
                $responsebean->message = "success";
                $responsebean->body = $houses;
                $response = $response->withStatus(200)
                    ->write(json_encode($responsebean));
            } else {
                $responsebean->status = 403;
                $responsebean->message = "No content";
                $responsebean->body = [];
                $response = $response->withStatus(403)
                    ->write(json_encode($responsebean));
            }
        } else {
            $errors = $validate->getErrors();
            $responsebean->status = 400;
            $responsebean->message = "bad request";
            $responsebean->body = $errors;
            $response = $response->withStatus(400)
                ->write(json_encode($parsedBody));
        }
        return $response;
    }

    public function addressInfo(Request $request, Response $response)
    {
        $responsebean = new GlobalResponse();
        $address = $this->villages-> groupBy("districtId")->get(["districtId","districtName"]);
        $responsebean->status = 200;
        $responsebean->message = "Success";
        $responsebean->body = $address;
        $response = $response->withStatus(200)
            ->write(json_encode($responsebean));
        return $response;
    }
}
