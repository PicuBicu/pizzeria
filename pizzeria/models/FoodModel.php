<?php

class FoodModel
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllProductsWithDetails()
    {
        $sql = "SELECT  f.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients
        FROM food AS f,
        (SELECT food_id, price FROM food_size WHERE name='mała') AS m, 
        (SELECT food_id, price FROM food_size WHERE name='średnia') AS s,
        (SELECT food_id, price FROM food_size WHERE name='duża') AS d,
        (SELECT f.id AS x, f.name, GROUP_CONCAT(i.name SEPARATOR ', ') 
        AS ingredients FROM food AS f, ingredients AS i, storage AS s 
        WHERE s.food_id = f.id AND s.ingredient_id = i.id 
        GROUP by f.id) AS skl
        WHERE f.id = m.food_id
        AND f.id = s.food_id
        AND f.id = d.food_id
        AND f.id = skl.x";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
