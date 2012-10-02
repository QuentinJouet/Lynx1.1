<?php require_once( "../includes/initialize.php"); ?>

<?php 
global $session;
$d=$session->datedebut;
$f=$session->datefin;

$sql="SELECT * FROM chiffre_affaires WHERE date>='" . $d->sql . "' AND date<='" . $f->sql . "'";
$lignes=ChiffreAffaires::find_by_sql($sql);
$ca_web=0;
$ca_boutique=0;

foreach ($lignes as $ligne){
if ($ligne->point_de_vente=web){
	$ca_web+=$ligne->ca;	
	}	elseif($ligne->point_de_vente=boutique) {
	$ca_boutique+=$ligne->ca;
	}
}

$ca=array($ca_web,$ca_boutique);
$json=json_encode(array("aaData"=>$ca));

echo $json;
?>