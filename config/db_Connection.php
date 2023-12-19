<?php

class db_Connection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db_name = 'opep2';
    public $con;

    public function __construct($host, $username, $password, $db_name) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;

        try {
            $this->con = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "You are connected ";
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage();
        }
    }

    // Add a method to prepare statements
    public function prepare($query) {
        return $this->con->prepare($query);
    }
}

// Instantiate the database connection
// $db = new db_Connection('localhost', 'root', '', 'opep2');

?>

