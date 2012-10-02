<?php require_once( "includes/initialize.php"); ?>
<?php include(LIB_PATH.DS."header.php");?>
<?php
	


	
	
	$commande_id = !empty($_GET['id_c']) ? (int)$_GET['id_c'] : false;
	$commande_ref = !empty($_GET['ref_c']) ? urldecode($_GET['ref_c']) : false;
	
	if ($commande_id){
		$commande=CommandeThelia::find_by_id($commande_id);	
		$_SESSION['commande_id']=$commande->id;	
	}
	elseif ($commande_ref){
		$commande=CommandeThelia::find_by_ref($commande_ref);
		$_SESSION['commande_id']=$commande->id;
	}
	
//Pour modifier les infos de la commande lorsque le formulaire local est soumis	
if (!empty($_POST)){
	$commande->paiement=$POST['paiement'];
	$commande->statut=$POST['statut'];
	$commande->save();
}


echo'<div class="nine columns" id="contenu">';

$lignes=$commande->lignes_pour_commande();
?>
<div class="panel">
<h5> Informations sur la commande <?php echo $commande->ref;?></h5>
<ul class="block-grid three-up">

<?php foreach(CommandeThelia::$champs_db as $attribut):?>
<li>
<?php if ($attribut=='paiement'){
	echo "Paiement par : ".$commande->moyenpaiement[$commande->{$attribut}];
} elseif ($attribut=='statut'){
	echo "Statut : ".$commande->statuts[$commande->{$attribut}];
} else {
echo ucfirst($attribut).' : '.$commande->{$attribut}; 
}
?>

</li>
<?php endforeach;?>
</ul>

</div>

<h5> Modifier</h5>
<form method="post">
<table>
<th>Moyen de paiement</th>
<th>Satut</th>
<th>Valider</th>
<tr>
	<td>
		<SELECT name="paiement">
			<OPTION VALUE=31 <?php if($commande->paiement==31){echo "selected='selected'";}?>>Paypal</OPTION>
			<OPTION VALUE=1 <?php if($commande->paiement==1){echo "selected='selected'";}?>>Chèque</OPTION>
		</SELECT>
	</td>
	<td>	
		<SELECT name="statut">
		<?php for ($i=0; $i<=5; $i++){
			if ($i==$commande->statut){
				echo "<OPTION VALUE=" . $i . " selected='selected'>" . $commande->statuts[$i] . "</OPTION>";
			} else {
			echo "<OPTION VALUE=" . $i . ">" . $commande->statuts[$i] . "</OPTION>";
		}
		} ?>
		</SELECT>
	</td>
	<td><button type="submit" class="small radius button"> Sauvegarder </button></td>
</tr>
</table>
</form>


<table>
<th>Reference</th><th>Produit</th><th>Quantité</th><th>Prix u</th><th>Prix TTC</th><th>TVA</th>
<?php foreach($lignes as $ligne):?>
<tr>
	<td>
	<?php echo $ligne->ref;?>
	</td>
	<td><a href="analyse_detail.php?ref_p=<?php echo $ligne->ref;?>">
	<?php echo ($ligne->titre);?>
	</a>
	</td>
	<td>
	<?php echo $ligne->quantite;?>
	</td>
	<td>
	<?php echo $ligne->prixu;?> €
	</td>
	<td>
	<?php echo $ligne->prix_total();?> €
	</td>
	<td>
	<?php echo $ligne->tva;?>%
	</td>

</tr>
<?php endforeach;?>
<tr>
	<td></td>
	<td style="text-align:right;">Total</td>
	<td><?php echo $commande->nb_produits();?></td>
	<td></td>
	<td><?php echo $commande->prix_produits();?> €</td>
	<td><?php echo number_format($commande->tva_val(),2);?> €</td>
</tr>
<tr>
	<td></td>
	<td style="text-align:right;">Frais de ports</td>
	<td></td>
	<td></td>
	<td><?php echo $commande->port;?> €</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td style="text-align:right;">Remise</td>
	<td></td>
	<td></td>
	<td><?php echo $commande->remise;?> €</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td style="text-align:right; font-weight:bold;">Montant TTC</td>
	<td></td>
	<td></td>
	<td><?php echo $commande->total_ttc();?> €</td>
	<td></td>
</tr>

</table>




</div>
</div>
<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
