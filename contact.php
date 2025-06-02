<?php
// contact.php
session_start();
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }
    if (empty($message)) {
        $errors[] = 'Message cannot be empty.';
    }

    // Process if no errors
    if (empty($errors)) {
        $to = 'anselemjudith0@gmail.com';
        $subject = 'New Contact Message';
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $success = true;
            $_SESSION['contact_success'] = 'Your message has been sent successfully!';
            header('Location: contact.php');
            exit;
        } else {
            $errors[] = 'Failed to send the message. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php require 'component/navbar.php'; ?>

<div class="container py-5">
    <h1>Contact Us</h1>

    <?php if (!empty($_SESSION['contact_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['contact_success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['contact_success']); ?>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="contact.php" method="post" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-12">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</div>

<?php require 'component/footer.php'; ?>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
