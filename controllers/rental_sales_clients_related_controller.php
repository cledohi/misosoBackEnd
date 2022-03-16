<?php
namespace App\Controllers;
use PDO;
use Exception;
use Slim\Http\UploadedFile;
class SignatureResponse{
  public $status;
  public $body;
}
class RSClients 
{
  public function internalPaymentTransaction($request,$response,$args){
      $input = json_decode($request->getBody());
      $startdate =$input->startdate;
      $enddate =$input->enddate;
      $productId =$input->productId;
      $BuyerId =$input->BuyerId;
      $month =$input->month;
      $paymentmode =$input->paymentmode;
      $chanel=$input->chanel;
      $sql="CALL buyTransactionProcedure(?,?,?,?,?,?,?)";
      $con = Db::cleDoHiDb("gkdujatf_misosodb");
      $sql=$con->prepare($sql);
      $sql->bindParam(1,$BuyerId);
      $sql->bindParam(2,$productId);
      $sql->bindParam(3,$chanel);
      $sql->bindParam(4,$paymentmode);
      $sql->bindParam(5,$startdate);
      $sql->bindParam(6,$enddate);
      $sql->bindParam(7,$month);
      $sql->execute();
      $rows= $sql->fetch(PDO::FETCH_OBJ);
      return json_encode($rows);
  }
  public function SignatureMembers($request,$response,$args){
    $resp = new RentalResponse();
    $input = json_decode($request->getBody());
    $clientId= $input->Id;
    $sql="SELECT * FROM clients_param WHERE clientid=?";
    $con = Db::cleDoHiDb("gkdujatf_misosodb");
    $sql=$con->prepare($sql);
    $sql->bindParam(1,$clientId);
    $sql->execute();
    if($sql->rowCount() > 0){
    $rows= $sql->fetchAll(PDO::FETCH_OBJ);
    $resp->status=200;
    $resp->body=$rows;
    return json_encode($resp);
    }else{
    $resp->status=300;
    $resp->body="No Relations";
    return json_encode($resp);
    }
  }
public function rsProducts($request,$response,$args){
$housedata = json_decode($request->getBody());
$datainput =$housedata->datainput;
$triggerinput = $housedata->triggerinput;
$actioninput  =$housedata->actioninput;
$currentId =$housedata->currentid;
$limitid  =$housedata->limitno;
$username=$housedata->username;
$sql="CALL loadAndCreatContractForHouseParteners(?,?,?,?,?,?)";
$con = Db::cleDoHiDb("gkdujatf_misosodb");
$sql= $con->prepare($sql);
$sql->bindParam(1,$datainput);
$sql->bindParam(2,$triggerinput);
$sql->bindParam(3,$actioninput);
$sql->bindParam(4,$currentId);
$sql->bindParam(5,$limitid);
$sql->bindParam(6,$username);
$sql->execute();
$rows = $sql->fetchAll(PDO::FETCH_OBJ);
return json_encode($rows);
}

  public function getAdminHouseInformation($request,$response,$args){
  
  $housedata = json_decode($request->getBody());
  $datainput =$housedata->datainput;
  $triggerinput = $housedata->triggerinput;
  $actioninput  =$housedata->actioninput;
  $currentId =$housedata->currentid;
  $limitid  =$housedata->limitno;
  $con = Db::cleDoHiDb("gkdujatf_misosodb");
  $sql = "CALL rs_loadHouseInforamtion(?,?,?,?,?)";
  $sql= $con->prepare($sql);
  $sql->bindParam(1,$datainput);
  $sql->bindParam(2,$triggerinput);
  $sql->bindParam(3,$actioninput);
  $sql->bindParam(4,$currentId);
  $sql->bindParam(5,$limitid);
  $sql->execute();
  $rows = $sql->fetchAll(PDO::FETCH_OBJ);
  return json_encode($rows);
  }
    public function getGalleryHouse($request ,$response,$args){
    $rs_response= new RentalResponse();
 try {
  $requestedData=json_decode($request->getBody());
  $houseid=$requestedData->houseId;
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql="SELECT  ID, HouseID, Photos FROM gkdujatf_misosodb.house_gallery  WHERE HouseID=?";
  $sql=$con->prepare($sql);
  $sql->bindParam(1,$houseid);
  $sql->execute();
  $row = $sql->fetchAll(PDO::FETCH_OBJ);
  $rs_response->status=200;
  $rs_response->body=$row;
  return json_encode($rs_response); 
    } catch (Exception $e) {
      return json_encode($e->getMessage());
    }   
  }

