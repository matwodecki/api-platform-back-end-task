<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AllowedStatus extends Constraint
{
    public string $message = 'Status zlecenia nie jest jednym z dozwolonych statusów: nowe, w naprawie, czeka na odbiór, odebrane przez klienta, anulowane';

    // all configurable options must be passed to the constructor
    public function __construct(string $message = null, array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
