<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    use enum\FilePathEnum;
    require_once __DIR__."/../shared/filePathEnum.php";
?>
<div class="bg-white py-4 shadow">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mx-10 lg:m-0">
            <a href="/web-store/">
                <h1 class="text-2xl cursor-pointer font-semibold">web-store</h1>
            </a>
            <div class="capitalize flex my-2 text-center text-sm">
                <form method="POST" action="/web-store/api/post.php">
                    <button class="cursor-pointer p-3 text-base hover:underline" type="submit" name="redirect"
                        value="<?php echo FilePathEnum::LOGIN ?>">Login</button>
                    <button type="submit" name="redirect" value="<?php echo FilePathEnum::REGISTER ?>"
                        class="cursor-pointer bg-secondary-default duration-300 text-base px-6 py-3 rounded-md shadow text-white hover:bg-secondary-dark">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>