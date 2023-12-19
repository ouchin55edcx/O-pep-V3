<?php

include("../class/display.php");
include("../class/admin.php");

$db = new db_Connection('localhost', 'root', '', 'opep2');
$admin = new Display($db);

// Retrieve all categories
$categories = $admin->getAllCategories();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $admin = new Admin($db);

    // Check if the required keys exist in the $_POST array
    if (
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['category']) &&
        isset($_FILES['image'])
    ) {
        // Retrieve form data
        $plantName = $_POST['name'];
        $plantPrice = $_POST['price'];
        $categoryId = $_POST['category']; // Assuming 'category' is your category select field
        $uploadedImage = $_FILES['image']; // Retrieve uploaded file information

        // Example usage of the addPlant method
        if ($admin->addPlant($plantName, $plantPrice, $categoryId, $uploadedImage)) {
           header('location: ../view/dashboard.php');
        } else {
            echo "Failed to add the plant. Please check for errors.";
        }
    } else {
        echo "Invalid form data.";
    }
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a4fc922de4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/png" href="../public/img/logo-1.png" />
    <link rel="stylesheet" href="./public/css/style.css">
   
</head>

<body class="bg-purple-700 font-[sitika] text-black">
    <section class="max-w-4xl p-6 mx-auto bg-purple-400 rounded-md shadow-md my-7">
        <h1 class="text-4xl font-bold capitalize ">Add Plant</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div id="formInp">
                <div class="form-group mb-6">
                    <input type="text" name="name"
                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        placeholder="Plant Name">
                </div>
                <div class="form-group mb-6 flex gap-4">
                    <div class="">
                        <input type="number" name="price"
                            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Plant Price">
                    </div>
                </div>
                <div class="form-group mb-6 w-full">
                    <select name="category" class="w-full p-2 rounded-md bg-white text-black">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['IdCategorie']; ?>">
                            <?php echo $category['CategorieName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-6 w-full">
                    <input type="file" name="image" class="block">
                </div>
                <hr class="border-2 my-4">
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex gap-6">
                    <button type="submit"
                        class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Save</button>
                    <a href="dashboard.php">
                        <button type="button"
                            class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Cancel</button>
                    </a>
                </div>
            </div>
        </form>
    </section>
</body>

</html>