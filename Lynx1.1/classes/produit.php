<?php
require_once(CLASS_PATH.DS.'database.php');

class Produit extends DatabaseObject {
	
	protected static $table_name="produit";
	protected static $champs_cakeshop_thelia_produit = array('id', 'ref', 'prix', 'rubrique', 'stock');
	protected static $champs_cakeshop_thelia_produit_p = array('p.id as id', 'p.ref as ref','p.datemodif as datemodif', 'p.prix as prix','p.promo as promo',
	'p.prix2 as prix2', 'p.rubrique as rubrique_id', 'p.nouveaute as nouveaute', 'p.stock as stock_web','p.ligne as ligne',
	'p.garantie as garantie','p.poids as poids','p.tva as tva','p.classement as classement');
	protected static $champs_cakeshop_thelia_produitdesc_d = array('d.titre as titre','d.chapo as chapo','d.description as description','d.postscriptum as postscriptum');
	protected static $champs_cakeshop_thelia_rubriquedesc_r = array('r.titre as rubrique');
	protected static $champs_cakeshop = array('codebarre as codebarre','conso_moy_boutique as conso_moy_boutique','et_conso_moy_boutique as et_conso_moy_boutique','stock_securite_boutique as stock_securite_boutique','stock_seuil_boutique as stock_seuil_boutique','stock_cible_boutique as stock_cible_boutique','conso_moy as conso_moy','et_conso_moy as et_conso_moy','stock_op as stock_op','stock_securite as stock_securite','stock_seuil as stock_seuil','stock_cible as stock_cible','stock_boutique as stock_boutique','commentaire as commentaire', 'poids_net as poids_net','unite as unite', 'categorie as rubrique_id', 'prix as prix', 'tva as tva', 'titre as titre','datemodif_produit as datemodif_produit');
	
	
	
	
	//table produit
	public $id;
	public $ref;
	public $datemodif;
	public $prix;
	public $promo;
	public $prix2;	
	public $rubrique_id;
	public $ligne;
	public $garantie;
	public $tva;
	public $poids;
	public $classement;
	public $nouveaute;
	public $stock_web;
	public $fournisseur_pref;
	//table rubriquedesc
	public $rubrique;
	//table produitdesc
	public $titre;
	public $chapo;
	public $description;
	public $postscriptum;
	public $image ;
	//table produit (client)
	public $commentaire;
	public $codebarre;
	public $poids_net;
	public $unite;
	public $stock_boutique;
	public $stock_op;
	public $datemodif_produit;
	//VARIABLES POUR LA GESTION DES STOCKS
	//Table produit base client cakeshop
		//Pour siteweb
			public $conso_moy; //par semaine
			public $et_conso_moy; //par semaine, PREND EN COMPTE COMMANDES BOUTIQUE ?
			public $stock_securite; //defini par client, methode de calcul pour conseil
			public $stock_seuil; //defini apr client, methode de calcul pour conseil
			public $stock_cible; //defini par client, methode de calcul pour conseil
		//Pour boutique
			public $conso_moy_boutique; //par semaine
			public $et_conso_moy_boutique; //par semaine
			public $stock_securite_boutique; //defini par client, methode de calcul pour conseil
			public $stock_seuil_boutique; //defini apr client, methode de calcul pour conseil
			public $stock_cible_boutique; //defini par client, methode de calcul pour conseil

	//Cache pour tri de tableau d'objets ou autre : 
		//Déclarer cette variable active le cache pour la fonction de tri d'objets
	public $temp;
	
	//Traduction des variables et methodes pour affichage
	public static $elements_tri=array('alerte_stock'=>'Alerte Stock','id'=>'Date de création','titre'=>'Titre','ref'=>'Réference','stock_web'=>'Stock Web','stock_boutique'=>'Stock Boutique','nb_ventes_boutique'=>'Volume ventes Shop','nb_ventes_web'=>'Volume ventes Web','ca_boutique'=>'Chiffre d\'affaires Shop','ca_web'=>'Chiffre d\'affaires Web','ca'=>'Chiffre d\'affaires Total', 'stock_op'=>'Stock opération', 'quantite_commandee'=>'Quantité commandée');
	
	
	
