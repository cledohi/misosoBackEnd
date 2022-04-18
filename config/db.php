<?php
namespace App\Controllers;
use PDO;
class Db{
    public function cleDoHiDb($db){
        $host="localhost";
        $user="gkdujatf_cledohi";
        $password="P.C@*wqy]-4Q";
        $dbdomain="mysql:host=".$host.";dbname=".$db;
        $pdo = new PDO($dbdomain,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;
        //mysqldump -u gkdujatf_cledohi -p -f -d gkdujatf_misosodb < c:\Users\cledohi\Downloads\gkdujatf_misosodb_1.sql;
    }
}
?>
