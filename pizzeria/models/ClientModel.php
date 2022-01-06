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
        $sql = "SELECT client.id, `client_role`.name AS `role`, client.first_name, client.last_name, client.email, client.`password` 
            FROM client, `client_role` 
            WHERE email = :email AND `client_role`.id = client.client_role_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}
