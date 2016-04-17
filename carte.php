<?php
include( "common.php");

$files= array("LYC_AGREG/Stabiliser/NET/ELTVOE_A.LYC_AGREG");

$eltvoe_fields=array(10, 10, 12);

$data_arr = tab2data($files[0], $eltvoe_fields);

$cart_arr = array_filter($data_arr, function($el){ return $el[1]=="CARTRA"; });


foreach( $cart_arr as $line){
    printf(implode(";", $line));
    printf("\n");
}

?>
