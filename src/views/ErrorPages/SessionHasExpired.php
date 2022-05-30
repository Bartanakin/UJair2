<?php
    header("",true,440);
?>
<h3> Error. Session has expired.</h3><br/>
<?php if( $this -> params['warning']) echo $this -> params['warning']; ?>
