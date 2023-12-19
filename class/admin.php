<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Admin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // add category
    public function AddCategory($name)
    {
        try {
            $insertQuery = "INSERT INTO categorie (CategorieName) VALUES (?)";
            $insertStmt = $this->db->con->prepare($insertQuery);

            if ($insertStmt) {
                $insertStmt->execute([$name]);
                header("location: ../view/dashboard.php");
                return true;
            } else {
                echo "Error preparing statement: " . $this->db->con->error;
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // delete category 
    public function deleteCategory($categoryIdToDelete)
    {
        try {
            // Check if the category exists
            $checkQuery = "SELECT * FROM categorie WHERE IdCategorie = ?";
            $checkStmt = $this->db->con->prepare($checkQuery);
            $checkStmt->execute([$categoryIdToDelete]);

            // Delete the category
            $deleteQuery = "DELETE FROM categorie WHERE IdCategorie = ?";
            $deleteStmt = $this->db->con->prepare($deleteQuery);

            if ($deleteStmt) {
                $deleteStmt->execute([$categoryIdToDelete]);
                header("location: ../view/dashboard.php");
                return true;
            } else {
                echo "Error preparing statement: " . $this->db->con->error;
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // add plants
    public function addPlant($plantName, $plantPrice, $categoryId, $uploadedImage)
    {
        try {

            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (
                isset($uploadedImage['name']) &&
                isset($uploadedImage['tmp_name'])
            ) {
                $imagePath = $uploadDir . uniqid() . '_' . $uploadedImage['name'];

                if (move_uploaded_file($uploadedImage['tmp_name'], $imagePath)) {

                    $insertQuery = "INSERT INTO Plant (Name, price, CategorieId, image) VALUES (?, ?, ?, ?)";
                    $insertStmt = $this->db->con->prepare($insertQuery);

                    if ($insertStmt) {
                        $insertStmt->execute([$plantName, $plantPrice, $categoryId, $imagePath]);
                        return true;
                    } else {
                        echo "Error preparing statement: " . $this->db->con->error;
                        return false;
                    }
                }
            } else {
                echo "Invalid file upload data.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    //delete plant
    public function deletePlant($plantIdToDelete)
    {
        try {
            $deleteQuery = "DELETE FROM plant WHERE IdPlant = ?";
            $deleteStmt = $this->db->con->prepare($deleteQuery);

            if ($deleteStmt) {
                // Bind the parameter directly in the execute statement
                $deleteStmt->execute([$plantIdToDelete]);

                return true;
            } else {
                echo "Error preparing statement: " . $this->db->con->error;
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    // edit category 

    public function updateCategory($categoryId, $updatedCategoryName)
    {
        // Perform the update query based on the retrieved category ID
        $query = "UPDATE `categorie` SET CategorieName = ? WHERE IdCategorie = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$updatedCategoryName, $categoryId]);

        // Redirect to the dashboard or another appropriate page after the update
        header("Location: dashboard.php");
        exit();
    }

    // edit plants 

    public function updatePlant($IdPlant, $plantName, $plantPrice, $categoryId, $uploadedImage) {
        try {
            $updateQuery = "UPDATE plant SET `Name` = ?, `price` = ?, `CategorieId` = ? WHERE `IdPlant` = ?";
            $updateStmt = $this->db->prepare($updateQuery);

            if ($updateStmt) {
                $updateStmt->execute([$plantName, $plantPrice, $categoryId, $IdPlant]);

            } else {
                throw new Exception("Error preparing statement: " . $this->db->errorInfo()[2]);
            }

            if (!empty($uploadedImage)) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $imagePath = $uploadDir . uniqid() . '_' . $uploadedImage['name'];

                if (move_uploaded_file($uploadedImage['tmp_name'], $imagePath)) {

                    $updateImageQuery = "UPDATE plant SET `image` = ? WHERE `IdPlant` = ?";
                    $updateImageStmt = $this->db->prepare($updateImageQuery);

                    if ($updateImageStmt) {
                        $updateImageStmt->execute([$imagePath, $IdPlant]);
                    } else {
                        throw new Exception("Error preparing image update statement: " . $this->db->errorInfo()[2]);
                    }
                } else {
                    throw new Exception("File move failed!");
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    


    
}
