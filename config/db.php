<?php
namespace App\Controllers;
use PDO;
class Db{

    public function n_micro($dbname){
        $host="192.168.1.12";
        $user="dharerimana";
        $db=$dbname;
        $password="radiantdominique";
        $dbdomain="mysql:host=".$host.";dbname=".$db;
        $pdo = new PDO($dbdomain,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;
    }
      public function novanet($dbname){
        $host="192.168.1.12";
        $user="dharerimana";
        $db=$dbname;
        $password="radiantdominique";
        $dbdomain="mysql:host=".$host.";dbname=".$db;
        $pdo = new PDO($dbdomain,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;
    }
    public function cleDoHiDb($db){
        $host="localhost";
        $user="root";
        $password="";
        $dbdomain="mysql:host=".$host.";dbname=".$db;
        $pdo = new PDO($dbdomain,$user,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;
    }
}
?>
