<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $business_name = $_POST['business_name'];

    if ($userObj->register($name, $email, $password, $business_name)) {
        header('Location: index.php?page=login&registered=1');
        exit();
    } else {
        $error = "Registration failed. Email might already exist.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <a href="index.php" class="h2 text-decoration-none fw-bold text-primary"><?php echo APP_NAME; ?></a>
                </div>
                <div class="card p-4 shadow-sm">
                    <h2 class="text-center mb-4">Create Account</h2>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Business Name</label>
                            <input type="text" name="business_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Sign Up</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="index.php?page=login">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