	//pour affichage des couleurs d'alerte : 
	//0 : bleu | 1 : vert | 2 : jaune \ 3 : orange | 4 : rouge
	public static $couleurs=array('#92dcee','#90eda4','#ffff00','#ffba4c','#f97373');
	public static $textealertestock=array('Surstock','OK','A commander','Urgence','Rupture');
	
	
	
	
	
	//Historique des stocks
	
	function historique($type='total'){
		//type peut etre 'web' 'boutique' 'total'
		return HistoriqueStock::historique($this->id,$type);
	}	

	function historique_brut($type='total'){
		//type peut etre 'web' 'boutique' 'total'
		return HistoriqueStock::historique_brut($this->id,$type);
	}	
  
  //Nb d'attentes clients si rupture
  
  public function nb_attentes(){
	  return PrevenirClient::nb_attentes_produit($this->id);
  }
  
  
  //Calcul du volume de ventes
  
  	
  	
  	
  	
  	private function get_lignes_web(){
  	global $db_cakeshop_thelia;  
  	global $session;	
  	//on récupère toutes les lignes de commandes qui contiennent le produit
  	//Celui ci est enregistré par sa référence et non son id
  	//Statut>1 : payé
  	//statut<5 : pas annulé  	
  	$sql="SELECT * FROM venteprod as v, commande as c WHERE v.commande=c.id AND c.statut IN (2,3,4) AND (c.date BETWEEN '{$session->datedebut->sql}' AND '{$session->datefin->sql}') AND v.ref='{$this->ref}'";
  	$lignes=LigneCommandeThelia::find_by_sql($sql);
  	return $lignes;
  					
	}

  
  
  public function nb_ventes_web(){

	  $lignes=$this->get_lignes_web(); 

  	//on a un array de lignes
  	//on les parcoure pour faire le total du nb vendu :
  	$nb_vendu=0;
	  foreach($lignes as $ligne){
	  $nb_vendu+=$ligne->quantite;		  
	  }
	return $nb_vendu;  	  
  }
  
  public function nb_ventes_boutique(){
	  $boutique=VenteCaisse::ventes_shop($this->ref);
	  return $boutique['nb_ventes'];
  }
  
  public function nb_ventes(){
	  return $this->nb_ventes_web()+$this->nb_ventes_boutique();
  }
  
  
  //Calcul du chiffre d'affaires 
	public function ca_boutique(){
	$boutique=VenteCaisse::ventes_shop($this->ref);
	  return $boutique['ca'];
  }

  	public function ca_web(){

   $lignes=$this->get_lignes_web(); 

   	//on a un array de lignes
  	//on les parcoure pour faire le total du nb vendu :
  	$ca=0;
	  foreach($lignes as $ligne){
	  $ca+=$ligne->prix_total();		  
	  }
	return $ca;    
	}	
	
	public function tout_web(){
		$lignes=$this->get_lignes_web(); 
		
		$ca=0;
		$nb_vendu=0;
	  foreach($lignes as $ligne){
	  $ca+=$ligne->prix_total();
	   $nb_vendu+=$ligne->quantite;	
	   }
	   return array('nb_vendu'=>$nb_vendu, 'ca'=>$ca);	
	}
	  
	public function ca() {
	  return $this->ca_web() + $this->ca_boutique();
	 }
	
	
	//tableau date=>nbventesweb
	public function ventes_web(){
  	global $db_cakeshop_thelia; 
  	global $session;
  	
  	//on initialise la boucle
  	$jour=$session->datedebut->jour_sql();
  	$matin=$jour.' 00:00:00';
  	$soir=$jour.' 23:59:59';
  	$fin_boucle=$session->datefin->jour_sql().' 00:00:00';
  	$tableau=array();
  	
  	//on va remplir un tableau de la forme array("2012-12-31 20:50:50"=>"nb_vendus")
  	
  	while($matin<=$fin_boucle){
  	$sql="SELECT SUBSTRING(c.date,1,10), SUM(v.quantite) FROM venteprod as v, commande as c WHERE v.commande=c.id AND c.statut IN (2,3,4) AND (c.date BETWEEN '{$matin}' AND '{$soir}') AND v.ref='{$this->ref}' GROUP BY SUBSTRING(c.date,1,10) ORDER BY c.date ASC";
	$result_set=$db_cakeshop_thelia->query($sql);
	$ligne=mysql_fetch_array($result_set);
	$tableau[$ligne[0]]=(int)$ligne[1];
	$jour=Date::date_from_sql($jour)->lendemain_date()->jour_sql();
	$matin=$jour.' 00:00:00';
  	$soir=$jour.' 23:59:59';
	}
	unset($tableau['']);
	return $tableau;
		
	}


