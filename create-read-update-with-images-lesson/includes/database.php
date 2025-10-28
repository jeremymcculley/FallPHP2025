<?php
class Database{
    private $host = "localhost";
    private $db_name = "phpclass";
    private $username = "root";
    private $password = "";
    public $conn;
    public function connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOExecption $e){
            echo "<p>Connection Error: " . $e->getMessage()"</p>";
        }
        return $this->conn;
    }
}
