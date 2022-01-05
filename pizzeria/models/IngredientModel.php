<?php

class IngredientModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function updateIgredientById()
    {
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
}
