<?php if (isset($_GET["state"]) && isset($_GET["state"])) { ?>
    <?php if (!$_GET["state"]) { ?>
        <div class="w-full flex items-center bg-red-100 rounded-lg p-4 mb-4 text-lg text-red-700" role="alert">
            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd"></path>
            </svg>
            <div>
                <span class="font-medium"><?php echo $_GET["message"] ?></span>
            </div>
        </div>
        <?php
    } else if ($_GET["state"]) { ?>
        <div class="w-full flex items-center bg-green-100 rounded-lg p-4 mb-4 text-lg text-green-700" role="alert">
            <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd"></path>
            </svg>
            <div>
                <span class="font-medium"><?php echo $_GET["message"] ?></span>
            </div>
        </div>
        <?php
    } ?>
    <?php
} ?>