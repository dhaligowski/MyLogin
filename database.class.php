<?php

class Database
{

    private $connection = null;

    public function __construct($dbhost = "localhost", $dbname = "usersdb", $username = "dhaligow", $password    = "root")
    {

        try {

            $this->connection = new PDO("mysql:host={$dbhost};dbname={$dbname};", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {

            session_start();
            $_SESSION['errors'] = "Error.  Unable to connect to database.";
            session_write_close();
            header('Location: index.php');
            exit;
            throw new Exception($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
