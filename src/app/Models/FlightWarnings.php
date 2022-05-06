<?php

namespace App\Models;

enum FlightWarnings: string
{
    case AIRPORT_INCOHERENCE_WARNING = "This flight can\'t take place because of improper starting airport";
}