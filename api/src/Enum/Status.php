<?php

namespace App\Enum;

enum Status: string
{
    case nowe = "nowe";
    case wNaprawie = 'w naprawie';
    case czekaNaOdbior = 'czeka na odbiór';
    case odebranePrzezKlienta = 'odebrane przez klienta';
    case anulowane = 'anulowane';
}
