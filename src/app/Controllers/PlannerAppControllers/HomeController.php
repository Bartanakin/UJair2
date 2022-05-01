<?php

namespace App\Controllers\PlannerAppControllers;

use App\View;
use App\ViewPaths;
use App\Views\HomeView;

class HomeController
{
    public function index(): View {
        // TODO: add redirect to all flights when logged
//        if( isset($_SESSION['logged']) ){
//            if( $_SESSION['logged'] === true ){
//                return View::make(ViewPaths::ALL);
//            }
//        }
        return View::make(ViewPaths::HOME_PAGE);
    }
}