<?php

class BasketModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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
}
