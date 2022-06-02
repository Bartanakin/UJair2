<?php
header("",true,500);
?>
<h3 style="margin: 10vh auto 0 auto;"> Internal Server Error.</h3>
<?php if( $this -> params['warning']) echo $this -> params['warning']; ?>
