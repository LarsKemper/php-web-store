<?php
    use enum\FilePathEnum;
    require_once __DIR__."/../../shared/filePathEnum.php";
?>
<div class="flex items-center justify-between bg-white py-4 px-6 rounded-md rounded-xl hover:bg-gray-200">
    <div class="text-sm font-medium text-gray-900 whitespace-nowrap">
        <?php echo $name_on_card; ?></div>
    <div class="text-sm truncate font-medium text-gray-500 whitespace-nowrap">
        <?php echo $created_at; ?></div>
    <div class="text-sm font-medium text-gray-900 whitespace-nowrap">
        <?php echo $total; ?>€</div>
    <a href="<?php echo FilePathEnum::ORDER."?order_id=$id"; ?>"
        class="cursor-pointer text-sm font-medium float-right whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </a>
</div>