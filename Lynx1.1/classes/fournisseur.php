<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class Fournisseur extends DatabaseObject {
	
	public static $database="db_cakeshop";
	protected static $table_name="fournisseur";
	public static $champs_db = array('id', 'nom', 'telephone', 'siret', 'mail', 'fax', 'siteweb', 'commentaire', 'adresse', 'pays', 'devise');
	
	//table fournisseur
	public $id;
	public $nom;
	public $telephone;
	public $siret;
	public $mail;
	public $fax;	
	public $siteweb;
	public $commentaire;
	public $adresse;
	public $pays;
	public $devise;
	
	//Choix devise
	public $choix_devise=array('euro','livre','dollar US','dollar CA');
	
	
  public function full_name() {
    if(isset($this->first_name) && isset($this->last_name)) {
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }

	
	static public function afficher_nom($id_fournisseur){
		$fournisseur = self::find_by_id($id_fournisseur);
		return $fournisseur->nom;	
		
	}
	
	
	public function enregistrer_old() {
	  
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	//CHANGER POUR PRIVATE
	private function paires(){
		$paires=array();
		$bruts = self::champs_db_thelia();
		foreach($bruts as $brut){
		$exp=explode(' as ',$brut)	;
		$paires[trim($exp[0])]=$this->{trim($exp[1])};
		}
		
	return $paires;	
	}
	
		private function enregistrer_cakeshop(){
		global $db_cakeshop;
	$sauvegarde_cakeshop=self::clean_tableau($this->paires(),$db_cakeshop);
	
	$attribute_pairs = array();
		foreach($sauvegarde_cakeshop as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
	$sql_cakeshop="UPDATE fournisseur";
	$sql_cakeshop.="SET ";
	$sql_cakeshop.= join(", ", $attribute_pairs);
	$sql_cakeshop.=" WHERE p.id=".$db_cakeshop_cakeshop->escape_value($this->id) ;		
	echo $sql_cakeshop;
	$db_cakeshop->query($sql_cakeshop);
	 return ($db_cakeshop_cakeshop->affected_rows() == 1) ? true : false;
	
	}
	
	public function verification(){
		
	
		
	}
	
	public function enregistrer(){
	
	$resultat=$this->enregistrer_thelia();
		return $resultat;
	}
	

	
	public static function produit_client_existe($id) {
		global $db_cakeshop;
		$sql = "SELECT count(id) FROM produit WHERE id={$id}";
		$result_set = $db_cakeshop->query($sql);	
		$p = mysql_fetch_array($result_set);
		return ((int)$p[0]==0)? false : true;	
	}
	
	public static function id_par_ref($ref){
	
		global $db_cakeshop;
		$sql = "SELECT id FROM produit WHERE ref='";
		$sql.= $db_cakeshop->escape_value($ref);
		$sql .= "' ";
		$sql.="LIMIT 1";
		$result=$db_cakeshop->query($sql);
		return array_shift(mysql_fetch_array($result));
	}
	
		 
	public static function autocomplete_liste(){
	global $db_cakeshop;
	$query = "SELECT id, nom FROM fournisseur";
	$query .= "ORDER BY nom ASC ";
	$result_set = $db_cakeshop->query($query);
	while($data = mysql_fetch_array($result_set)) {

	$tags[]=utf8_encode($data['nom']) . ' | ' . utf8_encode($data['id']) /*. ' | ' . utf8_encode($data['id'])*/;
}
return json_encode($tags);
}
	 


	  
	  
  

}

?>