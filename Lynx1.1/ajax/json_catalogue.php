<?php require_once( "../includes/initialize.php"); ?> 
 
 <?php 
 function genererjson(){


 	$tableau=array();
 	if (!isset($_GET['id_f'])){
	 	exit;
 	}
 	else{
 		$id_f=$_GET['id_f'];
	 	//$lignes = CatalogueFournisseur::find_by_sql("SELECT * FROM catalogue_fournisseur WHERE fournisseur=$id_f");
	 	$lignes=CatalogueFournisseur::find_all();
	 		 			 	
		
	foreach($lignes as $ligne){
		if (Produit::existe($ligne->produit)){
			$produit=Produit::produit_par_id($ligne->produit);
			$tableau[]=array('<form method="post" action="actions/catalogue_fournisseur.php"><input  type="hidden" name="ligne" value="'.$ligne->id.'"><input  type="hidden" name="fournisseur" value="'.$ligne->fournisseur.'">'.$produit->ref,
			
				$produit->titre,
				
				'<input type="text" name="prix" value="'.$ligne->prix.'">',
				
				'<input type="text" name="ref_fournisseur" value="'.$ligne->ref_fournisseur.'">',
				'<button type="submit" class="tiny button" value="modifier" name="valider">Modifier</button>',
				'<button type="submit" class="tiny alert button" value="supprimer" name="valider">Supprimer</button></form>'
			);
		}
		echo $ligne->fournisseur;
	}
	 
	 return json_encode(array('aaData'=>$tableau));
	 	
	 	}
 	}
 	
//echo genererjson(); 	
	
 ?>
