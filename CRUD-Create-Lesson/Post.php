<?php
    // this will handle our CRUD functions (Create for this lesson)
    class Post{
        private $pdo;
        public function __construct(PDO $pdo){
            $this->pdo = $pdo;
        }
        // save our new post
        public function create($title, $body, $is_featured, $tags){
            $sql = "INSERT INTO posts (title, body, is_featured, tags) VALUES (:title, :body, :is_featured, :tags)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->excute([
                ":title" => $title,
                ":body" => $body,
                ":is_featured" => $is_featured,
                ":tags" => $tags
            ]);
        }
    }
?>