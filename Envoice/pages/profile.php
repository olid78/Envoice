<?php
$user_id = $_SESSION['user_id'];
$user = $userObj->getById($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'business_name' => $_POST['business_name'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address']
    ];

    if ($userObj->updateProfile($user_id, $data)) {
        header('Location: index.php?page=profile&updated=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="mb-4">
            <h2>Business Profile</h2>
        </div>

        <div class="card p-4 shadow-sm">
            <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Profile updated successfully!</div>
            <?php endif; ?>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Name</label>
                        <input type="text" name="business_name" class="form-control" value="<?php echo $user['business_name']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="<?php echo $user['email']; ?>" disabled>
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Business Address</label>
                    <textarea name="address" class="form-control" rows="3"><?php echo $user['address']; ?></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
