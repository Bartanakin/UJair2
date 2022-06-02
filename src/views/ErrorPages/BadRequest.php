<?php
    header("",true,400);
?>
<h3 style="margin: 10vh auto 0 auto;"> Error. Incorrect form input.</h3>
<?php if( $this -> params['warning']) echo $this -> params['warning']; ?>
