<?php

require "../banco.php";

$_SESSION = [];

session_destroy();

header("location:../index.php");

exit;