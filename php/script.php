<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

  $server = '';
  $user = '';
  $passwd = '';
  $dbname = 'youtubeMyChannels';

  $conn = mysqli_connect($server, $user, $passwd, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if(!empty($_POST['func'])){
    $func = $_POST['func'];
    switch($func){
      case 'getAllChannels':
        $query = "SELECT * FROM channel_names WHERE ctype = (SELECT ctid FROM channel_type WHERE ctid = 1) ORDER BY cname ASC";
        $result = mysqli_query($conn, $query);
        $channels = array();
        while($row = mysqli_fetch_assoc($result)){
          array_push($channels, array('cid' => $row['cid'], 'cname' => $row['cname']));
        }
        echo json_encode($channels);
      break;
      case 'getChannelsType':
        $type = $_POST['channelType'];
        $query = "SELECT * FROM channel_names WHERE ctype = '$type' ORDER BY cname ASC";
        $result = mysqli_query($conn, $query);
        $channels = array();
        while($row = mysqli_fetch_assoc($result)){
          array_push($channels, array('cid' => $row['cid'], 'cname' => $row['cname']));
        }
        echo json_encode($channels);
      break;
      case 'getTypes':
        $query = "SELECT DISTINCT ctid, ctname FROM channel_type";
        $result = mysqli_query($conn, $query);
        $types = array();
        while($row = mysqli_fetch_assoc($result)){
          $types[$row['ctid']] = $row['ctname'];
        }
        echo json_encode($types);
      break;
      case 'addChannel':
        $channelName = $_POST['channelName'];
        $channelId = $_POST['channelType'];
        $query = "INSERT INTO channel_names VALUES (NULL, '$channelName', '$channelId')";
        if(mysqli_query($conn, $query)){
            echo "Channel saved successfully";
        } else {
          echo "Error: ".$query."\r\n".mysqli_error($conn);
        }
      break;
      case 'addType':
        $channelType = $_POST['channelType'];
        $query = "INSERT INTO channel_type VALUES (NULL, '$channelType')";
        if(mysqli_query($conn, $query)){
            echo "Category saved successfully";
        } else {
          echo "Error: ".$query."\r\n".mysqli_error($conn);
        }
      break;
      case 'delChannel':
        $channelID = $_POST['channelID'];
        $query = "DELETE FROM channel_names WHERE cid = '$channelID'";
        if(mysqli_query($conn, $query)){
          echo "Channel ".$channelID." deleted.";
        } else{
          echo "Error: ".$query."\r\n".mysqli_error($conn);
        }
      break;
    }
  }

  mysqli_close($conn);
?>
