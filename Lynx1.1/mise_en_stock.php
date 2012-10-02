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

$fournisseur=Fournisseur::find_by_id($commande->fournisseur);

//Crée un Tabstock correspondant à la commande
$tabstock=TabStock::recuperer($commande->id);
$tableau=$tabstock->gettableau();

?>


<?php include(LIB_PATH.DS."header.php");?>


<div class="nine columns" id="contenu">
<div class="row"> <br/>
    <div class="panel twelve centered columns">
        <div class="row">
        	<div class="ten columns">
        	<h3>Mise en stock de la commande n°<?php echo $commande->id;?> :</h3> 
        	<ul>
        	<li>Fournisseur : <?php echo Fournisseur::afficher_nom($commande->fournisseur);?></li>
        	<li>prête le <?php echo $commande->date_commande_prete;?></li>
        	<li>passée le <?php echo $commande->date_commande_passee;?></li>
        	<li>reçue le <?php echo $commande->date_commande_recue;?></li>
        	</ul>
        	</div>
        </div>
      
		
	</div>
    
    
    
    
    <?php $lignes = LigneCommandeFournisseur::find_by_commande($commande->id) ;?>
    
    
    
    
    
    
    
    
    
    
    
    <div class="row">
    <h5>Liste des produits de la commande</h5>
    
    	<form method="post" action="actions/mise_stock.php">
			    	<input  type="hidden" name="commande" value="<?php echo $commande->id;?>">
			    	<input  type="hidden" name="fournisseur" value="<?php echo $commande->fournisseur;?>">
			    	<input  type="hidden" name="id_tabstock" value="<?php echo $tabstock->id;?>">
    	

    	<table id="tableautri">
    	<thead>
    	<tr>
    		<th>Reference</th>
    		<th>Produit</th>
    		<th>Quantité commandée</th>
    		<th>Quantité reçue</th>
    		<th>Stock web</th>
    		<th>Stock boutique</th>
    		<th>Stock opé</th>
    	</tr>
    	</thead>
    	    	<tbody>	
    		
    		
    		
    		<?php foreach ($lignes as $ligne) : ?>
    		<?php $produit=Produit::produit_par_id($ligne->produit);
    				$id_p=$produit->id;
    		 ?>
    		<tr>
	    		<td>
	    			<?php echo $produit->ref;?>
	    		</td>
	    		<td>
	    			<a href="analyse_detail.php?id_p=<?php echo $produit->id;?>" ><?php echo ($produit->titre);?> </a>
	    		</td>
	    		<td>
	    			<?php echo $ligne->quantite;?>
	    		</td>
	    		<td>
	    			<input type="text" name="produit[<?php echo $id_p;?>][q_recue]" value="<?php echo $tableau[$id_p]['q_recue'];?>">
	    		</td>
	    		<td>
	    			<input type="text" name="produit[<?php echo $id_p;?>][stock_web]" value="<?php echo $tableau[$id_p]['stock_web']; ?>">
	    		</td>
	    		<td>
	    			<input type="text" name="produit[<?php echo $id_p;?>][stock_boutique]'; ?>" value="<?php echo $tableau[$id_p]['stock_boutique']; ?>">
	    		</td>
	    		<td>
	    			<input type="text" name="produit[<?php echo $id_p;?>][stock_ope]'; ?>" value="<?php echo $tableau[$id_p]['stock_ope']; ?>">
	    		</td>
	    		<!--
<td>
		    		<button type="submit" class="tiny button" value="valider" name="valider">Valider</button>
		    	</td>
-->
	    		</tr>
	    		
    	<?php endforeach ;?>
    		</tbody>
    	</table>
    	<div class="row">
			<div class="twelve columns " style="text-align:center;">
				<button type="submit" class="small button success" value="valider" name="valider">Vérifier la mise en stock</button>
			</div>
			<div class="twelve columns " style="text-align:center;">
				<button type="submit" class="small button alerte" value="confirmer" name="valider">Confirmer et terminer la mise en stock</button>
			</div>
		</div>

    	</form>
    </div>
    
    </div>
</div>


<?php //var_dump($tableau);?>
	



<?php //$tabstock->delete($commande->id);?>



<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
