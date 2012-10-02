<?php
//echo 'CHARGEMENT';

require_once("../includes/initialize.php");

//TROIS ACTIONS POSSIBLE SUR LA COMMANDE FOURNISSEUR
// AJOUTER , SUPPRIMER, MODIFIER.



if ($_POST['valider']=='ajouter'){


	if (isset($_POST['rech_ref'])){
		$tableau=explode(' | ',$_POST['rech_ref']);
		$ref=trim($tableau[0]);
		$produit=Produit::produit_par_ref($ref);
		$produit=$produit->id;
	}

$prod=CatalogueFournisseur::infos_produit($produit, $_POST['fournisseur']);

//Crée le produit dans le catalogue fournisseur
if (!$prod)	{
	$ligne_catalogue= new CatalogueFournisseur;
	$ligne_catalogue->fournisseur=$_POST['fournisseur'];
	$ligne_catalogue->produit=$produit;
	$ligne_catalogue->prix=0;
	$ligne_catalogue->ref_fournisseur="";
	$ligne_catalogue->save();
	$prod=$ligne_catalogue;
	} 

//Ajoute la ligne de commande	
	$ligne=new LigneCommandeFournisseur;
	$ligne->produit=$produit;
	$ligne->quantite=$_POST['quantite'];
	$ligne->prix= $prod->prix;
	$ligne->ref_fournisseur= $prod->ref_fournisseur;
	$ligne->commande_fournisseur = $_POST['commande'];
	$ligne->save();

if (!$prod)	{
	$ligne_catalogue= new CatalogueFournisseur;
	
	
}
	

}


if ($_POST['valider']=='modifier'){
//Met à jour la ligne commande
	$ligne=LigneCommandeFournisseur::find_by_id($_POST['ligne']);
	$ligne->prix=$_POST['prix'];
	$ligne->quantite=$_POST['quantite'];
	$ligne->ref_fournisseur=$_POST['ref_fournisseur'];
	$ligne->save();
//Met à jour le catalogue fournisseur	
	$produit=Produit::produit_par_ref($_POST['ref']);
	$produit=$produit->id;
	$fournisseur= $_POST['fournisseur'];
	$ligne_catalogue=CatalogueFournisseur::infos_produit($produit, $fournisseur);
	$ligne_catalogue->prix=$_POST['prix'];
	$ligne_catalogue->ref_fournisseur=$_POST['ref_fournisseur'];
	$ligne_catalogue->save();

}


if ($_POST['valider']=='supprimer'){

	$ligne=LigneCommandeFournisseur::find_by_id($_POST['ligne']);
	$ligne->delete();
	}



$urlretour='../detail_commande.php?id_c='.$_POST['commande'];
echo $urlretour;
redirect_to($urlretour);

?>