<?php

namespace enum;

abstract class GetRoutesEnum
{
    const GET_PROFILE = "getProfile";
    const GET_PRODUCTS = "getProducts";
    const GET_PRODUCT = "getProduct";
    const GET_ORDERS = "getOrders";
    const GET_ORDER = "getOrder";

    public static function getRoutes(): array
    {
        return [
            self::GET_PROFILE,
            self::GET_PRODUCTS,
            self::GET_PRODUCT,
            self::GET_ORDERS,
            self::GET_ORDER,
        ];
    }
}