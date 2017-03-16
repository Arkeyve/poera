<?php
include("header.php");
$_SESSION['user_id'] = 0;
session_unset();
session_destroy();
header("Location: ./index.php?msg=logout");
?>