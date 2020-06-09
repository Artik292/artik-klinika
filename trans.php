<?php

if (isset($_GET['tar'])) {
  session_start();
  $_SESSION['tar'] = $_GET['tar'];
  header('location: admin.php');
} else {
  header('location: logout.php');
}
