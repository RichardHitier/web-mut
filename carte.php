<?php
include( "common.php");
include( "./commonlib.php");

// Get eltvoe
$files= array("LYC_AGREG/Stabiliser/NET/ELTVOE_A.LYC_AGREG");
$eltvoe_fields=array(10, 10, 12);
$data_arr = tab2data($files[0], $eltvoe_fields);

echo "all eltvoa: ".count($data_arr)."<br>";

// and filter by 'CARTRA' only
$cart_arr = array_filter($data_arr, function($el){ return $el[1]=="CARTRA"; });
echo "cartra filtere: ".count($cart_arr)."<br>";

// get voeux
$files= array("LYC_AGREG/Stabiliser/NET/VOE_A.LYC_AGREG");
$voea_fields=array(32, 10, 9);
$data_arr = tab2data($files[0], $voea_fields);
echo "all voea: ".count($data_arr)."<br>";

// filter by carte voeux id (second field)
$voeaid_arr = array_column( $cart_arr, 0);
$voeux_arr= array_filter($data_arr, function($el) use ($voeaid_arr){ return in_array( $el[1] , $voeaid_arr ); });
echo "cartra filteerd: ".count($voeux_arr)."<br>";

// get candidates
$files= array("LYC_AGREG/Stabiliser/NET/CDT_A.LYC_AGREG");
$cdta_fields=array(10, 3, 15, 20);
$data_arr = tab2data($files[0], $cdta_fields);
echo "all CDT: ".count($data_arr)."<br>";

// filter by candidates ids in voeux  from CARTRA (third field)
$cdtid_arr = array_column( $voeux_arr, 2);
$cdt_arr = array_filter($data_arr, function($el) use ($cdtid_arr){ return in_array( $el[0], $cdtid_arr); });
echo "cartra filtered : ".count($cdt_arr)."<br>";

echo "<table>";
foreach( $cdt_arr as $line){
    $cont='<a href="LYC_AGREG/Stabiliser/Editions/web/ROS-'.$line[0].'.html">'.$line[1].' '.$line[2].' '.$line[3].'</a>';
    echo"<tr><td>" . $cont . "</td></tr>\n";
}
echo "</table>";
?>

