<?php

namespace App;

enum ViewPaths: string
{
    case HOME_PAGE = "Home/index.php";
    case ALL_FLIGHTS_PAGE = "All Flights/all_flights.php";

    // stylesheets
    case STYLE_SHEET = "styles/styles.php";

    // Error pages
    case BAD_REQUEST = "ErrorPages/BadRequest.php";
    case UNAUTHORIZED = "ErrorPages/Unauthorized.php";
}