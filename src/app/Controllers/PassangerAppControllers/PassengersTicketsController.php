<?php

namespace App\Controllers;

use App\View;
use App\ViewPaths;

class HomeController
{
    public function index(): View {
        return View::make(ViewPaths::HOME_PAGE);
    }
}