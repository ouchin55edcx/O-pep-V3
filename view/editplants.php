<?php
session_start();

include '../class/display.php';
include '../class/admin.php';

$db = new db_Connection('localhost', 'root', '', 'opep2');

$plantManager = new Display($db);
$admin = new Admin($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['IdPlant'])) {
    $plantId = $_GET['IdPlant'];
    $plant = $plantManager->getPlantDetails($plantId);
    $categories = $plantManager->getCategories();

    if (!$plant) {
        header("Location: dashboard.php");
        exit();
    }

    $plantId = $_GET['IdPlant'];
    $plantName = htmlspecialchars($plant['Name']);
    $plantPrice = htmlspecialchars($plant['price']);
    $categoryId = $plant['CategorieId'];
    $imagePath = htmlspecialchars($plant['image']);
}

// collection of form data

if (isset($_POST['updatePlant']) && isset($_GET['IdPlant'])) {
    $IdPlant = $_GET['IdPlant'];
    $plantName = $_POST['name'];
    $plantPrice = $_POST['price'];
    $categoryId = $_POST['category'];
    $uploadedImage = $_FILES['image'];

    // Set the category ID in the session
    $_SESSION['CategorieId'] = $categoryId;

    $admin->updatePlant($IdPlant, $plantName, $plantPrice, $categoryId, $uploadedImage);

    header('Location: dashboard.php');
    // exit();  // Add an exit to stop execution after the header redirect
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
        <h1 class="text-4xl font-bold capitalize">Edit Plant</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                <div>
                    <label class="font-bold" for="name">Plant Name</label>

                    <input id="name" name="name" value="<?php echo isset($plantName) ? htmlspecialchars($plantName) : ''; ?>" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-[#685942] rounded-md focus:border-[#685942] focus:outline-none focus:ring">
                    <span class="font-bold text-orange-400"></span>
                </div>

                <div>
                    <label class="font-bold" for="price">Price</label>
                    <input id="price" name="price" value="<?php echo isset($plantPrice) ? htmlspecialchars($plantPrice) : ''; ?>" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-[#685942] rounded-md focus:border-[#685942] focus:outline-none focus:ring ">
                    <span class="font-bold text-orange-400"></span>
                </div>

                <div>
                    <label class="block font-bold">
                        Plant Image
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white border-dashed rounded-md">
                        <div class="space-y-1 text-center">

                            <img src="<?php echo isset($imagePath) ? $imagePath : ''; ?>" alt="Current Image" class="h-24 w-24 mx-auto rounded-md">
                            <div class="flex text-sm">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium hover:text-blue-300">
                                    <span class="">Upload a file</span>
                                    <input id="file-upload" name="image" type="file" value="" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs">PNG, JPG</p>
                        </div>
                    </div>
                    <span class="font-bold text-orange-400"></span>
                </div>


                <div class="form-group mb-6 w-full">
                    <select name="category" class="w-full p-2 rounded-md bg-white text-black">
                        <option value="">Select Category</option>

                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['IdCategorie']; ?>" <?php echo ($category['IdCategorie'] == $categoryId) ? 'selected' : ''; ?>>
                                <?php echo $category['CategorieName']; ?>
                            </option>
                        <?php endforeach; ?>    
                    </select>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <div class="flex gap-6">
                    <button type="submit" name="updatePlant" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Save</button>
                    <a href="dashboard.php">
                        <button type="button" class="px-6 py-2 leading-5 transform rounded-md focus:outline-none font-bold bg-[#FFF8ED] transition hover:bg-purple-900 hover:text-[#FFF2DF]">Cancel</button>
                    </a>
                </div>
            </div>
            <input type="hidden" name="plantId" value="<?= $plantId ?>">
        </form>
    </section>
</body>

</html>