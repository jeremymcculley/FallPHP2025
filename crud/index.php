<?php
// This is the main file that handles the page display, form input, and calling CRUD methods.

// 1. Include the necessary class files
require_once './classes/Database.php';
require_once './classes/CrudOperations.php';

// 2. Initialize the Database connection and the CRUD class
$database = new Database();
$db = $database->getConnection();
$crud = new CrudOperations($db);

$errors = [];
$success_message = '';

// Handle Form Submission (CREATE operation)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_create'])) {
    // Collect all data from the form
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'radio_option' => $_POST['radio_option'] ?? '',
        // Checkboxes only appear in $_POST if checked
        'checkbox_option' => $_POST['checkbox_option'] ?? null, 
        'message' => trim($_POST['message'] ?? ''),
        'text_input' => trim($_POST['text_input'] ?? ''),
    ];

    // Call the create method which handles validation and insertion
    $result = $crud->create($data);
    
    if ($result['success']) {
        $success_message = $result['message'];
        // Reset POST data to clear the form fields on success
        $_POST = []; 
    } else {
        // Store validation errors to display back to the user
        $errors = $result['errors'] ?? ['general' => $result['message']];
    }
}

// Handle DELETE Request (via a link click)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // Sanitize the ID before use, FILTER_SANITIZE_NUMBER_INT is a sanitization filter used to clean up a value, typically user input, by removing unwanted characters and leaving only those that are typically part of a signed integer.
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $result = $crud->delete($id);
    if ($result['success']) {
        // Redirect to clear the GET parameters and show success
        header('Location: index.php?status=deleted'); 
        exit;
    } else {
        $errors['delete'] = $result['message'];
    }
}

// READ Operation: Fetch all records for the display table
$stmt = $crud->readAll();

// --- END: PHP Logic ---
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP CRUD with Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header class="bg-primary text-white p-3 mb-4">
        <div class="container">
            <h1>PHP CRUD Application</h1>
            <p class="lead">Object-Oriented Programming (OOP) lesson with Bootstrap styling.</p>
        </div>
    </header>

    <main class="container">

        <section class="mb-5 p-4 border rounded">
            <h2 class="mb-4">Create New Record</h2>

            <?php if ($success_message): ?>
                <div class="alert alert-success" role="alert"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
                <div class="alert alert-warning" role="alert">Record deleted successfully.</div>
            <?php endif; ?>
            <?php if (isset($errors['general'])): ?>
                <div class="alert alert-danger" role="alert"><?php echo $errors['general']; ?></div>
            <?php endif; ?>

            <form action="index.php" method="post">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name (Text Input):</label>
                    <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                           id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    <?php if (isset($errors['name'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                           id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label class="form-label d-block">Radio Option:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="radio_a" name="radio_option" value="option_a" 
                               <?php echo (($_POST['radio_option'] ?? '') == 'option_a') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio_a">Option A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="radio_b" name="radio_option" value="option_b"
                               <?php echo (($_POST['radio_option'] ?? '') == 'option_b') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="radio_b">Option B</label>
                    </div>
                    <?php if (isset($errors['radio_option'])): ?>
                        <div class="text-danger small mt-1"><?php echo $errors['radio_option']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox_option" name="checkbox_option" value="checked"
                           <?php echo (isset($_POST['checkbox_option'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="checkbox_option">Agree to terms (Checkbox)</label>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Message (Textarea):</label>
                    <textarea class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                              id="message" name="message" rows="3"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['message']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="text_input" class="form-label">Another Text Field:</label>
                    <input type="text" class="form-control" id="text_input" name="text_input" 
                           value="<?php echo htmlspecialchars($_POST['text_input'] ?? ''); ?>">
                </div>
                
                <button type="submit" name="submit_create" class="btn btn-success">Submit Record (Create)</button>
            </form>
        </section>

        <section class="mb-5">
            <h2 class="mb-4">Current Records (Read Operation)</h2>
            
            <?php if ($stmt->rowCount() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Radio</th>
                                <th>Checkbox</th>
                                <th>Message Snippet</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['radio_option']); ?></td>
                                <td><?php echo htmlspecialchars($row['checkbox_option']); ?></td>
                                <td><?php echo htmlspecialchars(substr($row['message'], 0, 30)) . '...'; ?></td>
                                <td>
                                    <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary me-2">Edit (UPDATE)</a>
                                    <a href="index.php?action=delete&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No records found. Create one above!</div>
            <?php endif; ?>
        </section>

    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> PHP CRUD Lesson. Built with OOP and Bootstrap 5.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>