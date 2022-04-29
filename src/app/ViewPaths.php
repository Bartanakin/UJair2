<?php

namespace App;

enum ViewPaths: string
{
    case HOME_PAGE = "Home/index.php";
    case ALL_FLIGHTS_PAGE = "Home/all_flights.php";

    // stylesheets
    case STYLE_SHEET = "styles/styles.php";

    // Error pages
    case BAD_REQUEST = "ErrorPages/BadRequest.php";
}