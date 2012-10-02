
<?
require_once(CLASS_PATH.DS.'database.php');

class LigneCommandeFournisseur extends DatabaseObject {
	
	public static $database="db_cakeshop";
	protected static $table_name="ligne_commande_fournisseur";
	public static $champs_db = array('id', 'commande_fournisseur', 'produit','quantite', 'prix', 'tva', 'ref_fournisseur');
	
	//table Commande fournisseur
	public $id;
	public $commande_fournisseur;
	public $produit	;
	public $quantite;
	public $prix;
	public $tva;
	public $ref_fournisseur;
	

	public static function find_by_commande($id_commande){
		 return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE commande_fournisseur=".$id_commande." ORDER BY id DESC");
		}
	
	public static function stock_en_commande($id_produit){
		$lignes = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit);
		$q_commandee=0;
		if (empty($lignes)){return 0;
			} else {
		foreach ($lignes as $ligne){
			$commande=CommandeFournisseur::find_by_id($ligne->commande_fournisseur);
			if(!empty($commande)){
				if($commande->statut == 1 || $commande->statut==2 || $commande->statut==3){
					$q_commandee+=$ligne->quantite;
				}
			}
		}
		return $q_commandee;	
		}
	}
	
}
	