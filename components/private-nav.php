<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    use controller\AuthController;
    use enum\FilePathEnum;

    require_once __DIR__."/../controller/AuthController.php";
    require_once __DIR__."/../shared/filePathEnum.php";

    $authController = new AuthController();
    if(!$authController->isLoggedIn()) {
        $authController->viewLogin();
    }
?>

<div class="bg-white py-4 shadow">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mx-10 lg:mx-0">
            <a href="/web-store/">
                <h1 class="cursor-pointer text-2xl font-medium hover:text-secondary-default duration-300">web-store</h1>
            </a>
            <div class="capitalize flex my-2 space-x-3 text-center text-sm">
                <form method="POST" action="/web-store/api/post.php">
                    <button type="submit" name="redirect" value="<?php echo FilePathEnum::CART ?>"
                        class="relative cursor-pointer py-3 text-base px-4">
                        <?php if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { ?>
                        <div class="absolute right-3 h-2 w-2 rounded-full bg-secondary-default"></div>
                        <?php } ?>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 hover:text-secondary-default duration-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                    <button type="submit" name="redirect" value="<?php echo FilePathEnum::SETTINGS ?>"
                        class="cursor-pointer py-3 text-base px-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 hover:text-secondary-default duration-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <button type="submit" name="logout" value="logout"
                        class="cursor-pointer py-3 text-base pl-4 lg:px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-red-700 duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>