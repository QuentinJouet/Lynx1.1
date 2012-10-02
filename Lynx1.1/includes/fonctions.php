<?php
	
// ICI FONCTIONS PHP ADVANCED GENERALES

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

//function __autoload($class_name) {
//	$class_name = strtolower($class_name);
//  $path = CLASS_PATH.DS."{$class_name}.php";
//  if(file_exists($path)) {
//    require_once($path);
//  } else {
//		die("The file {$class_name}.php could not be found.");
//	}
//}


function filtrer_nombres($string){
return preg_replace('/[^0-9]+/', '', $string );
}

function deux_colonnes($string1,$string2,$balise1='p',$balise2='p'){
$string = '<div class="row"><div class="six columns ">';
$string .= '<'.$balise1.'>';
$string .= $string1 ;
$string .= '</'.$balise1.'>';
$string .= '</div><div class="six columns">';
$string .= '<'.$balise2.'>';
$string .= $string2 ;
$string .= '</'.$balise2.'>';
$string .="</div></div>";

echo $string;
}



function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function log_action($action, $message="", $fichier='log.txt') {
	$logfile = SITE_ROOT.DS.'logs'.DS.$fichier;
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}



//ICI NOUVELLES FONCTIONS PERSO :

function exec_debut() {
$execution = microtime();
$execution = explode(' ',$execution);
return($execution[1]+$execution[0]);
}


function temps_exec() {
	global $execution_debut;
$execution = microtime();
$execution = explode(' ',$execution);
$execution_fin = $execution[1]+$execution[0];
$temps = $execution_fin-$execution_debut;
$temps = $temps ;
$temps = round(($temps),5);
echo'Page générée en '.$temps.' s.';
}

function nom_page() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function variables_url(){
	$uri = $_SERVER['REQUEST_URI'];
	$uri=explode('?',$uri);
	
	isset($uri[1])? $uri='?'.$uri[1] : $uri="";

	
	return $uri;
	
}
function nom_page_complet(){
	return nom_page().variables_url();
}


// ICI VIELLES FONCTIONS A ENLEVER OU UPDATER
	
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
	
function tri_get($tri,$ordre,$parpage,$filtre,$valeur){
	//global $page;
//	empty($page)? '': $tableau['page']=$page;
	$tableau['page']=1;
	$tableau['tri']=$tri;
	$tableau['o']=$ordre;
	$tableau['p_p']=$parpage;
	$tableau['fltr']=$filtre;
	$tableau['vlr']=$valeur;
	return http_build_query($tableau);
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
	
	
// TRI DE TABLEAU D'OBJETS

/**
* Sort one array of objects by one of the object's property
*
* @param mixed $array, the array of objects
* @param mixed $property, the property to sort with
* @return mixed, the sorted $array
*/
function tri_objets( $array, $property, $mode=2 ){

//mode = 2 : attribut ou methode, optimisé si cache activé pour l'objet ($temp déclaré)
//mode = 1 : méthode, NON optimisé
//mode =0 : attribut, optimisé

	//si le tableau envoyé est vide, on renvoie un tableau vide.
	if(empty($array)){
		return array();
	}

	$avec_cache=property_exists($array[0],'temp');
	$est_attribut=property_exists($array[0],$property);
	$est_methode=method_exists($array[0],$property);
	if ($est_attribut==false && $est_methode==false) {return false;}


	if ($mode==2){
		if ($est_attribut){
			return tri_objets( $array, $property, 0);
		}
		if ($est_methode){
			if($avec_cache){
			return tri_objets_fonction($array,$property);
				}
			else {
			return tri_objets($array,$property,1);	
			}
		}
	}

	
	
    $cur = 1;
    $stack[1]['l'] = 0;
    $stack[1]['r'] = count($array)-1;

    do
    {
        $l = $stack[$cur]['l'];
        $r = $stack[$cur]['r'];
        $cur--;

        do
        {
            $i = $l;
            $j = $r;
            $tmp = $array[(int)( ($l+$r)/2 )];

            // split the array in to parts
            // first: objects with "smaller" property $property
            // second: objects with "bigger" property $property
            do
            {
			
			// PROPERTY OU METHOD
			if($mode==0) {
                while( $array[$i]->{$property} < $tmp->{$property} ) $i++;
                while( $tmp->{$property} < $array[$j]->{$property} ) $j--;
			}
			
			if($mode==1) {			
			while( $array[$i]->{$property}() < $tmp->{$property}() ) $i++;
                  while( $tmp->{$property}() < $array[$j]->{$property}() ) $j--;
			}
		    
		    	

                // Swap elements of two parts if necesary
                if( $i <= $j)
                {
                    $w = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $w;

                    $i++;
                    $j--;
                }

            } while ( $i <= $j );

            if( $i < $r ) {
                $cur++;
                $stack[$cur]['l'] = $i;
                $stack[$cur]['r'] = $r;
            }
            $r = $j;

        } while ( $l < $r );

    } while ( $cur != 0 );

    return $array;

}

function tri_objets_fonction($array,$method){
		if(!method_exists($array[0],$method) || !property_exists($array[0],'temp')){
		return false;
		}
	//$method est une méthode.
	//On renseigne le $temp
	unset($temp);
	
	foreach($array as &$objet){
		$objet->temp=$objet->{$method}();
	}
	
	//on effectue le tri de tableau avec ce cache :
	return tri_objets( $array, 'temp', 0);

}

function filtrer_objets($array,$filtre,$valeur){
	$est_attribut=property_exists($array[0],$filtre);
	$est_methode=method_exists($array[0],$filtre);
	if ($est_attribut==false && $est_methode==false) {return false;}
	$max=count($array);
	for($i=0;$i<$max;$i++){
		if ($est_attribut){
			if ($array[$i]->{$filtre}!=$valeur){
				unset($array[$i]);
			}
		}
		if ($est_methode){
			if ($array[$i]->{$filtre}()!=$valeur){
				unset($array[$i]);
			}
		}
		
	}
	$final=array();
	while($shift=array_shift($array)){
		$final[]=$shift;
	}
	return $final;
}

	
	
?>