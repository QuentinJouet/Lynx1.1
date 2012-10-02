<?php require_once( "includes/initialize.php"); ?>

<?php

//On initialise la page :
if (isset($_GET['id_f'])){
	$getid=(int)$_GET['id_f'];
	unset($_GET['id_f']);
	$_SESSION['id_fournisseur']=$getid;
}
else {
	$getid=false;
}

if (isset($_SESSION['fournisseur'])){
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
	$fournisseur=Fournisseur::find_by_id($getid);
	$serial=serialize($fournisseur);
	$_SESSION['fournisseur']=$serial;
	unset($serial);
}

//Sinon on récupère celui en session
if ($getid==false && $en_session==true){
	$deserial=unserialize($_SESSION['fournisseur']);
	$fournisseur=$deserial;
	unset($deserial);
}


if(!empty($_POST)){

	$fournisseur_modif=unserialize($_SESSION['fournisseur']);
	$fournisseur_modif->recuperer_post();
	$fournisseur_modif->save();
	$_SESSION['fournisseur']=serialize($fournisseur_modif);
	header("Location: ".nom_page().'?modif=1');
	exit;
	}



//On rentre dans cette boucle si on créé un nouveau fournisseur
if ($nouveau){
	$fournisseur=new Fournisseur;
	$fournisseur->nom='Nouveau fournisseur';
	$_SESSION['fournisseur']=serialize($fournisseur);
}

if ($delete){
	$fournisseur->delete();
	header("Location: liste_fournisseurs.php?supression=1");
	exit;
}


?>




<?php include(LIB_PATH.DS."header.php");?>


<div class="nine columns" id="contenu">
<div class="row"> <br/>
    <div class="panel twelve centered columns">
        <div class="row">
        	<div class="ten columns">
        	<h3>Fournisseur : <?php echo $fournisseur->nom;?></h3>
        	</div>
        	<div class="two columns">
        	<a href="#" class="tiny alert button" data-reveal-id="supression">Supprimer</a>
        	</div>
        </div>
       <form method="post">
            <div class="row">
                <div class="five columns centrer">
                    <p>Site web : <a href="<?php echo $fournisseur->siteweb ;?>" target="_blank"><?php echo $fournisseur->siteweb ;?></a></p>
                </div>
                <div class="five columns end">
                    <input type="text" name="siteweb" value="<?php echo $fournisseur->siteweb ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Nom</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="nom" value="<?php echo $fournisseur->nom ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Telephone : </p>
                </div>
                <div class="five columns end">
                    <input type="text" name="telephone" value="<?php echo $fournisseur->telephone ;?>">
                </div>
            </div>
            <div class="row">
                <div class="five columns centrer">
                    <p>Fax</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="fax" value="<?php echo $fournisseur->fax ;?>">
                </div>
            </div>
            <div class="row">
                 <div class="five columns centrer">
                    <p>Siret</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="siret" value="<?php echo $fournisseur->siret ;?>">
                </div>
            </div>
            <div class="row">

                            <div class="five columns centrer">
                    <p>Mail</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="mail" value="<?php echo $fournisseur->mail ;?>">
                </div>
            </div>
            <div class="row">

                            <div class="five columns centrer">
                    <p>Adresse</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="adresse" value="<?php echo $fournisseur->adresse ;?>">
                </div>
            </div>
            <div class="row">

                            <div class="five columns centrer">
                    <p>Pays</p>
                </div>
                <div class="five columns end">
                    <input type="text" name="pays" value="<?php echo $fournisseur->pays ;?>">
                </div>
            </div>
            <div class="row">

                            <div class="five columns centrer">
                    <p>Devise</p>
                </div>
                <div class="five columns end">
                    <select name="devise">
					  <option  value="euro" <?php echo ($fournisseur->devise=='euro')? ' selected="selected" ' : '';?>>€</option>
					  <option value="livre" <?php echo ($fournisseur->devise=='livre')? ' selected="selected" ' : '';?>>£</option>
					  <option value="dollar US" <?php echo ($fournisseur->devise=='dollar US')? ' selected="selected" ' : '';?>>$(US)</option>
					   <option value="dollar CA" <?php echo ($fournisseur->devise=='dollar CA')? ' selected="selected" ' : '';?>>$(CA)</option>
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
                    <input type="text" name="commentaire"  value="<?php echo $fournisseur->commentaire ?>">
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
			    <li><a href="<?php echo nom_page().'?nouveau=1';?>">Créer un nouveau fournisseur</a></li>
			    <li class="divider"></li>
			    <li><a href="liste_fournisseurs.php" >Retour à la liste</a> </li>
			  </ul>
			</div>

                         </div>
                                 </div>
    </div>
    
	<div class="row">
		<div class="twelve columns">
			<h5>Ajouter un produit au catalogue fournisseur</h5>
				<form method="post" action="actions/catalogue_fournisseur.php">
					<label>Recherche par Ref ou Nom. Entrez le prix fournisseur. Entrez la référence fournisseur si différente.</label>
					<div class="row">
						<input  type="hidden" name="fournisseur" value="<?php echo $fournisseur->id;?>">
						<div class="four columns">
							<input placeholder="Recherche" type="text" name="rech_ref" id="autocomplete2">
						</div>
						<div class="one columns">
							<input placeholder="Prix" type="text" name="prix" >
						</div>
						<div class="three columns">
							<input placeholder="Ref Fournisseur" type="text" name="ref_fournisseur" >
						</div>
						<div class="three columns" >
							<button type="submit" class="postfix button" name="valider" value="ajouter">Ajouter</button>
						</div>
					</div>
			</form>
		</div>
	</div>
	
		
    <div class="row">
    	<h5>Catalogue de ce fournisseur</h5>
    	<table id="tableautricatalogue">
    	<thead>
    	<tr>
    		<th width="15%">Reference</th><th width="30%">Produit</th><th width="10%">Prix</th><th width="15%">Ref fournisseur</th><th width="10%">Modifier</th><th width="10%">Supprimer</th>
    	</tr>
    	</thead>
    	<tbody>
<!--
    	<?php
    	$catalogue=CatalogueFournisseur::catalogue_fournisseur($fournisseur->id);
    	foreach($catalogue as $ligne):?>
	    	<?php 
	    	if (Produit::existe($ligne->produit)):?>
	    	<?php $produit=Produit::produit_par_id($ligne->produit);
		    	$string=strtolower($produit->ref.$produit->titre);
		    	if((strpos($string, trim($recherche))!=false || $recherche=="###")&&(strpos($string, trim($recherche2))!=false || $recherche2=="###")):?>

	    	<tr>
		    	<form method="post" action="actions/catalogue_fournisseur.php">
		    	<input  type="hidden" name="ligne" value="<?php echo $ligne->id;?>">
		    	<input  type="hidden" name="fournisseur" value="<?php echo $ligne->fournisseur;?>">
		    		<td>
		    			<?php echo $produit->ref;?>
		    		</td>
		    		<td>
		    			<?php echo ($produit->titre);?>
		    		</td>
		    		<td>
			    		<input type="text" name="prix" value="<?php echo $ligne->prix;?>">		    			
			    		
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
	    	<? endif; ?>
	    	<? endif; ?>
    	
    	<?
    	endforeach;    	
    	?>
-->
    	</tbody>
    	</table>
    </div>
    </div>
</div>



	




<div id="supression" class="reveal-modal">
  <h2>Confirmation</h2>
  <p class="lead">Etes vous sûr de vouloir supprimer le fournisseur <?php echo $fournisseur->nom;?> ?</p>
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
