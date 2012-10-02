<?php

// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class LigneCommandeThelia extends DatabaseObject {

  public static $database="db_cakeshop_thelia";
  public static $table_name="venteprod";
  public static $champs_db=array('id', 'ref','titre', 'quantite', 'prixu', 'tva', 'commande', 'parent');
  public static $db_fields=array('id', 'ref','titre', 'quantite', 'prixu', 'tva', 'commande', 'parent');

  public $id;
  public $ref;
  public $titre;
  public $quantite;
  public $prixu;
  public $tva;
  public $commande;
  public $parent;
  
  public $produit;
  
  
 
	public static function lignes_pour_commande($id_commande='') {
    global $db_cakeshop_thelia;
    $sql = "SELECT * FROM " . self::$table_name;
    $sql .= " WHERE commande='" .$db_cakeshop_thelia->escape_value($id_commande);
    $sql .= "' ORDER BY ref ASC";
	//echo $sql;
    return self::find_by_sql($sql,$db_cakeshop_thelia,self::$db_fields);
	}
		
	public function prix_total(){
		return $this->prixu * $this->quantite;
	}
	
	public function tva_val(){
		return $this->tva * $this->prix_total() / 100;
	}
	

}

?>