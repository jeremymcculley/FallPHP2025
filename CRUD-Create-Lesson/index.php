<?php 
    require_once "config.php";
    require_once "Database.php";
    require_once "Post.php";
    // now connect to our database
    $db = new Database();
    $pdo = $db->getConnection();
    $postModel = new Post($pdo);
    $success = false;
    $error = "";
    // on form submission
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $title = trim($_POST["title"] ?? "");
        $body  = trim($_POST["body"] ?? "");
        $is_featured = isset($_POST["is_featured"]) ? 1 : 0; // checkbox 1 or zero
        $tagsArray = $_POST["tags"] ?? [];
        $tags = implode(",", $tagsArray);
        try{
            // try to save our post
            $postModel->create($title,$body,$is_featured,$tags);
            $success = true;
        }catch(Exception $e){
            $error = "Could not save post. " . $e->getMessage();
        }
    }
    // load the rest of our templates
    include "templates/header.php";
    include "form.php";
    include "templates/footer.php";
?>