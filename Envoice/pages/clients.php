<?php
$user_id = $_SESSION['user_id'];
$clients = $clientObj->getAllByUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Clients</h2>
            <a href="index.php?page=add_client" class="btn btn-primary">+ Add Client</a>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><strong><?php echo $client['name']; ?></strong></td>
                            <td><?php echo $client['company']; ?></td>
                            <td><?php echo $client['email']; ?></td>
                            <td><?php echo $client['phone']; ?></td>
                            <td class="text-end">
                                <a href="index.php?page=edit_client&id=<?php echo $client['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="api/delete_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($clients)): ?>
                            <tr><td colspan="5" class="text-center py-4">No clients found. Click "Add Client" to get started.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
