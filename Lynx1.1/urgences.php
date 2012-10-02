<?php require_once( "includes/initialize.php"); ?>

 <?php
   $produits=Produit::produits_par_sql();

$ruptures=array();


foreach ($produits as $produit)
{

if ($produit->alerte_stock()==4){
	$ruptures[]=$produit;
}

}

$tableau ="";
$tableau.= '<table><th>Référence</th><th>Produit</th><th>Stock Thelia</th><th>Modifier sur thelia</th><th>Modifier dans Lynx</th>';
foreach ($ruptures as $produit){
	$tableau.='<tr><td>'.$produit->ref.'</td><td>'.($produit->titre).'</td><td>'.$produit->stock_web.'</td><td><a class="tiny button radius" target="_blank" href="'.$produit->url_thelia().'">Modifier dans Thelia</td><td><a class="tiny button radius success" target="_blank" href="analyse_detail.php?id_p='.$produit->id.'">Modifier dans Lynx</a></td></tr>';	
	
}
$tableau.= '</table>';

$nb_urgences=count($ruptures);

?>





<?php include(LIB_PATH.DS."header.php");?>

<div class="nine columns" id="contenu">

<div class="row">
	<div class="ten columns centered panel">
		<h3>Nombre d'urgences  :  <?php echo $nb_urgences;?></h3>
	</div>
</div>


    <div class="row">
   
<?
  

echo $tableau;
    ?>
    
<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>