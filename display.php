<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Les Mut'</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <script type="text/javascript" src="jquery-2.1.4.min.js"></script> 
  </head>
  <body>
  <form method="GET" action="display.php">
<?php
// Hi, 
// I know this script is quickly and dirtily written.
// please, dont let me know ;-)

include( "common.php");
include( "./commonlib.php");
//$files = array("MUTES_A.150529_17-12-09.LYC_SANSAG.csv" , "MUTES_A.150602_15-06-34.LYC_AGREG.csv");
//$files = array("MUTES_A.150602_17-09-03.EPS");
global $files;


$file=( isset($_GET['file']) && !empty($_GET['file']) ) ? $_GET['file'] : $files[0];
$mat=( isset($_GET['mat']) && !empty($_GET['mat']) ) ? $_GET['mat'] : 'x';
$dpt=( isset($_GET['dpt']) && !empty($_GET['dpt']) ) ? $_GET['dpt'] : 'x';
$type=( isset($_GET['type']) && !empty($_GET['type']) ) ? $_GET['type'] : 'x';
$bar=( isset($_GET['bar']) && !empty($_GET['bar']) ) ? $_GET['bar'] : 'x';
$order=( isset($_GET['order']) && !empty($_GET['order']) ) ? $_GET['order'] : 'ASC';
$over=( isset($_GET['over']) && !empty($_GET['over']) ) ? $_GET['over'] : 'x';

$sort_order = ( $order == 'ASC' ) ? SORT_ASC:SORT_DESC;



//------------ get datas from selected file --------------------
// TODO: mutes_fields should go with $cols and $headings
$mutes_fields = array(7, 6, 4, 4, 7, 4, 10, 16, 11, 11, 11, 40, 9, 60);
$data_arr = tab2data($file, $mutes_fields);
//--------------------------------------------------------------

//------------ also get  from selected file --------------------
// extract base dir from MUTES file
// and get associativ VOEUX array
$eltvoe_file=dirname( $file )."/ELTVOE_A.".typeoffile($file);
$eltvoe_arr=voeu2bareme( $eltvoe_file );
//--------------------------------------------------------------

//// now  change idvoeu 2 barem // as column for $data_arr
$cdt_arr = array();
foreach( $data_arr as $row){
    $barem="----";
    if ( isset($eltvoe_arr[$row[8]]))
        $barem=$eltvoe_arr[$row[8]];
    //printf('<'.$row[7].'>\n');
    //printf('<'.$barem.'>\n');
    $row[8]=$barem;
    array_push( $cdt_arr, $row);
}
//$cdt_arr = array_map( function($row) use ($eltvoe_arr) { row[7] = $eltvoe_arr[row[7]]; return row;} );

echo "<h2>".count($cdt_arr)." lignes dans le fichier: <a href=\"$file\">$file</a></h2>";

// build matiers liste from data
$mats = array_merge( array( 'x') ,
                     array_unique( array_column( $cdt_arr, 1))
                   );
// build barem list from data
$barems = array_merge( array( 'x') ,
                     array_unique( array_column( $cdt_arr, 7))
                   );
$dpts = array( 'x', '11', '30', '34', '48', '66');
$overs = array( 'x', 'rg100');
$types = array( 'x', 'DPT', 'COM', 'GEO', 'COM|GEO', 'ZR', 'ZRE', 'ZRD');
$orders = array( 'ASC', 'DESC');

echo '<table>';
echo '<tr>';
echo '<td>discipline</td><td>matière</td><td>dpt</td><td>barème</td>';
echo '<td>type</td><td>rang&gt;100</td><td>ordre</td>';
echo '</tr><tr>';
echo '<td>';
echo '<select id="file_select" name="file">';
foreach( $files as &$lfile ){
    $selected = ($file == $lfile)?'selected="selected"':'';
    echo ' <option value="'. $lfile .'" '. $selected.'>'.typeoffile($lfile).'</option>';
}
echo '</select> ';
echo '</td>';

echo '<td>';
echo '<select id="mat_select" name="mat">';
foreach( $mats as &$lmat ){
    $selected = ($mat == $lmat)?'selected="selected"':'';
    echo ' <option value="'. $lmat .'" '. $selected.'>'.$lmat.'</option>';
}
echo '</select> ';
echo '</td>';

