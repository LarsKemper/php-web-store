<?php

namespace enum;

abstract class RegexEnum
{
    const EMAIL = '/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/';
    const PASSWORD = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/';
    const NAME = '/^[A-Za-z]+$/';
    const STREET = '/^(?<streetname>\d*[\p{L}\d \'\/\\\\\-\.]+)[,\s]+(?<housenumber>\d+)\s*(?<ext>[\p{L} \d\-\/\'"\(\)]*)$/';
    const CITY = '/^[A-Za-z]+$/';
    const POSTCODE = '/^[0-9]+([0-9\/ -]*)[0-9]$/'; 
    const FULL_NAME = "/^\p{L}+(['-]\p{L}+)*\.?(\s\p{L}+(['-]\p{L}+)*\.?)+$/";
    const CARD_NUMBER = '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}(?:2131|1800|35\d{3})\d{11})$/im';
    const SEC_CODE = '/^[3-9]\d\d$/';
}
