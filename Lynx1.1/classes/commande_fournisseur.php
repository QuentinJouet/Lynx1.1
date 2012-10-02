<?
require_once(CLASS_PATH.DS.'database.php');

class CommandeFournisseur extends DatabaseObject {
	
	public static $database="db_cakeshop";
	protected static $table_name="commande_fournisseur";
	public static $champs_db = array('id', 'statut', 'fournisseur', 'date_commande_prete', 'date_commande_passee', 'date_commande_recue','date_commande_stock','commentaire');
	
	//table Commande fournisseur
	public $id;
	public $statut;
	public $fournisseur	;
	public $date_commande_prete	;
	public $date_commande_passee;	
	public $date_commande_recue	;
	public $date_commande_stock	;
	public $commentaire	;

	//attributs pas dans la bdd
	public static $nom_statuts=array('Suggestion','Validée','Passée','Reçue','Entrée en stock','Annulée');
	
	//attributs pour tri
	public static $elements_tri = array('id'=>'date');
	
	
	public function texte_statut(){
		return self::$nom_statuts[$this->statut];
	}
	
	
	
	

}



?>