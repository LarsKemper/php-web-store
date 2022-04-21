<?php
    use enum\FilePathEnum;
    require_once __DIR__."/../../shared/filePathEnum.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="./../../style/app.css">
</head>

<div class="bg-gray-100">
    <div class="flex flex-col justify-between h-screen">
        <?php
          include(__DIR__."/../../components/nav.php");
        ?>
        <div>
            <div class="lg:p-12 max-w-md max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
                <h1 class="lg:text-3xl text-xl font-semibold  mb-6"> Log in</h1>
                <?php include(__DIR__."/../../components/alert.php"); ?>
                <p class="mb-2 text-black text-lg">Email or Username</p>
                <form method="POST" action="/web-store/api/post.php">
                    <input name="email" type="email" placeholder="example@mydomain.com"
                        class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                    <input name="password" type="password" placeholder="***********"
                        class="bg-gray-200 rounded border border-gray-400 mb-2 p-3 w-full shadow-none" />
                    <div class="flex text-right justify-end my-4">
                        <span class="cursor-pointer text-base text-right hover:underline duration-300">
                            Forgot Your Password?
                        </span>
                    </div>
                    <button name="login" value="login" type="submit"
                        class="bg-gradient-to-br from-secondary-default hover:from-secondary-dark py-3 rounded-md text-white text-xl to-secondary-dark hover:to-secondary-default duration-300 w-full">
                        Login
                    </button>
                </form>
                <div class="text-center mt-5 space-x-2">
                    <form method="POST" action="/web-store/api/post.php">
                        <p class="text-base">
                            Not registered?
                            <button type="submit" name="redirect" value="<?php echo FilePathEnum::REGISTER; ?>"
                                class="cursor-pointer hover:underline">Create a account</button>
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