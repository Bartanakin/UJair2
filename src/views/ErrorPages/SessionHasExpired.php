<?php
    header("",true,440);
?>
<h3 style="margin: 10vh auto 0 auto;"> Error. Session has expired.</h3><br/>
<?php if( $this -> params['warning']) echo $this -> params['warning']; ?>
