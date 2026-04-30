<?php
$user_id = $_SESSION['user_id'];
$clients = $clientObj->getAllByUser($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $invoice_number = $_POST['invoice_number'];
    $issue_date = $_POST['issue_date'];
    $due_date = $_POST['due_date'];
    $tax_rate = $_POST['tax_rate'];
    $notes = $_POST['notes'];
    
    $items = [];
    foreach ($_POST['desc'] as $key => $desc) {
        $items[] = [
            'description' => $desc,
            'quantity' => $_POST['qty'][$key],
            'unit_price' => $_POST['price'][$key]
        ];
    }

    $invoice_id = $invoiceObj->create($user_id, $client_id, $invoice_number, $issue_date, $due_date, $tax_rate, $notes, $items);
    if ($invoice_id) {
        header('Location: index.php?page=invoice_detail&id=' . $invoice_id);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="mb-4">
            <h2>Create New Invoice</h2>
        </div>

        <form method="POST" id="invoice-form">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card p-4 mb-4">
                        <h5 class="mb-3">Invoice Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client</label>
                                <select name="client_id" class="form-select" required>
                                    <option value="">Select Client</option>
                                    <?php foreach ($clients as $c): ?>
                                        <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?> (<?php echo $c['company']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Invoice Number</label>
                                <input type="text" name="invoice_number" class="form-control" value="INV-<?php echo time(); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Issue Date</label>
                                <input type="date" name="issue_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="card p-4">
                        <h5 class="mb-3">Line Items</h5>
                        <div class="table-responsive">
                            <table class="table" id="items-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th style="width: 100px;">Qty</th>
                                        <th style="width: 150px;">Price</th>
                                        <th style="width: 150px;">Total</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td><input type="text" name="desc[]" class="form-control" required></td>
                                        <td><input type="number" name="qty[]" class="form-control qty" value="1" step="0.01" required></td>
                                        <td><input type="number" name="price[]" class="form-control price" value="0.00" step="0.01" required></td>
                                        <td><span class="row-total">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-item">+ Add Item</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h5 class="mb-3">Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">0.00</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" id="tax-rate" class="form-control" value="0" step="0.01">
                        </div>
                        <div class="d-flex justify-content-between mb-3 fw-bold h5">
                            <span>Grand Total</span>
                            <span id="grand-total">0.00</span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Create Invoice</button>
                    </div>

                    <div class="card p-4">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Optional notes for the client..."></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-item').addEventListener('click', function() {
            const tbody = document.querySelector('#items-table tbody');
            const row = document.createElement('tr');
            row.className = 'item-row';
            row.innerHTML = `
                <td><input type="text" name="desc[]" class="form-control" required></td>
                <td><input type="number" name="qty[]" class="form-control qty" value="1" step="0.01" required></td>
                <td><input type="number" name="price[]" class="form-control price" value="0.00" step="0.01" required></td>
                <td><span class="row-total">0.00</span></td>
                <td><button type="button" class="btn btn-link text-danger remove-item p-0">&times;</button></td>
            `;
            tbody.appendChild(row);
            attachListeners(row);
        });

        function calculate() {
            let subtotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const price = parseFloat(row.querySelector('.price').value) || 0;
                const total = qty * price;
                row.querySelector('.row-total').innerText = total.toFixed(2);
                subtotal += total;
            });

            const taxRate = parseFloat(document.getElementById('tax-rate').value) || 0;
            const taxAmount = subtotal * (taxRate / 100);
            const grandTotal = subtotal + taxAmount;

            document.getElementById('subtotal').innerText = subtotal.toFixed(2);
            document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
        }

        function attachListeners(row) {
            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', calculate);
            });
            const removeBtn = row.querySelector('.remove-item');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    row.remove();
                    calculate();
                });
            }
        }

        document.querySelectorAll('.item-row').forEach(attachListeners);
        document.getElementById('tax-rate').addEventListener('input', calculate);
    </script>
</body>
</html>
