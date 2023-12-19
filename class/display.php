<?php

include("../config/db_Connection.php");

class Display
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    // get all category for selector
    public function getAllCategories()
    {
        try {
            $query = "SELECT * FROM categorie";
            $stmt = $this->db->con->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            // Handle the exception as needed
            echo "Error: " . $e->getMessage();
            return array();
        }
    }
//     public function getAllCategories()
// {
//     try {
//         $query = "SELECT IdCategorie, CategorieName FROM categorie";
//         $stmt = $this->db->con->prepare($query);
//         $stmt->execute();

//         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         return $result;
//     } catch (PDOException $e) {
//         // Handle the exception as needed
//         echo "Error: " . $e->getMessage();
//         return array();
//     }
// }

public function getCategoryNamesForSelector()
{
    try {
        $query = "SELECT IdCategorie, CategorieName FROM categorie";
        $stmt = $this->db->con->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        // Handle the exception as needed
        echo "Error: " . $e->getMessage();
        return array();
    }
}



    // get all category for dashboard
    public function displayCategoriesInDashboard()
    {
        try {
            // Retrieve all categories
            $query = "SELECT * FROM categorie";
            $result = $this->db->con->query($query);

            if ($result) {
                $categories = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($categories as $category) {
                    echo '<tr>';
                    echo '<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">';
                    echo '<p>' . htmlspecialchars($category['CategorieName']) . '</p>';
                    echo '</td>';
                    echo '<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">';
                    echo '<div class="flex space-x-4">';
                    echo '<a href="../view/editcategory.php?IdCategorie=' . $category['IdCategorie'] . '" class="text-blue-500 hover:text-blue-600">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />';
                    echo '</svg>';
                    echo '<p>Edit</p>';
                    echo '</a>';
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="categoryId" value="' . $category['IdCategorie'] . '">';
                    echo '<button type="submit" name="deleteCategory" class="text-red-500 hover:text-red-600">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />';
                    echo '</svg>';
                    echo '<p>Delete</p>';
                    echo '</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // desplay plants in dashboard 
    public function displayPlantsInDashboard()
    {
        $query = "SELECT * FROM plant";
        $result = $this->db->con->query($query);

        if ($result) {
            $plants = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($plants as $plant) {
                echo "
                <tr>
                    <td class='w-9'>
                        <img src='{$plant['image']}' alt='Plant Image'>
                    </td>
                    <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                        <p>" . htmlspecialchars($plant['Name']) . "</p>
                    </td>
                    <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                        <div class='flex text-[#685942]'>
                            <p>" . htmlspecialchars($plant['price']) . " DH</p>
                        </div>
                    </td>
                    <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                        <div class='flex space-x-4'>
                            <a href='../view/editplants.php?IdPlant={$plant['IdPlant']}' class='text-blue-500 hover:text-blue-600'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' />
                                </svg>
                                <p>Edit</p>
                            </a>
                            <form action='../view/dashboard.php' method='POST'>
                                <input type='hidden' name='IdPlant' value='{$plant['IdPlant']}'>
                                <button type='submit' name='deletePlant' class='text-red-500 hover:text-red-600'>
                                    <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 mr-1 ml-3' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                                    </svg>
                                    <p>Delete</p>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>";
            }
        }
    }

    
    // get category details foe editing 
    public function displayCategoryDetails($categoryId)
    {
        // Query to fetch category details from the database
        $query = "SELECT * FROM categorie WHERE IdCategorie = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categoryId]);

        // Fetch category details
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // get plants details for editing 
    public function getPlantDetails($plantId)
    {
        $query = "SELECT * FROM `plant` WHERE IdPlant = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$plantId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getCategories()
    {
        try {
            $query = "SELECT * FROM categorie";
            $stmt = $this->db->con->query($query);

            if ($stmt) {
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $categories;
            } else {
                // Handle the error, you might want to log it or throw an exception
                return array();
            }
        } catch (PDOException $e) {
            // Handle the exception as needed
            echo "Error: " . $e->getMessage();
            return array();
        }
    }

    // get plants details for home page
    public function getPlants() {
        try {
            $query = "SELECT IdPlant, Name, price, image FROM Plant";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $IdPlant = $_SESSION['IdPlant'] ;

            return $plants;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // public function displayCartCount($cartCount) {
    //     if ($cartCount > 0) {
    //         echo "<p class='bg-purple-700 text-white text-md text-center m-auto rounded-full animate-bounce font-bold w-[1rem]'>$cartCount</p>";
    //     } else {
    //         echo "";
    //     }
    // }
    // get user id
    public function fetchUserIdBySessionEmail()
    {
        try {
            if (isset($_SESSION['user_email'])) {
                $userEmail = $_SESSION['user_email'];

                $query = "SELECT IdUser FROM user WHERE email = ?";
                $stmt = $this->db->prepare($query);

                if ($stmt) {
                    $stmt->bindParam(1, $userEmail);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $stmt->closeCursor();

                    if ($result) {
                        return $result['IdUser'];
                    } else {
                        echo "User not found with email: " . $userEmail;
                        return false;
                    }
                } else {
                    echo "Error preparing statement: " . $this->db->errorInfo()[2];
                    return false;
                }
            } else {
                echo "User email not found in session.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getCartItemsByUserId($userId)
    {
        try {
            $query = "SELECT c.plant_id, c.plant_name, c.plant_price, c.plant_image
                      FROM cart c
                      JOIN user_cart uc ON c.plant_id = uc.plant_id
                      WHERE uc.user_id = ?";
            $stmt = $this->db->con->prepare($query);
            $stmt->bindParam(1, $userId);
            $stmt->execute();

            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $cartItems;
        } catch (PDOException $e) {
            // Handle the exception as needed
            echo "Error: " . $e->getMessage();
            return array();
        }
    }

    public function displayPlantsInCart()
    {
        // Assuming you have the user ID stored in your session
        $userId = $this->fetchUserIdBySessionEmail();
    
        if (!$userId) {
            // Handle the case where user ID is not available
            echo "User ID not found in session.";
            return;
        }
    
        $query = "SELECT cart.*, plant.*
                  FROM cart 
                  JOIN plant ON PlantId = IdPlant
                  WHERE UserId = ?";
        $result = $this->db->con->prepare($query);
    
        $result->bindParam(1, $userId);
        $result->execute();
    
        if ($result) {
            $plants = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $totalPrice = 0;
    
            foreach ($plants as $plant) {
                $plantTotalPrice = $plant['price'] * $plant['quantity'];
    
                $totalPrice += $plantTotalPrice;
    
                echo "
                    <tr>
                        <td class='w-9'>
                            <img src='{$plant['image']}' alt='Plant Image'>
                        </td>
                        <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                            <p>" . htmlspecialchars($plant['Name']) . "</p>
                        </td>
                        <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                            <div class='flex text-[#685942]'>
                                <p>Price: " . htmlspecialchars($plant['price']) . " DH</p>
                            </div>
                        </td>
                        <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                            <div class='flex text-[#685942]'>
                                <p>quantity: " . htmlspecialchars($plant['quantity']) . "</p>
                            </div>
                        </td>
                        <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                            <div class='flex text-[#685942]'>
                                <p>Total Price: " . htmlspecialchars($plantTotalPrice) . " DH</p>
                            </div>
                        </td>
                        <td class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                            <div class='flex space-x-4'>
                                <form action='' method='POST'>
                                    <input type='hidden' name='idplant' value='{$plant['IdPlant']}'>
                                    <button type='submit' name='deletePlant' class='text-red-500 hover:text-red-600'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 mr-1 ml-3' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                                        </svg>
                                        <p>Delete</p>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>";
            }
    
            echo "
                <tr>
                    <td colspan='5' class='px-6 py-4 whitespace-no-wrap text-sm leading-5'>
                        <div class='flex text-[#685942]'>
                            <p>Total Cart Price: " . htmlspecialchars($totalPrice) . " DH</p>
                        </div>
                    </td>
                </tr>";
        }
    }

    public function countPlantsInCart()
    {
        $query = "SELECT COUNT(*) FROM cart"; // Adjust the query based on your actual schema
        $stmt = $this->db->con->query($query);
        return $stmt->fetchColumn(); // Fetch the count directly
    }
    

    
    
    


    
}

    
