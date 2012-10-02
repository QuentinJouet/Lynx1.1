<?php require_once( "includes/initialize.php"); ?>
<?php include(LIB_PATH.DS."header.php");?>
<?php

	$surveille=ContenuAssocie::$contenus_surveilles;
		
?>

<div class="nine columns" id="contenu">




  <h2> Catégories virtuelles </h2>
	   <br/><br/>
  <table class="nice">
    	      
      <?php foreach($surveille as $titre=>$contenus): ?>
      <h4><?php echo $titre;?></h4>
		<table class="nice">
		<th>Titre</th>
		<th>Objet</th>
		<th>Voir dans Thelia</th>
		
		<?php foreach($contenus as $idcontenu) : ?>
		<?php $contenusassocies = ContenuAssocie::find_by_contenu; ?>
		<tr>
		<td><p><?php echo $fournisseur->id; ?></p></td>
		
		<td><p><a href="detail_fournisseur.php?id_f=<?php echo $fournisseur->id;?>"><?php echo $fournisseur->nom; ?></a></p></td>
		<td><p><?php echo $fournisseur->siteweb; ?></p></td>
		</tr>
		
		<?php endforeach;?>
		

		
		</table>
  	<?php endforeach; ?>
  </div>
<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
