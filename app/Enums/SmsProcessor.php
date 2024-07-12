<?php


namespace App\Enums;

interface SmsProcessor
{
    const AFRICA_IS_TALKING = "at";
    const INFO_BIP = "ib";
    const TWILIO = "tw";
    const BULK_SMS_NIGERIA = "bsn";
}
