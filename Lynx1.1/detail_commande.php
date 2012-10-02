<?php require_once( "includes/initialize.php"); ?>

<?php

//On initialise la page :
if (isset($_GET['id_c'])){
	$getid=(int)$_GET['id_c'];
	unset($_GET['id_c']);
	$_SESSION['id_commande']=$getid;
}
else {
	$getid=false;
}

if (isset($_SESSION['commande'])){
	$en_session=true;
}
else {
	$en_session=false;
}

if (isset($_POST['sauvegarde']))
{
	($_POST['sauvegarde']==1)?$sauvegarder=true : $sauvegarder=false;
}
else {$sauvegarder=false;}


if (isset($_GET['modif'])){
	($_GET['modif']==1)? $modif=true : $modif=false;
}
else{$validation=false;}


if (isset($_GET['nouveau'])){
	($_GET['nouveau']==1)? $nouveau=true : $nouveau=false;
}
else{$nouveau=false;}

if (isset($_GET['delconfirm'])){
	($_GET['delconfirm']==1)? $delete=true : $delete=false;
}
else{$delete=false;}


//On choisi quoi mettre en fournisseur.
//Si on initialise avec un id
if ($getid){
	$commande=CommandeFournisseur::find_by_id($getid);
	$serial=serialize($commande);
	$_SESSION['commande']=$serial;
	unset($serial);
}

//Sinon on récupère celui en session
if ($getid==false && $en_session==true){
	$deserial=unserialize($_SESSION['commande']);
	$commande=$deserial;
	unset($deserial);
}


//On rentre dans cette boucle si on a soumis un formulaire
if(!empty($_POST)){

	$commande_modif=unserialize($_SESSION['commande']);
	$commande_modif->recuperer_post();
	$commande_modif->save();
	$_SESSION['commande']=serialize($commande_modif);
	header("Location: ".nom_page().'?modif=1');
	exit;

}

//On rentre dans cette boucle si on créé un nouveau fournisseur
if ($nouveau){
	$commande=new CommandeFournisseur;
	$_SESSION['commande']=serialize($commande);
}

if ($delete){
	$commande->delete();
	header("Location: liste_commandes_fournisseurs.php?supression=1");
	exit;
}

$fournisseur=Fournisseur::find_by_id($commande->fournisseur);

?>

<?php 
	/*
public $date_commande_prete	;
	public $date_commande_passee;	
	public $date_commande_recue	;
	public $date_commande_stock	;
*/
?>


<?php include(LIB_PATH.DS."header.php");?>