  public function HouseAdvertList($request ,$response,$args){
    $rs_response= new RentalResponse();
 try { 
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql="CALL houseAdvertProc();";
  $sql=$con->query($sql);
  $row = $sql->fetchAll(PDO::FETCH_OBJ);
  $rs_response->status=200;
  $rs_response->body=$row;
  return json_encode($rs_response); 
    } catch (Exception $e) {
      return json_encode($e->getMessage());
    }   
  }
  public function getRecentHouseList($request ,$response,$args){
    $rs_response= new RentalResponse();
 try {
  $requestedData=json_decode($request->getBody());
  $house=$requestedData->houseengine;
  $province=$house->province;
  $district=$house->district;
  $sector=$house->sector;
  $cell=$house->cell;
  $village=$house->village;
  $tvillage=$house->tvillage;
  $tprovince=$house->tprovince;
  $tdistrict=$house->tdistrict;
  $tsector=$house->tsector;
  $tcell=$house->tcell;
  $nextt=$house->next;
  $clientlast=$house->clientlast;
  $clientIdNo=$house->clientIdNo;
  $houseType= $house->houseType;
  //$house=json_encode($house);
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql="CALL DisPlayHouseOnHomePage(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
  $sql=$con->prepare($sql);
  $sql->bindParam(1,$province);
  $sql->bindParam(2,$district);
  $sql->bindParam(3,$sector);
  $sql->bindParam(4,$cell);
  $sql->bindParam(5,$village);
  $sql->bindParam(6,$tvillage);
  $sql->bindParam(7,$tprovince);
  $sql->bindParam(8,$tdistrict);
  $sql->bindParam(9,$tsector);
  $sql->bindParam(10,$tcell);
  $sql->bindParam(11,$nextt);
  $sql->bindParam(12,$clientlast);
  $sql->bindParam(13,$clientIdNo);
  $sql->bindParam(14,$houseType);
  $sql->execute();
  $row = $sql->fetchAll(PDO::FETCH_OBJ);
  $rs_response->status=200;
  $rs_response->body=$row;
  return json_encode($rs_response); 
    } catch (Exception $e) {
      return json_encode($e->getMessage());
    }   
  }
  public function moveUploadedFile(UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $directory ="/home2/gkdujatf/public_html/assets/uploads/houseImages";
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    return "https://www.misoso.rw/assets/uploads/houseImages" . DIRECTORY_SEPARATOR . $filename;
}
  public function createUpdateHouse($request ,$response,$args){
  $rs_response= new RentalResponse();
  try {
  $house= json_decode($request->getParam("housebean"));
  $uploadedFiles = $request->getUploadedFiles();
  $houseProfile  = $uploadedFiles["houseprofimg"];
  $imgfile=RSClients::moveUploadedFile($houseProfile);
  $creator=$house->creator;
  $HouseId=$house->HouseId; 
  $UPICode=$house->UPICode; 
  $NationalId=$house->NationalId; 
  $Phone=$house->Phone; 
  $Location_up_road=$house->Location_up_road; 
  $Location_Code_road=$house->Location_Code_road;
  $Location_static=$house->Location_static; 
  $Location_static_code=$house->Location_static_code; 
  $ProvinceCode=$house->ProvinceCode;  
  $ProvinceName=$house->ProvinceName;  
  $DistrictCode=$house->DistrictCode;  
  $DistrictName=$house->DistrictName;  
  $SectorCode=$house->SectorCode;  
  $SectorName=$house->SectorName;  
  $CellCode=$house->CellCode;  
  $CellName=$house->CellName;  
  $VillageCode=$house->VillageCode;  
  $VillageName=$house->VillageName;  
  $RentalAmount=$house->RentalAmount;  
  $SellingAmount=$house->SellingAmount;  
  $amatafari=$house->amatafari;  
  $amatafari_code=$house->amatafari_code;   
  $ibiri_munzu=$house->ibiri_munzu;   
  $ibiri_munzu_code=$house->ibiri_munzu_code;   
  $igisenge=$house->igisenge;   
  $igisenge_code=$house->igisenge_code;   
  $parking=$house->parking;   
  $parking_code=$house->parking_code;   
  $Description=$house->Description;     
  $RoomNo=$house->RoomNo;  
  $clientId=$house->clientId;
  $xlength=$house->xlength;
  $width=$house->width;
  $productType=$house->productType;
  $businessType = $house->businessType;
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql="CALL AddUpdateHouse(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@response)";
  $sql=$con->prepare($sql);
  $sql->bindParam(1,$creator);
  $sql->bindParam(2,$HouseId);
  $sql->bindParam(3,$UPICode);
  $sql->bindParam(4,$NationalId);
  $sql->bindParam(5,$Phone);
  $sql->bindParam(6,$Location_up_road);
  $sql->bindParam(7,$Location_Code_road);
  $sql->bindParam(8,$Location_static);
  $sql->bindParam(9,$Location_static_code);
  $sql->bindParam(10,$ProvinceCode);
  $sql->bindParam(11,$ProvinceName);
  $sql->bindParam(12,$DistrictCode);
  $sql->bindParam(13,$DistrictName);
  $sql->bindParam(14,$SectorCode);
  $sql->bindParam(15,$SectorName);
  $sql->bindParam(16,$CellCode);
  $sql->bindParam(17,$CellName);
  $sql->bindParam(18,$VillageCode);
  $sql->bindParam(19,$VillageName);
  $sql->bindParam(20,$RentalAmount);
  $sql->bindParam(21,$SellingAmount);
  $sql->bindParam(22,$amatafari);
  $sql->bindParam(23,$amatafari_code);
  $sql->bindParam(24,$ibiri_munzu);
  $sql->bindParam(25,$ibiri_munzu_code);
  $sql->bindParam(26,$igisenge);
  $sql->bindParam(27,$igisenge_code);
  $sql->bindParam(28,$parking);
  $sql->bindParam(29,$parking_code);
  $sql->bindParam(30,$Description);

  $sql->bindParam(31,$imgfile);
  $sql->bindParam(32,$RoomNo);
  $sql->bindParam(33,$clientId);
  $sql->bindParam(34,$xlength);
  $sql->bindParam(35,$width);
  $sql->bindParam(36,$productType);
  $sql->bindParam(37,$businessType);
  $sql->execute();
  $sql=$con->query("SELECT @response AS response");
  $row=$sql->fetch(PDO::FETCH_OBJ);
  $HouseId=$row->response;
  if ($HouseId > 0 && ($HouseId !== '1992_' || $HouseId !== '601_' )){
//if (sizeof($house_galery) > 0){
if($HouseId === '1992_' || $HouseId ==='601_'){
$rs_response->status="1992_601";
$rs_response->body="1992_601";
 return json_encode($rs_response); 
}else{
foreach ($uploadedFiles["houseimgs"] as $photo) {
  $sql1="CALL updateHouseGalery(?,?,@response)";
  $sql1=$con->prepare($sql1);
  $imgfileGallery=RSClients::moveUploadedFile($photo);
  $sql1->bindParam(1,$HouseId);
  $sql1->bindParam(2,$imgfileGallery);
  $sql1->execute();

}
$sql1=$con->query("SELECT @response AS response");
$row=$sql1->fetch(PDO::FETCH_OBJ);
$rs_response->status="200";
$rs_response->body=$row->response;  
return json_encode($rs_response); 
}
/*
}else{
 $rs_response->status="200";
 $rs_response->body="200";
 return json_encode($rs_response); 
}*/

  }else{
$rs_response->status="601";
$rs_response->body=$row->response;  
return json_encode($rs_response);
  }
} catch (Exception $e) {
$rs_response->status="602";
$rs_response->body=$e->getMessage();
return json_encode($rs_response); 
}


  }
	public function createUpdateClient($request ,$response,$args)
  {
    $rs_response= new RentalResponse();
    try {
$requestedData=json_decode($request->getBody());
$client=$requestedData->data->client;
//$client=json_encode($client);

  $fname=$client->fname;
  $clientid=$client->clientid;
  $codeTitle= $client->codeTitle;
  $lname= $client->lname;
  $idUnique=$client->idUnique;
  $phoneNo=$client->phoneNo;
  $yearbirth=$client->yearbirth; 
  $provincename=$client->provincename;
  $provincecode=$client->provincecode; 
  $districtname=$client->districtname;
  $districtcode=$client->districtcode; 
  $sectorname=$client->sectorname; 
  $sectorcode=$client->sectorcode; 
  $cellname=$client->cellname; 
  $cellcode=$client->cellcode;
  $villagename=$client->villagename; 
  $villagecode=$client->villagecode; 
  $email=$client->email; 
  $sex=$client->sex; 
  $sitFam=$client->sitFam; 
  $profile=$client->profile;
$clientparam=$requestedData->data->clientparam;
$con=Db::cleDoHiDb("gkdujatf_misosodb");
$sql="CALL AddUpdateclientsInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@response)";
$sql=$con->prepare($sql);
$sql->bindParam(1,$fname);
$sql->bindParam(2,$clientid);
$sql->bindParam(3,$codeTitle);
$sql->bindParam(4,$lname);
$sql->bindParam(5,$idUnique);
$sql->bindParam(6,$phoneNo);
$sql->bindParam(7,$yearbirth);
$sql->bindParam(8,$provincename);
$sql->bindParam(9,$provincecode);
$sql->bindParam(10,$districtname);
$sql->bindParam(11,$districtcode);
$sql->bindParam(12,$sectorname);
$sql->bindParam(13,$sectorcode);
$sql->bindParam(14,$cellname);
$sql->bindParam(15,$cellcode);
$sql->bindParam(16,$villagename);
$sql->bindParam(17,$villagecode);
$sql->bindParam(18,$email);
$sql->bindParam(19,$sex);
$sql->bindParam(20,$sitFam);
$sql->bindParam(21,$profile);
$sql->execute();
$sql=$con->query("SELECT @response AS response");
$row=$sql->fetch(PDO::FETCH_OBJ);
$clientid=$row->response;
if ($row->response >0) {
  if (sizeof($clientparam) > 0) {
      foreach ($clientparam as $paramobject) {
$client_parmID=$paramobject->client_parmID;
$codeTitle=$paramobject->codeTitle;
$fname=$paramobject->fname;
$lname=$paramobject->lname;
$phone=$paramobject->phone;
$Email=$paramobject->Email;
$NationalId=$paramobject->NationalId;
$profile=$paramobject->profile;
$param_type=$paramobject->param_type;
$yearbirth =$paramobject->yearbirth;
$sql1="CALL AddUpdateClientsParams(?,?,?,?,?,?,?,?,?,?,?,@response)";
$sql1=$con->prepare($sql1);
$sql1->bindParam(1,$client_parmID);
$sql1->bindParam(2,$codeTitle);
$sql1->bindParam(3,$fname);
$sql1->bindParam(4,$lname);
$sql1->bindParam(5,$phone);
$sql1->bindParam(6,$Email);
$sql1->bindParam(7,$NationalId);
$sql1->bindParam(8,$profile);
$sql1->bindParam(9,$param_type);
$sql1->bindParam(10,$yearbirth);
$sql1->bindParam(11,$clientid);
if ($clientid==="16_" || $clientid==="12_") {
  # code...
}else{
$sql1->execute();
}
  }
$sql1=$con->query("SELECT @response AS response");
$row=$sql1->fetch(PDO::FETCH_OBJ);
$rs_response->status="200";
$rs_response->body=$row->response;  
return json_encode($rs_response); 
  }else{
$rs_response->status="200";
$rs_response->body="200";
return json_encode($rs_response);
  }
}else{
$rs_response->status="601";
$rs_response->body=$row->response;  
return json_encode($rs_response);
}
} catch (Exception $e) {
$rs_response->status="602";
$rs_response->body=$e->getMessage();
return json_encode($rs_response); 
    }
  }

//to get system clients 
public function getClientsInfo($request ,$response,$args){
try {
	$clientrequest=json_decode($request->getBody());
    $response=$clientrequest->data;	
    $trigger= $response->trigger;
    $clientIdNo=$response->clientIdNo;
    $clientlast=100; 
	$con=Db::cleDoHiDb("gkdujatf_misosodb");
	$sql="CALL rs_getClients(?,?,?)";
    $sql =$con->prepare($sql);
    $sql->bindParam(1,$trigger);
    $sql->bindParam(2,$clientIdNo);
    $sql->bindParam(3,$clientlast);
    $sql->execute();
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $response->status =200;
          $response->body =$row;
          return json_encode($response);
        }else{
          $response->status =301;
          $response->body ="No Data Found";
          return json_encode($response);
        }
	} catch (Exception $e) {
		
	}	
}

