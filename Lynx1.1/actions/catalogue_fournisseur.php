<?php
//echo 'CHARGEMENT';

require_once("../includes/initialize.php");

//TROIS ACTIONS POSSIBLE SUR LE CATALOGUE FOURNISSEUR
// AJOUTER , SUPPRIMER, MODIFIER.

if ($_POST['valider']=='ajouter'){


	if (isset($_POST['rech_ref'])){
		$tableau=explode(' | ',$_POST['rech_ref']);
		$ref=trim($tableau[0]);
		$produit=Produit::produit_par_ref($ref);
		$produit=$produit->id;
	}

	$ligne=new CatalogueFournisseur;
	$ligne->produit=$produit;
	$ligne->fournisseur=$_POST['fournisseur'];
	$ligne->prix= number_format(str_replace(',','.',$_POST['prix']),2);
	$ligne->ref_fournisseur=$_POST['ref_fournisseur'];
	$ligne->save();

}


if ($_POST['valider']=='modifier'){

	$ligne=CatalogueFournisseur::find_by_id($_POST['ligne']);
	$ligne->prix=$_POST['prix'];
	$ligne->ref_fournisseur=$_POST['ref_fournisseur'];
	$ligne->save();

}


if ($_POST['valider']=='supprimer'){

	$ligne=CatalogueFournisseur::find_by_id($_POST['ligne']);
	$ligne->delete();
	}



$urlretour='../detail_fournisseur.php?id_f='.$_POST['fournisseur'];
echo $urlretour;
redirect_to($urlretour);

?>