<?php
use enum\FilePathEnum;

require_once __DIR__ . "/../../shared/FilePathEnum.php";
require_once __DIR__ . "/../../api/get.php";

$_SESSION["profile"] = init_data("getProfile", $_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./../../style/app.css">
</head>

<body class="bg-gray-100">
<?php
include (__DIR__ . "/../../components/private-nav.php");
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
            <h1 class="pb-2 text-3xl md:text-5xl font-bold text-black">Checkout.</h1>
        </div>
        <?php include (__DIR__ . "/../../components/alert.php"); ?>
        <div class="w-full rounded-md bg-white px-5 py-10 text-gray-800">
            <div class="w-full">
                <div class="-mx-3 md:flex items-start">
                    <div class="px-3 md:w-7/12 lg:pr-10">
                        <?php if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) { ?>
                            <div
                                    class="w-full mx-auto rounded-lg bg-white border text-center py-8 border-dashed border-red-700 p-3 text-gray-800 font-light mb-6">
                                <div class="flex justify-center items-center">
                                    <div class="text-red-700">
                                        Your shopping cart is empty! To continue you must add one of the products to
                                        your shopping cart.
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            foreach ($_SESSION["cart"] as $product) {
                                include_with_prop(__DIR__ . "/../../components/product/cart-element.php", array("product_name" => $product["name"], "quantity" => $product["quantity"], "price" => $product["price"], "img_path" => $product["img_path"], "product_id" => $product["product_id"],));
                            }
                        } ?>
                        <?php if (isset($_SESSION["cart_costs"]) && !empty($_SESSION["cart_costs"])) { ?>
                            <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                                <div class="w-full flex mb-3 items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Subtotal</span>
                                    </div>
                                    <div class="pl-3">
                                        <span
                                                class="font-semibold"><?php echo $_SESSION["cart_costs"]["sub_total"]; ?>€</span>
                                    </div>
                                </div>
                                <div class="w-full flex items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Taxes (MwSt.)</span>
                                    </div>
                                    <div class="pl-3">
                                        <span class="font-semibold">
                                            <?php echo $_SESSION["cart_costs"]["taxes"]; ?>€
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-gray-800 text-xl">
                                <div class="w-full flex items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Total</span>
                                    </div>
                                    <div class="pl-3">
                                        <span class="pr-2 font-semibold text-gray-400 text-sm">EUR</span><span
                                                class="font-semibold"><?php echo $_SESSION["cart_costs"]["total"]; ?>€</span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <div class="px-3 md:w-5/12">
                        <form method="POST" action="/php-web-store/api/post.php">
                            <?php if ($_SESSION["profile"]) { ?>
                                <div
                                        class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-3 items-center">
                                        <span class="text-gray-600 font-semibold">Contact</span>
                                        <div class="flex-grow pl-3">
                                            <span><?php echo $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"]; ?></span>
                                        </div>
                                    </div>
                                    <div class="w-full flex items-center">
                                        <span class="text-gray-600 font-semibold">Address</span>
                                        <div class="flex-grow pl-3">
                                            <span><?php echo $_SESSION["profile"]["street"] . ", " . $_SESSION["profile"]["postcode"] . " " . $_SESSION["profile"]["city"] . ", " . $_SESSION["profile"]["country"]; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else { ?>
                                <div
                                        class="w-full mx-auto rounded-lg bg-white border text-center py-8 border-dashed border-red-700 p-3 text-gray-800 font-light mb-6">
                                    <div class="flex justify-center items-center">
                                        <div class="text-red-700">Address not set! Please setup your settings and come
                                            back.
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                            <div
                                    class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                                <form method="POST" action="/php-web-store/api/post.php">
                                    <input class="hidden" name="payment_type" value="credit" />
                                    <input class="hidden" name="total"
                                           value="<?php if (isset($_SESSION["cart_costs"]["total"])) echo $_SESSION["cart_costs"]["total"]; ?>" />
                                    <input class="hidden" name="user_id"
                                           value="<?php echo $_SESSION["user_id"] ?>" />
                                    <div class="w-full p-3 border-b border-gray-200">
                                        <div class="mb-5">
                                            <img src="./../../assets/images/cards.png" class="h-6 ml-3">
                                        </div>
                                        <div>
                                            <div class="mb-3">
                                                <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Name on
                                                    card</label>
                                                <div>
                                                    <input
                                                            class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-secondary-default transition-colors"
                                                            placeholder="<?php echo $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"]; ?>"
                                                            name="name_on_card" type="text" />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <p class="text-red-700 mt-4 ml-1     text-base">For test purposes
                                                    use:
                                                    5410123412344567</p>
                                                <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Card
                                                    number</label>
                                                <div>
                                                    <input name="card_number"
                                                           class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-secondary-default transition-colors"
                                                           placeholder="0000 0000 0000 0000" type="text" />
                                                </div>
                                            </div>
                                            <div class="mb-3 -mx-2 flex items-end">
                                                <div class="px-2 w-1/3">
                                                    <label
                                                            class="text-gray-600 truncate font-semibold text-sm mb-2 ml-1">Expiration
                                                        date</label>
                                                    <div>
                                                        <select name="month"
                                                                class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-secondary-default transition-colors cursor-pointer">
                                                            <option value="01/01">01 - January</option>
                                                            <option value="02/01">02 - February</option>
                                                            <option value="03/01">03 - March</option>
                                                            <option value="04/01">04 - April</option>
                                                            <option value="05/01">05 - May</option>
                                                            <option value="06/01">06 - June</option>
                                                            <option value="07/01">07 - July</option>
                                                            <option value="08/01">08 - August</option>
                                                            <option value="09/01">09 - September</option>
                                                            <option value="10/01">10 - October</option>
                                                            <option value="11/01">11 - November</option>
                                                            <option value="12/01">12 - December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-2 w-1/3">
                                                    <select name="year"
                                                            class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-secondary-default transition-colors cursor-pointer">
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2020">2030</option>
                                                    </select>
                                                </div>
                                                <div class="px-2 w-1/3">
                                                    <label
                                                            class="text-gray-600 truncate font-semibold text-sm mb-2 ml-1">Security
                                                        code</label>
                                                    <div>
                                                        <input name="sec_code"
                                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-secondary-default transition-colors"
                                                               placeholder="000" type="text" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div>
                                <?php if (isset($_SESSION["profile"]) && !empty($_SESSION["profile"]) && isset($_SESSION["cart"]) && !empty($_SESSION["cart"]) && isset($_SESSION["cart_costs"])) { ?>
                                    <button name="createOrder" value="createOrder" type="submit"
                                            class="mr-3 w-full bg-gradient-to-br from-secondary-default hover:from-secondary-dark px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                                        Pay now
                                    </button>
                                    <?php
                                } else { ?>
                                    <button
                                            class="cursor-default mr-3 w-full bg-gray-300 hover:from-secondary-dark px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                                        Pay now
                                    </button>
                                    <?php
                                } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>