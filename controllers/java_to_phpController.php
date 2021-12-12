<?php
namespace App\Controllers;
use PDO;
use Exception;
require __DIR__."/../config/IpAddressConf.php";

class JavaApiController
{
	
	public function getNationalIdInfo($request,$response,$args){
	$myclass = new JavaApiController();
    $address= new ApiAddress();
    $domresponse=new ApiResponse();
    $nid =$request->getParam('nationalid');
	$urlservices=$address->Nidurl ."nationalid/".$nid;
	$response=$myclass->apiGet($urlservices);
	$checkresponse =json_decode($response);
if(array_key_exists('applicationNumber',(array)$checkresponse)){
	if ($checkresponse->applicationNumber != null) {
		$domresponse->status=200;
    $domresponse->body=$response;
	}else{
       $domresponse->status=301;
        $domresponse->body="Invalid National Id In the system of NIDA";
	}
}else{
	$domresponse->status=601;
    $domresponse->body="Server of Nida Not In the Service";
}
return  json_encode($domresponse);
}
public function reciveSms($request,$response,$args){
	$requestedData=json_decode($request->getBody());
	$myclass = new JavaApiController();
	$myclass->sendSms($requestedData);
}

public function api($urlservices,$data){
	// kvstore API url
$url = $urlservices;
// Collection object
// Initializes a new cURL session
$curl = curl_init($url);
// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// Set the CURLOPT_POST option to true for POST request
curl_setopt($curl, CURLOPT_POST, true);
// Set the request data as JSON using json_encode function
curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'Access-Control-Allow-Origin: *',
  'Access-Control-Allow-Credentials: true',
  'Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE,PUT'
]);

// Execute cURL request with all previous settings
$response = curl_exec($curl);
// Close cURL session
curl_close($curl);
return $response;
}
 public function apiGet($urlrequest){
$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, $urlrequest);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($cURLConnection);
curl_close($cURLConnection);

return $response;
 }

 public function sendSms($data){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://209.97.143.178:8080/RequestsDispatcherV2/RequestsHandler',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'CMD: 002',
    'Domain: 384601e6599c03443922dc81d3710106cf9d'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
 }

}


class ApiResponse
{
   public $status;
   public $body;
}

 ?>