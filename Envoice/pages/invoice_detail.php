<?php
$invoice_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$invoice = $invoiceObj->getById($invoice_id, $user_id);

if (!$invoice) {
    header('Location: index.php?page=invoices');
    exit();
}

$payments = $paymentObj->getByInvoice($invoice_id);
$total_paid = $paymentObj->getTotalPaid($invoice_id);

$subtotal = 0;
foreach ($invoice['items'] as $item) {
    $subtotal += $item['quantity'] * $item['unit_price'];
}
$tax_amount = $subtotal * ($invoice['tax_rate'] / 100);
$grand_total = $subtotal + $tax_amount;
$balance_due = $grand_total - $total_paid;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_payment'])) {
    $amount = $_POST['amount'];
    $date = $_POST['payment_date'];
    $method = $_POST['method'];
    $notes = $_POST['payment_notes'];

    if ($paymentObj->record($invoice_id, $amount, $date, $method, $notes)) {
        // If fully paid, update status
        if (($total_paid + $amount) >= $grand_total) {
            $invoiceObj->updateStatus($invoice_id, $user_id, 'Paid');
        }
        header("Location: index.php?page=invoice_detail&id=$invoice_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Invoice <?php echo $invoice['invoice_number']; ?></h2>
                <span class="badge bg-<?php echo $invoice['status'] == 'Paid' ? 'success' : 'warning'; ?>">
                    <?php echo $invoice['status']; ?>
                </span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">Print</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal" <?php echo $balance_due <= 0 ? 'disabled' : ''; ?>>Record Payment</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-5 mb-4 shadow-sm">
                    <div class="row mb-5">
                        <div class="col-6">
                            <h4 class="text-primary fw-bold"><?php echo $_SESSION['user_name']; ?></h4>
                            <p class="text-muted"><?php echo nl2br($invoice['client_address']); // Simplified for demo ?></p>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="text-uppercase text-muted">Invoice To</h5>
                            <h4 class="fw-bold"><?php echo $invoice['client_name']; ?></h4>
                            <p class="text-muted"><?php echo nl2br($invoice['client_address']); ?></p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoice['items'] as $item): ?>
                                <tr>
                                    <td><?php echo $item['description']; ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-end">$<?php echo number_format($item['unit_price'], 2); ?></td>
                                    <td class="text-end">$<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>$<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (<?php echo $invoice['tax_rate']; ?>%)</span>
                                <span>$<?php echo number_format($tax_amount, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold h5">
                                <span>Grand Total</span>
                                <span>$<?php echo number_format($grand_total, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between text-success">
                                <span>Amount Paid</span>
                                <span>$<?php echo number_format($total_paid, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between text-danger fw-bold border-top mt-2 pt-2 h5">
                                <span>Balance Due</span>
                                <span>$<?php echo number_format($balance_due, 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="mb-4">Payment History</h5>
                    <?php if (empty($payments)): ?>
                        <p class="text-muted">No payments recorded yet.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($payments as $p): ?>
                                <li class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between">
                                        <strong>$<?php echo number_format($p['amount'], 2); ?></strong>
                                        <span class="text-muted small"><?php echo $p['payment_date']; ?></span>
                                    </div>
                                    <div class="text-muted small"><?php echo $p['method']; ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Record Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" value="<?php echo $balance_due; ?>" step="0.01" max="<?php echo $balance_due; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Method</label>
                        <select name="method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Card">Card</option>
                            <option value="Mobile Banking">Mobile Banking</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="payment_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="record_payment" class="btn btn-primary">Save Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
