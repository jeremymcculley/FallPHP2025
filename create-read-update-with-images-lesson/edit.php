<?php

?>
<section class="lesson-masthead">
    <h1>Create Read & Update with Images</h1>
</section>
<section class="table-row">
    <h2>Edit User</h2>
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">Name:</label>
        <input class="form-control" type="text" name="name" value="<?=  ?>" required><br>
        <label class="form-label">Email:</label>
        <input class="form-control" type="email" name="email" value="<?=  ?>" required><br>
        <label class="form-label">Current Image:</label><br>
        <?php  ?>
            <img src="uploads/<?=  ?>"><br>
        <?php  ?>
        <label class="form-label">New Image:</label>
        <input class="form-control" type="file" name="image"><br><br>
        <button class="btn btn-primary" type="submit">Update</button>
    </form>
    <a class="btn btn-success" href="index.php">Back</a>
</section>
<?php  ?>
