<?php
class Client {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($user_id, $name, $company, $email, $phone, $address) {
        $stmt = $this->db->prepare("INSERT INTO clients (user_id, name, company, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $name, $company, $email, $phone, $address]);
    }

    public function getAllByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM clients WHERE user_id = ? ORDER BY name ASC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $user_id) {
        $stmt = $this->db->prepare("SELECT * FROM clients WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $user_id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $values[] = $user_id;
        $sql = "UPDATE clients SET " . implode(', ', $fields) . " WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete($id, $user_id) {
        $stmt = $this->db->prepare("DELETE FROM clients WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $user_id]);
    }
}
