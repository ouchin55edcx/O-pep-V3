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
            $query = "INSERT INTO cart (UserId, PlantId) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bindParam(1, $userId);
                $stmt->bindParam(2, $plantId);

                $stmt->execute();
                $stmt->closeCursor();

                return true;
            } else {
                echo "Error preparing statement: " . $this->db->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    
    
}
