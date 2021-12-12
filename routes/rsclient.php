<?php 
use App\Controllers\CleDoHiUserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__."/../controllers/rental_sales_clients_related_controller.php";
$app->post("/rs-addup-client",RSClients::class.':createUpdateClient');
$app->post("/rs-clients",RSClients::class.':getClientsInfo');
$app->post("/rs-clients-ph-na",RSClients::class.':getClientByPhoneORNationalId');
$app->post("/rsclientsrl",RSClients::class.':getClientRelatedInfo');
$app->get("/rsuturutsekumuhanda",RSClients::class.':ahoInzuIriUturutseKumuhanda');
$app->get("/rsifiteigipangu",RSClients::class.':ahoInzuYubantseNibaAriMugipangu');
$app->get("/amatafari",RSClients::class.':Amatafari');
$app->get("/ibirimunzu",RSClients::class.':ibirimunzu');
$app->get("/parking",RSClients::class.':parking');
$app->get("/igisenge",RSClients::class.':igisenge');
$app->post("/uploadHouse", RSClients::class.':createUpdateHouse');
$app->post("/recenthouse", RSClients::class.':getRecentHouseList');
$app->get("/adverthouse", RSClients::class.':HouseAdvertList');
$app->post("/gallery", RSClients::class.':getGalleryHouse');
$app->post("/adm-house-info", RSClients::class.':getAdminHouseInformation');
$app->post("/product-contract", RSClients::class.':rsProducts');
$app->post("/signature-member", RSClients::class.':SignatureMembers');
$app->post("/transactionbuyint",RSClients::class.':internalPaymentTransaction');
?>