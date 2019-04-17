<?php
/**
    Copyright © 2015, 2016, 2017, 2018, 2019 Richard Hitier <hitier.richard@gmail.com>
    This work is free. You can redistribute it and/or modify it under the
    terms of the Do What The Fuck You Want To Public License, Version 2,
    as published by Sam Hocevar. See the COPYING file for more details.
 **/
?>
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
echo '<ul class="dir_list">';
foreach ( $dirs as $dir ){
    echo  "<li><a href=".$dir."/".$dir."-ENTREE.html>".$dir."/</a></li>";
}
echo '</ul>';
?>
  </body>

</html>

