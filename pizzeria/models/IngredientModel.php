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

    public function addNewIngredient()
    {
    }

    public function getAllIngredients()
    {
        $sql = "SELECT * FROM ingredients";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