public function getClientByPhoneORNationalId($request ,$response,$args)
{
	$resp=new RentalResponse();
	try {
	 $nationalid=$request->getParam("nationalidSearch");
     $phone=$request->getParam("phone");
     $trigger =$request->getParam('trigger');
	$con=Db::cleDoHiDb("gkdujatf_misosodb");
	$sql="CALL rs_getClientByPhoneORNationalId(?,?)";
    $sql =$con->prepare($sql);
    if($trigger === 'cl_tr'){
    $sql->bindParam(1,$nationalid);
    $sql->bindParam(2,$phone);
  }else if($trigger === 'house_tr'){
    $sql->bindParam(1,$phone);
    $sql->bindParam(2,$phone);
  }
    $sql->execute();
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
  }
	catch (Exception $e) {
		$resp->status =601;
          $resp->body =$e->getMessage();
            return json_encode($resp);
	}	
}
public function getClientRelatedInfo($request ,$response,$args){
	$resp=new RentalResponse();
	try {
	$clientrequest=json_decode($request->getBody());
     $clientid=$clientrequest->data->clientid;	
	$sql="CALL rs_clientRelatedInfo(?)";	
	$con=Db::cleDoHiDb("gkdujatf_misosodb");
	$sql =$con->prepare($sql);
    $sql->bindParam(1,$clientid);
    $sql->execute();
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
	} catch (Exception $e) {
	$resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);	
	}
}

