<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(CLASS_PATH.DS.'database.php');

class CatalogueFournisseur extends DatabaseObject {
	
	public static $database="db_cakeshop";
	protected static $table_name="catalogue_fournisseur";
	public static $champs_db = array('id', 'fournisseur', 'produit', 'prix', 'commentaire', 'ref_fournisseur');
	
		//table catalogue_fournisseur
	public $id;
	public $fournisseur;
	public $produit;
	public $prix;
	public $commentaire;
	public $ref_fournisseur;	//REFERENCE DU PRODUIT CHEZ LE FOURNISSEUR SI DIFFERENTE DE LA REFERENCE CAKESHOP
	

	public static function catalogue_fournisseur($id_fournisseur){
		//FONCTION QUI RETOURNE LE TABLEAU DES PRODUITS DANS LE CATALOGUE FOURNISSEUR
		global $db_cakeshop;
		$lignes_catalogue=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE fournisseur=".$id_fournisseur." ORDER BY id DESC");
		return $lignes_catalogue;
	}

	public static function fournisseurs_produit($id_produit){
		global $db_cakeshop;
		$lignes_catalogue=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit." ORDER BY prix ASC");
		return $lignes_catalogue;
		} 
  
		public static function infos_produit($id_produit,$id_fournisseur){
		global $db_cakeshop;
		$lignes_catalogue=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit." AND fournisseur=".$id_fournisseur." LIMIT 1");
		return (empty($lignes_catalogue)? false : array_shift($lignes_catalogue) );
		}
  
}

?>