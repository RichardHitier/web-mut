<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Web SE</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <style  type="text/css"> </style>
    <script type="text/javascript"> </script>
  </head>

  <body>
  <ul>
<?php
include( "./common.php");
global $dirs;
foreach ( $dirs as $dir ){
    echo  "<li><a href=".$dir."/".$dir."-ENTREE.html>".$dir."</a></li>";
}
?>
  </ul>
  <ul>
      <li><a href='webse/display.php'>Les Mut'</a> </li>
  </ul>
  </body>

</html>

