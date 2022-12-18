<?php
use enum\FilePathEnum;

require_once __DIR__ . "/../../shared/FilePathEnum.php";
require_once __DIR__ . "/../../api/get.php";

$_SESSION["orders"] = init_data("getOrders", $_SESSION["user_id"]);
$_SESSION["profile"] = init_data("getProfile", $_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETTINGS</title>
    <link rel="stylesheet" href="./../../style/app.css">
</head>

<body class="bg-gray-100">
<?php
require __DIR__ . "/../../components/private-nav.php";
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
            <h1 class="pb-2 text-3xl md:text-5xl font-bold text-black">Settings.</h1>
        </div>
        <?php require __DIR__ . "/../../components/alert.php"; ?>
        <div class="mb-4 w-full p-4 bg-white rounded-md">
            <div class="flex sm:flex-col items-center md:flex-row">
                <div style="clip-path: url(#roundedPolygon)">
                    <img class="w-auto h-32 rounded-full mr-8 border-4 border-secondary-default"
                         src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png"  alt=""/>
                </div>
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col items-center md:items-start">
                        <h2 class="text-xl font-medium">
                            <?php echo $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"]; ?></h2>
                        <p class="text-base font-medium text-gray-400">
                            <?php echo isset($_SESSION["profile"]["country"]) ? $_SESSION["profile"]["country"] : "Please fill in all information."; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-3 flex-col justify-start items-center space-y-4">
                <a href="<?php echo isset($_GET["viewOrders"]) ? FilePathEnum::SETTINGS : FilePathEnum::SETTINGS . "?viewOrders"; ?>"
                   class="flex justify-between py-3 px-5 cursor-pointer w-full bg-gray-100 hover:bg-gray-200 duration-300 rounded-md">
                    <p class="text-gray-700">View your Orders</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <?php if (isset($_GET["viewOrders"])) { ?>
                    <div class="flex-col py-5 px-5 bg-gray-100 rounded-md space-y-3">
                        <?php
                        if (isset($_SESSION["orders"]) && !empty($_SESSION["orders"])) {
                            foreach ($_SESSION["orders"] as $order) {
                                include_with_prop(__DIR__ . "/../../components/product/list-element.php", array("id" => $order["id"], "name_on_card" => $order["name_on_card"], "created_at" => $order["created_at"], "total" => $order["total"],));
                            }
                        } else {
                            echo "<h1 class='text-red-700 font-medium'>Failed to load Orders! Maybe you have no Orders.</h1>";
                        }
                        ?>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
        <h2 class="text-2xl text-gray-900">Account Setting</h2>
        <div class="mt-6 border-t border-gray-400 pt-4">
            <div class='flex flex-wrap -mx-3 mb-6'>
                <div class='w-full md:w-full px-3 mb-6 '>
                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>password</label>
                    <button class="cursor-default bg-gray-300 px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                        Change Password
                    </button>
                </div>
                <div class="personal mb-6 w-full border-t border-gray-400 pt-4">
                    <form method="POST" action="/php-web-store/api/post.php">
                        <input name="user_id" value="<?php echo $_SESSION["user_id"] ?>" class="hidden" />
                        <h2 class="text-2xl ml-3 text-gray-900">Personal info:</h2>
                        <div class="flex-col items-center justify-between mt-4">
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'
                                       for='grid-text-1'>email address</label>
                                <input value="<?php echo $_SESSION["user"]["email"]; ?>"
                                       class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                       id='grid-text-1' name="email" type='email' placeholder='Enter email'>
                            </div>
                            <div class="flex">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>first
                                        name
                                    </label>
                                    <input name="firstName" value="<?php echo $_SESSION["user"]["firstName"] ?>"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           type='text' />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>last
                                        name</label>
                                    <input name="lastName" value="<?php echo $_SESSION["user"]["lastName"] ?>"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           type='text' />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button name="updateUser" value="updateUser" type="submit"
                                    class="mr-3 bg-gradient-to-br from-secondary-default hover:from-secondary-dark px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="personal w-full border-t border-gray-400 pt-4">
                    <form method="POST" action="/php-web-store/api/post.php">
                        <input name="user_id" value="<?php echo $_SESSION["user_id"] ?>" class="hidden" />
                        <h2 class="text-2xl ml-3 text-gray-900">Address info:</h2>
                        <div class='mt-4 w-full md:w-full px-3 mb-6'>
                            <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Street
                                + House number</label>
                            <input
                                    value="<?php echo isset($_SESSION["profile"]["street"]) ? $_SESSION["profile"]["street"] : "" ?>"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    type='text' name="street">
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>City</label>
                                <input
                                        value="<?php echo isset($_SESSION["profile"]["city"]) ? $_SESSION["profile"]["city"] : "" ?>"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="city">
                            </div>
                            <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Postcode</label>
                                <input
                                        value="<?php echo isset($_SESSION["profile"]["postcode"]) ? $_SESSION["profile"]["postcode"] : "" ?>"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="postcode">
                            </div>
                        </div>
                        <div class='w-full md:w-full px-3 mb-6'>
                            <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>pick
                                your
                                country</label>
                            <div class="flex-shrink w-full inline-block relative">
                                <select name="country"
                                        class="block appearance-none text-gray-600 w-full bg-white border border-gray-400 shadow-inner px-4 py-2 pr-8 rounded">
                                    <option value="<?php echo isset($_SESSION["profile"]["country"]) ? $_SESSION["profile"]["country"] : "" ?>">
                                        <?php echo isset($_SESSION["profile"]["country"]) ? $_SESSION["profile"]["country"] : "choose..." ?>
                                    </option>
                                    <option>Germany</option>
                                    <option>USA</option>
                                    <option>France</option>
                                    <option>Spain</option>
                                    <option>UK</option>
                                </select>
                                <div class="pointer-events-none absolute top-0 mt-3  right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button name="updateProfile" value="updateProfile" type="submit"
                                    class="mr-3 bg-gradient-to-br from-secondary-default hover:from-secondary-dark px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="personal w-full border-t border-gray-400 pl-3 mt-4 pt-4">
                    <form method="POST" action="/php-web-store/api/post.php">
                        <input class="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>" />
                        <button name="deleteUser" value="deleteUser"
                                class="bg-red-600 hover:bg-red-700 px-3 p-2 rounded-md text-white text-base to-secondary-dark hover:to-secondary-default duration-300">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
