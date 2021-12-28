<?php
namespace App\Controllers;
use PDO;
use Slim\Http\UploadedFile;
use Exception;
require __DIR__."/../config/db.php";
class CleDoHiUserController
{
    public function userLogin($request, $response, $args)
    {

        $resp=new MyResponse();
     //   $con;

        try {
            $username=$request->getParam("username");
            $password=$request->getParam("password");
           // $password=md5($password);
            $systemtype=$request->getParam("systemType");
          //  if($systemtype ==='Admin'){
          //    $con=Db::cleDoHiDb("cledohiadmindb");
          //  }else if($systemtype=='Rental_Sales'){
            $con=Db::cleDoHiDb("gkdujatf_misosodb");
         //   }          
            $sql="SELECT * FROM users where (username=? or phone=? or NationalId=? OR Email=?) and Password=?";
            $sql=$con->prepare($sql);
            $sql->bindParam(1, $username);
            $sql->bindParam(2, $username);
            $sql->bindParam(3, $username);
            $sql->bindParam(4, $username);
            $sql->bindParam(5, $password);
            $sql->execute();
            if ($sql->rowCount()> 0) {
                $row=$sql->fetchAll(PDO::FETCH_OBJ);
                # session_start();
                $resp->status=201;
                $resp->body=$row;
                $_SESSION['users']=$resp;
                return json_encode($_SESSION['users']);
            }else{
                $resp->status=301;
                $resp->body="No Data Found to the system";
                return json_encode($resp);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $resp->status=601;
            $resp->body=$th->getMessage();;
            return json_encode($resp);
        }
    }
    public function moveUploadedFile(UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $directory ="/home2/gkdujatf/public_html/assets/uploads/userProfiles";
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return "https://www.misoso.rw/assets/uploads/userProfiles" . DIRECTORY_SEPARATOR . $filename;
    }
    public function allAgents($request , $response,$args){
      $resp=new MyResponse();
      try{
        
        $con=Db::cleDoHiDb("gkdujatf_misosodb");
        $sql="SELECT * FROM agents ORDER BY agents.id desc";
        $sql=$con->query($sql);
            $rows=$sql->fetchAll(PDO::FETCH_OBJ); 
            if($sql->rowCount()> 0){
              $resp->status=200;
              $resp->body=$rows;
            }else{
              $resp->status=404;
              $resp->body=$rows;
            }          
        return json_encode($resp);
      }catch(Exception $e){
        $resp->status=500;
        $resp->body=$e->getMessage();
        return json_encode($resp);   
      }
    }
    public function addNewAgent($request , $response,$args){
      $resp=new MyResponse();
      try{
        $reqData= json_decode($request->getBody());
        $aboutme=$reqData->aboutme;
        $dobplace=$reqData->placeOfBirth;
        $workplace=$reqData->placeOfWork;
        $userid=$aboutme->UserId;
        $documentno=$aboutme->NationalId;
        $phone=$aboutme->phone;
        $fullnames=$aboutme->Names;
        $workprovince=$workplace->provincename;
        $workdistrict=$workplace->districtname;
        $worksector=$workplace->sectorname;
        $workcell=$workplace->cellname;
        $dobprovince=$dobplace->provincename;
        $dobdistrict=$dobplace->districtname;
        $dobsector=$dobplace->sectorname;
        $dobcell=$dobplace->cellname;
        $dobvillage=$dobplace->villagename;
        $education="A2";
        $con=Db::cleDoHiDb("gkdujatf_misosodb");
        $sql="call creatNewAgent(?,?,?,?,?,?,?,?,?,?,?, ?, ?, ?)";
        $sql=$con->prepare($sql);
            $sql->bindParam(1, $userid);
            $sql->bindParam(2, $documentno);
            $sql->bindParam(3, $phone);
            $sql->bindParam(4, $fullnames);
            $sql->bindParam(5, $workprovince);
            $sql->bindParam(6, $workdistrict);
            $sql->bindParam(7, $worksector);
            $sql->bindParam(8, $workcell);
            $sql->bindParam(9, $dobprovince);
            $sql->bindParam(10, $dobdistrict);
            $sql->bindParam(11, $dobsector);
            $sql->bindParam(12, $dobcell);
            $sql->bindParam(13, $dobvillage);
            $sql->bindParam(14, $education);
            $sql->execute();
            $row=$sql->fetch(PDO::FETCH_OBJ);
           
            if($sql->rowCount()> 0){
              $resp->status=200;
              $resp->body=$row;
            }else{
              $resp->status=300;
              $resp->body=$row;
            }
               
        return json_encode($resp);
      }catch(Exception $e){
        $resp->status=500;
        $resp->body=$e->getMessage();
        return json_encode($resp);   
      }
    }
    public function getAgentByphone($request, $response, $args){
      $sql="call getAgentByPhone(?)";
      $resp=new MyResponse();
      try{
$phone=$request->getParam("phone");
$db=Db::cleDoHiDb("gkdujatf_misosodb");
$sql=$db->prepare($sql);
$sql->bindParam(1,$phone);
$sql->execute();
if($sql->rowCount()>0){
  $row=$sql->fetch(PDO::FETCH_OBJ);
  $resp->status=200;
  $resp->body=$row;
  return json_encode($resp);
}else{
  $row=$sql->fetch(PDO::FETCH_OBJ);
  $resp->status=403;
  $resp->body="No Content Found";
  return json_encode($resp);
}

      }catch(Exception $e){
        $resp->status=501;
        $resp->body=$e->getMessage();
        return json_encode($resp);   
      }
    }
    public function AddNewRentalUser($request, $response, $args){
      $resp=new MyResponse();
      try {
        $requestedData= json_decode($request->getParam("userbean"));
        $uploadedFiles = $request->getUploadedFiles();
        $userProfile  = $uploadedFiles["userprofimg"];
        $imgfile=CleDoHiUserController::moveUploadedFile($userProfile);
        $details= $requestedData->detail;
        $authentication=$requestedData->authentication;
        $photo=$requestedData->photo;
        $fname=$details->fname;
        $userid=$details->userid;
        $lname=$details->lname;
        $names=$fname." ".$lname;
        $email=$details->email;
        $phone=$details->phone;
        $systemtype=$details->systemtype;
        $nationalId=$authentication->nationalId;
        $username=$authentication->username;
        $password=$authentication->password;
        $profile=$photo->profile;
        $userType=$authentication->userType;
        $con=Db::cleDoHiDb("gkdujatf_misosodb");
        $sql="CALL updateUsers(?,?,?,?,?,?,?, @output,?,?)";
            $sql=$con->prepare($sql);
            $sql->bindParam(2, $names);
            $sql->bindParam(3, $password);
            $sql->bindParam(4, $userType);
            $sql->bindParam(5, $phone);
            $sql->bindParam(6, $email);
            $sql->bindParam(7, $nationalId);
            $sql->bindParam(8, $username);
            $sql->bindParam(9, $imgfile);
            $sql->bindParam(1, $userid);
            $sql->execute();
            $sql=$con->query("SELECT @output AS response");
                $row=$sql->fetch(PDO::FETCH_OBJ);
                $resp->status=200;
                $resp->body=$row->response;
                return json_encode($resp);
      } catch (Exception $e) {
        $resp->status=601;
        $resp->body=$e->getMessage();
        return json_encode($resp);
      }
    }
public function getAllRentalusers($request, $response, $args){
     $resp=new MyResponse();
     $systemtype=json_decode($request->getBody());

  try {
     $sql="SELECT `UserId`, `Names`, `username`, `Password`, `userType`, `phone`, `Email`, `NationalId`, `profile_str`, `created` FROM `users` WHERE 1 ORDER BY UserId DESC";
    $db=Db::cleDoHiDb("gkdujatf_misosodb");
    $sql= $db->query($sql);
    $row = $sql->fetchAll(PDO::FETCH_OBJ);
    $resp->status=200;
     $resp->body=$row;
    return json_encode($resp);
  } catch (Exception $e) {
     $resp->status=601;
     $resp->body=$e->getMessage();;
     return json_encode($resp);
  }
}
public function getprovince(){
    $response =new MyResponse();
    try {
        $sql="SELECT DISTINCT  vlg.provinceId as vcode, vlg.provinceName as vname FROM villages_du_rwanda AS vlg";
      $db=Db::cleDoHiDb("gkdujatf_misosodb");
        $sql=$db->query($sql);
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
       $response->status =301;
          $response->body =$e->getMessage();
          return json_encode($response); 
    }
}

public function getDistrict($request, $response, $args){
        $responsedata =new MyResponse();
        try {
        $province=$request->getParam("provincecode");
        $sql="SELECT DISTINCT vlg.districtId as vcode,vlg.districtName as vname FROM villages_du_rwanda AS vlg WHERE vlg.provinceId=:provinceid";
        $db=Db::cleDoHiDb("gkdujatf_misosodb"); 
        $sql =$db->prepare($sql);
        $sql->bindParam("provinceid",$province);
        $sql->execute();
        if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $responsedata->status =200;
          $responsedata->body = $row;
          return json_encode($responsedata);
        }else{
          $responsedata->status =301;
          $responsedata->body ="No Data Found";
          return json_encode($responsedata);
        }
    } catch (Exception $e) {
       $responsedata->status =301;
       $responsedata->body =$e->getMessage();
       return json_encode($responsedata); 
    }
}
public function getSector($request, $response, $args){
    $responsex =new MyResponse();
    try {
         $province=$request->getParam("districtcode");
         $sql="SELECT DISTINCT vlg.secteurId as vcode,vlg.secteurName as vname FROM villages_du_rwanda AS vlg WHERE vlg.districtId=:district";
          $db=Db::cleDoHiDb("gkdujatf_misosodb");
        $sql =$db->prepare($sql);
        $sql->bindParam("district",$province);
        $sql->execute();
        if ($sql->rowCount() > 0) {
          $row=$sql->fetchAll(PDO::FETCH_OBJ);
          $responsex->status =200;
          $responsex->body =$row;
          return json_encode($responsex);
        }else{
          $responsex->status =301;
          $responsex->body ="No Data Found";
          return json_encode($response);
        }

    } catch (Exception $e) {
       $responsex->status =301;
       $responsex->body =$e->getMessage();
          return json_encode($response); 
    }
}
public function getCell($request, $responsedata, $args){
    $response =new MyResponse();
    try {
        $sql="SELECT DISTINCT vlg.celluleId as vcode,vlg.cellName as vname FROM villages_du_rwanda AS vlg WHERE vlg.secteurId=:sector";
          $db=Db::cleDoHiDb("gkdujatf_misosodb");  
        $sectors=$request->getParam("sectorcode");
        $sql =$db->prepare($sql);
        $sql->bindParam("sector",$sectors);
        $sql->execute();
        if ($sql->rowCount() > 0) {
          $row = $sql->fetchAll(PDO::FETCH_OBJ);
          $response->status=200;
          $response->body=$row;
          return json_encode($response);
        }else{
          $response->status =301;
          $response->body ="No Data Found";
          return json_encode($response);
        }

    } catch (Exception $e) {
       $response->status =301;
          $response->body =$e->getMessage();
          return json_encode($response); 
    }
}
public function getVillage($request, $responsedata, $args){
    $response =new MyResponse();
    try {
        $sql="SELECT DISTINCT vlg.villageId as vcode,vlg.villageName as vname FROM villages_du_rwanda AS vlg WHERE vlg.celluleId=:cell";
        $db=Db::cleDoHiDb("gkdujatf_misosodb");
        $cells=$request->getParam("cellcode");
        $sql=$db->prepare($sql);
        $sql->bindParam('cell',$cells);
        $sql->execute();
        if ($sql->rowCount() > 0) {
          $row=$sql->fetchAll(PDO::FETCH_OBJ);
          $response->status=200;
          $response->body=$row;
          return json_encode($response);
        }else{
          $response->status =301;
          $response->body ="No Data Found";
          return json_encode($response);
        }

    } catch (Exception $e) {
       $response->status =301;
          $response->body =$e->getMessage();
          return json_encode($response); 
    }
}
    
}
class MyResponse
{
    public $status;
    public $body;
}
