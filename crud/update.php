<?php
// File: update.php
require_once './classes/Database.php';
require_once './classes/CrudOperations.php';

// Initialize the Database connection and the CRUD class
$database = new Database();
$db = $database->getConnection();
$crud = new CrudOperations($db);

$errors = [];
$success_message = '';

// 1. Get the ID from the URL (or redirect if missing)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// 2. Handle Form Submission (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_update'])) {
    // Collect data from the POST request
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'radio_option' => $_POST['radio_option'] ?? '',
        'checkbox_option' => $_POST['checkbox_option'] ?? null, 
        'message' => trim($_POST['message'] ?? ''),
        'text_input' => trim($_POST['text_input'] ?? ''),
    ];

    // Call the update method
    $result = $crud->update($id, $data);
    
    if ($result['success']) {
        $success_message = $result['message'];
        // Re-fetch the updated data to show the latest changes in the form
        $record = $crud->readOne($id); 
    } else {
        $errors = $result['errors'] ?? ['general' => $result['message']];
        // If validation fails, use the submitted POST data to re-populate the form
        $record = array_merge(['id' => $id], $data); 
    }
} else {
    // 3. Initial Load: Fetch the existing record data
    $record = $crud->readOne($id);

    // If no record is found, redirect
    if (!$record) {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record #<?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header class="bg-warning text-dark p-3 mb-4">
        <div class="container">
            <h1>Update Record (ID: <?php echo htmlspecialchars($id); ?>)</h1>
            <a href="index.php" class="btn btn-dark btn-sm">← Back to Records</a>
        </div>
    </header>

    <main class="container">

        <section class="mb-5 p-4 border rounded">
            
            <?php if ($success_message): ?>
                <div class="alert alert-success" role="alert"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($errors['general'])): ?>
                <div class="alert alert-danger" role="alert"><?php echo $errors['general']; ?></div>
            <?php endif; ?>

            <form action="update.php?id=<?php echo $id; ?>" method="post">
                
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name (Text Input):</label>
                    <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                           id="name" name="name" value="<?php echo htmlspecialchars($record['name'] ?? ''); ?>">
                    <?php if (isset($errors['name'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                           id="email" name="email" value="<?php echo htmlspecialchars($record['email'] ?? ''); ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label class="form-label d-block">Radio Option:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="radio_a" name="radio_option" value="option_a" 
                               <?php echo (($record['radio_option'] ?? '') == 'option_a') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio_a">Option A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="radio_b" name="radio_option" value="option_b"
                               <?php echo (($record['radio_option'] ?? '') == 'option_b') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio_b">Option B</label>
                    </div>
                    <?php if (isset($errors['radio_option'])): ?>
                        <div class="text-danger small mt-1"><?php echo $errors['radio_option']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox_option" name="checkbox_option" value="checked"
                           <?php echo (($record['checkbox_option'] ?? '') == 'Yes') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="checkbox_option">Agree to terms (Checkbox)</label>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Message (Textarea):</label>
                    <textarea class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                              id="message" name="message" rows="3"><?php echo htmlspecialchars($record['message'] ?? ''); ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['message']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="text_input" class="form-label">Another Text Field:</label>
                    <input type="text" class="form-control" id="text_input" name="text_input" 
                           value="<?php echo htmlspecialchars($record['text_input'] ?? ''); ?>">
                </div>
                
                <button type="submit" name="submit_update" class="btn btn-warning">Save Changes (UPDATE)</button>
            </form>
        </section>
    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <p>PHP CRUD Update Page.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>