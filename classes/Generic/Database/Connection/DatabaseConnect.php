<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 10/07/2019
* Time: 13:49
*/
namespace Generic\Database\Connection;

class DatabaseConnect {

    private $dbConnection = null;

    public function __construct()
    {
        $host = getenv('localhost');
        $db   = getenv('commerce');
        $user = getenv('gbenga22');
        $pass = getenv('arsenal1234go');

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}