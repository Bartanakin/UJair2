<?php
    /** @var  $flight \App\Entities\Flight*/
    $flight = $this -> params['flight'];
    $candidates = $this -> params['candidates'];
    /** @var  $roleToLink \App\Entities\PersonClasses\EmployeeDegree*/
    $roleToLink = $this -> params['roleToLink'];
    /** @var  $message string */
    $warning = $this -> params['warning'];
?>
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
        <form class="headerForm" method="post" action="/">
            <input type="submit" value="cancel" class="managerSubmit submit ">
        </form>
    </div>
    <?php if($warning): ?>
        <div class="headerMessage headerForm textInfo">
            <?= $warning ?>
        </div>
    <?php endif; ?>
</header>
<div class="wrapper">
    <div class="leftColumn">
        <?php if($flight -> getCrewList() -> getCaptain() === null ): ?>
        <section
            <?php if($roleToLink === \App\Entities\PersonClasses\EmployeeDegree::CAPTAIN):?>
                class="selectedMember"
            <?php endif;?>
        >
            <form class="crewTileForm" method="post" action="findAvailableMembers">
                <input type="hidden" name="RoleID" value="C">
                <input class="submit crewSubmit" type="submit" value="Add captain" >
            </form>
        </section>
        <?php endif; ?>
        <?php if($flight -> getCrewList() -> getFirstOfficer() === null ): ?>
        <section
            <?php if($roleToLink === \App\Entities\PersonClasses\EmployeeDegree::FIRST_OFFICER):?>
                class="selectedMember"
            <?php endif;?>
        >
            <form class="crewTileForm" method="post" action="findAvailableMembers">
                <input type="hidden" name="RoleID" value="F">
                <input class="submit crewSubmit" type="submit" value="Add first officer" >
            </form>
        </section>
        <?php endif; ?>
        <?php if($flight -> getCrewList() -> getMaxNumberOfFA() > count($flight->getCrewList()->getFlightAttendants()) ): ?>
        <section
            <?php if($roleToLink === \App\Entities\PersonClasses\EmployeeDegree::FLIGHT_ATTENDANT):?>
                class="selectedMember"
            <?php endif;?>
        >
            <form class="crewTileForm " method="post" action="findAvailableMembers">
                <input type="hidden" name="RoleID" value="S">
                <input class="submit crewSubmit" type="submit" value="Add flight attendant" >
            </form>
        </section>
        <?php endif; ?>
        <?php /** @var $Emp \App\Entities\PersonClasses\Employee */ ?>
        <?php foreach ( $flight -> getCrewList() -> getEmployers() as $Emp ): ?>
        <section>
            <div class="crewTile defaultContainer">
                <div class="crewSlot defaultContainerElement">
                    Slot: <?= $flight -> getCrewList() ->getSlot($Emp -> getID()) -> getFullString() ?>
                </div>
                <div class="crewInfo defaultContainerElement">
                    Name: <?= $Emp -> getFirstName() . " " . $Emp -> getSurname() ?>
                </div>
                <?php if($Emp instanceof \App\Entities\PersonClasses\Pilot): ?>
                <div class="crewInfo defaultContainerElement">
                    Degree: <?= $Emp -> getDegree() -> getFullString() ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if($Emp): ?>
            <form class="crewTileForm" method="post" action="unlinkMember">
                <input type="hidden" name="EmployeeID" value="<?= $Emp -> getID()?>">
                <input class="submit crewSubmit" type="submit" value="unlink member" >
            </form>
            <?php endif; ?>
        </section>
        <?php endforeach; ?>
    </div>
    <div class="rightColumn">
        <?php if($candidates ): ?>
        <div class="textInfo">Choose candidate:</div>
        <?php  /** @var $candidate \App\Entities\PersonClasses\Employee */?>
        <?php foreach ($candidates as $candidate): ?>
        <?php if( !$flight -> getCrewList() ->findEmployee($candidate ->getID())): ?>
        <section>
            <div class="selectableCrewTile defaultContainer">
                <div class="crewInfo defaultContainerElement">
                    Name: <?= $candidate -> getFirstName() . " " . $candidate -> getSurname() ?>
                </div>
                <div class="crewInfo defaultContainerElement">
                    Degree: <?= $candidate -> getDegree() -> getFullString() ?>
                </div>
            </div>
            <form class="crewTileForm" method="post" action="linkMember">
                <input type="hidden" value="<?= $candidate ->getID() ?>" name="EmployeeID">
                <input class="submit crewSubmit" type="submit" value="pick member" >
            </form>
        </section>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>