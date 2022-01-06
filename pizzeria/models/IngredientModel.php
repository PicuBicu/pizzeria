<?php

class IngredientModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function updateIgredientById(int $ingredientId, string $ingredientName)
    {
        $sql = "UPDATE ingredients SET `name` = :ingredientName WHERE id = :ingredientId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":ingredientId", $ingredientId, PDO::PARAM_INT);
        $stmt->bindParam(":ingredientName", $ingredientName, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addIngredient(string $ingredientName)
    {
        $sql = "INSERT INTO ingredients (`name`) VALUES (:ingredientName)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":ingredientName", $ingredientName, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllIngredients()
    {
        $sql = "SELECT * FROM ingredients";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteIngredientsByFoodId(int $foodId)
    {
        $sql = "DELETE FROM storage WHERE food_id = :foodId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
