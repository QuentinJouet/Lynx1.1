<?php require_once( "includes/initialize.php"); ?>
<?php include(LIB_PATH.DS."header.php");?>
<?php


	
	$fournisseurs = Fournisseur::find_all();
	
		
?>

<div class="nine columns" id="contenu">




  <h2> Fournisseurs </h2>
	  <?php 
	  // SI ON VIENT DE SUPPRIMER UN FOURNISSEUR :
	    if (!empty($_GET['supression'])):?>
		    <?php 
			    $fournisseursup=unserialize($_SESSION['fournisseur']);
			    unset($_SESSION['fournisseur']);    
		    ?>
			<div class="alert-box success">
			   Fournisseur : <?php echo $fournisseursup->nom; ?> supprimé avec succès.
			   <a href="" class="close">&times;</a>
			 </div>
	 <?php endif;?>
  <h5> Il y a <?php echo Fournisseur::count_all($db_cakeshop); ?> fournisseurs enregistrés : </h5>
  <a class="small button" href="detail_fournisseur.php?nouveau=1">Enregistrer un nouveau fournisseur</a>
  <br/><br/>
  
	<table class="nice" id="tableautri">
	<thead>
		<th>n°Id</th>
		<th>Nom</th>
		<th>Siteweb</th>
		<th>Nouvelle commande</th>
		<th>Commande préremplie</th>
	</thead>
	<tbody>
	
		<?php foreach($fournisseurs as $fournisseur): ?>
		<tr>
			<form method="post" action="actions/nouvelle_commande.php">
			<input  type="hidden" name="fournisseur" value="<?php echo $fournisseur->id;?>">
			<td><p><?php echo $fournisseur->id; ?></p></td>
			
			<td><p><a href="detail_fournisseur.php?id_f=<?php echo $fournisseur->id;?>"><?php echo $fournisseur->nom; ?></a></p></td>
			<td><p><?php echo $fournisseur->siteweb; ?></p></td>
			<td><button type="submit" class="small button" value="vide" name="valider">Créer une commande vide</button></td>
			<td><button type="submit" class="small button success" value="preremplie" name="valider"> Générer une commande préremplie</button></td>
			</form>
			
		</tr>
		
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<br/>
	<br/>

	<form method="post" action="actions/nouvelle_commande.php">
		<button type="submit" class="small button success" value="intelligente" name="valider"> Générer un ensemble intelligent de commandes</button></td>
	</form>
	
  </div>
<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
