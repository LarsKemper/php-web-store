<?php
    use enum\FilePathEnum;
    require_once __DIR__."/../../shared/filePathEnum.php";
?>
<div class="w-1/2 p-4">
    <div class="relative bg-white shadow-md rounded-3xl p-2">
        <div class="overflow-x-hidden rounded-2xl relative">
            <a <a href="<?php echo FilePathEnum::PRODUCT."?product_id=$product_id"; ?>" class="cursor-pointer">
                <img class="h-40 rounded-2xl w-full object-cover" src="<?php echo $img_path; ?>">
            </a>
        </div>
        <div class="mt-4 pl-2 mb-2 flex justify-between ">
            <div>
                <a href="<?php echo FilePathEnum::PRODUCT."?product_id=$product_id"; ?>"
                    class="hover:underline cursor-pointer text-lg font-semibold text-gray-900 mb-0"><?php echo $product_name; ?></a>
                <p class="text-md text-gray-800 mt-0"><?php echo $price; ?>€</p>
            </div>
        </div>
    </div>
</div>