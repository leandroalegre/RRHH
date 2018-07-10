<?php
session_start();

echo '<SCRIPT LANGUAGE="javascript">
location.href = "mainlog/index.php";
</SCRIPT>';

session_destroy();

?>
