<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Constants;

class PartnerConstants
{
    public const STATUS_NEW = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_REMOVED = 99;

    public const DETAILS_KEY_INN = 'inn';
    public const DETAILS_KEY_KPP = 'kpp';
    public const DETAILS_KEY_OGRN = 'ogrn';
    public const DETAILS_KEY_BANK = 'bank';
    public const DETAILS_KEY_ADDRESS = 'address';
    public const DETAILS_KEY_BIK = 'bik';
    public const DETAILS_KEY_ACCOUNT_NUMBER = 'account_number';
    public const DETAILS_KEY_CORR_ACCOUNT_NUMBER = 'corr_account_number';

    public const CONTACTS_KEY_PHONE_NUMBER = 'phone_number';
    public const CONTACTS_KEY_EMAIL = 'email';
}