public function ahoInzuIriUturutseKumuhanda($request ,$response,$args){
$resp=new RentalResponse();
	try {
	$con=Db::cleDoHiDb("gkdujatf_misosodb");
	$sql =$con->query("SELECT * FROM rs_aho_inzu_iherereye");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
	} catch (Exception $e) {
	$resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);	
	}	
}
public function ahoInzuYubantseNibaAriMugipangu(){
	$resp=new RentalResponse();
	try {
	$con=Db::cleDoHiDb("gkdujatf_misosodb");
	$sql =$con->query("SELECT * FROM rs_aho_inzu_iri");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
	} catch (Exception $e) {
	$resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);	
	}	

}
public function Amatafari(){
  $resp=new RentalResponse();
  try {
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql =$con->query("SELECT * FROM rs_amatafari");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
  } catch (Exception $e) {
  $resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);  
  } 

}
public function ibirimunzu(){
  $resp=new RentalResponse();
  try {
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql =$con->query("SELECT * FROM rs_ibiri_munzu");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
  } catch (Exception $e) {
  $resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);  
  } 

}
public function parking(){
  $resp=new RentalResponse();
  try {
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql =$con->query("SELECT * FROM rs_parking ");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
  } catch (Exception $e) {
  $resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);  
  } 

}
public function igisenge(){
  $resp=new RentalResponse();
  try {
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql =$con->query("SELECT * FROM rs_igisenge");
       if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $resp->status =200;
          $resp->body =$row;
          return json_encode($resp);
        }else{
          $resp->status =301;
          $resp->body ="No Data Found";
          return json_encode($resp);
        }
  } catch (Exception $e) {
  $resp->status =601;
    $resp->body =$e->getMessage();
    return json_encode($resp);  
  } 

}
}


class RentalResponse
{
	public $status;
	public $body;
}
?>