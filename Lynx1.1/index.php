<?php require_once( "includes/initialize.php"); ?>



<?php include(LIB_PATH.DS."header.php");?>

<div class="nine columns" id="contenu">
    <div class="row">
        <div class=" twelve  columns"> 
   

    <h1>Tableau de bord</h1>
    
    <div id="accordion" class="tableaudebord">
    
       <!--
  
        <h3>Chiffre d'affaires</h3> 
        <div id="caparjours" style="min-width: 400px; height: 400px; margin: 0 auto; padding-bottom:20px;"></div>
        
               
-->
        
        <h3>Top 10 produits </h3>
        
        <div>
        
        <?php $top10=ChiffreAffaires::top10();
	        $top10liste=array();
	        $top10liste['web']=array();
	        $top10liste['boutique']=array();
	        $top10liste['total']=array();
	        foreach ($top10['web'] as $key=>$value){
	        $top10liste['web'][]=array($key,$value);
	        }
	        foreach ($top10['boutique'] as $key=>$value){
	        $top10liste['boutique'][]=array($key,$value);
	        }
	        foreach ($top10['total'] as $key=>$value){
	        $top10liste['total'][]=array($key,$value);
	        }
        ?>
         <table>
         <th></th>
         <th>Web</th>
         <th>CA</th>
         <th>Boutique</th>
         <th>CA</th>
         <th>Total</th>
         <th>CA</th>
         
         <?php for ($i=0 ; $i<=9 ; $i++):?>
         <tr>
         <td><?php echo $i+1; ?></td>
         <td><?php $prod=Produit::produit_par_id($top10liste['web'][$i][0]);
         		if (!empty($prod)){
	         		echo $prod->titre;
         		} else {
         			echo $top10liste['web'][$i][0];
         			} ?></td>
         <td><?php echo $top10liste['web'][$i][1] . "€" ;?></td>
         <td><?php $prod=Produit::produit_par_id($top10liste['boutique'][$i][0]);
         		if (!empty($prod)){
	         		echo $prod->titre;
         		} else {
         			if ($top10liste['boutique'][$i][0]==999999){
	         			echo "<I>Référence produit inconnue</I>";
         			} else{
         			echo $top10liste['boutique'][$i][0];
         			}
         			} ?></td>
         <td><?php echo $top10liste['boutique'][$i][1] . "€" ;?></td>
         <td><?php $prod=Produit::produit_par_id($top10liste['total'][$i][0]);
         		if (!empty($prod)){
	         		echo $prod->titre;
         		} else {
					if ($top10liste['total'][$i][0]==999999){
					echo "<I>Référence produit inconnue</I>";
					} else{
					echo $top10liste['total'][$i][0];
         			}

         			} ?></td>
         <td><?php echo $top10liste['total'][$i][1] . "€" ;?></td>
         </tr>
         <?php endfor;?>
         </table>
        </div>
  
<!--
        <h3>CA par mois </h3>
        
        
        <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto; padding-bottom:20px;"></div>
        
      
-->
        
        <h3>Alertes Stocks</h3>
        <div>
        
        Nombre de produits en alerte : <a href="urgences.php"> Voir </a><?php ?>
        </div>
        
        <h3>Produits attendus</h3>
        <div>
        
        <a href="produits_attendus.php">Il y a actuellement <?php echo PrevenirClient::nb_clients_attente();?> clients en attente de <?php echo PrevenirClient::nb_produits_attente();?> produits en rupture de stock.</a>
        </div>
        
    </div>
        
        
        
        
        
    </div>
</div>
        
        		
	
<?php include(LIB_PATH.DS."footer.php");?>
<?php include(LIB_PATH.DS."finalize.php");?>
