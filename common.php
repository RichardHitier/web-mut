<?php
/**
    Copyright © 2015, 2016, 2017, 2018, 2019 Richard Hitier <hitier.richard@gmail.com>
    This work is free. You can redistribute it and/or modify it under the
    terms of the Do What The Fuck You Want To Public License, Version 2,
    as published by Sam Hocevar. See the COPYING file for more details.
 **/
?>
<a class="nav_btn" href="./index.php">répertoires web</a>
<a class="nav_btn" href="./display.php">tableau dynamique</a>
<?php
// show subdirs welcome page
$subdirs = array_filter(glob('*'), 'is_dir');
$dirs = array();

// guess if any MUTE_A files in such subdirs
$files = array();
foreach( $subdirs as $dir){
    $found=array_filter(glob("$dir/Stabiliser/NET/MUTE*"),'is_file');
    if ( 0 < count( $found )){
        array_push($files, $found[0]);
        array_push($dirs, $dir);
    }
}

// stop if nothing
if ( 0 == count( $dirs)){
    echo '<h2 class="alert">ajoutez les sous-répertoires afin d\'utiliser ce module</h2>';
    exit;
}

?>
