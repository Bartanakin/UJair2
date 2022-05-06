<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="stylesheet" type="text/css" href="allFlightsStyles" >
    <title>All flights</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h3>All Flights</h3>
        </header>
        <?php
            /* @var $flight \App\Entities\Flight */
            foreach ( $this -> params['allFLights'] as $flight ):
        ?>
            <div class="flight">
                <div class="flightData">
                    <div class="flightEntity">
                        <span class="bold">FROM</span>: <?= $flight -> getStartingAirport() -> getAirportName() ?>
                    </div>
                    <div class="flightEntity">
                        <span class="bold">TO:</span> <?= $flight -> getTargetAirport() -> getAirportName() ?>
                    </div>
                    <div class="flightEntity">
                        <span class="bold">Date of Departure:</span> <?= $flight -> getDateOfDeparture() -> format('Y-m-d H:i:s') ?>
                    </div>
                    <div class="flightEntity">
                        <span class="bold">Airplane ID: </span><?= $flight -> getAirplane() -> getID() ?>
                    </div>
                    <div class="flightEntity">
                        <span class="bold">Airplane type:</span> <?= $flight -> getAirplane() -> getTypeName() ?>
                    </div>
                    <div class="flightEntity">
                        <span class="bold">Ticket price:</span> <?= $flight -> getPrice() ?>
                    </div>
                    <?php if( $flight -> getWarning() ): ?>
                    <div class="warning">
                         <?= $flight -> getWarning() ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <form action="editFlight" method="post" class="flightForm">
                        <input name="flightID" value="<?= $flight -> getId() ?>" type="hidden"/>
                        <input type="submit" value="edit flight" class="flightSubmit"/>
                    </form>
                    <form action="editCrew" method="post" class="flightForm">
                        <input name="flightID" value="<?= $flight -> getId() ?>" type="hidden"/>
                        <input type="submit" value="edit crew" class="flightSubmit"/>
                    </form>
                </div>
                <div style="clear:both;"></div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>