	//FONCTIONS POUR GESTION DES STOCKS
	
	public function conso_moy(){
		return $this->conso_moy + $this->conso_moy_boutique;
	}


	//ALERTES DE STOCK :
		//0 : au dessus de 2 stocks cible
		//1 : au dessus de stock cible
		//2 : au dessus de seuil de commande
		//3 : Au dessus de stock de sécurité
		//4 : au Dessous de stock de sécurité
		
	public function alerte_stock(){
		return $this->alerte_stock_web();
		//return max($this->alerte_stock_web(),$this->alerte_stock_boutique()); //maximum de alerte web et boutique
	}
	
	public function alerte_stock_web(){
	$stock=$this->stock_brut_web();	
		if ($stock <= 0) {
		return 4;
		}elseif($stock <= $this->stock_securite){
		return 3;
		}elseif($stock <= $this->stock_seuil){
		return 2;
		}elseif($stock <= $this->stock_cible){
		return 1;
		}else{
		return 0;
		}
		
	}
	
	public function alerte_stock_boutique(){
	
	(isset($this->stock_boutique))? $stock=$this->stock_boutique:$stock=0;
		if ($stock <= 0) {
		return 4;
		}elseif($stock <= $this->stock_securite_boutique){
		return 3;
		}elseif($stock <= $this->stock_seuil_boutique){
		return 2;
		}elseif($stock <= $this->stock_cible_boutique){
		return 1;
		}else{
		return 0;
		}
		
	}
	
	
	public function couleur_stock_web(){
		
	}
	
	public function couleur_stock_boutique(){
		
	}

	


	//FONCTIONS CRUD (Produit est une classe Multi Database, on n'utilse pas DatabaseObject
  
	public static function existe($id){
			global $db_cakeshop;
		$sql = "SELECT count(id) FROM produit WHERE id={$id}";
		$result_set = $db_cakeshop->query($sql);
		$p = mysql_fetch_array($result_set);
		$cakeshop = ((int)$p[0]==0)? false : true;
	
		global $db_cakeshop_thelia;
		
		$result_set = $db_cakeshop_thelia->query($sql);
		$p = mysql_fetch_array($result_set);
		$cakeshop_thelia =  ((int)$p[0]==0)? false : true;
		
		return ($cakeshop && $cakeshop_thelia);
	}
	
	public static function produit_par_id_dbo($id=0) {
	global $db_cakeshop_thelia;
	$produit_thelia=Produit::find_by_id($id,$db_cakeshop_thelia,Produit::$champs_cakeshop_thelia);
	return $produit_thelia;  
  }
  
	
	public static function produit_par_id($id) {
		$tableau=self::produits_par_sql("p.id={$id}",'p.id ASC',1);
		$produit=array_shift($tableau);
		return $produit;		
	}
	
	public static function produit_par_ref($ref) {
		$tableau=self::produits_par_sql("p.ref='{$ref}'",'p.id ASC',1);
		$produit=array_shift($tableau);
		return $produit;		
	}
	
