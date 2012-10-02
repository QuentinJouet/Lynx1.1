<?php
	
	
	function stocks_produit($id_produit) {
		global $connection_cakeshop_thelia;
		$query='SELECT stock FROM produit WHERE id=';
		$query.=$id_produit;
		
		$result_set= mysql_query($query,$connection_cakeshop_thelia);
		$data=mysql_fetch_array($result_set);
		$stock_thelia=$data['stock'];
		
		$stock_boutique=0;
		
		$stock_total=$stock_thelia+$stock_boutique;
		$stock_securite=1;
		$stock_seuil=5;
		$stock_commande=0;
		$stock_brut=$stock_total+$stock_commande;
		return array('s_thelia'=>$stock_thelia,'s_boutique'=>$stock_boutique,
's_total'=>$stock_total,'s_securite'=>$stock_securite,'s_seuil'=>$stock_seuil,'s_commande'=>$stock_commande,'s_brut'=>$stock_brut);			
		
	}
	
	function tous_les_id_produits($tri='p.id',$asc=true,$limit=25){
		global $connection_cakeshop_thelia;
		$query='SELECT p.id FROM produit as p, produitdesc as d WHERE d.produit=p.id ORDER BY ';
		$query.=$tri;
		$query.= ($asc=true)? ' ASC ' : ' DESC ';  
		$query.='LIMIT ';
		$query.=$limit;
		$result_set= mysql_query($query,$connection_cakeshop_thelia);
		while ($data=mysql_fetch_array($result_set)) {
		$ids[]=intval($data[0]);	
		}
		return $ids;
		
	}
	
	function htmlentities_tableau($tableau) {
	foreach($tableau as &$tab){
		$tab=htmlentities($tab);
		
		
	}
		return $tableau;
		
	}
	
	function ref_et_nom($id){
		global $connection_cakeshop_thelia;
		$query='SELECT d.titre,p.ref FROM produit as p, produitdesc as d WHERE p.id=';
		$query.=$id;
		$query.= ' AND d.produit=p.id ';
		
		$result_set= mysql_query($query,$connection_cakeshop_thelia);
		$ref_titre=mysql_fetch_array($result_set);
		$final['ref']=htmlentities($ref_titre['ref']);
		$final['titre']=htmlentities($ref_titre['titre']);
		return $final ;
		
	}
	
	
	
	function dates_session_from_post(){
	 if (empty($_SESSION['date_debut']) && empty($_SESSION['date_fin']))
                        {$_SESSION['date_debut']='01/01/2012';
                        $_SESSION['date_fin']=date('d/m/Y');				
                        }
                        elseif (!empty($_POST['date_debut'])) {
                      $_SESSION['date_debut'] = $_POST['date_debut'];
                        }
                        elseif (!empty($_POST['date_fin'])) {
                      $_SESSION['date_fin'] = $_POST['date_fin'];		 
                        }
                        
                        $_SESSION['date_debut_db'] = explode('/',$_SESSION['date_debut']);
                        $_SESSION['date_fin_db'] = explode('/',$_SESSION['date_fin']);
                        $_SESSION['date_debut_db'] = $_SESSION['date_debut_db'][2] . '-' . $_SESSION['date_debut_db'][1] . '-' . $_SESSION['date_debut_db'][0];
                        $_SESSION['date_fin_db'] = $_SESSION['date_fin_db'][2] . '-' . $_SESSION['date_fin_db'][1] . '-' . $_SESSION['date_fin_db'][0];
                        	
	}
	
	
	
	function data_pie($objet) 
{
	if ($objet=="top5")
	{
		if ($_SESSION['id']==2) 
		{
		
		global $connection_cakeshop;
		
		//$query = "SELECT id,nom,marque,reference,prix,lim,poids,unite_prix,origine FROM `movida`.`produit` ORDER BY id ASC";
		$query = "SELECT libelle_interne, SUM(total_art_ttc) From `cakeshop`.`commandes_sf` GROUP BY ref_interne ORDER BY SUM(total_art_ttc) DESC LIMIT 5";
	
	$result_set = mysql_query($query , $connection_cakeshop);
	$tableau = requete_tableau($result_set);
	$pourcentages = pourcentage_nombre($tableau['SUM(total_art_ttc)'],2);
	$data = data_tableau($tableau['libelle_interne'],$pourcentages);
	echo $data;
		
		//echo(data_graphiques($result_set,'libelle_interne','SUM(total_art_ttc)'));
							
		}
	}
}
		function urlimage($image,$dossier='produit'){
		$url='http://cakeshop.anotherwayin.fr/client/gfx/photos/';
		$url.=$dossier;
		$url.='/' . $image;
		return $url;	
			
			
		}

		function produit_par_recherche($string){
			$eclate = explode(' | ',$string);
			$id=$eclate[2];
			global $connection_cakeshop_thelia;
			$query="SELECT p.*, d.lang, d.titre, d.chapo, d.description, d.postscriptum, i.fichier as image FROM image as i, produit as p, produitdesc as d WHERE d.produit=p.id AND i.produit=p.id AND p.id=";
			$query.=$id;
			$query .= " LIMIT 1";
			$result_set=mysql_query($query,$connection_cakeshop_thelia);
			$produit=mysql_fetch_array($result_set);
			
			
		return $produit;	
		}
	
		function produit_par_nom_code($nom_code) {
		$code_interne = explode(' | ',$nom_code);
		$code_interne = mysql_prep($code_interne[0]);
		$libelle_interne = mysql_prep($code_interne[1]);	
		global $connection_cakeshop;
		$query = "SELECT * ";
		$query .= "FROM produits_sf ";
		$query .= "WHERE code_interne='" . $code_interne ."' ";
		$query .= "OR libelle_interne='" . $libelle_interne ."' ";
		$query .= "GROUP BY id ";
		$query .= "LIMIT 1;";
		$result_set = mysql_query($query, $connection_cakeshop);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($resultat = mysql_fetch_array($result_set)) {
			foreach ($resultat as &$value){
			$value = utf8_encode($value);				
			}
			return $resultat;
		} else {
			return NULL;
		}
	}
	
	function data_graphiques($result,$x,$y){
		
		$datalist = '';
		while ($array = mysql_fetch_assoc($result) )
				{
				$datalist .= '[';
				$datalist .= "'";
				$datalist .= sans_accents($array[$x]);
				$datalist .= "'," ;
				$datalist .= $array[$y] ;
				$datalist .= '],' ;
				} 
		return $datalist;
				
	}
	
	function data_tableau($tabx,$taby){
		$datalist = '';
				foreach($tabx as $index => $contenu)
				{$datalist .= '[';
				$datalist .= "'";
				$datalist .= $contenu;
				$datalist .= "'," ;
				$datalist .= $taby[$index] ;
				$datalist .= '],' ;		
				}
		return $datalist;		
		
	}
	
	function requete_tableau($ressource){
		
	$tableau=array();	
		
			while ($array = mysql_fetch_assoc($ressource) )
				{
					foreach($array as $champ => $chaine)
					$tableau[utf8_encode($champ)][]=utf8_encode($chaine);		
			
				} 		
		return $tableau;
		
	}
	
	
	function pourcentage_nombre ($liste_nombre,$decimales)
	{
		$somme=0;
		foreach($liste_nombre as $nombre)
				{
					$somme += $nombre;
				}
		reset($liste_nombre);
		
		foreach($liste_nombre as &$nombre)
				{
					$nombre = number_format(  (100 * $nombre / $somme ),$decimales) ; 
				}
				
		return $liste_nombre;
			
		
	}
	
	
	
	
	function tableau($array){
	echo'<table  border="1">';
foreach($array as $champ=>$chaine) 
    { 
	echo(" <tr><th scope=\"row\">");
	echo($champ);
	echo("</th><td>");
	echo($chaine);
    echo("</td></tr>");
    } 
echo'</table>';	
			}
			
			
	
	function virgule_en_point($chaine){
		return str_replace(',','.',$chaine);		
		
	}
	
	function format_nombre($chaine){
 $chaine=preg_replace('/[^0-9,]/', '',$chaine);
 $chaine=virgule_en_point($chaine);

return $chaine;	
		
		}
		
		
		
		
