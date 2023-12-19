<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function signUp($firstName, $lastName, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user (`FirstName`, `LastName`, `Email`, `Password`) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bindParam(1, $firstName);
                $stmt->bindParam(2, $lastName);
                $stmt->bindParam(3, $email);
                $stmt->bindParam(4, $hashedPassword);

                $stmt->execute();
                $stmt->closeCursor();

                $_SESSION['user_email'] = $email;

                header("Location: ../view/role.php");
                exit();
            } else {
                echo "Error preparing statement: " . $this->db->con->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function selectRole($selectedRole)
    {
        try {
            if (isset($_SESSION['user_email'])) {
                $userEmail = $_SESSION['user_email'];

                $query = "UPDATE user SET roleId = ? WHERE email = ?";
                $stmt = $this->db->prepare($query);

                if ($stmt) {
                    $stmt->bindParam(1, $selectedRole);
                    $stmt->bindParam(2, $userEmail);

                    $stmt->execute();
                    $stmt->closeCursor();
                    header('location: ../view/login.php');

                    // if ($selectedRole == 1) {
                    //     header("Location: ../view/index.php");
                    //     exit();
                    // } elseif ($selectedRole == 2) {
                    //     header("Location: ../view/dashboard.php");
                    //     exit();
                    // }
                } else {
                    echo "Error preparing statement: " . $this->db->con->errorInfo()[2];
                }
            } else {
                echo "User email not found in session.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $query = "SELECT IdUser, RoleId, `Password` FROM User WHERE Email = ?";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $stmt->bindParam(1, $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $storedPassword = $result['Password'];

                    // Verify the entered password against the stored hashed password
                    if (password_verify($password, $storedPassword)) {
                        session_start();
                        $_SESSION['user_email'] = $email;

                        // Redirect based on the user's role
                        if ($result['RoleId'] === 2) {
                            header("Location: ../view/dashboard.php");
                        } elseif ($result['RoleId'] === 1) {
                            header("Location: ../view/home.php");
                        } else {
                            header("Location: ../view/sign_up.php");
                        }
                    } else {
                        echo "Entered password does not match. Please try again.";
                    }
                } else {
                    echo "Invalid credentials. Please try again.";
                }

                $stmt->closeCursor();
            } else {
                // Handle the case where the prepare statement fails
                echo "Error preparing statement: " . $this->db->con->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function logout() {
        session_start();  // Start the session (if not already started)

        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Unset all session variables
            $_SESSION = array();

            // Destroy the session
            session_destroy();

            // Redirect to the login page or any other page you desire
            header('Location: login.php');
            exit();
        } else {
            // If the user is not logged in, redirect them to the login page
            header('Location: login.php');
            exit();
        }
    }
}

?>

