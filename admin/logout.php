<?php
ob_start();
session_save_path("../env/sessions");
session_start();
unset($_SESSION['admin']);
ob_end_flush();
header("Location: login.php");
?>