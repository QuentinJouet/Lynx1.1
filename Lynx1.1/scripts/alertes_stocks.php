<?php
require_once('/var/www/vhosts/anotherwayin.fr/sitesweb/client/1.1/includes/initialize.php');
global $db_cakeshop_thelia;
global $db_cakeshop;


$produits=Produit::produits_par_sql();

$ruptures=array();


foreach ($produits as $produit)
{

if ($produit->alerte_stock()==4){
	$ruptures[]=$produit;
}

}

$tableau ="";
$tableau.= '<table><th>Référence</th><th>Produit</th><th>Stock Thelia</th><th>Modifier sur thelia</th>';
foreach ($ruptures as $produit){
	$tableau.='<tr><td>'.$produit->ref.'</td><td>'.$produit->titre.'</td><td>'.$produit->stock_web.'</td><td><a target="_blank" href="'.$produit->url_thelia().'">MODIFIER DANS THELIA</td></tr>';	
	
}
$tableau.= '</table>';


echo $tableau;




?>