<?php
    $pageTitle = "View Users";
    $pageDesc = "This page lets us see our users";
    require 'includes/header.php';
    require 'includes/database.php';
    require 'includes/user.php';
    $db = (new Database())->connect();
    $user = new User($db);
    $users = $user->getAll();
?>
<section class="lesson-masthead">
    <h1>Create Read & Update with Images</h1>
</section>
<section class="table-row">
    <h2>All Users</h2>
    <a class="btn btn-primary" href="create.php">Create New</a>
    <table class="table table-striped align-middle">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php foreach($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <?php if ($u['image']): ?>
                        <img src="uploads/<?= $u['image'] ?>">
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-warning" href="edit.php?id=<?= $u['id'] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php require 'includes/footer.php'; ?>
