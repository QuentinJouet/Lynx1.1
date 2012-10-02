<?php require_once( "../includes/initialize.php"); ?>

<?php 
//Nouvelle commande vierge
if ($_POST['valider']=='vide'){
	$commande=new CommandeFournisseur();
	$commande->fournisseur=$_POST['fournisseur'];
	$commande->save();
	
	$urlretour='../detail_commande.php?id_c='.$id_c;
	redirect_to($urlretour); 
	} 
	
//Nouvelle commande préremplie pour ce fournisseur
	elseif ($_POST['valider']=='preremplie'){
	//Crée une commande
		$commande=new CommandeFournisseur();
		$commande->fournisseur=$_POST['fournisseur'];
		$commande->statut=0;
		$commande->save();
		$id_c=$commande->id;
	//Cherche les produits fournisseurs	en rupture et crée les lignes de commande
		$lignes_catalogue=CatalogueFournisseur::catalogue_fournisseur($commande->fournisseur);
		foreach ($lignes_catalogue as $ligne_catalogue){
			
		//checker les stocks et décider si $alerte
		if (Produit::existe($ligne_catalogue->produit)){
			$produit=Produit::produit_par_id($ligne_catalogue->produit);
			$alerte=$produit->alerte_stock();
			if (($alerte==3 ||$alerte==4)&&$produit->quantite_commandee()==0){
				$ligne_commande=new LigneCommandeFournisseur();
				$ligne_commande->commande_fournisseur=$id_c;
				$ligne_commande->produit=$ligne_catalogue->produit;
				$ligne_commande->prix= $ligne_catalogue->prix;
				$ligne_commande->ref_fournisseur= $ligne_catalogue->ref_fournisseur;
				$quantite=($produit->stock_cible - $produit->stock());
				$ligne_commande->quantite=$quantite;
				$ligne_commande->save();	
			}
			}
		}	
		$urlretour='../detail_commande.php?id_c='.$id_c;
		redirect_to($urlretour); 
	} 
	//Créer toutes les commandes préremplies
	elseif ($_POST['valider']=='intelligente') {
		$produits=Produit::produits_par_sql();
		$ar_commandes=array();
		
		foreach ($produits as $produit){
		$alerte=$produit->alerte_stock();
		if (($alerte==3 ||$alerte==4)&&$produit->quantite_commandee()==0){
				if(!empty($produit->fournisseur_pref)){
				$quantite=($produit->stock_cible - $produit->stock());
				$ligne_catalogue=CatalogueFournisseur::infos_produit($produit->id, $produit->fournisseur_pref);
				$ar_commandes[$produit->fournisseur_pref][]=array($ligne_catalogue,$quantite);
				} else {
				$best_catalogue=array_shift(CatalogueFournisseur::fournisseurs_produit($produit->id));
				if (!empty($best_catalogue)){
				$quantite=($produit->stock_cible - $produit->stock());
				$ar_commandes[$best_catalogue->fournisseur][]=array($best_catalogue,$quantite);
				}
				}
			}
		}
		
		foreach ($ar_commandes as $fournisseur=>$ar_commande){
			$commande=new CommandeFournisseur();
			$commande->fournisseur=$fournisseur;
			$commande->statut=0;
			$commande->save();
			$id_c=$commande->id;
			foreach ($ar_commande as $ligne_catalogue){
				$ligne_commande=new LigneCommandeFournisseur();
				$ligne_commande->commande_fournisseur=$id_c;
				$ligne_commande->produit=$ligne_catalogue[0]->produit;
				$ligne_commande->prix= $ligne_catalogue[0]->prix;
				$ligne_commande->ref_fournisseur= $ligne_catalogue[0]->ref_fournisseur;
				$ligne_commande->quantite=$ligne_catalogue[1];
				$ligne_commande->save();	
			}
		}
		$urlretour='../liste_commandes_fournisseurs.php';
		redirect_to($urlretour); 
	}
	
//Erreur de formulaire	
	else {
	
	$urlretour='../liste_fournisseurs.php';
	redirect_to($urlretour); 

	}
	
	

?>       

