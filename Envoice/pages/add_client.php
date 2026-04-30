<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    if ($clientObj->create($user_id, $name, $company, $email, $phone, $address)) {
        header('Location: index.php?page=clients');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="mb-4">
            <h2>Add New Client</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=clients">Clients</a></li>
                    <li class="breadcrumb-item active">Add Client</li>
                </ol>
            </nav>
        </div>

        <div class="card p-4">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Billing Address</label>
                    <textarea name="address" class="form-control" rows="3"></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">Save Client</button>
                    <a href="index.php?page=clients" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
