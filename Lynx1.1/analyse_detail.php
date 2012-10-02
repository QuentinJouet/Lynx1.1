<?php require_once( "includes/initialize.php"); ?>

<?php
	
	$produit_id = !empty($_GET['id_p']) ? (int)$_GET['id_p'] : false;
	$produit_ref = !empty($_GET['ref_p']) ? urldecode($_GET['ref_p']) : false;
	
	if ($produit_ref){
		$produit=Produit::produit_par_ref($produit_ref);	
		$_SESSION['produit_id']=$produit->id;	
		$_SESSION['produit']=serialize($produit);
	}
	elseif ($produit_id){
		$produit=Produit::produit_par_id($produit_id);
		$_SESSION['produit_id']=$produit->id;	
		$_SESSION['produit']=serialize($produit);	 
	}
	
	//Si pas de ref ou id (update du formulaire..) on reprend le produit en session
	if (empty($produit_id)&&empty($produit_ref)) {
		//Erreur si aucun produit en session : FAIRE CHOIX DE PRODUIT ou produit favori par def.
		if(empty($_SESSION['produit'])){
			 header("Location: index.php");
			 exit;
		}
		//On reprend le produit en session
		else{
			$produit=unserialize($_SESSION['produit']);	
			}
	}
	

	//$produits = Produit::produits_par_sql('','p.id DESC',$pagination->per_page,$pagination->offset());
	
	// Need to add ?page=$page to all links we want to 
	// maintain the current page (or store $page in $session)
	
?>
<?php
//PROCESS DU FORMULAIRE

//SI pas de formulaire soumis.
if (empty($_POST)){
	}

//Sinon on modifie et on serialize.
elseif(isset($_POST['sauvegarde'])) {
	if($_POST['sauvegarde']==1){
		$produit=unserialize($_SESSION['produit']);
		
		if ($produit->enregistrer()==false){
			$sauvegarde_ok="<div class=\"alert-box success\">  Produit : ".$produit->ref." modifié et enregistré avec succès !".'<a href="" class="close">&times;</a> </div>';
			echo $sauvegarde_ok;			
		}
		else {
			$sauvegarde_echec="<div class=\"alert-box alert\"> Echec lors de la sauvegarde du produit : ".$produit->ref." veuillez vérifier vos modifications.".'<a href="" class="close">&times;</a> </div>';
			echo $sauvegarde_echec;
		}
	}
}
	else{
	
$produit_modif=unserialize($_SESSION['produit']);
(empty($_POST['stock_web']))? false : $produit_modif->stock_web=(int)$_POST['stock_web'];
(empty($_POST['stock_op']))? false : $produit_modif->stock_op=(int)$_POST['stock_op'];
(empty($_POST['stock_boutique']))? false : $produit_modif->stock_boutique=(int)$_POST['stock_boutique'];
(empty($_POST['commentaire']))? false : $produit_modif->commentaire=$_POST['commentaire'];
(empty($_POST['prix']))? false : $produit_modif->prix=(float)virgule_en_point($_POST['prix']);
(empty($_POST['ligne']))? $produit_modif->ligne=0 : $produit_modif->ligne=1;
$_SESSION['produit']=serialize($produit_modif);
 header("Location: ".nom_page());
 exit;
}
//EXEMPLE : 
//(empty($_POST['stock_web']))? false : $produit->stock_web=(int)$_POST['stock_web'];



?>


<?php include(LIB_PATH.DS."header.php");?>

<div class="nine columns" id="contenu">
<div class="row"> <br/>
    <div class="twelve centered columns">
        <h3>Modifier le produit</h3>
        <form method="post" action="analyse_detail.php" >
            <div class="row">
                <div class="six columns ">
                    <p>Réference : <?php echo $produit->ref ;?></p>
                </div>
                <div class="six columns"> <img src="<?php echo $produit->image ;?>" max-width="50%" width="75px" style="float:right;"> </div>
            </div>
            <div class="row" >
                <div class="twelve columns centrer">
                    <p style="font-weight:bold;"><?php echo ($produit->chapo) ?></p>
                </div>
            </div>
            <div class="row">
                  <div class="five centered columns">
                  <a href="<?php echo $produit->url_thelia(); ?>" target="_blank" class="secondary button radius">Modifier ce produit dans Thelia</a>
                 
                  </div>
                   <br/>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>Rubrique : </p>
                </div>
                <div class="four columns end"> <?php echo ($produit->rubrique);?> 
                </div>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>Stock Web : <?php echo $produit->stock_web;?></p>
                </div>
                <div class="four columns end">
                    <input type="text" name="stock_web"  placeholder="Stock Web">
                </div>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>Stock Boutique : <?php echo $produit->stock_boutique ;?></p>
                </div>
                <div class="four columns end">
                    <input type="text" name="stock_boutique" placeholder="Stock Boutique">
                </div>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>Stock Opération : <?php echo $produit->stock_op ;?></p>
                </div>
                <div class="four columns end">
                    <input type="text" name="stock_op" placeholder="Stock Opération">
                </div>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>Quantité commandée : </p>
                </div>
                <div class="four columns end"> <?php echo ($produit->quantite_commandee());?> 
                </div>
            </div>
            <!--
<div class="row">
	            <div class="twelve columns">
		            <table>
			            <th>Unités vendues</th><th>CA généré</th><th>Ventes Web</th><th>CA Web</th><th>Ventes Boutique</th><th>CA Boutique</th>
			            <tr>
				            <td>
				            
				            </td>
				            <td>
				            
				            </td>
				            <td>
				            <?php echo $produit->nb_ventes_web();?>
				            </td>
				            <td>
				            <?php echo $produit->ca_web();?>
				            </td>
			            </tr>
		            </table>
	            </div>
            </div>
