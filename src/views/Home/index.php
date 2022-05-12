<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style" >
    <link rel="stylesheet" type="text/css" href="commonStyle" >
    <title>Planner login</title>
</head>
<body>
<header>
    <div class="headerTitle">
        UJAIR2 - planner login panel
    </div>
</header>
<div class="wrapper">
    <div style="height: 100px;"></div>
    <div class="login_input_div shadow">
        <div class="correctness_message">
            <?php if(isset($this -> params['serverMessage']))
                echo $this -> params['serverMessage'];
            ?>
        </div>
        <form method="post" action="/" class="formContainer">
            <h6>Login:</h6>
            <input type="text" name="login" class="login_form_input"/>
            <h6>Password:</h6>
            <input type="password" name="password" class="login_form_input"/>
            <input type="submit" class="submit login_input_submit " value="Log in"/>
        </form>
    </div>
</div>

</body>
</html>



