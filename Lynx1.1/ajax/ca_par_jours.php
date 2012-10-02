<?php require_once( "../includes/initialize.php"); ?>

<?php 

//Construit un array $ca_par_jour de la forme : (mois=>(web=>ca,boutique=>ca),mois+1=> ...) , le mois est sous la forme "2012-09"


$lignes=ChiffreAffaires::find_all();

$ca_par_jour=array();
$ca_web=0;
$ca_boutique=0;

foreach ($lignes as $ligne){
	$jour=$ligne->date;
	if ($jour>"2012-08-31"){
		if (!isset($ca_par_jour[$jour])){
			$ca_par_jour[$jour]=array('web'=>0,'boutique'=>0);
		}
	if ($ligne->point_de_vente=='web'){
		$ca_par_jour[$jour]['web']+=$ligne->ca;	
		} elseif ($ligne->point_de_vente=='boutique') {
		$ca_par_jour[$jour]['boutique']+=$ligne->ca;
		}
	}
}

$json=json_encode(array("aaData"=>$ca_par_jour));

$xaxis="[";
$webserie="[";
$boutiqueserie="[";
foreach ($ca_par_jour as $jour=>$values){
	$xaxis.= $jour . "," ;
	$webserie.=$values['web']. "," ;
	$boutiqueserie.=$values['boutique']. "," ;
}
$xaxis.="]";
$webserie.="]";
$boutiqueserie.="]";

//$data=array("xaxis"=>$xaxis , "webserie"=> $webserie , "boutiqueserie"=> $boutiqueserie);
echo json_encode(array('xaxis'=>$xaxis , 'webserie'=> $webserie , 'boutiqueserie'=> $boutiqueserie));

?>