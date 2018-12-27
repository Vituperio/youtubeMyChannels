<?php
  include('php/script.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My Favourite Youtube Channels</title>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/search.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
    <script src="js/script.js"></script>


    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />

    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>

    <nav class="navbar">
      <ul class="nav navbar-nav">
        <li><a href="/youtubeMyChannels">Home</a></li>
        <li class='dropdown'>
          <a href='#' class="dropdown-toggle" data-toggle="dropdown">Aggiungi <span class='caret'></span></a>
          <ul class="dropdown-menu">
            <li><a href='#' class='add-channel-btn' onclick='addChannelPage();'><span class='glyphicon glyphicon-plus'></span> Canale</a></li>
            <li><a href='#' class='add-type-btn' onclick='addTypePage();'><span class='glyphicon glyphicon-plus'></span> Categoria</a></li>
          </ul>
        </li>
        <li class='dropdown'>
          <a href='#' class="dropdown-toggle" data-toggle="dropdown">Categorie <span class='caret'></span></a>
          <ul class="dropdown-menu">
            <?php
              $server = 'localhost';
              $user = 'root';
              $passwd = 'fabio84';
              $dbname = 'youtubeMyChannels';

              $conn = mysqli_connect($server, $user, $passwd, $dbname);
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $query = "SELECT DISTINCT ctid, ctname FROM channel_type";
              $result = mysqli_query($conn, $query);
              $types = array();
              while($row = mysqli_fetch_assoc($result)){
                echo "<li><a href='#' class='channel-btn' onclick='getChannelsType(".$row['ctid'].");'>".$row['ctname']."</a></li>";
              }
            ?>
          </ul>
        </li>

      </ul>
      <div id="query-wrap">
        <input class="form-control" id="query" type="text"/> <button id="search-button" class="btn btn-primary" disabled onclick="search();"><span class="glyphicon glyphicon-search"></span></button>
        <div id='show'></div>
      </div>
      <a id="login-link">Login</a>
    </nav>
    <br>
    <div id="channels-container"></div>
    <div id='load'><img src='load.gif' /></div>
  </body>
</html>
