
<?php

require_once(CLASS_PATH.DS.'database.php');

class TabStock extends DatabaseObject {

	public static $table_name="tabstock";
	static public $database = 'db_cakeshop';
	public static $champs_db=array('id', 'tableau', 'commande', 'nom', 'date');


	public $id;
	public $tableau;
	public $commande;	
	public $nom;	
	public $date;
	
	
	public function gettableau(){
		return unserialize($this->tableau);
	}
	
	public function settableau($tab){
		$this->tableau=serialize($tab);
	}
	
	public static function exist($id_c){
		global $db_cakeshop;
		$sql="SELECT id FROM " . self::$table_name . " WHERE commande=" . $id_c . " LIMIT 1";
		//echo $sql;
		$resultat=$db_cakeshop->query($sql);
		$resultat=mysql_fetch_array($resultat);
		if(empty($resultat)){
			return false;
		}else{
			return array_shift($resultat);
		}
	}
	
	public static function recuperer($id_c){
		global $db_cakeshop;
		$existe=self::exist($id_c);
		if ($existe){
			//On la récupère de la base de données
			$tabstock=self::find_by_id($existe);
			return $tabstock;
		}
		else{
			return self::creer_tabstock_pour_commande($id_c);
			
		}
		
		
	}
	
	
	public static function creer_tabstock_pour_commande($id_c){
	$tabstock=new self;
	$tabstock->commande=$id_c;
	//Crée le tableau
	$tableau=array();
	$lignes = LigneCommandeFournisseur::find_by_commande($id_c) ;
	foreach ($lignes as $ligne){
		$id_p=$ligne->produit;
		$tableau[$id_p]=array('q_commandee'=>$ligne->quantite,'q_recue'=>0,'stock_web'=>0,'stock_boutique'=>0,'stock_ope'=>0);
	}
	$tabstock->settableau($tableau);
	$tabstock->save();
	return $tabstock;
	}
	
	public function delete_tabstock($id_c){
		$sql="DELETE  FROM " . self::$table_name . " WHERE commande=" . $id_c;
		$db_cakeshop->query($sql);
	}
	
}

?>