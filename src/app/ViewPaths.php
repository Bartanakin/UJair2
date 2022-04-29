<?php

namespace App;

enum ViewPaths: string
{
    case HOME_PAGE = "Home/index.php";

    // Error pages
    case BAD_REQUEST = "ErrorPages/BadRequest.php";
}