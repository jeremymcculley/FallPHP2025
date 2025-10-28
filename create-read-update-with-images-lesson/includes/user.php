<?php
class User{
    private $conn;
    private $table = 'userRecords';
    public function __construct($db){
        $this->conn = $db;
    }
    // our create function
    public function create($name, $email, $image){
        $sql = "INSERT INTO {$this->table} (name, email, image) VALUES (:name, :email, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':image' => $image
        ]);
    }
    // get all the data from our table
    public function getAll(){
        $sql = "SELECT * FROM {$this->table} ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // get a record by id
    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute->([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // update a record
    public function update($id, $name, $email, $image = null){
        if($image){
            $sql = "UPDATE {$this->table} SET name=:name, email=:email, image=:image WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':image' => $image,
                ':id' => $id
            ]);
        }else{
            $sql = "UPDATE {$this->table} SET name=:name, email=:email WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':id' => $id
            ]);
        }
    }
}