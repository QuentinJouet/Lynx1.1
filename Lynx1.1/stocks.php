<?php require_once( "includes/initialize.php");?>

<?php $produits = Produit::produits_par_sql();
	//On compte le nombre d'alertes pour chaque alerte :
	
	$alweb=array(array(),array(),array(),array(),array());
	$albout=array(array(),array(),array(),array(),array());
	$altot=array(array(),array(),array(),array(),array());
	
	foreach($produits as $produit){
		$alweb[$produit->alerte_stock_web()][]=$produit->id;
		$albout[$produit->alerte_stock_boutique()][]=$produit->id;
		$altot[$produit->alerte_stock()][]=$produit->id;
		
	}
		
		
?>



<?php include(LIB_PATH.DS."header.php");?>

    <div class="nine columns" id="contenu">
       <h2>Analyse des stocks</h2>            
            <form method="post" action="liste_produits.php">
	            <table id="analyse_stocks">
		            <th>Type</th>		<th>&nbsp; Couleur &nbsp;</th>		<th>Stock Web</th>						<th>Stock Boutique</th>						<th>Global</th>
		            <tr>
			            <td>Surstock</td>	<td><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[0];?>"></div></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_web&vlr=0"><?php echo count($alweb[0]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_boutique&vlr=0"><?php echo count($albout[0]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock&vlr=0"><?php echo count($altot[0]);?></a></td>
		            </tr>
		            <tr>
		            <td>Stock ok</td>	<td><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[1];?>"></div></td>	
		            	<td><a href="liste_produits.php?fltr=alerte_stock_web&vlr=1"><?php echo count($alweb[1]);?></a></td>
		            	<td><a href="liste_produits.php?fltr=alerte_stock_boutique&vlr=1"><?php echo count($albout[1]);?></a></td>	
		            	<td><a href="liste_produits.php?fltr=alerte_stock&vlr=1"><?php echo count($altot[1]);?></a></td>
		            </tr>	            
		            <tr>
		            <td>A commander</td><td><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[2];?>"></div></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_web&vlr=2"><?php echo count($alweb[2]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_boutique&vlr=2"><?php echo count($albout[2]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock&vlr=2"><?php echo count($altot[2]);?></a></td>
		            </tr>
		            <tr>
		            <td>Urgence</td>	<td><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[3];?>"></div></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_web&vlr=3"><?php  echo count($alweb[3]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_boutique&vlr=3"><?php echo count($albout[3]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock&vlr=3"><?php echo count($altot[3]);?></a></td>
		            </tr>
		            <tr>
		            <td>Rupture</td>	<td><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[4];?>"></div></td>
			            <td><a href="liste_produits.php?fltr=alerte_stock_web&vlr=4"><?php echo count($alweb[4]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock_boutique&vlr=4"><?php echo count($albout[4]);?></a></td>	
			            <td><a href="liste_produits.php?fltr=alerte_stock&vlr=4"><?php echo count($altot[4]);?></a></td>
		            </tr>          	            
	            </table>
            </form>
<br/>
<br/>
<?php if(isset($_GET['envoi'])):?>
<a href="" class="medium radius success button">Les mails ont bien été envoyés!</a>
<?php else :?>
<a href="actions/mails_alerte.php" class="medium radius button">Envoyer les mails d'information rupture</a>
<?php endif;?>
     </div>


<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>