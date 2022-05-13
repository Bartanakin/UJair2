<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="jsCalendarsStyles">
    <script type="text/javascript" src="jsCalendarsScript"></script>
    <link rel="stylesheet" type="text/css" href="flightEditorStyle" >
</head>
<body>
    <header>
        <div class="headerTitle">
            UJAIR2 - Flight editor
        </div>
    </header>
    <div class="wrapper">
        <div id="my-calendar"></div>
        Picked date: <br>
        <input id="my-input-a"><br>
        <input id="hour-picker"><br>
        <input id="minute-picker"><br>


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