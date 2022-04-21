<?php

namespace App\Controllers;

use App\Models\DataBaseTest;
use App\View;

class TestPageController
{
    public function testPage(): View {
        $test = new DataBaseTest();
        $test -> addRow();
        $test -> addRow();
        $test -> addRow();

        return View::make("TestPage/testPage.php",$test -> printAll());
    }
    
    public function check(): View {
        $test = new DataBaseTest();
        $test -> check1();
        return View::make("TestPage/testPage.php",$test -> printAll());
    }
}
