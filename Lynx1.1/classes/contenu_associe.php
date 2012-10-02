<?php
require_once(CLASS_PATH.DS.'database.php');

class ContenuAssocie extends DatabaseObject {

	protected static $table_name="contenuassoc";
	public static $champs_db=array('id','objet','type','contenu','classement');
	public static $database='db_cakeshop_thelia';
	
	public $id;
	public $objet; //id du produit ou rubrique
	public $type; // 1 ou 0 (1 pour un produit, 0 pour une rubrique)
	public $contenu;//contenuassocié àl'objet
	public $classement; //a réécrirepour que cela soit la meme chose que objet.
	
	
	public static $contenus_surveilles= 
	array(
		"Produits par Thème"=>array(102,103,104,106,107,116,119,141),
		"Produits par saison"=>array(98,97,99,100,117,118),
		"Autour du cupcake"=>array(89,90,91,92,93,94)
	);
	
	
	
	
	
	
	public function titre_contenu(){
		global $db_cakeshop_thelia;
		$table= 'contenudesc';
		$colonne= 'contenu';
		
		$sql="SELECT titre FROM {$table} WHERE lang=1 AND {$colonne}={$this->contenu}";

	}
	
	public function titre_objet(){
		global $db_cakeshop_thelia;
		$table= ($this->type==1 ? 'produitdesc' :'rubriquedesc');
		$colonne= ($this->type==1 ? 'produit' :'rubrique');
		
		$sql="SELECT titre FROM {$table} WHERE lang=1 AND {$colonne}={$this->objet}";
	}
	
	static public function find_by_produit($id_produit){
	
	return self::find_by_sql("SELECT * FROM {$table_name} WHERE type=1 AND objet={$id_produit}");
		
	}
	
	static public function find_by_rubrique($id_rubrique){
	
	return self::find_by_sql("SELECT * FROM {$table_name} WHERE type=0 AND objet={$id_rubrique}");
		
	}

	static public function find_by_contenu($id_contenu){
	
	return self::find_by_sql("SELECT * FROM {$table_name} WHERE contenu={$id_contenu}");
			
	}
	
		
	

}