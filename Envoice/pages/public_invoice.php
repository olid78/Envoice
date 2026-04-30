<?php
$token = $_GET['token'] ?? '';
$invoice = $invoiceObj->getByToken($token);

if (!$invoice) {
    die("Invalid invoice link.");
}

$subtotal = 0;
foreach ($invoice['items'] as $item) {
    $subtotal += $item['quantity'] * $item['unit_price'];
}
$tax_amount = $subtotal * ($invoice['tax_rate'] / 100);
$grand_total = $subtotal + $tax_amount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo $invoice['invoice_number']; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; padding-top: 50px; padding-bottom: 50px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        @media print {
            body { background: none; padding: 0; }
            .invoice-box { box-shadow: none; border: none; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container no-print mb-4 text-center">
        <button onclick="window.print()" class="btn btn-primary px-4">Print / Download PDF</button>
    </div>

    <div class="invoice-box">
        <div class="row mb-5">
            <div class="col-6">
                <h2 class="text-primary fw-bold"><?php echo $invoice['business_name'] ?: 'Envoice'; ?></h2>
                <p class="text-muted"><?php echo nl2br($invoice['user_address'] ?? ''); ?></p>
            </div>
            <div class="col-6 text-end">
                <h1 class="text-uppercase text-muted display-6">Invoice</h1>
                <p class="mb-0"><strong>Invoice #:</strong> <?php echo $invoice['invoice_number']; ?></p>
                <p class="mb-0"><strong>Date:</strong> <?php echo $invoice['issue_date']; ?></p>
                <p class="mb-0"><strong>Due Date:</strong> <?php echo $invoice['due_date']; ?></p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-6">
                <h5 class="text-muted text-uppercase small fw-bold">Bill To:</h5>
                <h4 class="fw-bold mb-1"><?php echo $invoice['client_name']; ?></h4>
                <p class="text-muted"><?php echo nl2br($invoice['client_address'] ?? ''); ?></p>
            </div>
        </div>

        <table class="table mb-5">
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
                <div class="d-flex justify-content-between border-top pt-2 fw-bold h4">
                    <span>Grand Total</span>
                    <span>$<?php echo number_format($grand_total, 2); ?></span>
                </div>
            </div>
        </div>

        <?php if ($invoice['notes']): ?>
        <div class="mt-5 border-top pt-3">
            <h6 class="text-muted text-uppercase small fw-bold">Notes:</h6>
            <p class="text-muted small"><?php echo nl2br($invoice['notes']); ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
