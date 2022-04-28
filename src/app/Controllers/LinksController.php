<?php

namespace App\Controllers;

use App\View;

class LinksController
{
    public function style(): View{
        return View::make("styles/styles.php");
    }
}