<?php

class BasketModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function countItemsUserBasket(int $clientId)
    {
        $sql = "SELECT COUNT(*) AS `count` FROM basket WHERE client_id = :clientId 
        AND is_realised = 0 AND order_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) {
            return 0;
        } else {
            return $row["count"];
        }
    }

    public function checkIfProductIsInBasket(int $clientId, int $foodId, string $size): bool
    {
        $sql = "SELECT basket.food_size_id AS id FROM basket, food_size 
            WHERE client_id = :clientId 
            AND food_size.id = basket.food_size_id
            AND food_size.food_id = :foodId
            AND food_size.name = :size
            AND basket.order_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        $stmt->bindParam(":size", $size, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->fetch();
        return ($stmt->rowCount() > 0);
    }

    public function addNewProductToBasket(int $foodSizeId, int $clientId, int $quantity): bool
    {
        $sql = "INSERT INTO basket (client_id, food_size_id, quantity) 
                VALUES(:clientId, :foodSizeId, :quantity)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodSizeId", $foodSizeId, PDO::PARAM_INT);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteFromBasket(int $clientId, int $foodSizeId): bool
    {
        $sql = "DELETE FROM basket 
            WHERE client_id = :clientId 
            AND food_size_id = :foodSizeId
            AND order_id IS NULL
            AND is_realised = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":foodSizeId", $foodSizeId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getProductsFromBasket(int $clientId)
    {
        $sql = "SELECT food_size.id, food_size.name AS size_name, food_size.price, basket.quantity, f.name, skl.ingredients 
        FROM basket, food_size, food AS f, 
        ( SELECT f.id AS X, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') 
        AS ingredients 
        FROM food AS f, ingredients AS i, STORAGE AS s 
        WHERE s.food_id = f.id 
        AND s.ingredient_id = i.id 
        GROUP BY f.id ) AS skl 
        WHERE f.id = skl.x 
        AND food_size.food_id = f.id 
        AND basket.client_id = :clientId 
        AND basket.food_size_id = food_size.id
        AND basket.order_id IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function setOrderIdInBasket(int $clientId, int $orderId): bool
    {
        $sql = "UPDATE basket SET is_realised = true, order_id = :orderId 
            WHERE client_id = :clientId 
            AND is_realised = false";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateBasket(int $clientId, array $quantities, array $ids)
    {
        $len = count($quantities);
        for ($i = 0; $i < $len; $i++) {
            $sql = "UPDATE basket 
                    SET quantity = :quantity 
                    WHERE food_size_id = :foodSizeId 
                    AND client_id = :clientId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":quantity", $quantities[$i], PDO::PARAM_INT);
            $stmt->bindParam(":foodSizeId", $ids[$i], PDO::PARAM_INT);
            $stmt->bindParam(":clientId", $clientId, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }

    public function getBasketByOrderId(int $orderId)
    {
        $sql = "SELECT food_size.id, food_size.name AS size_name, food_size.price, basket.quantity, f.name, skl.ingredients 
        FROM basket, food_size, food AS f, 
        ( SELECT f.id AS X, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') 
        AS ingredients 
        FROM food AS f, ingredients AS i, STORAGE AS s 
        WHERE s.food_id = f.id 
        AND s.ingredient_id = i.id 
        GROUP BY f.id ) AS skl 
        WHERE f.id = skl.x 
        AND food_size.food_id = f.id 
        AND basket.food_size_id = food_size.id
        AND basket.order_id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":orderId", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
