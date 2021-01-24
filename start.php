<?php

function debug_to_console($data) {
  $output = $data;
  if (is_array($output))
      $output = implode(',', $output);

  echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<head>
  <meta charset="utf-8">
  <title>Tytuł strony</title>

  <link rel="stylesheet" href="style/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/style1.css">
  <script src="scripts.js"></script>
  <script src="js/jquery.min.js"></script>


</head>