<?php

include_once 'conf.php';

function getConnction()
{
    try
    {
        #return mysqli_connect("127.0.0.1","root","fast9002","sgo_portal",'3306');
        $conn = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
        // set the PDO error mode to exception
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();exit;
    }

} 	

?>