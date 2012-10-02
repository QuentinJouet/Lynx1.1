<?php
require_once(CLASS_PATH.DS.'database.php');

class HistoriqueStock extends DatabaseObject {

	protected static $table_name="historique_stock";
	public static $champs_db=array('id','produit','date','stock_boutique','stock_web');
	public static $database='db_cakeshop';
	
	public $id;
	public $produit;
	public $date; // DOIT ETRE AU FORMAT AAAA:MM:JJ 
	public $stock_boutique;
	public $stock_web;
	public $valeur_boutique;
	public $valeur_web;
	
	
	
	public function __construct(){

		$ajd=new Date('osef',time()*1000);
		$ajd=$ajd->jour_sql();
		$this->date=$ajd;

	}
	
	public function renseigner($id_produit){
		$produit=Produit::produit_par_id($id_produit);
		$this->produit=$id_produit;
		$this->stock_boutique = $produit->stock_boutique;
		$this->stock_web=$produit->stock_web;
		$this->valeur_web=$produit->stock_web*$produit->prix;
		$this->valeur_boutique=$produit->stock_boutique*$produit->prix;
	}
	
	function stock(){
		return $this->stock_boutique+$this->stock_web;
	}	
	
	
	static public function total_stock($date_mysql_jour){
		global $db_cakeshop;
		
		
		$query ="SELECT sum(stock_web) FROM historique_stock WHERE date='{$date_mysql_jour}' GROUP BY date";
		return false; //fonction pas finie.
		
		
	}
	
	
	static public function find_by_product($id_produit){
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit." ORDER BY date ASC");
	}
	
	static public function find_last_by_product($id_produit){
		$resultat= self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE produit=".$id_produit." ORDER BY date DESC LIMIT 1");
		//c'est un tableau avec un seul élément, on retourne sans l'array : 
		return !empty($resultat) ? array_shift($resultat) : false;
	}
	
	public function maj(){
	//RENSEIGNER() AVANT DE METTRE A JOUR
		$produit=Produit::produit_par_id($this->produit);
		$this->stock_boutique = $produit->stock_boutique;
		$this->stock_web=$produit->stock_web;
		$this->valeur_web=$produit->stock_web*$produit->prix;
		$this->valeur_boutique=$produit->stock_boutique*$produit->prix;
	}
	
	private function objet_date(){
		return Date::date_from_sql($this->date);
	}
	
	public function timestamp(){
		return $this->objet_date()->timestamp;
	}
	
	public static function historique_brut($id_produit,$type='total'){
		$historique = self::historique($id_produit,$type);
		$historique = json_decode($historique);
		$final=array();
		foreach($historique as $nombre){
			$final[]=(int)$nombre;
		}
		return json_encode($final);
	}
	
	public static function historique($id_produit,$type='total'){
	//type peut etre 'web' 'boutique' 'total'
		$text='';
		switch ($type)  {
			case 'web' :
				$text='web';
				break;
			case 'boutique' : 
				$text='boutique';
				break;
			default:
				$text='stock';				
		}
		
		$historiques=self::find_by_product($id_produit);
		$tableau = array();
			//On créé un tableau de type (timestampjava=>stock)
			global $session;
			foreach($historiques as $ligne){
				
				if ( ($ligne->timestamp() <= $session->datefin->timestamp) && ($ligne->timestamp() >= $session->datedebut->timestamp)){
				
				$timestamp=intval($ligne->objet_date()->timestamp);
					if ($text=='stock'){ //ICI SI C4ETS UNE METHODE
						$tableau[$timestamp]=(int)$ligne->{'stock_'.$text}();	
					}	
					else {
						$tableau[$timestamp]=(int)$ligne->{'stock_'.$text};	
					}
				}		
			}
		//return str_replace('"', '',json_encode($tableau)) ;		
		$final='['; //forme [ [x,y],[x,y],...]
		
		foreach ($tableau as $key=>$value){
			$final.='['.(int)$key.','.(int)$value.'],';
			
		}
		$final = substr($final, 0, -1).']';
		return $final;
	}


}