function afficher_produits() {
	global $connection;
	
$query = "SELECT id,nom,marque,reference,prix,lim,poids,unite_prix,origine FROM `movida`.`produit` ORDER BY id ASC";

$result_set = mysql_query($query , $connection);

$colonnes = array('id','nom','marque','reference','prix','lim','quantité','unité','origine');

// on fait une boucle qui va faire un tour pour chaque enregistrement
echo'<table  border="1">';
echo'<tr>';
foreach($colonnes as $champ=>$chaine)
	{
	echo("<td>");
	echo($chaine);
    echo("</td>");
    } 
echo('</tr>');

while($data = mysql_fetch_assoc($result_set))
{
	echo('<tr>');
	foreach($data as $champ=>$chaine)
	{
	echo("<td>");
	echo($chaine);
    echo("</td>");
    } 
	echo('</tr>');
}
echo'</table>';	
}
	
			
	
	// This file is the place to store all basic functions

	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	function get_all_categories() {
		global $connection;
		$query = "SELECT * 
				FROM categorie ";
		
		$query .= "ORDER BY id ASC";
		$categories_set = mysql_query($query, $connection);
		confirm_query($subject_set);
		return $categories_set;
	}
	
	function get_pages_for_subject($subject_id, $public = true) {
		global $connection;
		$query = "SELECT * 
				FROM pages ";
		$query .= "WHERE subject_id = {$subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysql_query($query, $connection);
		confirm_query($page_set);
		return $page_set;
	}
	
	function get_subject_by_id($subject_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($subject = mysql_fetch_array($result_set)) {
			return $subject;
		} else {
			return NULL;
		}
	}

	function get_page_by_id($page_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=" . $page_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		if ($page = mysql_fetch_array($result_set)) {
			return $page;
		} else {
			return NULL;
		}
	}
	
	function get_default_page($subject_id) {
		// Get all visible pages
		$page_set = get_pages_for_subject($subject_id, true);
		if ($first_page = mysql_fetch_array($page_set)) {
			return $first_page;
		} else {
			return NULL;
		}
	}
	
	function find_selected_page() {
		global $sel_subject;
		global $sel_page;
		if (isset($_GET['subj'])) {
			$sel_subject = get_subject_by_id($_GET['subj']);
			$sel_page = get_default_page($sel_subject['id']);
		} elseif (isset($_GET['page'])) {
			$sel_subject = NULL;
			$sel_page = get_page_by_id($_GET['page']);
		} else {
			$sel_subject = NULL;
			$sel_page = NULL;
		}
	}

	function navigation($sel_subject, $sel_page, $public = false) {
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysql_fetch_array($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			$page_set = get_pages_for_subject($subject["id"], $public);
			$output .= "<ul class=\"pages\">";
			while ($page = mysql_fetch_array($page_set)) {
				$output .= "<li";
				if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) .
					"\">{$page["menu_name"]}</a></li>";
			}
			$output .= "</ul>";
		}
		$output .= "</ul>";
		return $output;
	}

	function public_navigation($sel_subject, $sel_page, $public = true) {
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects($public);
		while ($subject = mysql_fetch_array($subject_set)) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			if ($subject["id"] == $sel_subject['id']) {	
				$page_set = get_pages_for_subject($subject["id"], $public);
				$output .= "<ul class=\"pages\">";
				while ($page = mysql_fetch_array($page_set)) {
					$output .= "<li";
					if ($page["id"] == $sel_page['id']) { $output .= " class=\"selected\""; }
					$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) .
						"\">{$page["menu_name"]}</a></li>";
				}
				$output .= "</ul>";
			}
		}
		$output .= "</ul>";
		return $output;
	}
	
	
	
	
	
	function convertir_utf8($texte) {
	return iconv('UTF-8', 'US-ASCII//TRANSLIT', $text); 		
		
	}
	
	function sans_accents($string) 
{ 
  return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 
} 
	
	
?>