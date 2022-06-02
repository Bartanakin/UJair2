<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="allFlightsStyles" >
    <title>All flights</title>
</head>
<body>
    <header>
        <div class="headerTitle">
            All Flights
        </div>
        <div class="headerManager">
            <form method="get" action="editFlight" class="headerForm">
                <input type="submit" value="Add new flight" class="managerSubmit submit"/>
            </form>
            <form method="get" action="settlements" class="headerForm">
                <input type="submit" value="Incomes and expenses" class="managerSubmit submit"/>
            </form>
        </div>
        <?php if($this -> params['warning']): ?>
            <div class="headerMessage headerForm textInfo">
                <?= $this -> params['warning'] ?>
            </div>
        <?php endif; ?>
    </header>
    <div class="wrapper">
        <?php
            /* @var $flight \App\Entities\Flight */
            foreach ( $this -> params['allFLights'] as $flight ):
        ?>
            <div class="flight">
                <div class="defaultContainer flightData ">
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">FROM</span>: <?= $flight -> getStartingAirport() -> getAirportName() ?>
                    </div>
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">TO:</span> <?= $flight -> getTargetAirport() -> getAirportName() ?>
                    </div>
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">Date of Departure:</span> <?= $flight -> getDateOfDeparture() -> format('Y-m-d H:i:s') ?>
                    </div>
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">Airplane ID: </span><?= $flight -> getAirplane() -> getID() ?>
                    </div>
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">Airplane type:</span> <?= $flight -> getAirplane() -> getTypeName() ?>
                    </div>
                    <div class="defaultContainerElement flightEntity">
                        <span class="bold">Ticket price:</span> <?= $flight -> getPrice() ?>
                    </div>
                    <?php if( $flight -> getWarning() ): ?>
                    <div class="defaultContainerElement warning">
                        <span class="bold">Warning:</span><?= $flight -> getWarning() ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <form action="editFlight" method="post" class="flightForm">
                        <input name="flightID" value="<?= $flight -> getId() ?>" type="hidden"/>
                        <input type="submit" value="edit flight" class="flightSubmit submit"/>
                    </form>
                    <form action="loadCrewList" method="post" class="flightForm">
                        <input name="flightID" value="<?= $flight -> getId() ?>" type="hidden"/>
                        <input type="submit" value="edit crew" class="flightSubmit submit"/>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>