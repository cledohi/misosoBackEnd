<?php
use App\Controllers\VisitorsController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__."/../controllers/visitor_controller.php";
$app->post("/createnewvisitor",VisitorsController::class.':createVisitor');
$app->get("/allvisitors",VisitorsController::class.':getAllVisitors');
$app->post("/visitordetails",VisitorsController::class.':getvisitorDetailsInfo');
$app->post("/pgallery",VisitorsController::class.':productGallery');

?>