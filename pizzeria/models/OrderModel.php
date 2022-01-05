<?php

class OrderModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addNewOrder(int $clientId, int $addressId, string $informationForCourier): bool
    {
        $sql = "INSERT INTO `order` (client_id, address_id, information_for_courier, order_status_id) 
            VALUES(:clientId, :addressId, :informationForCourier, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":informationForCourier", $informationForCourier, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteOrderById(int $clientId, int $orderId): bool
    {
        $sql = "DELETE FROM `order` 
            WHERE id= :orderId 
            AND client_id= :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllClientOrders(int $client)
    {
        $sql = "DELETE FROM `order` 
        WHERE id= :orderId 
        AND client_id= :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
