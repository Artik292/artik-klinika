<?php

session_start();
unset($_SESSION['id']);
unset($_SESSION['status']);
unset($_POST);
header('location: index.php');
