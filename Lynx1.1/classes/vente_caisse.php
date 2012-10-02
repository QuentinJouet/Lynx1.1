<?php

require_once(CLASS_PATH.DS.'database.php');

class VenteCaisse extends DatabaseObject {
	
	public static $table_name="vente_caisse";
	static public $database = 'db_cakeshop';
	public static $champs_db=array('id', 'ticket','datetime','ref','titre','quantite','prixu','tva','paiement');

	public $id;
	public $ticket;
	public $datetime;	
	public $ref;	
	public $titre;
	public $quantite;
	public $prixu;
	public $tva;
	public $paiement;
	
	public static function ventes_shop($ref_produit){
	global $db_cakeshop;
		$sql="SELECT * FROM " . self::$table_name . " WHERE ref='" . $ref_produit . "'";
		$ventes=self::find_by_sql($sql);
		if (empty($ventes)){
		return array('nb_ventes'=>0,'ca'=>0);
		} else {
			$nb_ventes=0;
			$ca=0;
			foreach ($ventes as $vente){
				$nb_ventes+=$vente->quantite;
				$ca+=($vente->quantite * $vente->prixu);
			}
			return array('nb_ventes'=>$nb_ventes,'ca'=>$ca);
		}
	}	
	
}

?>
