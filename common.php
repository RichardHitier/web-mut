<a href="./">accueil</a>
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
