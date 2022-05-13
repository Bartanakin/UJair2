<?php
    $date = '2022-06-06 20:00:00';
    $speed = 800;
    $distance = 2000;

    const FORMAT = "Y-m-d H:i:s";
    $arrivalTime = DateTime::createFromFormat(FORMAT,$date);

    $estimatedArrivalTime = $arrivalTime -> add( DateInterval::createFromDateString(3600*$distance/$speed . ' second'));

    echo $estimatedArrivalTime -> format(FORMAT). PHP_EOL;