<div class="nine columns" id="contenu">
<div class="row"> <br/>
    <div class="panel twelve centered columns">
        <div class="row">
        	<div class="ten columns">
        	<h3>Commande n°<?php echo $commande->id;?> : <?php echo Fournisseur::afficher_nom($commande->fournisseur);?></h3>
        	</div>
        	<div class="two columns">
        	<a href="#" class="tiny alert button" data-reveal-id="supression">Supprimer</a>
        	</div>
        </div>
       <form method="post">
            <div class="row">
                <div class="five columns centrer">
                    <p>Date de validation : </p>
                </div>
                <div class="five columns end">
                    <input type="text" name="date_commande_prete" value="<?php echo $commande->date_commande_prete ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Date d'envoi : </p>
                </div>
                <div class="five columns end">
                    <input type="text" name="date_commande_passee" value="<?php echo $commande->date_commande_passee ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Date de reception : </p>
                </div>
                <div class="five columns end">
                    <input type="text" name="date_commande_recue" value="<?php echo $commande->date_commande_recue ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Date de mise en stock : </p>
                </div>
                <div class="five columns end">
                    <input type="text" name="date_commande_stock" value="<?php echo $commande->date_commande_stock ;?>">
                </div>
            </div>                                    
            <div class="row">

                     <div class="five columns centrer">
                    <p>Statut</p>
                </div>
                <div class="five columns end">
                    <select name="statut">
                    
					  <option  value="0" <?php echo ($commande->statut==0)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[0] ?></option>
					  <option value="1" <?php echo ($commande->statut==1)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[1] ?></option>
					  <option value="2" <?php echo ($commande->statut==2)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[2] ?></option>
					  <option value="3" <?php echo ($commande->statut==3)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[3] ?></option>
					  <option value="4" <?php echo ($commande->statut==4)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[4] ?></option>
					  <option value="5" <?php echo ($commande->statut==5)? ' selected="selected" ' : '';?>><?php echo CommandeFournisseur::$nom_statuts[5] ?></option>
					</select>
                </div>
            </div>




            <div class="row">
                <div class="six columns">
                    <label>Commentaires : </label>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <input type="text" name="commentaire"  value="<?php echo $commande->commentaire ?>">
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="nine columns centered" style="text-align:center;"> <br/>
                    <button type="submit" class="radius button"> Sauvegarder </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="twelve columns " style="text-align:center;">
            <div href="#" class="small radius button dropdown">
			 Autres modifications
			  <ul>
			    <li><a href="<?php echo nom_page().'?nouveau=1';?>">Créer une nouvelle commande</a></li>
			    <li class="divider"></li>
			    <li><a href="liste__commandes_fournisseurs.php" >Retour à la liste</a> </li>
			  </ul>
			</div>

                         </div>
                                 </div>
    </div>
    
    
    <?php $lignes = LigneCommandeFournisseur::find_by_commande($commande->id) ;?>
    
    
    
    
    
    <div class="row">
		<div class="twelve columns">
			<h5>Ajouter un produit à cette commande</h5>
				<form method="post" action="actions/ligne_commande.php">
					<label>Recherche par Ref ou Nom. Entrez la quantité.</label>
					<div class="row">
						<input  type="hidden" name="commande" value="<?php echo $commande->id;?>">
						<input  type="hidden" name="fournisseur" value="<?php echo $commande->fournisseur;?>">
						<div class="four columns">
							<input placeholder="Recherche" type="text" name="rech_ref" id="autocomplete2">
						</div>
						<div class="one columns">
							<input placeholder="Quantité" type="text" name="quantite" >
						</div>
						<div class="three columns" >
							<button type="submit" class="postfix button" name="valider" value="ajouter">Ajouter</button>
						</div>
					</div>
			</form>
		</div>
	</div>

    
    
    
    
    
    <div class="row">
    <h5>Liste des produits de la commande</h5>
    	<table id="tableautri">
    	<thead>
    		<th>Reference</th>
    		<th>Produit</th>
    		<th>Prix</th>
    		<th>Quantité</th>
    		<th>Ref Fournisseur</th>
    		<th>Modifier</th>
    		<th>Supprimer</th>
    	</thead>
    	<tbody>    		
    		<?php foreach ($lignes as $ligne) : ?>
    		<?php $produit=Produit::produit_par_id($ligne->produit); ?>
    		<tr>
	    		<form method="post" action="actions/ligne_commande.php">
			    	<input  type="hidden" name="ligne" value="<?php echo $ligne->id;?>">
			    	<input  type="hidden" name="commande" value="<?php echo $ligne->commande_fournisseur;?>">
			    	<input  type="hidden" name="fournisseur" value="<?php echo $commande->fournisseur;?>">
			    	<input  type="hidden" name="ref" value="<?php echo $produit->ref;?>">
	    		<td>
	    			<?php echo $produit->ref;?>
	    		</td>
	    		<td>
	    			<a href="analyse_detail.php?id_p=<?php echo $produit->id;?>" ><?php echo ($produit->titre);?> </a>
	    		</td>
	    		<td>
	    			<input type="text" name="prix" value="<?php echo $ligne->prix;?>">	
	    		</td>
	    		<td>
	    			<input type="text" name="quantite" value="<?php echo $ligne->quantite;?>">
	    		</td>
	    		<td>
	    		<input type="text" name="ref_fournisseur" value="<?php echo $ligne->ref_fournisseur;?>">
	    		</td>
	    		<td>
		    		<button type="submit" class="tiny button" value="modifier" name="valider">Modifier</button>
		    	</td>
	    		<td>
	    		  <button type="submit" class="tiny alert button" value="supprimer" name="valider">Supprimer</button>
	    		</td>
	    		</form>
	    	</tr>
    	<?php endforeach ;?>
    	</tbody>
    	</table>
    </div>
    
<?php /*    
    <div class="row">
    	<table>
    	<th>Reference</th><th>Produit</th><th>Prix</th><th>Ref fournisseur</th><th>Quantite</th><th>Supprimer</th>
    	<?php
    	$catalogue=CatalogueFournisseur::catalogue_fournisseur($fournisseur->id);
    	foreach($catalogue as $ligne):?>
    	<?php $produit=Produit::produit_par_id($ligne->produit);?>
    	<tr>
    		<td>
    			<?php echo $produit->ref;?>
    		</td>
    		<td>
    			<?php echo $produit->titre;?>
    		</td>
    		<td>
    			<?php echo $ligne->prix;?>
    		</td>
    		<td>
    			<?php echo $ligne->ref_fournisseur;?>
    		</td>
    	</tr>
    	
    	
    	<?
    	endforeach;    	
    	?>
    	</table>
    </div>
    
    */?>
    </div>
</div>



	




<div id="supression" class="reveal-modal">
  <h2>Confirmation</h2>
  <p class="lead">Etes vous sûr de vouloir supprimer cette commande ?</p>
  <div class="row">
	  <div class="twelve columns">
		  <ul class="button-group even two-up" >
		                    <li>
		                        <a href="<?php echo nom_page();?>?delconfirm=1" class="success radius button">Supprimer</a>
		                    </li>
		                    <li> <a href="<?php echo nom_page();?>" class="alert radius button" >Annuler</a> </li>
		  </ul>
	  </div>
  </div>
  <a class="close-reveal-modal">&#215;</a>
</div>


<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
