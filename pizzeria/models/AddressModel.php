<?php

class AddressModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClientAddresses(int $clientId)
    {
        $sql = "SELECT * FROM client_address WHERE client_id = :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getClientAddressesNumber(int $clientId): int
    {
        $sql = "SELECT COUNT(*) AS num FROM client_address WHERE client_id = 17 GROUP BY client_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if (isset($row["num"])) {
            return $row["num"];
        }
        return 0;
    }

    public function addNewAddress(int $clientId, string $street, string $houseNumber, string $city): bool
    {
        $sql = "INSERT INTO client_address (client_id, street, house_number, city) 
            VALUES (:clientId, :street, :houseNumber, :city)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":street", $street, PDO::PARAM_STR);
        $stmt->bindParam(":houseNumber", $houseNumber, PDO::PARAM_STR);
        $stmt->bindParam(":city", $city, PDO::PARAM_STR);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
