<?php

class AddressModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClientAddresses(int $clientId): array
    {
        $sql = "SELECT * FROM client_address WHERE client_id = :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
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
}
