<?php 
namespace App\Controllers;
use PDO;
use Exception;
class VisitorsController
{
    public function createVisitor($request, $response, $args){
    $requestedData=json_decode($request->getBody());
     $names=$requestedData->names;
    $phone=$requestedData->phone; 
    $visitingDate=$requestedData->visitingdate;  
    $houseId=$requestedData->houseId;
	  $con=Db::cleDoHiDb("gkdujatf_misosodb");
          $sql="CALL createnewVisitors(?,?,?,?)";
          $sql= $con->prepare($sql);
          $sql->bindParam(1,$names);
          $sql->bindParam(2,$phone);
          $sql->bindParam(3,$visitingDate);
          $sql->bindParam(4,$houseId);
          $sql->execute();
          $row= $sql->fetch(PDO::FETCH_OBJ);
          return json_encode($row);
    }
    public function getAllVisitors($request,$response,$args)
    {
$sql='SELECT h.RoomNo,v.UnitePrice AS visityprice,v.TatalPrice AS totalprice,v.VisitedTimes AS noTimes,v.created AS lastvisite, h.HouseId AS houseid,h.UPICode AS upi,CONCAT( c.fname," ", c.lname) AS ownerNames, h.NationalId AS ownerNid, h.Phone AS ownerphone,h.Location_up_road AS nearroad,h.Location_static AS inhouse,h.ProvinceName AS province,h.DistrictName AS district,h.SectorName AS sector,h.CellName AS cell,
  h.VillageName AS village,h.businessType AS bussiness,h.RentalAmount AS rentalprice,h.SellingAmount AS sellprice,h.HousePhoto AS picture FROM visited AS v 
INNER JOIN house AS h  ON h.HouseId=v.HouseId
INNER JOIN clients AS c ON h.Phone=c.phoneNo';
$con=Db::cleDoHiDb("gkdujatf_misosodb");
$sql=$con->query($sql);
$rows=$sql->fetchAll(PDO::FETCH_OBJ);
return json_encode($rows);
}
public function getvisitorDetailsInfo($request,$response,$args)
{
  $vresp = new VisitorDetailResponse();
  $requestedData=json_decode($request->getBody());
  $houseid=$requestedData->houseid;
  $sql="SELECT b.Names,b.NationalId,b.Phone, vd.Price,vd.BuyerId,vd.PaymentMode, vd.Agent_incharge,vd.Paid, vd.visitingDate,vd.created FROM visite_details AS vd INNER JOIN buyer AS b ON b.BuyerId=vd.BuyerId WHERE vd.HouseId=?";
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql=$con->prepare($sql);
  $sql->bindParam(1,$houseid);
  $sql->execute();
  $rows=$sql->fetchAll(PDO::FETCH_OBJ);
  $vresp->visitors=$rows;
  $vresp->houseImages=VisitorsController::getPhotosOfHouse($houseid);
  return json_encode($vresp);
}
public function productGallery($request,$response,$args){
  $requestedData=json_decode($request->getBody());
  $houseid=$requestedData->houseid;
  return json_encode(VisitorsController::getPhotosOfHouse($houseid));
}
public function getPhotosOfHouse($houseid){
  $sql="SELECT * FROM house_gallery WHERE house_gallery.HouseID=?";
  $con=Db::cleDoHiDb("gkdujatf_misosodb");
  $sql=$con->prepare($sql);
  $sql->bindParam(1,$houseid);
  $sql->execute();
  $rows=$sql->fetchAll(PDO::FETCH_OBJ);
  return $rows;
}
}


class VisitorDetailResponse 
{
   public $visitors;
   public $houseImages;
}
 ?>