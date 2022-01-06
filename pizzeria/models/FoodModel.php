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

    public function deleteProductById(int $foodId)
    {
        $sql = "DELETE FROM food WHERE id = :foodId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addProduct(string $productName)
    {
        $sql = "INSERT INTO food (`name`) VALUES (:productName)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":productName", $productName, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addProductPrices(int $foodId, float $small, float $average, float $big)
    {
        $sql = "INSERT INTO food_size (food_id, `name`, price) 
                VALUES
                (:foodId, 'mała', :small),
                (:foodId, 'średnia', :average),
                (:foodId, 'duża', :big)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        $stmt->bindParam(":small", $small, PDO::PARAM_STR);
        $stmt->bindParam(":average", $average, PDO::PARAM_STR);
        $stmt->bindParam(":big", $big, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addProductIngredients(int $foodId, array $ingredientsIds)
    {
        $length = count($ingredientsIds);
        for ($i = 0; $i < $length; $i++) {
            $sql = "INSERT INTO storage (food_id, ingredient_id) VALUES(:foodId, :ingredientId)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
            $stmt->bindParam(":ingredientId", $ingredientsIds[$i], PDO::PARAM_INT);
            if (!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }

    public function updateProductById(int $foodId, string $foodName)
    {
        $sql = "UPDATE food SET `name` = :foodName WHERE id = :foodId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        $stmt->bindParam(":foodName", $foodName, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateProductPricesByFoodId(int $foodId, float $small, float $average, float $big)
    {
        $sql = "UPDATE food_size SET price = :small WHERE id = :foodId AND `name` = 'mała';
                UPDATE food_size SET price = :average WHERE id = :foodId AND `name` = 'średnia';
                UPDATE food_size SET price = :big WHERE id = :foodId AND `name` = 'duża';";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":foodId", $foodId, PDO::PARAM_INT);
        $stmt->bindParam(":small", $small, PDO::PARAM_STR);
        $stmt->bindParam(":average", $average, PDO::PARAM_STR);
        $stmt->bindParam(":big", $big, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
