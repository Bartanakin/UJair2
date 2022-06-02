<?php

namespace App;

enum ViewPaths: string
{
    case HOME_PAGE = "Home/index";
    case ALL_FLIGHTS_PAGE = "PlannerAppPages/all_flights";
    case EDIT_FLIGHT_PAGE = "PlannerAppPages/flight_editor";
    case EDIT_CREW_PAGE = 'PlannerAppPages/crew_editor';
    case SETTLEMENTS_PAGE = "PlannerAppPages/settlements";
    case CONFIRMATION_PAGE = "PlannerAppPages/edit_flight_confirmation";

    // stylesheets
    case STYLE_SHEET = "styles/styles";

    // Error pages
    case BAD_REQUEST = "ErrorPages/BadRequest";
    case UNAUTHORIZED = "ErrorPages/Unauthorized";
    case SESSION_EXPIRED = "ErrorPages/SessionHasExpired";
    case SERVER_ERROR = "ErrorPages/ServerError";
    case NOT_FOUND = "ErrorPages/NotFound";

    // Redirects ( starting with / )
    case ALL_FLIGHT_REDIRECT = '/';

}