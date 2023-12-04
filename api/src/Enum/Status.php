<?php

namespace App\Enum;

enum Status: string
{
    case new = "nowe";
    case repairing = 'w naprawie';
    case waiting = 'czeka na odbiór';
    case pickedUp = 'odebrane przez klienta';
    case cancelled = 'anulowane';
}
