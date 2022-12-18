<?php
use enum\FilePathEnum;
require_once __DIR__ . "/../../shared/FilePathEnum.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" href="./../../style/app.css">
</head>

<body class="bg-gray-100">
<div class="flex flex-col justify-between h-screen">
    <?php
    require __DIR__ . "/../../components/nav.php";
    ?>
    <div>
        <div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
            <h1 class="lg:text-3xl text-xl font-semibold mb-6"> Sign in</h1>
            <?php require __DIR__ . "/../../components/alert.php"; ?>
            <p class="mb-2 text-black text-lg">
                Register to manage your account
            </p>
            <form method="POST" action="/web-store/api/post.php">
                <div class="flex lg:flex-row flex-col lg:space-x-2">
                    <input name="firstName" type="text" placeholder="First Name"
                           class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                    <input name="lastName" type="text" placeholder="Last Name"
                           class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                </div>
                <input name="email" type="email" placeholder="Email"
                       class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                <input name="password" type="password" placeholder="Password"
                       class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                <input name="password2" type="password" placeholder="Confirm Password"
                       class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                <div class="flex justify-start my-4 space-x-1">
                    <div class="control-group">
                        <label class="control control-checkbox">
                            <input type="checkbox" defaultChecked />
                            <span class="ml-3">I agree</span>
                            <span class="control_indicator"></span>
                        </label>
                    </div>
                    <a href="#"> Terms and Conditions</a>
                </div>
                <button name="register" value="register" type="submit"
                        class="bg-gradient-to-br from-secondary-default hover:from-secondary-dark py-3 rounded-md text-white text-xl to-secondary-dark hover:to-secondary-default duration-300 w-full">
                    Register
                </button>
            </form>
            <div class="text-center mt-5 space-x-2">
                <form method="POST" action="/web-store/api/post.php">
                    <p class="text-base">
                        Do you have an account?
                        <button type="submit" name="redirect" value="<?php echo FilePathEnum::LOGIN; ?>"
                                class="cursor-pointer hover:underline">Login</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <div class="lg:mb-5 py-3">
        <div
                class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
            <p class="capitalize"></p>
        </div>
    </div>
</div>
</body>

</html>