<?php
    $pageTitle = "Create Products";
    $pageDesc  = "This page lets the user create a product";
    require_once './inc/Database.php';
    $success = null;
    // 1. check if the form was submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // 2. Get the submitted data
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        // 3. the $_FILES superglobal holds information about the uploaded file
        $imageFile = $_FILES['product_image'];
        // 4. Validate and create the record using the OOP method
        if($db->create($name, $description, $imageFile)){
            $success = "Product created!!";
        }
    }
    require './templates/header.php';
?>
    <main>
        <section class="row">
            <h1 class="mb-4">Create New Product</h1>   
            <div class="col-4">
                <a href="index.php" class="btn btn-secondary mb-3">View All Products</a>
            </div>
        </section>
        <section class="messageRow row">
            <?php if($success): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <?php if($db->error): ?>
                <div class="alert alert-danger" role="alert">
                    Error: <?php echo $db->error; ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="createRow row">
            <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">    
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($name ?? ''); ?>">
                </div>    
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>   
                <div class="mb-3">
                    <label for="product_image" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="product_image" name="product_image" required>
                    <small class="text-muted">Allowed: JPG, PNG, GIF. Max 2MB.</small>
                </div>      
                <button type="submit" class="btn btn-primary">Save Product</button>
            </form>
        </section>
    </main>
<?php require './templates/footer.php'; ?>