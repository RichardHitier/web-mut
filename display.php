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

//$data_arr = csv2data("../LYC_AGREG/Stabiliser/NET/MUTES_A.150602_15-06-34.LYC_AGREG");
//$data_arr = csv2data("MUTES_A.150529_17-12-09-1.LYC_SANSA.csv");
//$data_arr = csv2data("MUTES_A.150602_15-06-34.LYC_AGREG.csv");

$files = array("MUTES_A.150529_17-12-09.LYC_SANSAG.csv" , "MUTES_A.150602_15-06-34.LYC_AGREG.csv");


$file=( isset($_GET['file']) && !empty($_GET['file']) ) ? $_GET['file'] : $files[0];
$mat=( isset($_GET['mat']) && !empty($_GET['mat']) ) ? $_GET['mat'] : 'x';
$dpt=( isset($_GET['dpt']) && !empty($_GET['dpt']) ) ? $_GET['dpt'] : 'x';
$type=( isset($_GET['type']) && !empty($_GET['type']) ) ? $_GET['type'] : 'x';
$order=( isset($_GET['order']) && !empty($_GET['order']) ) ? $_GET['order'] : 'ASC';

$sort_order = ( $order == 'ASC' ) ? SORT_ASC:SORT_DESC;


//--------------------------------------------------------------
$data_arr = csv2data($file);
//--------------------------------------------------------------

// build matiers liste from data
$mats = array_merge( array( 'x') ,
        array_unique(
            array_column( $data_arr, 1)));
$dpts = array( 'x', '11', '30', '34', '48', '66');
$types = array( 'x', 'DPT', 'COM', 'GEO', 'ZR');
$orders = array( 'ASC', 'DESC');

echo '<select id="file_select" name="file">';
foreach( $files as &$lfile ){
    $selected = ($file == $lfile)?'selected="selected"':'';
    echo ' <option value="'. $lfile .'" '. $selected.'>'.typeoffile($lfile).'</option>';
}
echo '</select> ';
echo '<select id="mat_select" name="mat">';
foreach( $mats as &$lmat ){
    $selected = ($mat == $lmat)?'selected="selected"':'';
    echo ' <option value="'. $lmat .'" '. $selected.'>'.$lmat.'</option>';
}
echo '</select> ';

echo '<select id="dpt_select" name="dpt">';
foreach( $dpts as &$ldpt ){
    $selected = ($dpt == $ldpt)?'selected="selected"':'';
    echo ' <option value="'. $ldpt .'" '. $selected.'>'.$ldpt.'</option>';
}
echo '</select> ';

echo '<select id="type_select" name="type">';
foreach( $types as &$ltype){
    $selected = ($type == $ltype)?'selected="selected"':'';
    echo ' <option value="'. $ltype .'" '.$selected.'>'.$ltype.'</option>';
}
echo '</select> ';

echo '<select id="order_select" name="order">';
foreach( $orders as &$lorder){
    $selected = ($order == $lorder)?'selected="selected"':'';
    echo ' <option value="'. $lorder .'" '.$selected.'> barême '.$lorder.'</option>';
}
echo '</select> ';

echo '<input type="submit"/>';
echo '<span id="cdt"> candidats trouvés</span>';
echo ' </form>';





$data_arr = filterdata( $data_arr, $mat, $dpt, $type );

// sort the array by bareme
$bareme = array_column( $data_arr, 4);
array_multisort( $bareme, $sort_order, $data_arr);

//$cols = array(1,2,3,4,5,6,7,8,9,10,11,12);
$cols = array(1,2,3,4,5,6,10,11,12);
$headings = array( 'phase2',
            'matiere ',
            'dpt ',
            'type etb',
            'bareme',
            'rang',
            'type',
            'id1',
            'id2',
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
foreach ( $data_arr as &$row){
    $num++;
    echo "<tr>";
    foreach( $cols as &$col){
        $cont=$row[$col];
        if( $col == 10 ){
            $cont='<a href="../'.typeoffile($file).'/Stabiliser/Editions/web/ROS-'.$row[8].'.html">'.$row[$col].'</a>';
        }
        if( $col == 12 ){
            $cont='<a href="../'.typeoffile($file).'/Stabiliser/Editions/web/PIL-'.$row[1].'-'.$row[11].'.html">'.$row[$col].'</a>';
        }
        echo "<td>" . $cont . "</td>\n";
    }
    echo "</tr>";
}

echo "</table>";
echo '<span id="hidden_cdt">'.$num.'</span>';

function typeoffile($file){
    // agreg or sans ?
    //list( $mutes, $date, $type, $ext) = explode( '.', $file );
    $type= explode( '.', $file )[2];
    return $type;
}

function csv2data( $csvfile ){

    // get array from csv
    $data_arr = array();
    if (($handle = fopen($csvfile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            array_push( $data_arr, $data);
        }
    }
    fclose($handle);

    return $data_arr;

}

function filterdata($data_arr, $mat, $dpt, $type){
    $data_res = array();
    foreach ( $data_arr as $row){
        if ( ( 'x' == $mat or $row[1] == $mat )
         and ( 'x' == $dpt or $row[2] == $dpt )
         and ( 'x' == $type or ( strpos( $row[6], $type) !== false ) ) ) {
             array_push( $data_res, $row);
        }
    }
    return $data_res;
}


?>

<script type="text/javascript" src="main.js"></script> 
</body>
</html>
