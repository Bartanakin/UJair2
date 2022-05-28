<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="crewStyle" >
    <title>UJAIR2</title>
</head>
<body>
<header>
    <div class="headerTitle">
        Crew list
    </div>
    <div class="headerManager">
        <form class="headerForm">
            <input type="submit" value="cancel" class="managerSubmit submit ">
        </form>
    </div>
</header>
<div class="wrapper">
    <div class="leftColumn">
        <section>
            <div class="crewTile defaultContainer">
                <div class="crewSlot defaultContainerElement">
                    Slot: Captain
                </div>
                <div class="crewInfo defaultContainerElement">
                    Name: Jan Kowalski
                </div>
                <div class="crewInfo defaultContainerElement">
                    Degree: Captain
                </div>
            </div>
            <form class="crewTileForm">
                <input class="submit crewSubmit" type="submit" value="unlink member" >
            </form>
        </section>
        <section class="selectedMember">
            <div class="crewTile defaultContainer">
                <div class="crewSlot defaultContainerElement">
                    Slot: Flight attendant
                </div>
                <div class="crewInfo defaultContainerElement">
                    Name: Adrianna Nowakowska
                </div>
            </div>
            <form class="crewTileForm">
                <input  class="submit crewSubmit" type="submit" value="unlink member" >
            </form>
        </section>
    </div>
    <div class="rightColumn">
        <div class="textInfo">Choose candidate:</div>
        <section>
            <div class="selectableCrewTile defaultContainer">
                <div class="crewInfo defaultContainerElement">
                    Name: Robert Rewucki
                </div>
                <div class="crewInfo defaultContainerElement">
                    Degree: Captain
                </div>
            </div>
            <form class="crewTileForm">
                <input class="submit crewSubmit" type="submit" value="pick this member" >
            </form>
        </section>
    </div>
</div>
</body>
</html>