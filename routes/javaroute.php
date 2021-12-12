<?php
use App\Controllers\CleDoHiUserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__."/../controllers/java_to_phpController.php";
$app->post("/nationalid",JavaApiController::class.':getNationalIdInfo');
$app->post("/sendsms",JavaApiController::class.':reciveSms');