	public static function tous(){
		return self::produits_par_sql();
	}
	
	
	public static function produits_par_sql($sql='',$order='d.titre ASC', $limit=4000,$offset=0) {
		global $db_cakeshop_thelia;
		global $db_cakeshop;
		
		$produit=new Produit();
		$requete_thelia = "Select ";
		$requete_thelia .= join(', ',self::$champs_cakeshop_thelia_produit_p) ;
		$requete_thelia .= ', ';
		$requete_thelia .= join(', ',self::$champs_cakeshop_thelia_produitdesc_d);
		$requete_thelia .= ', ';
		$requete_thelia .= join(', ',self::$champs_cakeshop_thelia_rubriquedesc_r);
		$requete_thelia .= " FROM produit as p, produitdesc as d, rubriquedesc as r ";
		//ICI POUR SPECIFIER ID, remplacer par sql spécifique sinon
		$requete_thelia .= 'WHERE d.produit=p.id ';
		$requete_thelia .= 'AND r.rubrique=p.rubrique ';
		$requete_thelia .= 'AND d.lang=1 ';
		$requete_thelia .= '';
		(!empty($sql))?	$requete_thelia .= 'AND '.$sql.' ' : $requete_thelia.='';
		$requete_thelia .= 'GROUP BY p.id ';
			$requete_thelia .= ' ORDER BY ';
		$requete_thelia .= $order;
		$requete_thelia .= ' LIMIT ';
				$requete_thelia .= $limit;
		$requete_thelia .= ' OFFSET ';
				$requete_thelia .= $offset;

		$requete_thelia .='';
		
		//AFFICHER REQUETE POUR DEBUG
		//echo $requete_thelia;
		
		
		$result_set=$db_cakeshop_thelia->query($requete_thelia);
				$object_array = array();
				while ($row = mysql_fetch_array($result_set)) {
				$nvo_objet = new Produit;
				$nvo_objet->remplir_attributs($row);
				
		
		//On complete avec bdd client
		$requete_cakeshop = "SELECT ";
		$requete_cakeshop .= join(', ',self::$champs_cakeshop) ;
		$requete_cakeshop .= " FROM produit " ;
		$requete_cakeshop .= "WHERE id =";  
		$requete_cakeshop .=  $nvo_objet->id;
		$result_set2=$db_cakeshop->query($requete_cakeshop);		
		$nvo_objet->remplir_attributs_vides(mysql_fetch_array($result_set2));
		//On renseigne l'image
		$image=$nvo_objet->get_image($nvo_objet->id);
		$nvo_objet->image=$image;		
				
				
				
				$object_array[] = $nvo_objet;
				}
				return $object_array;
			
	}
	
	private function champs_db_thelia(){
	$tableau = array_merge(Produit::$champs_cakeshop_thelia_produit_p,Produit::$champs_cakeshop_thelia_produitdesc_d);
	return $tableau;
	
	}
	
	private function paires_thelia(){
		$paires=array();
		$bruts = self::champs_db_thelia();
		foreach($bruts as $brut){
		$exp=explode(' as ',$brut)	;
		$paires[trim($exp[0])]=$this->{trim($exp[1])};
		}
		
	return $paires;	
	}
	
	private function paires_cakeshop(){
			global $db_cakeshop;
		$paires=array();
		$bruts = self::$champs_cakeshop;
		foreach($bruts as $brut){
		$exp=explode(' as ',$brut)	;
		$valeur=trim($exp[1]);
		$paires[trim($exp[0])]=$db_cakeshop->escape_value($this->{trim($exp[1])});
		}
		
	return $paires;	
	}
	
