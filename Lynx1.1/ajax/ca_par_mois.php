<?php require_once( "../includes/initialize.php"); ?>

<?php 

//Construit un array $ca_par_mois de la forme : (mois=>(web=>ca,boutique=>ca),mois+1=> ...) , le mois est sous la forme "2012-09"


$lignes=ChiffreAffaires::find_all();

$ca_par_mois=array();
$ca_web=0;
$ca_boutique=0;

foreach ($lignes as $ligne){
	$mois=substr($ligne->date,0,7);
	if ($mois>"2012-08"){
		if (!isset($ca_par_mois[$mois])){
			$ca_par_mois[$mois]=array('web'=>0,'boutique'=>0);
		}
	if ($ligne->point_de_vente=='web'){
		$ca_par_mois[$mois]['web']+=$ligne->ca;	
		} elseif ($ligne->point_de_vente=='boutique') {
		$ca_par_mois[$mois]['boutique']+=$ligne->ca;
		}
	}
}

$json=json_encode(array("aaData"=>$ca_par_mois));

$xaxis="[";
$webserie="[";
$boutiqueserie="[";
foreach ($ca_par_mois as $mois=>$values){
	$xaxis.= $mois . "," ;
	$webserie.=$values['web']. "," ;
	$boutiqueserie.=$values['boutique']. "," ;
}
$xaxis.="]";
$webserie.="]";
$boutiqueserie.="]";

//$data=array("xaxis"=>$xaxis , "webserie"=> $webserie , "boutiqueserie"=> $boutiqueserie);
echo json_encode(array('xaxis'=>$xaxis , 'webserie'=> $webserie , 'boutiqueserie'=> $boutiqueserie));

?>