<?php


$refstock=array();

$refstock["2308-1238"]= 0;
$refstock["2105-2044"]  = 1;
$refstock["2105-2079"]  = 3;
$refstock["417-431"]  = 8;
$refstock["417-442"]  = 9;
$refstock["CW925"]  = 0;
$refstock["CW921"]  = 6;
$refstock["BC730"]  = 4;
$refstock["SF708"]  =10;
$refstock["SL901"]  =28;
$refstock["SN904"]  =16;
$refstock["2310-644	"]  =23;
$refstock["710-755"]  = 0;
$refstock["710-586"]  = 0;
$refstock["704-112"]  = 7;
$refstock["GFO934"]  = 3;
$refstock["2308-1328"]  =15;
$refstock["2105-1011"]  = 5;
$refstock["2811-1011"]  = 5;
$refstock["2815-101"]  = 4;
$refstock["404-5168	"]  =14;
$refstock["2104-2536_03-611"]  = 7;
$refstock["LVC210200"]  = 3;
$refstock["BK01A001-01"]  = 1;
$refstock["BK01A070-01"]  = 1;
$refstock["BK01A170-01"]  = 0;
$refstock["PUR-SN-S-L"]  = 0;
$refstock["702-6007_03-704"]  = 6;
$refstock["DV1010"]  =10;
$refstock["BC740"]  =14;
$refstock["BC741"]  =14;
$refstock["BC721"]  =19;
$refstock["1911-448_ou_1911-1367"]  =37;
$refstock["1904-1193"]  = 9;
$refstock["2308-2502"]  = 1;
$refstock["710-1126"]  = 0;
$refstock["415-313"]  = 2;
$refstock["1911-511"]  = 6;
$refstock["CUTFRL1"]  = 8;
$refstock["S199521"]  = 1;
$refstock["415-260"]  = 7;
$refstock["415-0167"]  = 8;
$refstock["2105-2010"]  = 1;

$requete="";
foreach($refstock as $ref=>$stock)
{
	$requete.='UPDATE produit SET stock='.$stock.' WHERE ref=\''.$ref.'\';';

}

echo $requete;
echo 'br/><br/><br/>';


$requete2="SELECT * FROM produit WHERE ref IN('2308-1238'";
foreach($refstock as $ref=>$stock){
	$requete2.=",'".$ref."'";
}

echo $requete2;

?>