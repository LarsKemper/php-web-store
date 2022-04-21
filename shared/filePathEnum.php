<?php

namespace enum;

abstract class FilePathEnum
{
    const HOME = "/web-store/index.php";
    const LOGIN = "/web-store/pages/auth/login.php";
    const REGISTER = "/web-store/pages/auth/register.php";
    const SETTINGS = "/web-store/pages/user/settings.php";
    const CART = "/web-store/pages/user/cart.php";
    const NOT_FOUND = "/web-store/pages/not_found.php";
    const PRODUCT = "/web-store/pages/product.php";
    const ORDER = "/web-store/pages/user/order.php";
}