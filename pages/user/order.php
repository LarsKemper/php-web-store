<?php
  use enum\FilePathEnum;
  require_once __DIR__."/../../shared/filePathEnum.php";
  require_once __DIR__."/../../api/get.php";
  $_SESSION["profile"] = init_data("getProfile", $_SESSION["user_id"]);
  if(isset($_GET["order_id"]) && !empty($_GET["order_id"])){
      $_SESSION["order"] = init_data("getOrder", $_GET["order_id"]);
      if($_SESSION["order"]["details"]["user_id"] !== $_SESSION["user_id"]) {
          header("location: ".FilePathEnum::NOT_FOUND);
      }
  } else {
      header("location: ".FilePathEnum::CART);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER</title>
    <link rel="stylesheet" href="./../../style/app.css">
</head>

<body class="bg-gray-100">
    <?php
      include(__DIR__."/../../components/private-nav.php");
    ?>
    <div class="my-8 container mx-auto">
        <div class="w-full max-w-4xl p-6 mx-auto">
            <form method="POST" action="/web-store/api/post.php">
                <button name="redirect" value="<?php echo FilePathEnum::HOME ?>" type="submit"
                    class="flex items-center mr-3 bg-white hover:bg-gray-200 px-3 p-2 rounded-md text-black text-base to-secondary-dark hover:to-secondary-default duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Home
                </button>
            </form>
            <?php if(isset($_SESSION["profile"]) && !empty($_SESSION["profile"]) && isset($_SESSION["order"]) && !empty($_SESSION["order"])) { ?>
            <div class="my-5 mb-2">
                <h1 class="text-3xl md:text-5xl font-bold text-black">Order
                    #<?php echo $_SESSION["order"]["details"]["id"] ?></h1>
                <p class="pl-1 pb-2 text-lg font-medium leading-6 text-gray-600">
                    <?php echo $_SESSION["order"]["details"]["created_at"]; ?>
                </p>
            </div>
            <?php include(__DIR__."/../../components/alert.php"); ?>
            <div
                class="flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
                <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                    <div
                        class="flex flex-col justify-start items-start bg-white rounded-md px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                        <p class="text-lg md:text-xl font-semibold leading-6 xl:leading-5 text-gray-800">
                            Ordered Products</p>
                        <?php 
                            if(isset($_SESSION["order"]["items"])){
                                foreach($_SESSION["order"]["items"] as $product){ 
                                    include_with_prop(__DIR__."/../../components/product/order-element.php", array(
                                        "img_path" => $product["img_path"],
                                        "product_name" => $product["product_name"],
                                        "quantity" => $product["quantity"],
                                        "price" => $product["price"],
                                        "size" => $product["size"],
                                        "color" => $product["color"],
                                    ));
                                }
                            } else {
                                echo "<h1 class='text-red-700 font-medium'>Failed to load Products!</h1>";
                            }
                        ?>
                    </div>
                    <div
                        class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                        <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-white rounded-md space-y-6">
                            <h3 class="text-xl font-semibold leading-5 text-gray-800">Summary</h3>
                            <div
                                class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                                <div class="flex justify-between w-full">
                                    <p class="text-base leading-4 text-gray-800">Subtotal</p>
                                    <p class="text-base leading-4 text-gray-600">
                                        <?php echo $_SESSION["order"]["details"]["total"] ?>€</p>
                                </div>
                                <div class="flex justify-between items-center w-full">
                                    <p class="text-base leading-4 text-gray-800">Shipping</p>
                                    <p class="text-base leading-4 text-gray-600">8.00€</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base font-semibold leading-4 text-gray-800">Total</p>
                                <p class="text-base font-semibold leading-4 text-gray-600">
                                    <?php echo $_SESSION["order"]["details"]["total"] + 8 ?>€
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-white rounded-md space-y-6">
                            <h3 class="text-xl font-semibold leading-5 text-gray-800">Shipping</h3>
                            <div class="flex justify-between items-start w-full">
                                <div class="flex justify-center items-center space-x-4">
                                    <div class="w-8 h-8">
                                        <img class="w-full h-full" alt="logo" src="./../../assets/dpd_logo.png" />
                                    </div>
                                    <div class="flex flex-col justify-start items-center">
                                        <p class="text-lg leading-6 font-semibold text-gray-800">DPD
                                            Delivery<br /><span class="font-normal">Delivery with 24 Hours</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-center items-center">
                                <a href="https://www.dpd.com/" target="__blank"
                                    class="text-center bg-gradient-to-br text-base from-secondary-default hover:from-secondary-dark py-3 rounded-md text-white to-secondary-dark hover:to-secondary-default duration-300 w-full">
                                    View Carrier Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-md w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
                    <h3 class="text-xl font-semibold leading-5 text-gray-800">Profile</h3>
                    <div
                        class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                        <div class="flex flex-col justify-start items-start flex-shrink-0">
                            <div
                                class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                                <img class="h-12 w-12 rounded-md" src="./../../assets/user_pb.png" alt="avatar" />
                                <div class="flex justify-start items-start flex-col space-y-2">
                                    <p class="text-base font-semibold leading-4 text-left text-gray-800">
                                        <?php echo $_SESSION["user"]["firstName"]." ".$_SESSION["user"]["lastName"]; ?>
                                    </p>
                                    <p class="text-sm leading-5 text-gray-600">
                                        <? echo $_SESSION["profile"]["country"]; ?>
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex justify-center text-gray-800 md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 7L12 13L21 7" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <p class="cursor-pointer text-sm leading-5 "><?php echo $_SESSION["user"]["email"]; ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                            <div
                                class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                                <div
                                    class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                                    <p class="text-base font-semibold leading-4 text-center md:text-left text-gray-800">
                                        Shipping Address</p>
                                    <p
                                        class="w-48 lg:w-full xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                                        <?php echo $_SESSION["profile"]["street"].", ".$_SESSION["profile"]["postcode"]." ".$_SESSION["profile"]["city"].", ".$_SESSION["profile"]["country"]; ?>
                                    </p>
                                </div>
                                <div
                                    class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4">
                                    <p class="text-base font-semibold leading-4 text-center md:text-left text-gray-800">
                                        Billing Address</p>
                                    <p
                                        class="w-48 lg:w-full xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                                        <?php echo $_SESSION["profile"]["street"].", ".$_SESSION["profile"]["postcode"]." ".$_SESSION["profile"]["city"].", ".$_SESSION["profile"]["country"]; ?>
                                    </p>
                                </div>
                            </div>
                            <form method="POST" action="/web-store/api/post.php">
                                <div class="flex w-full justify-center items-center md:justify-start md:items-start">
                                    <button name="redirect" value="<?php echo FilePathEnum::SETTINGS; ?>"
                                        class="mt-6 md:mt-0 py-4 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black border border-secondary-default font-medium w-96 2xl:w-full text-base font-medium leading-4 text-secondary-default">Edit
                                        Details</button>
                                </div>
                            </form>
                            <form method="POST" action="/web-store/api/post.php">
                                <input class="hidden" name="order_id" value="<?php echo $_GET["order_id"] ?>" />
                                <div class="flex w-full justify-center items-center md:justify-start md:items-start">
                                    <button type="submit" name="deleteOrder" value="deleteOrder"
                                        class="mt-6 md:mt-0 py-4 rounded-md hover:bg-red-700 bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black font-medium w-96 2xl:w-full text-base font-medium leading-4 text-white">Cancel
                                        Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div class="mt-4 w-full flex items-center bg-red-100 rounded-lg p-4 mb-4 text-lg text-red-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-medium">Failed to load Data!</span>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>