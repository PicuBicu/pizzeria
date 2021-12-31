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

    public function getProductWithDetailsById(int $productId)
    {
        $sql = "SELECT f.id, f.name, m.price AS mała, s.price AS średnia, d.price AS duża, skl.ingredients
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
            AND f.id = skl.x
            AND f.id = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getFoodSizeIdByFoodId(int $foodId, string $size)
    {
        $sql = "SELECT id AS food_size_id 
            FROM food_size 
            WHERE name = :size 
            AND food_id = :foodId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        $stmt->bindParam(":size", $size, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            return $row["food_size_id"];
        }
        return false;
    }
}
