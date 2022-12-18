<?php

namespace enum;

abstract class PostRoutesEnum
{
    public const REDIRECT = "redirect";
    public const LOGIN = "login";
    public const REGISTER = "register";
    public const LOGOUT = "logout";
    public const UPDATE_USER = "updateUser";
    public const UPDATE_PROFILE = "updateProfile";
    public const UPDATE_CART = "updateCart";
    public const DELETE_FROM_CART = "deleteFromCart";
    public const CREATE_ORDER = "createOrder";
    public const DELETE_USER = "deleteUser";
    public const DELETE_ORDER = "deleteOrder";

    public static function getRoutes(): array
    {
        return [
            self::REDIRECT,
            self::LOGIN,
            self::REGISTER,
            self::LOGOUT,
            self::UPDATE_USER,
            self::UPDATE_PROFILE,
            self::UPDATE_CART,
            self::DELETE_FROM_CART,
            self::CREATE_ORDER,
            self::DELETE_USER,
            self::DELETE_ORDER,
        ];
    }
}