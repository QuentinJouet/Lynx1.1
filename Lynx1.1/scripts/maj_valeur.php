<?php
require_once('/var/www/vhosts/anotherwayin.fr/sitesweb/client/1.1/includes/initialize.php');
$produits=Produit::produits_par_sql();
global $db_cakeshop;
$sql="";
foreach ($produits as $produit){
	$sql.="UPDATE historique_stock SET valeur_boutique=stock_boutique*{$produit->prix} WHERE produit={$produit->id};";
	
	}
//$db_cakeshop->query($sql);
echo $sql;

?>