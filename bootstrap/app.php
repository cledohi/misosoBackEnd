<?php
session_start();
ini_set('max_execution_time', '0'); 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require  __DIR__."/../vendor/autoload.php";

$app =new \Slim\App([
'settings'=>[
    'displayErrorDetails'=> true,
]
]);
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->get('/',function(Request $request, Response $response, $params){
return 'Welcome to cledohi Web services ';
});

$container=$app->getContainer();

$container['CleDoHiUserController']=function($container){
    return new \App\Controllers\CleDoHiUserController;
};
$container['ReportController']=function($container){
    return new \App\Controllers\ReportController;
};
$container['JavaApiController'] = function($container){
	return new \App\Controllers\JavaApiController;
};
$container['RSClients']=function($container){
    return new \App\Controllers\RSClients;
};
$container['VisitorsController']=function($container){
    return new \App\Controllers\VisitorsController;
};
$container['StripeController']=function($container){
    return new \App\Controllers\StripeController;
};
require __DIR__."/../routes/users.php";
require __DIR__."/../routes/javaroute.php";
require __DIR__."/../routes/rsclient.php";
require __DIR__."/../routes/visitors.php";
require __DIR__."/../routes/stripe.php";
?>