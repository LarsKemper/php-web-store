<?php
  require_once __DIR__."/api/get.php";
  $_SESSION["products"] = init_data("getProducts");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="./style/app.css">
</head>

<body class="bg-gray-100">
    <?php require __DIR__."/components/private-nav.php"; ?>
    <div class="my-8 container mx-auto">
        <div class="inputs w-full max-w-4xl p-6 mx-auto">
            <div class="mt-5 mb-2">
                <div class="flex flex-wrap w-full mb-4 p-4">
                    <div class="w-full mb-6 lg:mb-0">
                        <h1 class="text-3xl md:text-5xl font-bold text-black">Welcome,
                            <?php echo $_SESSION["firstName"]; ?>!
                        </h1>
                        <div class="my-2 h-1 w-20 bg-secondary-default rounded"></div>
                    </div>
                </div>
                <div class="flex flex-wrap -m-4">
                    <?php 
                    if(isset($_SESSION["products"]) || !$_SESSION["products"]) {
                        foreach($_SESSION["products"] as $product){
                            include_with_prop(
                                __DIR__."/components/product/product.php", array(
                                    "product_id" => $product["id"],
                                    "product_name" => $product["name"],
                                    "price" => $product["price"],
                                    "img_path" => $product["img_path"],
                                )
                            );
                        }
                    } else {
                        echo "<h1 class='text-red-700 font-medium'>Failed to load Products!</h1>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>