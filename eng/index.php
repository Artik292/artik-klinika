<?php

require '../connection.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Space jump</title>
    <link rel="icon" href="../src/logo.png">
    <link rel="stylesheet" media="only screen and (max-device-width: 480px)" href="../css/phone.css">
    <link rel="stylesheet" media="only screen and (min-device-width: 481px)" href="../css/pc.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/places.js"></script>
    <script src="../js/main.js"></script>
  </head>
  <body>
    <nav>
      <img id="menu-logo" src="src/menu-phone.png" alt="menu">
      <ul id="nav" class="nav">
        <li><a href="index.html"><img id=logo-img src="../src/logo.png" alt="Space jump"></a></li>
        <li class="nav-el"><a href="https://www.google.com/sky//">Places to visit</a></li>
        <li class="nav-el"><a href="price.html">Prices</a></li>
        <li class="nav-el"><a href="https://en.wikipedia.org/wiki/Wormhole">Info</a></li>
        <li class="nav-el"><a href="gal.html">Why you should travel with us?</a></li>
        <li class="nav-el"><a href="login.php">Log in</a></li>
      </ul>
    </nav>
      <div class="main par">
        <form>
          <p class="label from">From:</p>
          <select id="place_from"></select>
          <p class="label to">To:</p>
          <select id="place_back"></select>
          <br>
          <input type="date" class="date" id="date_to" name="to">
          <input type="date" class="date" id="date_back" name="back">
          <br>
          <p class="label back">Round trip?</p>
          <input id="back" type="checkbox" name="back" value="back">
          <br>
        </form>
        <button id="submit">Search</button>

      </div>
      <div class="list par">
        <h1>Choose your time</h1>
        <table id="time_list">

        </table>

      </div>
      <div class="ship par">
      </div>
      <div class="sub par">
        <h2>Subscribe</h2>
        <form id="sub" class="sub" action="http://naivist.net/form" method="get" onsubmit="return SubCheck()">
          <p>Name and surname</p>
          <p id="warning">Name can't contain numbers</p>
          <input id="sub-name" type="text" name="name" placeholder="Name and Surname" required>
          <p>E-mail</p>
          <input id="sub-email" type="email" name="email" placeholder="example@example.com" required>
          <input id="sub-sub" type="submit" name="Subscribe">
        </form>
        <p>Subscribe us if you want to be <u>in touch with</u> space!</p>
      </div>
      <footer>
        <p>
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
                <img
                    src="http://jigsaw.w3.org/css-validator/images/vcss"
                    alt="Правильный CSS!" />
            </a>
        </p>
        <h4>This web page was created specially for LUDF by <b>Artūrs Koņevņikovs (ak19192)</b> .</h4>
      </footer>

  </body>
</html>
