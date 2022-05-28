<?php
    /* @var $editedFlight \App\Entities\Flight */
    $editedFlight = $this->params['editedFlight'];
    /* @var $airplanes array */
    $airplanes = $this->params['airplanes'];
    /* @var $targetAirports array */
    $targetAirports = $this->params['targetAirports'];
    /* @var $warning string */
    $warning = $this->params['warning'];
?>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="jsCalendarsStyles">
    <link rel="stylesheet" type="text/css" href="flightEditorStyles" >
    <script type="text/javascript" src="jsCalendarsScript"></script>
</head>
<body>
    <header>
        <div class="headerTitle">
            UJAIR2 - Flight editor
        </div>
        <div class="headerManager">
            <form class="headerForm">
                <input type="submit" class="submit managerSubmit" value="Delete flight">
            </form>
            <form class="headerForm">
                <input type="submit" class="submit managerSubmit" value="Cancel editing">
            </form>
        </div>
    </header>
    <div class="wrapper wrapper1">
        <div class="firstContainer">
            <div class="dateContainer">
                <div class="calendarContainer">
                    <div id="my-calendar"></div>
                </div>
                <form action="selectDate" method="post" class="timeAndDateInputsContainer" >
                    <div class="textInfo"> Picked date: </div>
                    <input id="my-input-a" class="textInput dateInput" name="date"
                        <?= 'value="'. ($editedFlight ?-> getDateOfDeparture() -> format('Y-m-j') ?? (new DateTime()) -> format('Y-m-j')). '"'?>
                    >
                    <div class="textInfo"> Pick hour and minute: </div>
                    <div class="timeInputsContainer" >
                        <input id="hour-picker"  class="textInput timeInput" name="hour"
                            <?= 'value="'. ($editedFlight ?-> getDateOfDeparture() -> format('H') ?? "00") . '"'?>
                        >
                        <input id="minute-picker" class="textInput timeInput" name="minute"
                            <?= 'value="'. ($editedFlight ?-> getDateOfDeparture() -> format('i') ?? '00') . '"'?>
                        >
                    </div>
                    <input type="submit" value="Confirm date and time" class="submit dateAndTimeSubmit">
                </form>
            </div>
            <?php if($airplanes): ?>
            <div class="airplanesContainer">
                <?php if($editedFlight -> getAirplane() ): ?>
                    <div class="textInfo">
                        Chosen aircraft ID: <?= $editedFlight -> getAirplane() -> getID() ?>
                    </div>
                <?php endif; ?>
                <div class="textInfo">
                    Choose an aircraft:
                </div>
                <?php /* @var $airplane \App\Entities\Airplane */ ?>
                <?php foreach ($airplanes as $airplane ): ?>
                <form class=" aircraft" method="post" action="selectAirplane">
                    <div class="defaultContainer aircraftData">
                        <input type="hidden" name="airplaneID" value="<?= $airplane -> getID() ?>">
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">ID:</span>
                            <?= $airplane -> getID() ?>
                        </div>
                        <input type="hidden" name="airplaneTypeName" value="<?= $airplane -> getTypeName() ?>">
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Type name:</span>
                            <?= $airplane -> getTypeName() ?>
                        </div>
                        <input type="hidden" name="startingAirportID" value="<?= $airplane -> getCurrentAirport() -> getID()?>">
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Residing in:</span>
                            <?= $airplane -> getCurrentAirport() -> getAirportName() ?>
                        </div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Occupancy:</span>
                            <?= $airplane -> getCondition() ?>
                        </div>
                        <input type="hidden" name="startingAirportName" value="<?= $airplane -> getCurrentAirport() -> getAirportName() ?>">
                    </div>
                    <input type="submit" value="Choose this aircraft" class="submit aircraftSubmit">
                </form>
                </form>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <form method="post" action="" class="secondContainer">
            <?php if($targetAirports): ?>
            <div class="textInfo" >
                Select ticket price:
            </div>
            <input type="text" value="<?= $editedFlight ?-> getPrice() ?? '100' ?>" class="textInput priceInput">
            <input type="submit" value="confirm edition" class="submit airportSubmit">
            <div class="textInfo" >
                Select target airport:
            </div>
            <?php /* @var $targetAirport \App\Entities\Airport */ ?>
            <?php foreach ($targetAirports as $targetAirport): ?>
            <div class="defaultContainer targetAirportsContainer">
                <div class="airportName">
                    <input id="airport<?= $targetAirport -> getID() ?>" type="radio" value="<?= $targetAirport -> getID() ?>" name="targetAirportID">
                    <label  for="airport<?= $targetAirport -> getID() ?>"><?=$targetAirport -> getAirportName() ?></label>
                </div>
            </div>
            <?php  endforeach; ?>
            <?php endif; ?>
        </form>
    </div>
    <script type="text/javascript">
        // Get the element
        var element = document.getElementById("my-calendar");
        // Create the calendar
        var myCalendar = jsCalendar.new(element);
        // Get the inputs
        var inputA = document.getElementById("my-input-a");
        // Add events
        function formatDateForMe(date){
            let month = date.getMonth() > 9 ? (date.getMonth() + 1) : "0" + (date.getMonth() + 1);
            return date.getFullYear() + "-" + month + "-" + date.getDate()
        }

        // window.addEventListener('load', (event) => {
        //     date = new Date(Date.now());
        //     inputA.value = formatDateForMe(date);
        // });
        myCalendar.onDateClick(function(event, date){
            inputA.value = formatDateForMe(date);
        });

        let hour_picker = document.getElementById("hour-picker");

        hour_picker.addEventListener("change",function(){
            let val = hour_picker.getAttribute('value');
        });

    </script>
</body>