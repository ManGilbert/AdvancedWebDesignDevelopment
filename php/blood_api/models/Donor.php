<?php
class Donor
{
    private $conn;
    private $table = "donors";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE DONOR
    public function create($data)
    {
        $query = "INSERT INTO " . $this->table . "
        (name, blood_type, city, phone, last_donation_date)
        VALUES (:name, :blood_type, :city, :phone, :last_donation_date)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute($data);
    }

    // GET ALL
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SEARCH
    public function search($blood_type = null, $city = null, $name = null)
    {

        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";

        if ($blood_type) {
            $query .= " AND blood_type = :blood_type";
        }

        if ($city) {
            $query .= " AND city = :city";
        }

        if ($name) {
            $query .= " AND name LIKE :name";
        }

        $stmt = $this->conn->prepare($query);

        if ($blood_type) {
            $stmt->bindParam(":blood_type", $blood_type);
        }

        if ($city) {
            $stmt->bindParam(":city", $city);
        }

        if ($name) {
            $name = "%$name%";
            $stmt->bindParam(":name", $name);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute(["id" => $id]);
    }

    // UPDATE DONOR
    public function update($id, $data)
    {

        $query = "UPDATE " . $this->table . " 
              SET name = :name,
                  blood_type = :blood_type,
                  city = :city,
                  phone = :phone,
                  last_donation_date = :last_donation_date
              WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $data['id'] = $id;

        return $stmt->execute($data);
    }
}
