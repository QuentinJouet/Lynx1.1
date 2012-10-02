<?php

require_once(CLASS_PATH.DS.'database.php');

class ChiffreAffaires extends DatabaseObject {

public static $table_name="chiffre_affaires";
	static public $database = 'db_cakeshop';
	public static $champs_db=array('id', 'id_produit', 'point_de_vente','date','quantite', 'ca');


	public $id;
	public $id_produit;
	public $point_de_vente;	
	public $date;
	public $quantite;	
	public $ca;
	
	public static function find_by_produit($id_p){
		$sql= "SELECT * FROM " . self::$table_name . " WHERE id_produit=" . $id_p;
		$lignes=self::find_by_sql($sql);
		return $lignes;
	}
	
	public static function ca_by_produit($id_p){
		$lignes=self::find_by_produit($id_p);
		$ca_web=0;
		$ca_boutique=0;
		$nb_ventes_web=0;
		$nb_ventes_boutique=0;
		foreach ($lignes as $ligne){
			if ($ligne->point_de_vente=='web'){
				$ca_web+=$ligne->ca;
				$nb_ventes_web+=$ligne->quantite;
			} elseif($ligne->point_de_vente=='boutique') {
				$ca_boutique+=$ligne->ca;
				$nb_ventes_boutique+=$ligne->quantite;
			}
		}
		return array('web'=>$ca_web,'nb_web'=>$nb_ventes_web,'boutique'=>$ca_boutique,'nb_boutique'=>$nb_ventes_boutique);
	}
	
	public static function mise_a_jour(){
		//On check la table existante pour voir le dernier jour enregistré
		$sql="SELECT * FROM " . self::$table_name . " WHERE point_de_vente='web' ORDER BY date DESC LIMIT 1";
		$date1=self::find_by_sql($sql);
		if (!empty($date1)){
			$date1=array_shift($date1)->date;
			}else{
			$date1=0;
				}
		
		//On choppe les commandes Thelia ultérieures à $date
		$sql2="SELECT * FROM commande WHERE date>='" . $date1 . "' AND statut IN (2,3,4)";
		$commandes=CommandeThelia::find_by_sql($sql2);
		
		//On crée un tableau contenant les infos qui nous intéressent, bien organisées
		$CA_web=array();
		
			foreach ($commandes as $commande){
			$sql3="SELECT * FROM venteprod WHERE commande=" . $commande->id;
			$lignes=LigneCommandeThelia::find_by_sql($sql3);

				
				foreach ($lignes as $ligne){
					$date=substr($commande->date,0,10);
					$produit=Produit::produit_par_ref($ligne->ref);
					$produit_id=(empty($produit)?999999:$produit->id);
					if (!isset($CA_web[$date])){
						$CA_web[$date]=array();
					}
					if	(!isset($CA_web[$date][$produit_id])){
						$CA_web[$date][$produit_id]=array('quantite'=>0,'ca'=>0);
					}
						
					$CA_web[$date][$produit_id]['quantite']+=$ligne->quantite;
					$CA_web[$date][$produit_id]['ca']+=(($ligne->quantite)*($ligne->prixu));
				}
			}
		
		//On crée maintenant les rows "web"
		foreach ($CA_web as $date=>$prods){
			foreach($prods as $id_p=>$values){
				$sql5="SELECT * FROM " . self::$table_name . " WHERE date='" . $date . "' AND id_produit=" . $id_p . " AND point_de_vente='web'";
				$row=self::find_by_sql($sql5);
				if (empty($row)){
				$ca_row = new ChiffreAffaires;
				$ca_row->date=$date;
				$ca_row->id_produit=$id_p;
				$ca_row->point_de_vente='web';
				$ca_row->quantite=$values['quantite'];
				$ca_row->ca=$values['ca'];
				$ca_row->save();
				} else {
				$ca_row=array_shift($row);
				$ca_row->quantite=$values['quantite'];
				$ca_row->ca=$values['ca'];
				$ca_row->save();
				}
			}
		}
		
		//On choppe les ventes caisse
		
		$sql="SELECT * FROM " . self::$table_name . " WHERE point_de_vente='boutique' ORDER BY date DESC LIMIT 1";
		$date1=self::find_by_sql($sql);
		if (!empty($date1)){
			$date1=array_shift($date1)->date;
			}else{
			$date1=0;
				}

		
		$CA_boutique=array();
		$sql4="SELECT * FROM vente_caisse WHERE datetime>='" . $date1 . "'";
		$ventes=VenteCaisse::find_by_sql($sql4);
		
		//On crée le tableau organisé
		$CA_boutique=array();

		foreach ($ventes as $vente){
			$date2=substr($vente->datetime,0,10);
			$produit=Produit::produit_par_ref($vente->ref);
			$produit_id=(empty($produit)?999999:$produit->id);				
			if (!isset($CA_boutique[$date2])){
				$CA_boutique[$date2]=array();
			}
			if(!isset($CA_boutique[$date2][$produit_id])){
				$CA_boutique[$date2][$produit_id]=array('quantite'=>0,'ca'=>0);
			}
			$CA_boutique[$date2][$produit_id]['quantite']+=$vente->quantite;
			$CA_boutique[$date2][$produit_id]['ca']+=(($vente->quantite)*($vente->prixu));
		}
		
		//On crée les rows "boutique"
		foreach ($CA_boutique as $date=>$prods){
			foreach($prods as $id_p=>$values){
				$sql5="SELECT * FROM " . self::$table_name . " WHERE date='" . $date . "' AND id_produit=" . $id_p . " AND point_de_vente='boutique'";
				$row=self::find_by_sql($sql5);
				if (empty($row)){
				$ca_row = new ChiffreAffaires;
				$ca_row->date=$date;
				$ca_row->id_produit=$id_p;
				$ca_row->point_de_vente='boutique';
				$ca_row->quantite=$values['quantite'];
				$ca_row->ca=$values['ca'];
				$ca_row->save();
				}  else {
				$ca_row=array_shift($row);
				$ca_row->quantite=$values['quantite'];
				$ca_row->ca=$values['ca'];
				$ca_row->save();
				}
			}
		}
	}
	
	public static function top10(){
		$lignes=self::find_all();
		$list_web=array();
		$list_boutique=array();
		$list_total=array();
		foreach ($lignes as $ligne){
		if (!isset($list_total[$ligne->id_produit])){
					$catemp=self::ca_by_produit($ligne->id_produit);
					$list_total[$ligne->id_produit]=$catemp['web']+$catemp['boutique'];
					}

			if ($ligne->point_de_vente == 'web'){
				if (!isset($list_web[$ligne->id_produit])){
					$catemp=self::ca_by_produit($ligne->id_produit);
					$list_web[$ligne->id_produit]=$catemp['web'];
					}
			} elseif ($ligne->point_de_vente == 'boutique'){
				if (!isset($list_boutique[$ligne->id_produit])){
					$catemp=self::ca_by_produit($ligne->id_produit);
					$list_boutique[$ligne->id_produit]=$catemp['boutique'];
				}
			}
		}
		//var_dump($list_web);
		arsort($list_web);
		//echo "<br/>";
		//var_dump($list_web);
		$list_web=array_slice($list_web,0,10, true);
		//var_dump($list_web);
		arsort($list_boutique);
		$list_boutique=array_slice($list_boutique,0,10, true);
		
		arsort($list_total);
		$list_total=array_slice($list_total,0,10, true);

		
		return array('web'=>$list_web,'boutique'=>$list_boutique, 'total'=>$list_total);
	}
}








?>