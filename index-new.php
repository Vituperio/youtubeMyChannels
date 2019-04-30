<?php
$host = 'localhost';
$user = 'root';
$pass = 'fabio84';
$dbname = 'youtubeMyChannels';

$conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $pass);


$types = array('');
$qtypes = "SELECT * FROM channel_type";
$rtypes = $conn->prepare($qtypes);
$rtypes->execute();
foreach($rtypes as $kt => $vt){
  array_push($types, $vt['ctname']);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My Favourite Youtube Channels</title>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/newscript.js"></script>


    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" />

    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <nav class="navbar">
      <ul class="nav navbar-nav">
        <li><a href="/youtubeMyChannels/index.php">Home</a></li>
        <li><a href="/youtubeMyChannels/index-new.php">Alternative</a></li>
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
              $query = "SELECT DISTINCT * FROM channel_type";
              $result = $conn->prepare($query);
              $result->execute();
              $re = $result->fetchAll(PDO::FETCH_ASSOC);
              foreach ($re as $ke => $ve) {
                echo "<li><a href='#' class='channel-btn' onclick='getChannelsType(".$ve['ctid'].");'>".$ve['ctname']."</a></li>";              
              }
              ?>
          </ul>
        </li>
      </ul>
    </nav>
    <br><br><br>
    <div class='container'>
      <div id='accordion'>
      <?php
        $query = "SELECT * FROM channel_names ORDER BY ctype DESC";
        $result = $conn->prepare($query);
        $result->execute();
        $r = $result->fetchAll(PDO::FETCH_BOTH);
        foreach ($r as $k => $v) {
          $xml =  @file_get_contents("https://www.youtube.com/feeds/videos.xml?user=".$v['cname']);
          if($xml === false){
            $xml = @file_get_contents("https://www.youtube.com/feeds/videos.xml?channel_id=".$v['cname']);
          }
          $output = simplexml_load_string($xml);
          $type = $types[$v['ctype']];
          echo "<h3 class='".$type."'>";
            echo (string)$output->author->name[0];
          echo "</h3>";
          echo "<div>";
            echo "<ul>";
            foreach($output->entry as $entry){
              echo "<li><a href='".(string)$entry->link['href']."'>".$entry->title."</a></li>";
            }
            echo "</ul>";
          echo "</div>";
        }
      ?>
      </div>
    </div>
    <br>
    <footer class='footer'>
    </footer>
  </body>
</html>
