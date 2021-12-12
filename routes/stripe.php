<?php
use App\Controllers\CleDoHiUserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__."/../controllers/stripe-controller.php";
$app->get("/stripe",StripeController::class.':stripepay');

