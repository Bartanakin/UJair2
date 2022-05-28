<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <link rel="stylesheet" type="text/css" href="confirmationStyle" >
    <title>UJAIR2</title>
</head>
<body>
<header>
    <div class="headerTitle">
        Confirmation page
    </div>
    <?php if($this -> params['warning']): ?>
        <div class="headerMessage headerForm textInfo">
            <?= $this -> params['warning'] ?>
        </div>
    <?php endif; ?>
</header>
<div class="wrapper">
    <div class="confirmationContainer">
        <form class="confirmationForm" method="post" action="/acceptConfirmation">
            <input type="hidden" name="confirmationType" value="<?= $this ?-> params['type'] ?>">
            <input class="submit confirmationSubmit" type="submit" value="confirm">
        </form>
        <form class="confirmationForm" method="post" action="/cancelConfirmation">
            <input class="submit confirmationSubmit" type="submit" value="cancel">
        </form>
    </div>
</div>
</body>
</html>