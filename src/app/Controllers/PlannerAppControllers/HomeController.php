<?php

namespace App\Controllers\PlannerAppControllers;

use App\View;
use App\ViewPaths;
use App\Views\HomeView;

class HomeController
{
    public function index(): View {
        return View::make(ViewPaths::HOME_PAGE);
    }
}