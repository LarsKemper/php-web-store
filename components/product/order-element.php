<div class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
    <div class="pb-4 md:pb-8 w-full md:w-40">
        <img class="w-full hidden md:block" src="<?php echo $img_path; ?>"  alt=""/>
        <img class="w-full md:hidden" src="<?php echo $img_path; ?>"  alt=""/>
    </div>
    <div
            class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
        <div class="w-full flex flex-col justify-start items-start space-y-2">
            <h3 class="text-xl xl:text-2xl font-semibold leading-6 text-gray-800">
                <?php echo $product_name; ?></h3>
            <div class="flex justify-start items-start flex-col space-y-2">
                <p class="text-sm leading-none text-gray-600"><span class="text-gray-600">Quantity:
                    </span> <?php echo $quantity; ?></p>
                <p class="text-sm leading-none text-gray-600"><span class="text-gray-600">Price:
                    </span> <?php echo $price; ?>€
                </p>
                <p class="text-sm leading-none text-gray-600"><span class="text-gray-600">Size:
                    </span> <?php echo $size; ?>
                </p>
                <p class="text-sm leading-none text-gray-600"><span class="text-gray-600">Color:
                    </span> <?php echo $color; ?>
                </p>
            </div>
        </div>
    </div>
</div>
