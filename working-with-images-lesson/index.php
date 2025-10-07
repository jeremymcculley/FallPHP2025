<?php
    // define our page title and description
    $pageTitle = "View Products";
    $pageDesc  = "This page will allow the user to add a product";
    require_once './inc/Database.php';
    // call on the read method
    $products = $db->read();
    // check for a read error
    if($products === false){
        $readError = "<p>No products found!</p>";
    }
    require './templates/header.php';
?>
    <main>
        <section class="row">
            <h1 class="mb-4">Product List with Images</h1>
            <div class="col-4">
                <a href="create.php" class="btn btn-success mb-3">Add New Product</a>
            </div>
        </section>
        <section class="messageRow row">
            <?php if(isset($readError)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $readError; ?>
                </div>
            <?php endif; ?>
        </section>
        <section class="productRow row">
            <?php if($products && count($products) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="product-img">
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert alert-info">
                    No products found. Start by adding one!
                </div>
            <?php endif; ?>
        </section>
    </main>
<?php require './templates/footer.php'; ?>