-->
            <div class="row">
                <div class="three columns centrer">
                    <p>Prix : <?php echo number_format($produit->prix,2) ;?> €</p>
                </div>
                <div class="four columns end">
                    <input type="text" name="prix" placeholder="Prix en euros">
                </div>
            </div>
            <div class="row">
                <div class="three columns centrer">
                    <p>En ligne sur Thelia : <?php echo ($produit->ligne==1)? 'oui' : 'non' ;?> </p>
                </div>
               <div class="four columns end">
                    <input type="checkbox" name="ligne" value="1" <?php if($produit->ligne==1){echo 'checked';} ?>>
               </div>
            </div>
              <div class="row">
                <div class="three columns centrer">
                    <p>Code Barre : <?php echo $produit->codebarre ;?> </p>
                </div>
                <div class="four columns end">
                    <input type="text" name="codebarre" placeholder="Scanner le produit">
                </div>
            </div>

            <div class="row">
                <div class="six columns">
                    <label>Commentaires : </label>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <textarea name="commentaire"  value="<?php echo $produit->commentaire ?>">
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="nine columns centered" style="text-align:center;"> <br/>
                    <button type="submit" class="radius button">Valider</button>
                    <label>Vous devez valider les modifications faites au produit avant de sauvegarder.</label>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="eight columns centered" style="margin: 0 auto; text-align:center;">
                <ul class="button-group" >
                    <li>
                        <form action="<?php echo nom_page(); ?>" method="post" style="text-align:center;">
                            <input type="hidden" name="sauvegarde" value="1">
                            <button type="submit" class="success radius button">Sauvegarder</button>
                        </form>
                    </li>
                    <li> <a href="analyse_detail.php?id_p=<?php echo $produit->id ;?>" class="alert radius  button" >Annuler</a> </li>
                    <li>
                        <?php $est_favori=Favori::est_favori($produit->id);?>
                        <form action="actions/favoris.php" method="post" style="text-align:center;">
                            <input type="hidden" name="favoris" value="<?php echo $est_favori? 0 : 1; ?>">
                            <input type="hidden" name="url" value="<?php echo nom_page(); ?>">
                            <input type="hidden" name="id_p" value="<?php echo $produit->id; ?>">
                            <button type="submit" class="secondary radius button"><?php echo $est_favori? 'Supprimer des ' : 'Ajouter aux '; ?>favoris</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    
    <div class="row">
   <!--
 <p>
    Ventes :
    <?php var_dump($produit->ventes_web());?>
    </p>
-->
    <h3>
    Evolution des stocks :
    </h3>
    <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    <?php $graph= new GraphSplines;
	$graph->renseigner($produit->id);	
	//echo $graph->container();
	
?>
    </div>

	<div class=row>
	<div class="twelve columns">
	<h3>Commandes où apparaît ce produit</h3>
		<?php 
		//Cherche les commandes où apparaIt ce produit
			$lignes = LigneCommandeFournisseur::find_by_sql("SELECT * FROM ligne_commande_fournisseur WHERE produit=".$produit->id);
			//var_dump($lignes);	
		?>
		
		<table>
			<tr>
				<th>Numéro<br/>Commande</th>
				<th>Statut</th>
				<th>Fournisseur</th>
				<th>Date de la commande</th>
				<th>Quantité</th>
				<th>prix</th>
			</tr>
			<?php foreach ($lignes as $ligne):?>
				<?php $commande=CommandeFournisseur::find_by_id($ligne->commande_fournisseur);
					$fournisseur=Fournisseur::find_by_id($commande->fournisseur);
				?>
				<?php if (!empty($fournisseur)):?>
			<tr>
				<td><p><a href="detail_commande.php?id_c=<?php echo $commande->id;?>"><?php echo $commande->id; ?></a></p></td>
				<td><p><a href="detail_commande.php?id_c=<?php echo $commande->id;?>"><?php echo CommandeFournisseur::$nom_statuts[$commande->statut];?></a></p></td>
				<td><p><a href="detail_fournisseur.php?id_f=<?php echo $fournisseur->id;?>"><?php echo $fournisseur->nom; ?></a></p></td>
				<td><?php echo $commande->date_commande_passee;?></td>
				<td><?php echo $ligne->quantite;?></td>
				<td><?php echo $ligne->prix;?></td>
			</tr>
			<?php endif;?>
			<?php endforeach;?>
		</table>
	</div>
	</div>
	
	
	<div class=row>
	<div class="twelve columns">
	<h3>Fournisseurs proposant ce produit</h3>
		<?php 
		//Cherche les fournisseurs qui vendent ce produit
		$catalogues=CatalogueFournisseur::find_by_sql("SELECT * FROM catalogue_fournisseur WHERE produit=".$produit->id);
		//var_dump($catalogues);
		?>
		<table>
			<tr>
				<th>Fournisseur</th>
				<th>Prix</th>
				<th>Ref fournisseur</th>
				<th>Commentaire</th>
			</tr>
			<?php if (!empty($catalogues)):?>
			<?php foreach ($catalogues as $catalogue):?>
			<?php $fournisseur=Fournisseur::find_by_id($catalogue->fournisseur);?>
				<?php if (!empty($fournisseur)):?>
			
				<tr>
					<td><p><a href="detail_fournisseur.php?id_f=<?php echo $fournisseur->id;?>"><?php echo $fournisseur->nom; ?></a></p></td>
					<td><?php echo $catalogue->prix; ?></td>
					<td><?php echo $catalogue->ref_fournisseur; ?></td>
					<td><?php echo $catalogue->commentaire; ?></td>
				</tr>
				<?php endif;?>
							<?php endforeach; ?>
			<?php endif;?>
		</table>
	</div>
	</div>

</div>
</div>


<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
