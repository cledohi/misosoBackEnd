<?php

use App\Controllers\CleDoHiUserController;


require __DIR__ . "/../controllers/cledohi_user_controller.php";
require __DIR__.'/../controllers/SearchController.php';
$app->post("/login", CleDoHiUserController::class . ':userLogin');
$app->post("/rs-create-user", CleDoHiUserController::class . ':AddNewRentalUser');
$app->post("/rs-alluser", CleDoHiUserController::class . ':getAllRentalusers');
$app->get("/provinces", CleDoHiUserController::class . ':getprovince');
$app->post("/districts", CleDoHiUserController::class . ':getDistrict');
$app->post("/sectors", CleDoHiUserController::class . ':getSector');
$app->post("/cells", CleDoHiUserController::class . ':getCell');
$app->post("/villages", CleDoHiUserController::class . ':getVillage');
$app->get("/agent-by-phone", CleDoHiUserController::class . ':getAgentByphone');
$app->post("/add-new-agent", CleDoHiUserController::class . ':addNewAgent');
$app->get("/all-agents", CleDoHiUserController::class . ':allAgents');
$app->post("/search-house",SearchController::class.':searchHouseByLocation');
$app->get("/address",SearchController::class.":addressInfo");