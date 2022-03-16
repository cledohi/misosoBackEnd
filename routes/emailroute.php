<?php
use App\Controllers\CleDoHiUserController;
use App\Controllers\EmailController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__."/../controllers/email.php";
$app->get("/send-email",EmailController::class.':sendEmail');