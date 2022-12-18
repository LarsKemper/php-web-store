<?php
use enum\FilePathEnum;

require_once __DIR__ . "/../shared/FilePathEnum.php";
require_once __DIR__ . "/../api/get.php";

if (isset($_GET["product_id"])) {
    $_SESSION["product"] = init_data("getProduct", $_GET["product_id"]);
} else {
    header("location: " . FilePathEnum::HOME);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCT</title>
    <link rel="stylesheet" href="./../style/app.css">
</head>

<body class="bg-gray-100">
<?php
require __DIR__ . "/../components/private-nav.php";
?>
<div class="my-8 container mx-auto">
    <div class="w-full max-w-4xl p-6 mx-auto">
        <form method="POST" action="/php-web-store/api/post.php">
            <button name="redirect" value="<?php echo FilePathEnum::HOME ?>" type="submit"
                    class="flex items-center mr-3 bg-white hover:bg-gray-200 px-3 p-2 rounded-md text-black text-base to-secondary-dark hover:to-secondary-default duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Home
            </button>
        </form>
        <div class="my-5 mb-2">
            <h1 class="pb-2 text-3xl md:text-5xl font-bold text-black">Product.</h1>
        </div>
        <section class="rounded-md text-gray-700 body-font overflow-hidden bg-white">
            <div class="container px-5 2xl:px-0 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                    <?php require __DIR__ . "/../components/alert.php"; ?>
                    <?php if (!empty($_SESSION["product"])) { ?>
                        <img alt="ecommerce"
                             class="lg:w-1/2 w-full object-cover object-center rounded-md border border-gray-200"
                             src="<?php echo $_SESSION["product"]["img_path"]; ?>">
                        <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                            <form method="POST" action="/php-web-store/api/post.php">
                                <input class="hidden" name="name" value="<?php echo $_SESSION["product"]["name"]; ?>" />
                                <input class="hidden" name="price"
                                       value="<?php echo $_SESSION["product"]["price"]; ?>" />
                                <input class="hidden" name="img_path"
                                       value="<?php echo $_SESSION["product"]["img_path"]; ?>" />
                                <input class="hidden" name="product_id"
                                       value="<?php echo $_SESSION["product"]["id"] ?>" />
                                <h2 class="text-sm title-font text-gray-500 tracking-widest">php-web-store</h2>
                                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">
                                    <?php echo $_SESSION["product"]["name"]; ?></h1>
                                <p class="mt-4 leading-relaxed">
                                    <?php echo $_SESSION["product"]["description"]; ?>
                                </p>
                                <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-200 mb-5">
                                    <div class="flex items-center">
                                        <span class="mr-3">Color</span>
                                        <div class="relative">
                                            <select name="color"
                                                    class="rounded border appearance-none border-gray-400 py-2 focus:outline-none text-base pl-3 pr-10">
                                                <option value="Black">Black</option>
                                                <option value="Grey">Grey</option>
                                                <option value="Red">Red</option>
                                                <option value="Blue">Blue</option>
                                            </select>
                                            <span
                                                    class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                     stroke-linejoin="round" stroke-width="2" class="w-4 h-4"
                                                     viewBox="0 0 24 24">
                                                    <path d="M6 9l6 6 6-6"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex ml-6 items-center">
                                        <span class="mr-3">Size</span>
                                        <div class="relative">
                                            <select name="size"
                                                    class="rounded border appearance-none border-gray-400 py-2 focus:outline-none text-base pl-3 pr-10">
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                            </select>
                                            <span
                                                    class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                     stroke-linejoin="round" stroke-width="2" class="w-4 h-4"
                                                     viewBox="0 0 24 24">
                                                    <path d="M6 9l6 6 6-6"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-200 mb-5">
                                    <div class="flex items-center">
                                        <span class="mr-3">Quanity</span>
                                        <div class="relative">
                                            <select name="quantity"
                                                    class="rounded border appearance-none border-gray-400 py-2 focus:outline-none text-base pl-3 pr-10">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                     stroke-linejoin="round" stroke-width="2" class="w-4 h-4"
                                                     viewBox="0 0 24 24">
                                                    <path d="M6 9l6 6 6-6"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <span class="title-font font-medium text-2xl text-gray-900"><?php echo $_SESSION["product"]["price"]; ?>€</span>
                                    <button name="updateCart" value="updateCart" type="submit"
                                            class="flex ml-auto bg-gradient-to-br from-secondary-default hover:from-secondary-dark px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                        <?php
                    } else { ?>
                        <div class="flex w-full items-center bg-red-100 rounded-lg p-4 mb-4 text-lg text-red-700"
                             role="alert">
                            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <span class="font-medium">Product not found!</span>
                            </div>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        </section>
    </div>
</div>
</body>

</html>
