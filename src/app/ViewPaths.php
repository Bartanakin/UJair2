<?php

namespace App;

enum ViewPaths: string
{
    case HOME_PAGE = "Home/index";
    case ALL_FLIGHTS_PAGE = "PlannerAppPages/all_flights";
    case EDIT_FLIGHT_PAGE = "PlannerAppPages/flight_editor";
    case EDIT_CREW_PAGE = 'PlannerAppPages/crew_editor';
    case SETTLEMENTS_PAGE = "PlannerAppPages/settlements";

    // stylesheets
    case STYLE_SHEET = "styles/styles";

    // Error pages
    case BAD_REQUEST = "ErrorPages/BadRequest";
    case UNAUTHORIZED = "ErrorPages/Unauthorized";
    case SESSION_EXPIRED = "ErrorPages/SessionHasExpired";


}