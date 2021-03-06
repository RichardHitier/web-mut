<?php
/**
    Copyright © 2015, 2016, 2017, 2018, 2019 Richard Hitier <hitier.richard@gmail.com>
    This work is free. You can redistribute it and/or modify it under the
    terms of the Do What The Fuck You Want To Public License, Version 2,
    as published by Sam Hocevar. See the COPYING file for more details.
 **/
?>
<?php

// some libs func //


function tab2data( $tabedfile, $fields_length){

    $fp=fopen( $tabedfile, "r");

    while ( ( $line = fgets($fp, 4096))!== false){

        // split line into row array
        $cursor_pos = 0;
        $row = array();
        foreach ($fields_length as $length) {
            $row[] = trim(substr($line, $cursor_pos, $length));
            $cursor_pos += $length;
        }

        $datas[] = $row;
    }
    return $datas;
}

function typeoffile($file){
    // agreg or sans ?
    //list( $mutes, $date, $type, $ext) = explode( '.', $file );
    $type= explode( '.', $file )[2];
    return $type;
}

//
//read file ELTVOE_A.*
//return an associativ indexed by idVoeu
//example:
// cut -c 11-16 ELTVOE_A.LYC_AGREG | sort -u
// 
function voeu2bareme($file){
    // get voeux array from file
    $fields = array(10, 10, 14, 5);
    $baremes_arr = tab2data($file, $fields);

    usort($baremes_arr, "baremcmp");

    // build associative array
    $baremes_ass = array();
    foreach( $baremes_arr as &$row){
        $baremes_ass[$row[0]]=$row[1];
    }

    return $baremes_ass;
}


function baremcmp($a, $b)
{
        if ($a[3] == $b[3]) {
            return 0;
        }
        return ($a[3] < $b[3]) ? -1 : 1;
}


?>
