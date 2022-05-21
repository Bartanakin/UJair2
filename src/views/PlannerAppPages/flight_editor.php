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
                <form action="" method="post" class="timeAndDateInputsContainer" >
                    <div class="textInfo"> Picked date: </div>
                    <input id="my-input-a" class="textInput dateInput">
                    <div class="textInfo"> Pick hour and minute: </div>
                    <div class="timeInputsContainer" >
                        <input id="hour-picker" value="00" class="textInput timeInput">
                        <input id="minute-picker" value="00" class="textInput timeInput">
                    </div>
                    <input type="submit" value="Confirm date and time" class="submit dateAndTimeSubmit">
                </form>
            </div>
            <div class="airplanesContainer">
                <div class="textInfo">
                    Choose an aircraft:
                </div>
                <form class=" aircraft">
                    <div class="defaultContainer aircraftData">
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">ID:</span> 1</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Type name:</span> Boeing 737 MAX</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Residing in:</span> Heathrow Airport</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Occupancy:</span> Free</div>
                    </div>
                    <input type="submit" value="Choose this aircraft" class="submit aircraftSubmit">
                </form>
                <form class=" aircraft">
                    <div class="defaultContainer aircraftData">
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">ID:</span> 1</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Type name:</span> Boeing 737 MAX</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Residing in:</span> Heathrow Airport</div>
                        <div class="defaultContainerElement aircraftInfo"> <span class="bold">Occupancy:</span> Free</div>
                    </div>
                    <input type="submit" value="Choose this aircraft" class="submit aircraftSubmit">
                </form>
            </div>
        </div>
        <form method="post" action="" class="secondContainer">
            <div class="textInfo" >
                Select ticket price:
            </div>
            <input type="text" value="100" class="textInput priceInput">
            <input type="submit" value="confirm edition" class="submit airportSubmit">
            <div class="textInfo" >
                Select target airport:
            </div>
            <div class="defaultContainer targetAirportsContainer">
                <div class="airportName">
                    <input id="airport1" type="radio" value="1" name="xd">
                    <label  for="airport1">Balice</label>
                </div>
                <div class="airportName">
                    <input id="airport2" type="radio" value="1" name="xd">
                    <label  for="airport2">Chopin</label>
                </div>
                <div class="airportName">
                    <input id="airport3" type="radio" value="1" name="xd">
                    <label  for="airport3">Heathrow</label>
                </div>
            </div>
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

        window.addEventListener('load', (event) => {
            date = new Date(Date.now());
            inputA.value = formatDateForMe(date);
        });
        myCalendar.onDateClick(function(event, date){
            inputA.value = formatDateForMe(date);
        });

        let hour_picker = document.getElementById("hour-picker");

        hour_picker.addEventListener("change",function(){
            let val = hour_picker.getAttribute('value');
        });

    </script>
</body>