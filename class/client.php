<?php

class Client

{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addToCart($userId, $plantId)
{
    try {
        // Check if the product is already in the cart
        $checkQuery = "SELECT IdCart, quantity FROM cart WHERE UserId = ? AND PlantId = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(1, $userId);
        $checkStmt->bindParam(2, $plantId);
        $checkStmt->execute();
        $existingCartItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE IdCart = ?";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(1, $existingCartItem['IdCart']);
            $updateStmt->execute();
        } else {
            // If the product is not in the cart, insert a new row
            $insertQuery = "INSERT INTO cart (UserId, PlantId, quantity) VALUES (?, ?, 1)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(1, $userId);
            $insertStmt->bindParam(2, $plantId);
            $insertStmt->execute();
        }

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

public function deletePlantFromCart($userId, $plantId)
{
    try {
        // Delete the plant from the cart based on the UserId and PlantId
        $query = "DELETE FROM cart WHERE UserId = ? AND PlantId = ?";
        $stmt = $this->db->con->prepare($query);

        if ($stmt) {
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $plantId);

            $stmt->execute();
            $stmt->closeCursor();

            return true;
        } else {
            // Handle the case where the statement preparation fails
            echo "Error preparing statement: " . $this->db->errorInfo()[2];
            return false;
        }
    } catch (PDOException $e) {
        // Handle the case where an exception occurs
        echo "Error: " . $e->getMessage();
        return false;
    }
}


public function searchPlantsByName($searchTerm)
{
    $query = "SELECT * FROM plant WHERE Name LIKE :searchTerm";
    $stmt = $this->db->con->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Check if the search form is submitted



    




    
    
}
