<?php

namespace App\Entities;

enum AirplanePosition: string
{
    case IN_FLIGHT = "In flight";
    case FREE = "Free";
    case PREPARING_FOR_FLIGHT = "Preparing for flight";
    case AFTER_FLIGHT = "After flight";

}