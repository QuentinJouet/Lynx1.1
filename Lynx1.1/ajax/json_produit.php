<?php require_once( "../includes/initialize.php"); ?>

 <?php 
 function genererjson(){
 	$tableau=array();
 	$produits = Produit::produits_par_sql();

foreach($produits as $produit){
	$ca=ChiffreAffaires::ca_by_produit($produit->id);
	$tableau[]=array("<a href=analyse_detail.php?id_p=" . $produit->id . ">" . $produit->titre . "</a>",
							$produit->ref,
							$produit->stock_web,
							$produit->stock_boutique,
							$produit->stock_op,
							$produit->quantite_commandee(),
							Produit::$textealertestock[$produit->alerte_stock()],
							$produit->conso_moy(),
							$ca['nb_web'],
							$ca['web'],
							$ca['nb_boutique'],
							$ca['boutique'],
							($ca['web'] + $ca['boutique']));
	}
 
 return json_encode(array('aaData'=>$tableau));
 	
 	}
 	
echo genererjson(); 	
 	
 ?>
 
