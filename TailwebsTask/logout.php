<?php
session_start();
session_unset();
session_destroy();
header('Location: loginform.php');
exit;

