<?php
require_once('/var/www/vhosts/anotherwayin.fr/sitesweb/client/1.1/includes/initialize.php');

global $db_cakeshop_thelia;
global $db_cakeshop;

////// ENSEMBLE DE 4 SCRIPTS PERMETTANT DE SYNCRONISER LES PRODUITS ET CATEGORIES COTE LYNX.

function produit_client_existe($id) {
	global $db_cakeshop;
	$sql = "SELECT count(id) FROM produit WHERE id={$id}";
	$result_set = $db_cakeshop->query($sql);
	$p = mysql_fetch_array($result_set);
	return ((int)$p[0]==0)? false : true;
}

function produit_thelia_existe($id) {
	global $db_cakeshop_thelia;
	$sql = "SELECT count(id) FROM produit WHERE id={$id}";
	$result_set = $db_cakeshop_thelia->query($sql);
	$p = mysql_fetch_array($result_set);
	return ((int)$p[0]==0)? false : true;
}

function produit_client_identique($id) {
	global $db_cakeshop;
	$sql = "SELECT categorie, prix, tva, titre, datemodif_produit FROM produit WHERE id={$id}";
	
	
	$result_set = $db_cakeshop->query($sql);
	$p = mysql_fetch_array($result_set);

	$outofsync=0;
	$ok=0;

	$produit_thelia=Produit::produit_par_id($id);

	($produit_thelia->rubrique_id!=$p['categorie'])? $outofsync++ : $ok++;
	($produit_thelia->prix!=$p['prix'])? $outofsync++ : $ok++;
	($produit_thelia->tva!=$p['tva'])? $outofsync++ : $ok++;
	($produit_thelia->titre!=$p['titre'])? $outofsync++ : $ok++;
	($produit_thelia->datemodif!=$p['datemodif_produit'])? $outofsync++ : $ok++;

	return ($outofsync == 0)? true : false;
}

function creer_p_client($id,$ref){

	global $db_cakeshop;
	if (produit_client_existe($id)) {return false;}
	else {
		$sql = "INSERT INTO produit (id,ref) VALUES (";
		$sql.= $db_cakeshop->escape_value($id);
		$sql .= ", '";
		$sql.= $db_cakeshop->escape_value($ref);
		$sql.="')";
		$db_cakeshop->query($sql);
		$produit=Produit::produit_par_id($id);
		return $produit->enregistrer_cakeshop();
	}
}

function categorie_thelia_existe($id) {
	global $db_cakeshop_thelia;
	$sql = "SELECT COUNT(*) FROM rubrique WHERE id={$id}";
	$result_set = $db_cakeshop_thelia->query($sql);
	$p = mysql_fetch_array($result_set);
	$count = array_shift($p);
	return ($count==1)? true : false;
}

function id_produit_client($id) { //FONCTION QUI CHERCHE LE MEME ID DANS CLIENT
	global $db_cakeshop;
	$sql = "SELECT * FROM produit ORDER BY id DESC";
	$result_set = $db_cakeshop->query($sql);
	$p = mysql_fetch_array($result_set);
	return $p;
}

function rubrique_par_id($id) {
	global $db_cakeshop;
	$sql = "SELECT * FROM categorie WHERE id={$id}";
	$result_set = $db_cakeshop->query($sql);
	$p = mysql_fetch_array($result_set);
	return $p;
}

function rubrique_existe($id) {
	global $db_cakeshop;
	$sql = "SELECT COUNT(*) FROM categorie WHERE id={$id}";
	//echo $sql;
	$result_set = $db_cakeshop->query($sql);
	$p = mysql_fetch_array($result_set);
	$count=array_shift($p);
	if ($count == 1) { $resultat=true; }
	else {$resultat=false;}
	return $resultat;
}

function synchro_rubrique($id,$titre,$parent) {
	if (rubrique_existe($id)) {
		return update_rubrique($id,$titre,$parent);
	}
	else {
		return creer_rubrique($id,$titre,$parent);
	}
}

