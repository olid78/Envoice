<?php
$user_id = $_SESSION['user_id'];
$invoices = $invoiceObj->getAllByUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Invoices</h2>
            <a href="index.php?page=create_invoice" class="btn btn-primary">+ Create Invoice</a>
        </div>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $inv): ?>
                        <tr>
                            <td><strong><?php echo $inv['invoice_number']; ?></strong></td>
                            <td><?php echo $inv['client_name']; ?></td>
                            <td><?php echo $inv['issue_date']; ?></td>
                            <td><?php echo $inv['due_date']; ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $inv['status'] == 'Paid' ? 'success' : ($inv['status'] == 'Overdue' ? 'danger' : 'warning'); 
                                ?>">
                                    <?php echo $inv['status']; ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="index.php?page=invoice_detail&id=<?php echo $inv['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="index.php?page=public_invoice&token=<?php echo $inv['public_token']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Public Link</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($invoices)): ?>
                            <tr><td colspan="6" class="text-center py-4">No invoices found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
