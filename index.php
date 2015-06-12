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
<?php
include( "./common.php");
global $dirs;
echo '<ul>';
foreach ( $dirs as $dir ){
    echo  "<li><a href=".$dir."/".$dir."-ENTREE.html>".$dir."</a></li>";
}
echo '</ul>';
?>
  <ul>
      <li><a href='./display.php'>Les Mut'</a> </li>
  </ul>
  </body>

</html>

