<?php header("Content-type: text/css");
ob_start();

include __DIR__ . "/styles.css";

echo (string) ob_get_clean();
?>