<div class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
    <form method="POST" action="/web-store/api/post.php">
        <input class="hidden" name="product_id" value="<?php echo $product_id ?>" />
        <div class="w-full flex items-center">
            <button name="deleteFromCart" value="deleteFromCart" type="submit">
                <div class="group relative overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                    <div
                        class="absolute cursor-pointer group-hover:block hidden z-50 h-full w-full bg-black bg-opacity-60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto my-5 h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <img class="w-full h-full" src="<?php echo $img_path ?>" alt="">
                </div>
            </button>
            <div class="flex-grow pl-3">
                <h6 class="font-semibold uppercase text-gray-600"><?php echo $product_name; ?></h6>
                <p class="text-gray-400">x<?php echo $quantity; ?></p>
            </div>
            <div>
                <span class="font-semibold text-gray-600 text-xl"><?php echo $price; ?>€</span>
            </div>
        </div>
    </form>
</div>