function update_rubrique($id,$titre,$parent){
	global $db_cakeshop;
	$titre=$db_cakeshop->escape_value($titre);
	$sql = "UPDATE categorie SET titre='{$titre}', parent={$parent} WHERE id={$id}";
	return $db_cakeshop->query($sql);
}

function creer_rubrique($id,$titre,$parent){
	global $db_cakeshop;
	$titre=$db_cakeshop->escape_value($titre);
	$sql = "INSERT INTO categorie (id, titre, parent) VALUES ({$id}, '{$titre}',{$parent})	";
	return $db_cakeshop->query($sql);
}

//NETTOYAGE DES PRODUITS
$sql = "SELECT id, ref FROM produit GROUP BY id ORDER BY id ASC";
$result_set = $db_cakeshop->query($sql);
?>
_______________NETTOYAGE PRODUITS____________________
<?php
$nb_ok=0;
$nb_obsoletes=0;
$nb_supprimes=0;
$nb_asup=0;


while($produit=mysql_fetch_array($result_set)){
	$existe = produit_thelia_existe($produit['id']);

	$existe? $nb_ok ++ : $nb_asup++;
	global $db_cakeshop;

	if (!($existe)) {
			if (!$existe) {
			$sup =  $db_cakeshop->query("DELETE FROM produit WHERE id={$produit['id']}");
		}
		
		if ($sup) {$nb_supprimes ++;}
		
	}
}
?>
OK : <?php echo $nb_ok; ?> || Obsoletes : <?php echo $nb_obsoletes; ?> || Supprimés : <?php echo $nb_supprimes; ?>
<?php
$message='ok : '.$nb_ok." | a supprimer : ".$nb_obsoletes." | supprimés : ".$nb_supprimes;
log_action('Nettoyage Produits',$message,'syncro.txt');

// FIN DU NETTOYAGE PRODUITS
?>


<?php
// SCRIPT DE NETTOYAGE DES CATEGORIES

$sql = "SELECT id, titre FROM categorie GROUP BY id ORDER BY id ASC";
$result_set = $db_cakeshop->query($sql);




?>
_______NETTOYAGE CATEGORIES _________


<?php
$nb_ok=0;
$nb_asup=0;
$nb_obsoletes=0;
$nb_supprimes=0;


while($categorie=mysql_fetch_array($result_set)){
	$existe = categorie_thelia_existe($categorie['id']);

	$existe? $nb_ok ++ : $nb_asup++;


	if (!($existe)) {
		echo '<tr><td>';
		echo utf8_encode($categorie['id']);
		echo '</td><td>';
		echo utf8_encode($categorie['titre']);
		echo '</td><td>';
		echo 'Obsolète';
		echo '</td><td>';
		if (!$existe) {
			$sup =  $db_cakeshop->query("DELETE FROM categorie WHERE id={$categorie['id']}");
		}
		echo ($sup)? 'Supprimé' : 'Echec' ;
		if ($sup) {$nb_supprimes ++;}
		echo '</td><tr>';
	}
}
?>
OK : <?php echo $nb_ok; ?> || Obsoletes : <?php echo $nb_obsoletes; ?> || Supprimés : <?php echo $nb_supprimes; ?>
<?php
$message='ok : '.$nb_ok." | a supprimer : ".$nb_asup." | supprimés : ".$nb_supprimes;
log_action('Nettoyage Categories',$message,'syncro.txt');
//FIN DU NETTOYAGE DES CATEGORIES
?>

<?php

//SYNCRONISATION DES PRODUITS (VALEUR DES CHAMPS)
$sql = "SELECT id, ref FROM produit GROUP BY id ORDER BY id ASC";
$result_set = $db_cakeshop_thelia->query($sql);
?>

_____SYNCRO PRODUITS_______

<?php
$nb_existants=0;
$nb_inexistants=0;
$nb_crees=0;
$nb_identiques=0;
$nb_passync=0;
$nb_sync=0;



