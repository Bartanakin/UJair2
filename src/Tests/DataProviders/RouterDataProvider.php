<?php

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function UnknownUriCases(): array {
        return [
            ['/users','PUT'],
            ['/airplanes','GET'],
            ['/users','GET'],
            ['/users','POST']
        ];
    }
}