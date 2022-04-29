<?php

namespace App\Controllers;

use App\View;
use App\ViewPaths;

class LinksController
{
    public function style(): View{
        return View::make(ViewPaths::STYLE_SHEET);
    }
}