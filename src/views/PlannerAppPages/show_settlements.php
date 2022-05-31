<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="settlementsStyle" >
    <title>All flights</title>
</head>
<body>
<header>
    <div class="headerTitle">
        All incomes and expenses
    </div>
    <div class="headerManager">
        <form method="get" action="/" class="headerForm">
            <input type="submit" value="All flights" class="managerSubmit submit"/>
        </form>
    </div>
</header>
<div class="wrapper">
    <div class="totals defaultContainer">
        <div class="totalsTile defaultContainerElement"><span class="bold">Total income: </span>200</div>
        <div class="totalsTile defaultContainerElement"><span class="bold">Total expense: </span>100</div>
        <div class="totalsTile defaultContainerElement"><span class="bold">Total sum: </span>100</div>
    </div>
    <div class="tilesContainer defaultContainer">
        <div class="defaultContainerElement tile">
            <div class="setInfo tileInfo"><span class="bold">Type</span></div>
            <div class="date tileInfo"><span class="bold">Date</span></div>
            <div class="amount tileInfo"><span class="bold">Amount</span></div>
        </div>
        <div class="defaultContainerElement tile">
            <div class="setInfo tileInfo">Salary</div>
            <div class="date tileInfo">2022-06-06</div>
            <div class="amount tileInfo">1000</div>
        </div>
    </div>
</div>
</body>
</html>