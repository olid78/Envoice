<?php
class Payment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function record($invoice_id, $amount, $date, $method, $notes) {
        $stmt = $this->db->prepare("INSERT INTO payments (invoice_id, amount, payment_date, method, notes) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$invoice_id, $amount, $date, $method, $notes]);
    }

    public function getByInvoice($invoice_id) {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE invoice_id = ? ORDER BY payment_date DESC");
        $stmt->execute([$invoice_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPaid($invoice_id) {
        $stmt = $this->db->prepare("SELECT SUM(amount) as total FROM payments WHERE invoice_id = ?");
        $stmt->execute([$invoice_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