	private function enregistrer_thelia(){
		global $db_cakeshop_thelia;
		$db_cakeshop_thelia->query("SET NAMES UTF8");
	$sauvegarde_thelia=self::clean_tableau($this->paires_thelia(),$db_cakeshop_thelia);
	
	$attribute_pairs = array();
		foreach($sauvegarde_thelia as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
	$sql_thelia="UPDATE produit as p INNER JOIN produitdesc as d ON(p.id = d.produit) ";
	$sql_thelia.="SET ";
	$sql_thelia.= join(", ", $attribute_pairs);
	$sql_thelia.=" WHERE d.lang=1 AND p.id=".$db_cakeshop_thelia->escape_value($this->id) ;		
	//echo "<h5> SAVE THELIA </h5> <p>{$sql_thelia}</p>";
	 $db_cakeshop_thelia->query($sql_thelia);
	 return ($db_cakeshop_thelia->affected_rows() == 1) ? true : false;
	}
	
	public function enregistrer_cakeshop(){
		global $db_cakeshop;
	//$sauvegarde_cakeshop=self::clean_tableau($this->paires_cakeshop(),$db_cakeshop);
	$this->syncro=1; // ON MARQUE LE PRODUIT COMME MODIFIé
	$sauvegarde_cakeshop=$this->paires_cakeshop();
	$attribute_pairs = array();
		foreach($sauvegarde_cakeshop as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
	$sql_cakeshop="UPDATE produit ";
	$sql_cakeshop.="SET ";
	$sql_cakeshop.= join(", ", $attribute_pairs);
	$sql_cakeshop.=" WHERE id=".$db_cakeshop->escape_value($this->id) ;		
	//echo "<h5> SAVE CAKESHOP </h5> <p>{$sql_cakeshop}</p>";
	$db_cakeshop->query($sql_cakeshop);
	 return ($db_cakeshop->affected_rows() == 1) ? true : false;
	
	}
		
	public function enregistrer(){
	$thelia=$this->enregistrer_thelia();
	$cakeshop=$this->enregistrer_cakeshop();
	$resultat=( $thelia && $cakeshop );
			return $resultat;
	}
	
	public function get_image() {
		global $db_cakeshop_thelia;
		$id=$this->id;
		$sql = "SELECT fichier FROM image WHERE produit={$id} LIMIT 1";
		$result_set = $db_cakeshop_thelia->query($sql);	
		$p = mysql_fetch_array($result_set);
		if(empty($p)){
		$image=	URL_SITE . DS . 'images/vide.png';
		}
		else {
		$image=array_shift($p);
		$image=URL_THELIA . '/client/gfx/photos/produit/' . $image;
		}
		return $image;
		;
	}
	
	public function get_public_url(){
		$lien=URL_THELIA.'/?fond=produit&ref='.$this->ref.'&id_rubrique='.$this->rubrique_id;
		return $lien;
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

	

	//FONCTIONS POUR JAVASCRIPT
		 
	public static function autocomplete_liste(){
	global $db_cakeshop_thelia;
	$query = "SELECT p.id, p.ref, d.titre FROM produit as p, produitdesc as d WHERE d.lang=1 AND d.produit=p.id ";
	$query .= "ORDER BY titre ASC ";
	$result_set = $db_cakeshop_thelia->query($query);
	while($data = mysql_fetch_array($result_set)) {

	$tags[]=utf8_encode($data['ref']) . ' | ' . ($data['titre']) /*. ' | ' . utf8_encode($data['id'])*/;
		}
		return json_encode($tags);
	}
			 

	public function url_thelia(){
	$url = URL_THELIA .'admin_cakeshop/produit_modifier.php?ref=' . $this->ref . '&rubrique=' . $this->rubrique_id;	
	return $url;
	}
	
	public function stock(){
	$stock=($this->stock_web + $this->stock_boutique);
		return $stock;
	}
	
	public function stock_brut(){
		global $db_cakeshop;
		$stock=($this->stock_web + $this->stock_boutique);
		$stock_brut=($stock	+ LigneCommandeFournisseur::stock_en_commande($this->id));
		return $stock_brut;
		}
	public function quantite_commandee(){
		return LigneCommandeFournisseur::stock_en_commande($this->id);
	}	
	
	public function stock_brut_web(){
		global $db_cakeshop;
		$stock=($this->stock_web);
		$stock_brut=($stock	+ LigneCommandeFournisseur::stock_en_commande($this->id));
		return $stock_brut;
		}
	
	public function stock_brut_boutique(){
		global $db_cakeshop;
		$stock=($this->stock_boutique);
		$stock_brut=($stock	+ LigneCommandeFournisseur::stock_en_commande($this->id));
		return $stock_brut;
		}

	  
	 //FONCTIONS POUR DESACTIVER LE COMPORTEMENT STANDARD
	 public static function find_all(){
		 echo 'FONCTION DESACTIVEE POUR LES PRODUITS';
	 }
	 public function delete(){
		 return false;
	 }
	 public function save(){
		 return false;
	 }
	 public function update(){
		 return false;
	 }

}

?>