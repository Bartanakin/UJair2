<?php

namespace App\Models;

use DateTime;

class CurrentsImpl implements \App\Interfaces\Currents
{

    public function now(): DateTime
    {
        return new DateTime();
    }
}