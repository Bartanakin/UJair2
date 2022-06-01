<?php

namespace App\Interfaces;

use DateTime;

interface Currents
{
    public function now(): DateTime;
}