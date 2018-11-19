<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
          $types[$row['ctid']] = $row['ctname'];
        }
        echo json_encode($types);