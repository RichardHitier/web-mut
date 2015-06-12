<?php
// show subdirs welcome page
$dirs = array_filter(glob('*'), 'is_dir');

// stop if nothing
if ( 0 == count( $dirs)){
    echo '<h2 class="alert">ajoutez les sous-répertoires afin d\'utiliser ce module</h2>';
    exit;
}
?>