while($produit=mysql_fetch_array($result_set)){


	$existe = produit_client_existe($produit['id']);
	$identique = produit_client_identique($produit['id']);

	$existe? $nb_existants++ : $nb_inexistants++;
	$identique? $nb_identiques++ : $nb_passync++;

	if (!($existe && $identique)) {
		$creation=false;
		if (!$existe) {
			$creation = creer_p_client($produit['id'],$produit['ref']);
		}
		if ($creation) {$nb_crees ++;}
		if ($identique==false) {
			$prod=Produit::produit_par_id($produit['id']);
			$prod->datemodif_produit = $prod->datemodif;
			$sync = $prod->enregistrer_cakeshop();
		}
		if($sync){ $nb_sync++;}
	}
}

$message='ok : '.$nb_identiques." | nouveaux : ".$nb_inexistants." | outofsync : ".$nb_passync." | crees : ".$nb_crees." | modifiés : ".$nb_sync;
echo $message;
log_action('MAJ Produits',$message,'syncro.txt');


//FIN SYNCRO PRODUITS


// SYNCRO DES CATEGORIES

$sql = "SELECT rd.titre, r.id, r.parent FROM rubrique r, rubriquedesc rd WHERE rd.rubrique = r.id AND rd.lang=1 ORDER BY r.id ASC";
$result_set = $db_cakeshop_thelia->query($sql);



?>
<?php
$nb_existants=0;
$nb_inexistants=0;
$nb_crees=0;


while($categorie=mysql_fetch_array($result_set)){
	//var_dump($categorie);
	if (rubrique_existe($categorie['id'])==true){
		$nb_existants ++;
	}
	else {
		$nb_inexistants ++;
		$existe=rubrique_existe($categorie['id']);
		$creation =  synchro_rubrique($categorie['id'],$categorie['titre'],$categorie['parent']);
		if ($creation) {$nb_crees ++;}



	}
}
?>


<?php
$message='ok : '.$nb_existants." | outofsync : ".$nb_inexistants." | crees : ".$nb_crees;
echo $message;
log_action('MAJ Categories',$message,'syncro.txt');



//__________________FIN DU SCRIPT DE SYNCRONISATION DES PRODUITS


//// SCRIPT QUI MET A JOUR L'HISTORIQUE DES STOCKS POUR TOUS LES PRODUITS DU CATALOGUE


$produits=Produit::tous();
$ajd=new date('osef',time()*1000);
$ajd=$ajd->jour_sql();


echo '\n \n MAJ Historique des stocks au '.$ajd.' \n \n';

$nouveau=0;
$update=0;
$creation=0;

foreach($produits as $produit){

	$historique=HistoriqueStock::find_last_by_product($produit->id);


	if($historique){

		if($historique->date==$ajd){
			$update++;
			$historique->maj();
		}
		else{
			$historique=new HistoriqueStock();
			$historique->renseigner($produit->id);
			$creation++;
		}
	}else{
		$nouveau++;
		$historique=new HistoriqueStock();
		$historique->renseigner($produit->id);

	}

	$historique->save();
}

$message='nouveaux produits : '.$nouveau." | creation du jour : ".$creation." | MAJ : ".$update;
echo $message;
log_action('MAJ Categories',$message,'historique.txt');

//___________________FIN DU SCRIPT DE CREATION D'HISTORIQUE

//Script de rangement des affichage des ordres de rubriques par rapport aux contenus associés.

$sql1='UPDATE produit as p, contenuassoc as c  SET c.classement=p.classement  where c.type=1 AND  c.objet=p.id';
$sql2='UPDATE rubrique as r, contenuassoc as c  SET c.classement=r.classement  where c.type=0 AND  c.objet=r.id'; 
$db_cakeshop_thelia->query($sql1);
$db_cakeshop_thelia->query($sql2);



//_________SCRIPT CHIFFRE AFFAIRES
//met a jour la table chiffreaffaires
ChiffreAffaires::mise_a_jour();




?>