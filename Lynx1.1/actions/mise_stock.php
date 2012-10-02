<?php 
require_once("../includes/initialize.php");

//var_dump($_POST);

	$tabstock=TabStock::find_by_id($_POST['id_tabstock']);
	unset($_POST['id_tabstock']);
	$tableau=$tabstock->gettableau();
	
	$id_commande=$_POST['commande'];
	unset($_POST['commande']);
	$commande=CommandeFournisseur::find_by_id($id_commande);

	$fournisseur=$_POST['fournisseur'];
	unset($_POST['fournisseur']);
	
	
	if ($_POST['valider']=="valider"){
	//echo "<br /> ça marche";
		//unset($_POST['valider']);
		foreach ($_POST['produit'] as $id_p=>$quantites){
			foreach ($quantites as $name=>$value){
				$tableau[$id_p][$name]=$value;
			}
		}
		//Vérifie la cohérence des stocks entrés
		foreach ($tableau as &$quantites){
			if ($quantites['q_recue']==($quantites['stock_web']+$quantites['stock_boutique']+$quantites['stock_ope'])){
				//OK
			} else {
				$quantites['stock_web']="erreur";
				$quantites['stock_boutique']="erreur";
				$quantites['stock_ope']="erreur";
					//'<span style="font-weight:bold;color:red;">'.'20'.'</span>'
				
			}
		}
		$tabstock->settableau($tableau);
		$tabstock->save();
		$urlretour='../mise_en_stock.php?id_c='.$id_commande;
		echo urlretour;
		redirect_to($urlretour);

		
	} elseif ($_POST['valider']=='confirmer'){
		foreach ($_POST['produit'] as $id_p=>$quantites){
			foreach ($quantites as $name=>$value){
				$tableau[$id_p][$name]=$value;
			}
		}
		//Vérifie la cohérence des stocks entrés
		foreach ($tableau as &$quantites){
			if ($quantites['q_recue']==($quantites['stock_web']+$quantites['stock_boutique']+$quantites['stock_ope'])){
				//OK
			} else {
				$quantites['stock_web']="erreur";
				$quantites['stock_boutique']="erreur";
				$quantites['stock_ope']="erreur";
				$urlretour='../mise_en_stock.php?id_c='.$id_commande;
				redirect_to($urlretour);
			}
		}
		$tabstock->settableau($tableau);
		$commande->statut=4;
		$commande->date_commande_stock=Date::timestamp_to_sql(time()*1000);
		$commande->save();
		$tabstock->save();
		//Met à jour les stocks
		foreach($tableau as $id_p=>$quantites){
			$produit=Produit::produit_par_id($id_p);
			$produit->stock_web+=$quantites['stock_web'];
			$produit->stock_boutique+=$quantites['stock_boutique'];
			$produit->stock_op+=$quantites['stock_ope'];
			// à remplaver par $produit->enregistrer(); pour toucher à Thelia
			$produit->enregistrer_cakeshop();
			
		}
		
		$urlretour='../reception.php';
		redirect_to($urlretour);
	}
?>


