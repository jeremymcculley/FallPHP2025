<div class="container mt-4">
    <?php if($success): ?>
        <div class="alert alert-success">
            <p>Your post has been created</p>
        </div>
    <?php endif; ?> 
    <?php // if($success){ ?>
        <!-- <div class="alert alert-success">
            <p>Your post has been created</p>
        </div> -->
    <?php //} ?>   
    <?php if(!empty($error)): ?> 
        <div class="alert alert-danger">
            <?php htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <form method="post" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="name" class="form-control" required> 
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Featured</label><br>
            <input type="checkbox" name="is_featured" value="1">Mark as featured
        </div>
        <div class="mb-3">
            <label class="form-label">Tags</label>
            <input type="checkbox" name="tags[]" value="PHP">PHP
            <input type="checkbox" name="tags[]" value="HTML">HTML
            <input type="checkbox" name="tags[]" value="CSS">CSS
            <input type="checkbox" name="tags[]" value="JS">JS
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>    
</div>
