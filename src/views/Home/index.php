<!DOCTYPE html>
<html lang="eng">
<head>
    <link rel="stylesheet" type="text/css" href="style" >
    <title>Planner login</title>
</head>
<body>
<div class="wrapper">
    <div class="ujair_header">UJAIR2 - planner login panel</div>
    <div class="login_input_div">
        <div class="correctness_message">
            <?php if(isset($this -> params['serverMessage']))
                echo $this -> params['serverMessage'];
            ?>
        </div>
        <form method="post" action="/">
            <label>
                <h6>Login:</h6>
                <input type="text" name="login" class="login_form_input"/>
            </label>
            <label>
                <h6>Password:</h6>
                <input type="password" name="password" class="login_form_input"/>
            </label>
            <label>
                <input type="submit" class="login_input_submit" value="Login"/>
            </label>
        </form>
    </div>
</div>

</body>
</html>



