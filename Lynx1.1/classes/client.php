<?php
require_once(CLASS_PATH.DS.'database.php');

class Client extends DatabaseObject {

  protected static $database="db_cakeshop_thelia";
  protected static $table_name="client";
  protected static $champs_db=array('id','ref','raison','entreprise','siret','intracom','nom','prenom','adresse1','adresse2','adresse3','cpostal','ville','pays','telfixe','telport','email','motdepasse','parrain','type','pourcentage','lang',);
  public static $elements_tri=array('id'=>'Date de création','ca'=>'Chiffre d\'affaires','nom'=>'Nom','pourcentage'=>'Réduction','nb_commandes'=>"Nombre de commandes",'pays'=>"Pays",);


//attriuts base de donnée
public $id;
public $ref;
public $raison;
public $entreprise;
public $siret;
public $intracom;
public $nom;
public $prenom;
public $adresse1;
public $adresse2;
public $adresse3;
public $cpostal;
public $ville;
public $pays;
public $telfixe;
public $telport;
public $email;
public $motdepasse;
public $parrain;
public $type;
public $pourcentage;
public $lang;

//on active le cache pour tri de tableau. Cf fonction tri tableau
public $temp;





public function commandes(){
	return CommandeThelia::find_by_client($this->id);	
}

public function nb_commandes(){ // pas optimisé...

return count($this->commandes());
	
}

//Chiffre d'affaire du client.
public function ca(){
	$commandes=$this->commandes();
	$ca=0;
	foreach ($commandes as $commande){
	//Seulement pour commandes payées 
	if ($commande->statut>1 && $commande->statut<5){
		$ca+=$commande->total_ttc();
		}
	}
	return $ca;
}


public function nom_complet(){
	return ucfirst(strtolower($this->prenom)).' '.strtoupper($this->nom);
}

public function adresse(){
	$adresse=$this->adresse1.' '.$this->adresse2.' '.$this->adresse3.'<br/>'.$this->cpstal.' '.$this->ville;
	return $adresse;
}
	

}

?>