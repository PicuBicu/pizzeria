<?php

class ClientModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getClientByEmail(string $email)
    {
        $sql = "SELECT client.id, `client_role`.name AS `role`, client.first_name, client.last_name, contact_data.email, client.`password` 
            FROM client, `client_role`, contact_data
            WHERE email = :email 
            AND `client_role`.id = client.client_role_id
            AND contact_data.client_id = client.id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function checkIfEmailIsAlreadyTaken(string $email): bool
    {
        $sql = "SELECT email FROM contact_data WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function addNewClient(string $firstName, string $lastName, string $password)
    {
        $hashPassword = password_hash(trim($password), PASSWORD_DEFAULT, ["cost" => 12]);
        $sql = "INSERT INTO client (first_name, last_name, `password`)
        VALUES(:firstName, :lastName, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":firstName", $firstName, PDO::PARAM_STR);
        $stmt->bindParam(":lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashPassword, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addContactData(int $clientId, string $email, string $phoneNumber)
    {
        $sql = "INSERT INTO contact_data (client_id, email, phone_number)
        VALUES(:clientId, :email, :phoneNumber)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllClientData(int $clientId)
    {
        $sql = "SELECT * FROM contact_data WHERE client_id = :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