echo '<td>';
echo '<select id="dpt_select" name="dpt">';
foreach( $dpts as &$ldpt ){
    $selected = ($dpt == $ldpt)?'selected="selected"':'';
    echo ' <option value="'. $ldpt .'" '. $selected.'>'.$ldpt.'</option>';
}
echo '</select> ';
echo '</td>';

echo '<td>';
echo '<select id="barem_select" name="bar">';
foreach( $barems as &$lbar ){
    $selected = ($bar == $lbar)?'selected="selected"':'';
    echo ' <option value="'. $lbar .'" '. $selected.'>'.$lbar.'</option>';
}
echo '</select> ';
echo '</td>';

echo '<td>';
echo '<select id="type_select" name="type">';
foreach( $types as &$ltype){
    $selected = ($type == $ltype)?'selected="selected"':'';
    echo ' <option value="'. $ltype .'" '.$selected.'>'.$ltype.'</option>';
}
echo '</select> ';
echo '</td>';

echo '<td>';
echo '<select id="ov_select" name="over">';
foreach( $overs as &$lover){
    $selected = ($over == $lover)?'selected="selected"':'';
    echo ' <option value="'. $lover .'" '.$selected.'> '.$lover.'</option>';
}
echo '</select> ';
echo '</td>';


echo '<td>';
echo '<select id="order_select" name="order">';
foreach( $orders as &$lorder){
    $selected = ($order == $lorder)?'selected="selected"':'';
    echo ' <option value="'. $lorder .'" '.$selected.'> barême '.$lorder.'</option>';
}
echo '</select> ';
echo '</td>';
echo '</tr>';
echo '</table>';

echo '<input type="submit"/>';
echo '<span id="cdt"> candidats filtrés</span>';
echo ' </form>';



$cdt_arr = filterdata( $cdt_arr, $mat, $dpt, $bar, $type, $over );


// sort the array by bareme
$bareme = array_column( $cdt_arr, 4);
array_multisort( $bareme, $sort_order, $cdt_arr);

$cols = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13);
//$cols = array(1,2,3,4,5,6,10,11,12);
$headings = array(
            'phase2',
            'matière ',
            'dpt ',
            'type etb',
            'barème',
            'rang',
            'type',
            'ss-type',
            'idVoeux',
            'idCandidat',
            'date nais',
            'nom cdt',
            'rne ',
            'résultat');

// build result table
echo "<table>";

// first titles
echo "<tr>";
foreach( $cols as &$col){
    echo "<th>" . $headings[$col] . "</th>";
}
echo "</tr>";

// then data rows
$num=0;
// TODO: sort before display
foreach ( $cdt_arr as &$row){
    $num++;
    echo "<tr>";
    foreach( $cols as &$col){
        $cont=$row[$col];
        if( $col == 11 ){
            $cont='<a href="'.typeoffile($file).'/Stabiliser/Editions/web/ROS-'.$row[9].'.html">'.$row[$col].'</a>';
        }
        if( $col == 13 ){
            $comp="";
            if( $row[7] == "EREA")
                $comp="-38";
            else if ( $row[7] == "SEGPA")
                $comp="-41";
            $cont='<a href="'.typeoffile($file).'/Stabiliser/Editions/web/PIL-'.$row[1].'-'.$row[12].$comp.'.html">'.$row[$col].'</a>';
        }
        echo "<td>" . $cont . "</td>\n";
    }
    echo "</tr>";
}

echo "</table>";
echo '<span id="hidden_cdt">'.$num.'</span>';

function csv2data( $csvfile ){

    // get array from csv
    $cdt_arr = array();
    if (($handle = fopen($csvfile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            array_push( $cdt_arr, $data);
        }
    }
    fclose($handle);

    return $cdt_arr;

}


function filterdata($cdt_arr, $mat, $dpt, $bar, $type, $over){
    $data_res = array();
    foreach ( $cdt_arr as $row){
        if ( ( 'x' == $mat or $row[1] == $mat )
         and ( 'x' == $bar or $row[7] == $bar )
         and ( 'x' == $dpt or $row[2] == $dpt )
         and ( 'x' == $over or preg_match( '/\d\d\d/', $row[5]) )
         and ( 'x' == $type or ( preg_match( '/'.$type.'/', $row[6]) !== 0 ) ) ) {
             array_push( $data_res, $row);
        }
    }
    return $data_res;
}


?>

<script type="text/javascript" src="main.js"></script> 
</body>
</html>
