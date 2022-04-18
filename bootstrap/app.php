<?php
session_start();
ini_set('max_execution_time', '0');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use  \Illuminate\Database\Capsule\Manager;
use App\Controllers\GlobalResponse;
require __DIR__ . "/../vendor/autoload.php";
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        "determineRouteBeforeAppMiddleware" => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'gkdujatf_misosodb',
            'username' => 'gkdujatf_cledohi',
            'password' => 'P.C@*wqy]-4Q',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],
]);
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->add(function($request, $response, $next) {
    $route = $request->getAttribute("route");

    $methods = [];

    if (!empty($route)) {
        $pattern = $route->getPattern();

        foreach ($this->router->getRoutes() as $route) {
            if ($pattern === $route->getPattern()) {
                $methods = array_merge_recursive($methods, $route->getMethods());
            }
        }
        //Methods holds all of the HTTP Verbs that a particular route handles.
    } else {
        $methods[] = $request->getMethod();
    }

    $response = $next($request, $response);


    return $response->withHeader("Access-Control-Allow-Methods", implode(",", $methods));
});
$app->get('/', function (Request $request, Response $response, $params) {
    return 'Welcome to Misoso Ltd Web services ';
});
$container = $app->getContainer();

$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        //Format of exception to return
        $responseError=new GlobalResponse();
        $responseError->status=500;
        $responseError->message="System Error";
        $responseError->body=$exception->getMessage();
        return $container->get('response')->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($responseError));
    };
};


$container['notAllowedHandler'] = function ($c) {
    $responseError = new GlobalResponse();
    $responseError->status = 405;
    $responseError->message = 'Method not Allowed ' ;
    $responseError->body ="method not allowed use another one";
    return function ($request, $response, $methods) use ($responseError, $c) {
        return $response->withStatus(405)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($responseError));
    };
};
$container['validator'] = function () {
    return new Awurth\SlimValidation\Validator();
};
$container['CleDoHiUserController'] = function ($container) {
    return new \App\Controllers\CleDoHiUserController;
};
$container['MisosoContract'] = function ($container) {
    return new \App\Controllers\MisosoContract;
};
$container['EmailController'] = function ($container) {
    return new \App\Controllers\EmailController;
};
$container['JavaApiController'] = function ($container) {
    return new \App\Controllers\JavaApiController;
};
$container['RSClients'] = function ($container) {
    return new \App\Controllers\RSClients;
};
$container['VisitorsController'] = function ($container) {
    return new \App\Controllers\VisitorsController;
};
$container['StripeController'] = function ($container) {
    return new \App\Controllers\StripeController;
};
$container['SearchController'] = function ($c) {
    $validate=$c->get('validator');
    $house = $c->get('db')->table("house");
    $villages=$c->get('db')->table("villages_du_rwanda");
    return new \App\Controllers\SearchController($house,$villages ,$validate);
};
require __DIR__ . "/../routes/users.php";
require __DIR__ . "/../routes/javaroute.php";
require __DIR__ . "/../routes/rsclient.php";
require __DIR__ . "/../routes/visitors.php";
require __DIR__ . "/../routes/stripe.php";
require __DIR__ . "/../routes/contract.php";
require __DIR__ . "/../routes/emailroute.php";
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
?>