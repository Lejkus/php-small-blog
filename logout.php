<?php
session_start();
session_destroy();
header("Location: /cms/main.php");
exit();
?>