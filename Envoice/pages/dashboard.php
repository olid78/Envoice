<?php
$user_id = $_SESSION['user_id'];

// Get summary data
$stmt = $db->prepare("SELECT COUNT(*) as total FROM clients WHERE user_id = ?");
$stmt->execute([$user_id]);
$client_count = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as total FROM invoices WHERE user_id = ?");
$stmt->execute([$user_id]);
$invoice_count = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT SUM(amount) as total FROM payments p JOIN invoices i ON p.invoice_id = i.id WHERE i.user_id = ?");
$stmt->execute([$user_id]);
$total_revenue = $stmt->fetch()['total'] ?? 0;

$recent_invoices = $invoiceObj->getAllByUser($user_id);
$recent_invoices = array_slice($recent_invoices, 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Welcome back, <?php echo $_SESSION['user_name']; ?>!</h2>
            <a href="index.php?page=create_invoice" class="btn btn-primary">+ Create Invoice</a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="text-muted mb-2">Total Revenue</div>
                    <h3 class="fw-bold">$<?php echo number_format($total_revenue, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="text-muted mb-2">Active Clients</div>
                    <h3 class="fw-bold"><?php echo $client_count; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="text-muted mb-2">Total Invoices</div>
                    <h3 class="fw-bold"><?php echo $invoice_count; ?></h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card p-4 h-100">
                    <h5 class="mb-4">Revenue Overview (Last 6 Months)</h5>
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="mb-4">Quick Actions</h5>
                    <div class="d-grid gap-3">
                        <a href="index.php?page=add_client" class="btn btn-light text-start">Add New Client</a>
                        <a href="index.php?page=invoices" class="btn btn-light text-start">Manage All Invoices</a>
                        <a href="index.php?page=profile" class="btn btn-light text-start">Account Settings</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card p-4">
                    <h5 class="mb-4">Recent Invoices</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_invoices as $inv): ?>
                                <tr>
                                    <td><?php echo $inv['invoice_number']; ?></td>
                                    <td><?php echo $inv['client_name']; ?></td>
                                    <td><?php echo $inv['issue_date']; ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $inv['status'] == 'Paid' ? 'success' : ($inv['status'] == 'Overdue' ? 'danger' : 'warning'); 
                                        ?>">
                                            <?php echo $inv['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="index.php?page=invoice_detail&id=<?php echo $inv['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($recent_invoices)): ?>
                                    <tr><td colspan="5" class="text-center">No invoices yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="mb-4">Quick Actions</h5>
                    <div class="d-grid gap-3">
                        <a href="index.php?page=add_client" class="btn btn-light text-start">Add New Client</a>
                        <a href="index.php?page=invoices" class="btn btn-light text-start">Manage All Invoices</a>
                        <a href="index.php?page=profile" class="btn btn-light text-start">Account Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [1200, 1900, 3000, 500, 2000, 3000],
                    backgroundColor: '#4361ee',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
