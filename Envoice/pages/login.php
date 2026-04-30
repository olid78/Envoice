<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userObj->login($email, $password)) {
        header('Location: index.php?page=dashboard');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
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
                    <h2 class="text-center mb-4">Welcome Back</h2>
                    <?php if (isset($_GET['registered'])): ?>
                        <div class="alert alert-success">Registration successful. Please login.</div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="index.php?page=signup">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
