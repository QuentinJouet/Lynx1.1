<?php
require_once(CLASS_PATH.DS.'database.php');

class Favori extends DatabaseObject {
	
	protected static $table_name="favori";
	protected static $database="db_cakeshop";
	public static $champs_db = array('id, id_p, titre, ref');
	
	//table fournisseur
	public $id;
	public $id_p;
	public $titre;
	public $ref;


	public static function est_favori($id) {
		global $db_cakeshop;
		$sql = "SELECT count(id) FROM favori WHERE id_p={$id}";
		//echo $sql;
		$result_set = $db_cakeshop->query($sql);	
		$p = mysql_fetch_array($result_set);
		return ((int)$p[0]==1)? true : false;	
	}
	
	
	public static function ajouter_favori($id) {
		if (self::est_favori($id)){
		return false;	
		}
		else {
		global $db_cakeshop;
		$produit = Produit::produit_par_id($id);
		$titre=$db_cakeshop->escape_value($produit->titre);
		$ref=$db_cakeshop->escape_value($produit->ref);
		$sql = "INSERT INTO favori (id_p, titre, ref) VALUES ({$id}, '{$titre}','{$ref}')";
		//echo $sql;
		$reussite = $db_cakeshop->query($sql);	
		return $reussite;	
		}
	}
	
	public static function supprimer_favori($id) {
		if (!self::est_favori($id)){
		return false;	
		}
		else {
		global $db_cakeshop;
		$sql = "DELETE FROM favori WHERE id_p={$id}";
		$reussite = $db_cakeshop->query($sql);	
		return $reussite;	
		}
	}
}

?>