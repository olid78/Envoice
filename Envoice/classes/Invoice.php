<?php
class Invoice {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($user_id, $client_id, $invoice_number, $issue_date, $due_date, $tax_rate, $notes, $items) {
        try {
            $this->db->beginTransaction();

            $public_token = bin2hex(random_bytes(16));
            $stmt = $this->db->prepare("INSERT INTO invoices (user_id, client_id, invoice_number, issue_date, due_date, tax_rate, notes, public_token) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $client_id, $invoice_number, $issue_date, $due_date, $tax_rate, $notes, $public_token]);
            $invoice_id = $this->db->lastInsertId();

            foreach ($items as $item) {
                $stmt_item = $this->db->prepare("INSERT INTO invoice_items (invoice_id, description, quantity, unit_price) VALUES (?, ?, ?, ?)");
                $stmt_item->execute([$invoice_id, $item['description'], $item['quantity'], $item['unit_price']]);
            }

            $this->db->commit();
            return $invoice_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAllByUser($user_id) {
        $stmt = $this->db->prepare("SELECT i.*, c.name as client_name FROM invoices i JOIN clients c ON i.client_id = c.id WHERE i.user_id = ? ORDER BY i.created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $user_id) {
        $stmt = $this->db->prepare("SELECT i.*, c.name as client_name, c.email as client_email, c.address as client_address FROM invoices i JOIN clients c ON i.client_id = c.id WHERE i.id = ? AND i.user_id = ?");
        $stmt->execute([$id, $user_id]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($invoice) {
            $stmt_items = $this->db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
            $stmt_items->execute([$id]);
            $invoice['items'] = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
        }
        return $invoice;
    }

    public function getByToken($token) {
        $stmt = $this->db->prepare("SELECT i.*, c.name as client_name, u.business_name, u.logo_path, u.address as user_address FROM invoices i JOIN clients c ON i.client_id = c.id JOIN users u ON i.user_id = u.id WHERE i.public_token = ?");
        $stmt->execute([$token]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($invoice) {
            $stmt_items = $this->db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
            $stmt_items->execute([$invoice['id']]);
            $invoice['items'] = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
        }
        return $invoice;
    }

    public function updateStatus($id, $user_id, $status) {
        $stmt = $this->db->prepare("UPDATE invoices SET status = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$status, $id, $user_id]);
    }
}
