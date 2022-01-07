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

    public function getAllOrders()
    {
        $sql = "SELECT
            o.id,
            o.information_for_courier,
            o.order_date,
            ca.city,
            ca.house_number,
            ca.street,
            os.name
        FROM
            `order` AS o,
            client_address AS ca,
            order_status AS os
        WHERE
            ca.id = o.`address_id` AND os.id = o.order_status_id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllClientOrders(int $clientId)
    {
        $sql = "SELECT
            o.id,
            o.information_for_courier,
            o.order_date,
            ca.city,
            ca.house_number,
            ca.street,
            os.name
        FROM
            `order` AS o,
            client_address AS ca,
            order_status AS os
        WHERE
            ca.id = o.`address_id` AND os.id = o.order_status_id;
            AND o.client_id = :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderById(int $orderId)
    {
        $sql = "SELECT
        o.id,
        o.information_for_courier,
        o.order_date,
        ca.city,
        ca.house_number,
        ca.street,
        os.name
    FROM
        `order` AS o,
        client_address AS ca,
        order_status AS os
    WHERE
        ca.id = o.`address_id` 
        AND os.id = o.order_status_id
        AND o.id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getClientOrderById(int $clientId, int $orderId)
    {
        $sql = "SELECT
        o.id,
        o.information_for_courier,
        o.order_date,
        ca.city,
        ca.house_number,
        ca.street,
        os.name
    FROM
        `order` AS o,
        client_address AS ca,
        order_status AS os
    WHERE
        ca.id = o.`address_id` 
        AND os.id = o.order_status_id
        AND o.id = :orderId
        AND o.client_id = :clientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllStatuses()
    {
        $sql = "SELECT
        * FROM order_status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateOrderStatusId(int $orderId, int $orderStatusId)
    {
        $sql = "UPDATE `order` 
            SET order_status_id = :orderStatusId
            WHERE id = :orderId;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->bindParam(":orderStatusId", $orderStatusId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
