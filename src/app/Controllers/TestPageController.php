<?php

namespace App\Controllers;

use App\View;

class TestPageController
{
    public function testPage(): View {
        return View::make("TestPage/testPage.php");
    }
}